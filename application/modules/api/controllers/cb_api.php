<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cb_api extends CI_Controller{    	
    function __construct(){
		parent::__construct();	
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);	
        $this->base_key =$this->config->item('base_key');
        //$this->admin_edit = $this->memcache->get($this->base_key.'_offer_admin_edit');     
        $this->redis = new Redis(); 
        $this->redis->connect('127.0.0.1', 6379); 
    }
    
    function index(){
        echo 'helloo';
    }	
    function curlip($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        $result = curl_exec($ch);  // grab URL and pass it to the variable.
        curl_close($ch);
        return $result;
    }
    function debug($vv){
        if($_POST){$vv=serialize($_POST);}else $vv='';
        $uri = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"].'--'.$vv;        
        $this->db->insert('debug',array('debug1'=>$uri));
              
        
    }
    function postback($idpb=0){//postback với từng con off   
        $this->debug();        
        if($_POST){$vv=serialize($_POST);}else $vv='-get-';
        $this->debug($vv);  
        //$uri = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"].'--'.$vv;        
        //$this->db->insert('debug',array('debug1'=>$uri)); 
          
        if(!is_numeric($idpb)){$idpb=0;}
        $this->db->select('pb_value,id,title');
        $network=$this->Home_model->get_one('network',array('id'=>$idpb));
        if(!empty($network)){//đúng pas và id pótback            
            $pb_value_array= unserialize($network->pb_value);//mang du lieu de get     
            $tracklink=$this->input->get_post("trackingCodes", TRUE); //->chinh la id_track
            if($tracklink){
                 //dah cho net adwork tru tien Lead Status: 1 (credited leads) or 2 (reversed leads)//http://www.mysite.com/postback.php?campaign_id=[INFO]&campaign_name=[INFO]&sid=[INFO]&sid2=[INFO]&sid3=[INFO]&status=1&commission=[INFO]&ip=[INFO]&leadID=[INFO]
               
                 //get du lieu ca 3 bang user offer va tracking  
                 //**********************************************************
                 //***************************************************->
                 // get     dislead ở bảng user          
                 //như vậy cần get ofer.percent và smartlink,type, smartlink.percent
                $qr ="
                    SELECT cpalead_tracklink.*,cpalead_offer.percent as offpercent,cpalead_users.dislead 
                    FROM cpalead_tracklink
                    LEFT JOIN cpalead_users ON cpalead_users.id = cpalead_tracklink.userid
                    LEFT JOIN cpalead_offer ON cpalead_offer.id = cpalead_tracklink.offerid
                    WHERE cpalead_tracklink.id = $tracklink
                ";
                $track = $this->db->query($qr)->row();
                if(!empty($track)){ 
                    
                     //chặn lead 
                     $key = $this->base_key.'-'.$track->offerid;     
                     $tlead_key = $key.'-tlead';   //tổng lead      
                                      
                    $ct = $this->redis->INCR($tlead_key."-".$track->userid,1);  //đếm lead//key theo userr
                    /*
                    $dislead = $this->redis->get($dislead_key);
                   // $dislead = $this->
                   
                   if(empty($dislead)){
                    
                        //chưa có dislead
                        $offer=$this->Home_model->get_one('offer',array('id'=>$track->offerid));
                        if(!empty($offer)){
                            if($offer->dislead>=1){
                                $this->redis->set($dislead_key,$offer->dislead);
                                $this->redis->EXPIRE($dislead_key,300);//đặt thời gian cho key
                            }else{
                                $this->redis->set($dislead_key,200);
                                $this->redis->EXPIRE($dislead_key,300);//đặt thời gian cho key
                            }
                        }
                        
                        
                    }
                    $dislead = $this->redis->get($dislead_key);
                    */                
                    $dislead =$track->dislead;
                    $mchan = array();
                     if($dislead >=1 ){
                        //xử lý chặn lead
                        $ttc = round(100/$dislead,1);
                        $j=0;
                        for($i=0;$i<100;$i++){
                            $j=$j+1;
                            if($j>=$ttc){
                                $mchan[] = $i;
                                //echo $i.'<br>';
                                $j = $j-$ttc;
                                
                            }
                        }

                    }
                    
                    if(in_array($ct,$mchan)){
                        echo 1;
                        return;
                    }                           
                          
                    if($ct >=100){
                        $this->redis->INCR($tlead_key."-".$track->userid,-99);
                    }  
                   
                        // Retrieve additional (optional) data to improve accuray.
                        //$user_agent = $_SERVER['HTTP_USER_AGENT']; 
                        //$user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                        $strictness = (int)file_get_contents('setting_file/strictness.txt');
                        //$strictness = 0; // 0 (light) -> 3 (strict)
 
                        $json_result = $this->checkProxy($track->ip, $track->useragent, $track->user_language, $strictness);
                        // Decode the result into an array.
                        $result = json_decode($json_result, true);
                        $fraud_score  = $proxy = '0';
                        
                        if($result['success'] == true) {
                            if($result['fraud_score'])$fraud_score = $result['fraud_score'];
                            if($result['proxy'])$proxy = $result['proxy'];
                                
                        }
                       
                    //end chặn lead//point_net laf point tra tu net ve
                  
                    $point =$point_net= 0;
                    //fix cái amount2 này để nhầm lưu data vào amount 2 cho chuẩn phần hiển thị
                    if($track->amount2>0){
                        $point=$track->amount2;
                    }else{
                        //lay point tuef net
                        if (!empty($pb_value_array[2])) {
                            $point_net = (double)$this->input->get_post("affiliateCommission", true); 
                        } 
                        //kieemr tra xem dang naof
                        $point = round($point_net*$track->offpercent/100,2); 
                        
                        
                    }

                     
                     $this->db->where('id',$tracklink);
                     if($point!=0){
                        $this->db->update('tracklink',array('amount'=>$point,'amount2'=>$point,'flead'=>1,'status'=>1,'fraud_score'=>$fraud_score,'proxy'=>$proxy));
                     }else{
                        $this->db->update('tracklink',array('amount'=>$point,'flead'=>1,'status'=>1,'fraud_score'=>$fraud_score,'proxy'=>$proxy));
                     }
                     
                     if($this->db->affected_rows()>0){
                         //update thành công-- tránh lead trùng
                        //xử lý thêm point-report          
                        $this->db->where('id', $track->userid)            
                        ->set('curent', "curent +$point", FALSE)
                        ->set('balance', "balance +$point", FALSE)
                        ->update('users');
                    
                        // add vao report
                        $this->db->where( array('id'=>$track->offerid))
                            ->set('lead','lead+1',false)
                            ->set('revenue',"revenue+$point",false)                       
                            ->update('offer');
                        //earn la so tien ad kiem dc
                        
                        //update vao bang report dayli
                        /*/check xem toonf taij chuwa	dayli 	usersid 	offerid
                        $today = date("Y-m-d");
                        $this->db->where(array('dayli'=>$today,'usersid'=>$track->userid,'offerid'=>$track->offerid));
                        $this->db->set('lead', "lead +1", FALSE); 
                        $this->db->set('revenue', "revenue +".$track->amount2, FALSE); 
                        $this->db->update('reportday');  
                        //end report dayli

                        */

                        //chay link postback cua mem                    
                        $pb= $this->Home_model->get_one('postback',array('affid'=>$track->userid));
                        if(!empty($pb)){
                            $url = $pb->postback;

                            if(strpos($url,'{sum}')){
                                //
                                $url = str_replace('{sum}',$point,$url);
                            }
                            if(strpos($url,'{payout}')){
                                //
                                $url = str_replace('{payout}',$point,$url);
                            }
                            if(strpos($url,'{offerid}')){
                                //
                                $url = str_replace('{offerid}',rawurlencode($track->offerid),$url);
                            }
                            if(strpos($url,'{sub1}')){
                                //
                                $url = str_replace('{sub1}',$track->s1,$url);
                            } 
                            
                            if(strpos($url,'{sub2}')){
                                //
                                $url = str_replace('{sub2}',$track->s2,$url);
                            }

                            if(strpos($url,'{sub3}')){
                                //
                                $url = str_replace('{sub3}',$track->s3,$url);
                            }
                            if(strpos($url,'{sub4}')){
                                //
                                $url = str_replace('{sub4}',$track->s4,$url);
                            }
                            if(strpos($url,'{sub5}')){
                                //
                                $url = str_replace('{sub5}',$track->s5,$url);
                            }
                            if(strpos($url,'{sub6}')){
                                //
                                $url = str_replace('{sub6}',$track->s6,$url);
                            }
                                                    
                            
                            $resutl = $this->curl_senpost($url);                            
                         //end xưr ly  thêm point report
                        }else{
                            $url =$resutl= 'Not Postback URL';
                        }
                        //chèn vào log postback
                        $this->db->insert('postback_log',array(
                            'finalurl'=>$url,
                            'response'=>$resutl,
                            'tracklink'=>$track->id,
                            'userids'=>$track->userid,
                            'campaignid'=>$track->offerid
                        ));
                      
                    
                        
                     }
                     
                     //end chay link postback
                     //gửi chuông cho mem
                     //$link = "http://35.233.176.54:2222/chuonglead?idmem=$track->userid&site=wepro";
                     //$this->curlip($link);
                     
                     //end gửi chuông cho mem
                     $this->thongbao($network->title); 
                     
                }
            }                
                      
        }
    }
    
    function checkProxy($ip, $user_agent, $user_language, $strictness) {
        // Your API Key
        $key = '56b4f42494b6455d97fce1b5bac29f85';

        // Create parameters array
        $parameters = array(
                'key' => $key,
                'ip'	=> $ip,
                'user_agent' => $user_agent,
                'user_language' => $user_language,
                'strictness' => $strictness
        );

        // Format Params
        $formatted_parameters = http_build_query($parameters);

        // Create API Call URL
        $url = sprintf(
                'https://network.affmine.com/api/proxy/proxy_lookup.php?%s', 
                $formatted_parameters
        );


        $timeout = 5;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        $json = curl_exec($curl);
        curl_close($curl);

        return $json;
}
    function curl_senpost($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        $result = curl_exec($ch);  // grab URL and pass it to the variable.
        curl_close($ch);
        return $result;
    }
    function thongbao($netname=''){
        switch($netname){
            case 'Sonic':
                $eventId=$this->input->get('eventId');
                echo $eventId.":OK";
                break;
            case 'PaymentWall':
                echo 'OK';
            break;
            default:
                echo 1;
        }
        
    }
  
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */