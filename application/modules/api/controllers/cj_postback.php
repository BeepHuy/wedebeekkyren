<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cj_postback extends CI_Controller{    	
    function __construct(){
		parent::__construct();	
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);	
        $this->base_key =$this->config->item('base_key');
        //$this->admin_edit = $this->memcache->get($this->base_key.'_offer_admin_edit');     
        $this->redis = new Redis(); 
        $this->redis->connect('127.0.0.1', 6379); 
    }
    
    function index(){
        
    }
    function getCjData(){//lấy dữ liệu trừ cj//lấy 1 tuần vậy
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
            $to = date('Y-m-d',strtotime('+1 day'));
            $from = date('Y-m-d',strtotime('-7 day'));
            $ch = curl_init();
            $data = '{ 
                publisherCommissions
                (
                    forPublishers: ["7056083"],
                    sincePostingDate:"'. $from.'T00:00:00Z",
                    beforePostingDate:"'.$to.'T00:00:00Z"
                    )
                {count payloadComplete records 
                    { pubCommissionAmountUsd shopperId }
                }
                    
            }';
            curl_setopt($ch, CURLOPT_URL, 'https://commissions.api.cj.com/query');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

            $headers = array();
            $headers[] = 'Authorization: Bearer 1e6ycdzd0vb6nyryt4x0k9grsf';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $dt = json_decode($result);
            $dt = $dt->data->publisherCommissions->records;    
            $where_in = '';
            $arr_track_point = array();          
            if($dt){                
                foreach($dt as $dt){
                    $point = (double)$dt->pubCommissionAmountUsd;
                    $track = trim($dt->shopperId);
                    $track = (int)str_replace('api','',$track);
                    if($track){
                        if($where_in)$where_in .=",$track";
                        else $where_in .="$track";
                        $arr_track_point[$track] = $point;                         
                    }
                }                
                if($where_in){
                    $where_in = "cpalead_tracklink.id IN ($where_in)";
                    //xử lý get data từ tracklink
                    $qr ="
                    SELECT cpalead_tracklink.*,cpalead_offer.percent as offpercent,cpalead_users.dislead 
                    FROM cpalead_tracklink
                    LEFT JOIN cpalead_users ON cpalead_users.id = cpalead_tracklink.userid
                    LEFT JOIN cpalead_offer ON cpalead_offer.id = cpalead_tracklink.offerid
                    WHERE cpalead_tracklink.flead=0 AND $where_in
                    ";
                    $track = $this->db->query($qr)->result();                  
                    if(!empty($track)){
                        foreach($track as $track){
                            $point = $arr_track_point[$track->id]; 
                            echo $track->id.'-'. $point.'<br>';
                            try{
                                $this->postback($track,$point);
                            }catch(Exception $e){
                                print_r($e);
                            }
                            
                        }
                    }
                    
                }
                
            }

            ///get dữ liệu gửi xuống postback  
               
            
            
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
    function postback($track=0,$point_net= 0){//postback với từng con off   
                $point =0;
            
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
                  
                   
                    //fix cái amount2 này để nhầm lưu data vào amount 2 cho chuẩn phần hiển thị
                    if($track->amount2>0){
                        $point=$track->amount2;
                    }else{                        
                        //kieemr tra xem dang naof
                        $point = round($point_net*$track->offpercent/100,2); 
                        
                    }
                     
                     $this->db->where('id',$track->id);
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
                    // add vao OFFER LED VAD REVENUE
                        $this->db->where( array('id'=>$track->offerid))
                        ->set('lead','lead+1',false)
                        ->set('capcount','capcount+1',false)
                        ->set('revenue',"revenue+$point",false)                       
                        ->update('offer');
                    //update vào cappub
                    $this->db->where( array('usersid'=>$track->userid,'offerid'=>$track->offerid))
                        ->set('capcount','capcount+1',false)                      
                        ->update('pubcap');
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
                    // $this->thongbao(); 
                     
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