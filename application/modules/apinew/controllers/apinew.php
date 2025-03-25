<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apinew extends CI_Controller { 
    private $base_url_trang='';
    private $total_rows='';
    private $per_page=50;   
    private $urigeg = 2; 
    public $member = '';
    function  __construct(){
        parent::__construct(); 
         /*  
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        
        if($this->session->userdata('logedin')){
            $this->member=$this->Home_model->get_one('users',array('id'=>$this->session->userdata('userid')));
            $this->member_info = unserialize($this->member->mailling);
        }elseif($this->uri->segment(3)!='in'&&$this->uri->segment(3)!='up'){
            redirect('v2/sign/in');            
        }
        */
    }
   
    function index(){
        
        $Gpubkey = $this->input->get('pubkey');
        $Guser_id = $this->input->get('user_id');
        $pubkey = md5('wdb-'.$Guser_id);
        $Gaction = $this->input->get('action');  
        
        if($Gpubkey!= $pubkey){
            echo 'Incorrect API Key!';
            return;
        }else{
            //kiểm tra action
            if($Gaction=='offers_cats'){
                $this->offers_cats();
            }
            if($Gaction=='offers_types'){
                $this->offers_types();
            }
            if($Gaction=='offers'){
                $this->offers();
            }
            
            
        }
        
    }
   
    private function offers_cats(){    
        $this->db->select('id,offercat as offercats');
        $this->db->where('show',1);
        $ocat =$this->db->get('offercat')->result();
        if($ocat){
            echo json_encode($ocat);
        }else{
            echo '0';
        }
    }
    private function offers_types(){    
        $this->db->select('id,type as offertypes');
        $this->db->where('show',1);
        $ocat =$this->db->get('offertype')->result();
        if($ocat){
            echo json_encode($ocat);
        }else{
            echo '0';
        }
    }
   
    function offers(){   
        //
        //https://maxpointmedia.com/3.0/offers?API-Key=4d447bd0749d031677700831adcfb7c1&int_id[]=1421&countries[]=VN
        $APIKey = $this->input->get('API-Key');
        $this->db->select('id');
        $this->db->where('api_key',$APIKey);
        $check = $this->db->get('users')->row();        
        $Guser_id = $check->id;
        if(empty($Guser_id)){
            echo '{"status":2,"error":"Invalid token"}';
            return;
        }else{
            $Guser_id = $check->id;
        }
        $ocat =$this->db->get('offercat')->result();
        //Search by title and id
        $q = $this->input->get('q');
        //Array[integer]		Search by one or more offer IDs
        $int_id = $this->input->get('int_id');
        //countries Array[string]		Array of offers countries(ISO)// lấy theo countries và description_lang lấy theo key và uperkey
        $countries = $this->input->get('countries');
        // Array[string]		Array of offers categories
        $categories = $this->input->get('categories');
        //Sort offers. Sample sort[id]=asc, sort[title]=desc. You can sort offers by one of (id, title, cr, epc, is_top, created, revenue, daily_cap, total_cap)
        $sort = $this->input->get('sort');
        //Page of offers
        $page = $this->input->get('page')?:1;
        //Default: 100 Available: max 500	Count offers by page
        $limit = $this->input->get('limit')?:100;
        $offset =  ($page-1)*$limit;
       
        $where = $like = array();
        $where = 'cpalead_offer.show = 1 ';       
        $arrCountry= array();  
        ///
        if($int_id){
            $int_id = array_filter($int_id, 'is_numeric');
            $int_id = implode(',',$int_id);
            $where .= " AND cpalead_offer.id in ($int_id)";
        }    
        if($q){
            if(is_numeric($q)){
                $where .= " AND cpalead_offer.id = $q";
            }else{
                $like['title'] = $this->db->escape_str(trim($q));
            }            
        }
      
        // if($Gcat){
        //     $like['offercat'] = trim($Gcat);            
        // }
        // if($Gtype){
        //     $like['type'] = trim($Gtype); 
        // }
        //xuwr lys lay idcounty
        // $ct =$this->Home_model->get_data('country',array());
        // $ct_id = $ct_keycode= array();
        // if($ct){
        //     foreach($ct as $ct){
        //         $ct_id[$ct->id] =  $ct->keycode;
        //         $ct_keycode[$ct->keycode] =  $ct->id;
        //     }
        // }
        // //xử lý category       
        // $oc =$this->Home_model->get_data('offercat',array());
        // $oc_arr =  array();
        // if($oc){
        //     foreach($oc as $oc){
        //         $oc_arr[$oc->id] =  $oc;
                
        //     }
        // }
        // if($countries){
        //     if(!empty($ct_keycode[trim($Gcountry)])){
        //         $like['country'] =$ct_keycode[trim($Gcountry)];
        //     }
            
        // }
        // $ct_Like = '';
        // if(!empty($like)){
        //     $count = 0;
        //     foreach($like as $key=>$value){
        //         $count++;
        //         if($count==1){
        //             $ct_Like .="$key LIKE '%$value%'";                
        //         }else{
        //             $ct_Like .=" AND $key LIKE \'%o'.$value.'o%\'";  
        //         } 
                
        //     }
        //     $cat_Like = " AND (".$ct_Like.") ";
        // }    
      
        $burl = base_url("click?pid=$Guser_id&offer_id=");
        /* lấy theo approved
        $qr = "SELECT cpalead_offer.* , 'Approved' as status
                FROM cpalead_offer
                WHERE $where $cat_Like AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $Guser_id) ELSE 'Approved' END)='Approved'
                ORDER BY `id` DESC                 
                ";
        */
        $qr = "SELECT count(*) as total_count
        FROM cpalead_offer
        WHERE $where $cat_Like AND apion =1              
        ";
        $total_count = $this->db->query($qr)->row()->total_count;          

        $qr = "SELECT cpalead_offer.* , 'Approved' as status
        FROM cpalead_offer
        WHERE $where $cat_Like AND apion =1
        ORDER BY `id` DESC        
        LIMIT $limit OFFSET $offset        
        ";
        $offer = $this->db->query($qr)->result();       
        $offers = array();
        if($offer){
            foreach($offer as $offer){
                $dt = array();
                $dt['id'] = $offer->id;
                $dt['offer_id'] = $offer->id;
                $dt['advertiser'] = "5bc9d7c16d73e41c008b4567";
                $dt['title'] = $offer->title;

                $dt['preview_url'] = $offer->preview;
                $dt['cr'] = $offer->cr;
                $dt['epc'] = $offer->epc;
                $dt['logo'] = $offer->img;
                $dt['description_lang'] = [
                    'en'=>$offer->description
                ];
                $dt['sources'] = [];               
                $dt['full_categories'] = [];
                $dt['caps'] = [];
               
                //xử lý point
                $payout = [];
                $flagIcon = [];
                $targeting = [];
                $point_geo = unserialize($offer->point_geos);
                $point= '';
                if($point_geo){                 
                    foreach($point_geo as $key=>$value){                        
                        if($value>0){                            
                            $dt1 = array(
                                'countries' => [$key],
                                'cities' =>[],
                                'devices' =>[],
                                'os' =>[],
                                'revenue' =>$value,
                                'currency' =>  "usd",
                                'title' => "Default"
                            );  

                            $targeting[] = ['country'=>['allow'=>[$key],'deny'=>[]]];
                            if(!in_array($key,$flagIcon))   $flagIcon[] =  $key ;                         
                            $payout[] = $dt1;
                        }
                    }
                    
                }
                //xử lý payout theo percent
                if($point<=0||$point==''){
                    $percent_geos = unserialize($offer->percent_geos);
                    if($percent_geos){               
                        foreach($percent_geos as $key=>$value){
                            if($value>0){                            
                                $dt1 = array(
                                    'countries' => [$key],
                                    'cities' =>[],
                                    'devices' =>[],
                                    'os' =>[],
                                    'revenue' =>$value,
                                    'currency' =>  "usd",
                                    'title' => "Default"
                                );   
                                $targeting[] = ['country'=>['allow'=>[$key],'deny'=>[]]];
                                if(!in_array($key,$flagIcon))   $flagIcon[] =  $key ;                  
                                $payout[] = $dt1;
                            }
                        }
                    }
                }
                
                $dt['payments'] = $payout;
                $dt['targeting'] = $targeting;
                $dt['url'] = $burl.$offer->id;
                $dt['link'] = $burl.$offer->id;
                //xử ly country//hiện tại country đang theo payout nên k lấy county ở đấy
                // $mIdCountry=explode('o',substr($offer->country,1,-1));
                // $flagIcon = [];
                // if($mIdCountry){
                //    foreach($mIdCountry as $mIdCountry){
                //       if($mIdCountry !='all'){
                //         $flagIcon[]= $ct_id[$mIdCountry];
                //       }
                //    }
                // }
                $dt['countries'] = $flagIcon;
                //xử lý category

                $cat=explode('o',substr($offer->offercat,1,-1));
                $ccc = [];
                if($cat){
                    foreach($cat as $cat){                                       
                        $ccc[]= $oc_arr[$cat]->offercat;
                       
                    }
                 }    
                $dt['categories'] = $ccc;

                $dt['convert_on'] = $offer->convert_on;
                $dt['traffic_source'] = $offer->traffic_source;
                $dt['restriced_traffics'] = $offer->restriced_traffics;
                $offers[] = $dt;
            }
        } 
        $mdata['status']  = 1; 
        $mdata['offers']  =$offers; 
        
        $mdata['pagination'] = [
            "per_page" => $limit,
            "total_count" => $total_count,
            "page" => $page,
            "next_page" => ($page*$limit) < $total_count?$page+1:$page
        ];       
 
        if($mdata){
            echo json_encode($mdata);
        }else{
            echo 0;
        }

        
        
        
    }
    function document(){
        $content =$this->load->view('document.php',$data,true); 
        $this->load->view('members/default/vindex.php',array('content'=>$content)); 
    }
    
    
    function phantrang(){
        $this->load->library('pagination');
        $config['base_url'] = $this->base_url_trang;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->urigeg;
        $config['num_links'] = 13;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_pag">';//div cho chu <<
        $config['first_tag_close'] = '</li>';//div cho chu <<
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<li class="last_pag">';
        $config['last_tag_close'] = '</li>';
        //-------next-
        $config['next_link'] = 'next &gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        //------------preview
        $config['prev_link'] = '&lt; prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
       // ------------------cu?npage
        $config['cur_tag_open'] = '<li class="activep">';
        $config['cur_tag_close'] = '</li>';
        //--so 
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //-----
        $this->pagination->initialize($config);
    
    }
    
}