<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Postback extends CI_Controller{    	
    function __construct(){
		parent::__construct();	
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);	
        $this->base_key =$this->config->item('base_key');       
        $this->redis = new Redis(); 
        $this->redis->connect('127.0.0.1', 6379); 
                
    }
    function test(){
        
            $url = "http:dantri.com.vn";

            if(strpos($url,'{sum}')){
                //
                $url = str_replace('{sum}',112,$url);
            }
         
             echo   $url;                     
            
                                        
         //end xưr ly  thêm point report
       
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
    function banner($idpb=0,$password=''){//postback với từng con off 
    
        //if($_POST){$vv=serialize($_POST);}else $vv='-get-';
        //$uri = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"].'--'.$vv;        
        //$this->db->insert('debug',array('debug1'=>$uri));         
        if(!is_numeric($idpb)){$idpb=0;}
        $this->db->select('pb_value,id,title');
        $network=$this->Home_model->get_one('network',array('idpb'=>$idpb,'pb_pass'=>$password));        
        if(!empty($network)){//đúng pas và id pótback 
            $this->debug($network->id);           
            $pb_value_array= unserialize($network->pb_value);//mang du lieu de get             
            $tracklink=$this->input->get_post($pb_value_array[0], TRUE); //->chinh la id_track
            $saleAmount = $this->input->get_post($pb_value_array[6],TRUE);
            if (!is_numeric($saleAmount)) {
                $saleAmount = 0.0;
            } else {
                $saleAmount = (float)$saleAmount;
            }
            //lay point tuef net
            if (!empty($pb_value_array[2])) {
                $point_net = (double)$this->input->get_post($pb_value_array[2], true); 
            }else $point_net = 0;

            return $this->addLead($tracklink, $point_net, $network->title, 0, $saleAmount);

                      
        }
        return 1;
    }
    function admin_add_lead(){
        if(!($this->session->userdata('admin'))){           
            echo 'You need permission to perform this action!';
            exit();
        }else{
            $data = $this->input->Post('data');
            if(!empty($data)){
                foreach($data as $leadData){
                    $amount2 = isset($leadData['amount2']) ? $leadData['amount2'] : 0;
                    $saleAmount = isset($leadData['saleAmount']) && $leadData['saleAmount'] !== '' ?
                        (float)$leadData['saleAmount'] : 0;
                    $this->addLead(
                        $leadData['trackId'],
                        0,
                        '',
                        $amount2,
                        $saleAmount
                    );
                }
            }
        }
    }
    private function chanLead($track){
        //chặn lead 
        $key = $this->base_key.'-'.$track->offerid;     
        $tlead_key = $key.'-tlead';   //tổng lead      
                         
       $ct = $this->redis->INCR($tlead_key."-".$track->userid,1);  //đếm lead//key theo userr
             
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
             
       if($ct >=100){
           $this->redis->INCR($tlead_key."-".$track->userid,-99);
       } 
       if(in_array($ct,$mchan)){           
            return 1;
        }
       return 0;
    }
    private function addLead($tracklink, $point_net = 0, $networktitle = '', $adminAddPoint = 0, $saleAmount){
        if($tracklink){
            $this->load->library('TracklinkDistributor', array('redis' => $this->redis));
            //dah cho net adwork tru tien Lead Status: 1 (credited leads) or 2 (reversed leads)//http://www.mysite.com/postback.php?campaign_id=[INFO]&campaign_name=[INFO]&sid=[INFO]&sid2=[INFO]&sid3=[INFO]&status=1&commission=[INFO]&ip=[INFO]&leadID=[INFO]
          
            //get du lieu ca 3 bang user offer va tracking  
            //**********************************************************
            //***************************************************->
            // get     dislead ở bảng user          
            //như vậy cần get ofer.percent và smartlink,type, smartlink.percent
           $qr ="
               SELECT cpalead_tracklink.*,cpalead_offer.percent as offpercent,cpalead_users.dislead,cpalead_offer.cappub
               FROM cpalead_tracklink
               LEFT JOIN cpalead_users ON cpalead_users.id = cpalead_tracklink.userid
               LEFT JOIN cpalead_offer ON cpalead_offer.id = cpalead_tracklink.offerid
               WHERE cpalead_tracklink.id = $tracklink AND cpalead_tracklink.flead =0 AND cpalead_tracklink.status=0
           ";
           $track = $this->db->query($qr)->row();
           if(!empty($track)){ 
           
                if($adminAddPoint==0 && $this->chanLead($track)) {
                    return 1;
                }
                  
               //end chặn lead//point_net laf point tra tu net ve
             
               $point = 0;
               //fix cái amount2 này để nhầm lưu data vào amount 2 cho chuẩn phần hiển thị
               if($track->amount2>0){
                   $point=$track->amount2;
               }else{                         
                   //lấy $ từ net gửi về
                   $point = round($point_net*$track->offpercent/100,2); 
               }

               if($adminAddPoint>0){
                $point = $adminAddPoint;
               }
                
               $this->db->where('id',$tracklink);
               if($point!=0){
                   $this->db->update('tracklink', array('amount' => $point, 'amount2' => $point, 'flead' => 1, 'status' => 1, 'saleAmount' => $saleAmount));
               }else{
                   $this->db->update('tracklink', array('amount' => $point, 'flead' => 1, 'status' => 1, 'saleAmount' => $saleAmount));
               }
                
                if($this->db->affected_rows()>0){      //update thành công-- tránh lead trùng

                   //update cái check proxy sau. vì update trên sẽ bị hen xưiz là thành duplicate postback
                   //$user_agent = $_SERVER['HTTP_USER_AGENT']; 
                   //$user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                   $strictness = (int)file_get_contents('setting_file/strictness.txt');
                   //$strictness = 0; // 0 (light) -> 3 (strict)
                   //tạm dừng cái check pryx and fraud_scre
                   // $json_result = $this->checkProxy($track->ip, $track->useragent, $track->user_language, $strictness);
                   // Decode the result into an array.
                   //$result = json_decode($json_result, true);
                   $fraud_score  = $proxy = '0';
                   
                   // if($result['success'] == true) {
                   //     if($result['fraud_score'])$fraud_score = $result['fraud_score'];
                   //     if($result['proxy'])$proxy = $result['proxy'];
                           
                   // }
                   $this->db->where('id',$tracklink);
                   $this->db->update('tracklink',array('fraud_score'=>$fraud_score,'proxy'=>$proxy));
                   
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
                    //update vào subcap
                    if(!empty($track->s2)){
                        $this->db->where( array('usersid'=>$track->userid,'offerid'=>$track->offerid,'s2'=>$track->s2))
                       ->set('capcount','capcount+1',false)                      
                       ->update('sub2cap');
                    }

                    if($track->cappub >0 ){
                        $this->tracklinkdistributor->incrementCapByPub($track->offerid,$track->userid);
                    }
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
                   $pb= $this->Home_model->get_data('postback',array('affid'=>$track->userid));
                   if($pb){
                       foreach($pb as $pb){                                
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
                           if (strpos($url, '{saleAmount}')) {
                            $url = str_replace('{saleAmount}', $saleAmount, $url);
                            }
                                                   
                           
                           $resutl = $this->curl_senpost($url);                            
                       //end xưr ly  thêm point report
                       
                       //chèn vào log postback
                       $this->db->insert('postback_log',array(
                           'finalurl'=>$url,
                           'response'=>$resutl,
                           'tracklink'=>$track->id,
                           'userids'=>$track->userid,
                           'campaignid'=>$track->offerid
                       ));
                       }
                   }else{
                       $url =$resutl= 'Not Postback URL';
                       $this->db->insert('postback_log',array(
                           'finalurl'=>$url,
                           'response'=>$resutl,
                           'tracklink'=>$track->id,
                           'userids'=>$track->userid,
                           'campaignid'=>$track->offerid
                       ));
                   }
                     
                 
               
                   
                }
                
                //end chay link postback
                //gửi chuông cho mem
                //$link = "http://35.233.176.54:2222/chuonglead?idmem=$track->userid&site=wepro";
                //$this->curlip($link);
                
                //end gửi chuông cho mem
                $this->thongbao(($networktitle?:'')); 
                
           }else{
               echo 0;
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
  
    
    function debug($idnet = 0){
        if($_POST){$vv=serialize($_POST);}else $vv='';
        $uri = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"].'--'.$vv;        
        $this->db->insert('debug',array('debug1'=>$uri,'idnet' => $idnet)); 
        // $data = array(//add vao history
        //            'iduser'=>$this->uri->segment(3),
        //            'point' => $this->uri->segment(4), 
        //            'created'=>time(),
        //            'type'=>0,
        //            'ip' =>$this->input->ip_address(),
        //            'name' =>urldecode($this->uri->segment(5)),
        //            'idnet'=>3                   
        //         );          
        //       $this->addcredit($data);       
        //echo $uri;
        if($_POST){
            //print_r($_POST);
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */