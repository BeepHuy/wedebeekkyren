<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller { 
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
   
    private function offers(){    
        
        $Guser_id = $this->input->get('user_id');
        $where = $like = array();
        $where = 'cpalead_offer.show = 1 ';
        $Gkeyword = $this->input->get('keyword');//like
        $Gcat = (int)$this->input->get('cat'); //wwhere
        $Gid = (int)$this->input->get('id');//where
        $Gtype = (int)$this->input->get('type');    //where
        $Gcountry = $this->input->get('country');  //where//xuwr lys country dde lay id
        $arrCountry= array();  
        
        ///
        if($Gid){
            $where .= " AND cpalead_offer.id = $Gid ";
        }

        if($Gkeyword){
            $like['title'] = trim($Gkeyword);
        }
        
        if($Gcat){
            $like['offercat'] = trim($Gcat);            
        }
        if($Gtype){
            $like['type'] = trim($Gtype); 
        }
        //xuwr lys lay idcounty
        $ct =$this->Home_model->get_data('country',array());
        $ct_id = $ct_keycode= array();
        if($ct){
            foreach($ct as $ct){
                $ct_id[$ct->id] =  $ct->keycode;
                $ct_keycode[$ct->keycode] =  $ct->id;
            }
        }
        //xử lý category       
        $oc =$this->Home_model->get_data('offercat',array());
        $oc_arr =  array();
        if($oc){
            foreach($oc as $oc){
                $oc_arr[$oc->id] =  $oc;
                
            }
        }
        if($Gcountry){
            if(!empty($ct_keycode[trim($Gcountry)])){
                $like['country'] =$ct_keycode[trim($Gcountry)];
            }
            
        }
        $ct_Like = '';
        if($like){
            $count = 0;
            foreach($like as $key=>$value){
                $count++;
                if($count==1){
                    $ct_Like .="$key LIKE \'%o'.$value.'o%\'";                
                }else{
                    $ct_Like .=" AND $key LIKE \'%o'.$value.'o%\'";  
                } 
                
            }
            $cat_Like = " AND (".$cat_Like.") ";
        }      
        $burl = base_url("click?pid=$Guser_id&offer_id=");
        /* lấy theo approved
        $qr = "SELECT cpalead_offer.* , 'Approved' as status
                FROM cpalead_offer
                WHERE $where $cat_Like AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $Guser_id) ELSE 'Approved' END)='Approved'
                ORDER BY `id` DESC                 
                ";
        */

        $qr = "SELECT cpalead_offer.* , 'Approved' as status
        FROM cpalead_offer
        WHERE $where $cat_Like AND apion =1
        ORDER BY `id` DESC                 
        ";
        $offer = $this->db->query($qr)->result();       
        $mdata = array();
        if($offer){
            foreach($offer as $offer){
                $dt = array();
                $dt['offerid'] = $offer->id;
                $dt['title'] = $offer->title;
                //xử lý point
                $point_geo = unserialize($offer->point_geos);
                $point= '';
                if($point_geo){
                    $dem = 0;
                    foreach($point_geo as $key=>$value){
                        
                        if($value>0){
                            $dem++;
                            if($dem==1){
                                $phay = '';
                            }else{
                                $phay = ', ';
                            }
                            $point .= $phay. $key.': $'.$value;
                        }
                    }
                }
                //xử lý payout theo percent
                if($point<=0||$point==''){
                    $percent_geos = unserialize($offer->percent_geos);
                    if($percent_geos){
                    $dem = 0;
                    foreach($percent_geos as $key=>$value){
                        
                        if($value>0){
                            $dem++;
                            if($dem==1){
                                $phay = '';
                            }else{
                                $phay = ', ';
                            }
                            $point .= $phay. $key.':'.$value.'%';
                        }
                    }
                }
                }
                
                $dt['payout'] = $point;

                $dt['track'] = $burl.$offer->id;
                //xử ly country
                $mIdCountry=explode('o',substr($offer->country,1,-1));
                $flagIcon = '';
                if($mIdCountry){
                   foreach($mIdCountry as $mIdCountry){
                      if($mIdCountry=='all'){
                         $flagIcon = 'All Countries';
                      }else{                  
                         @$flagIcon .= $ct_id[$mIdCountry].', ';
                      }
                   }
                }
                @$dt['Geo'] =substr($flagIcon,0,-2);
                //xử lý category
                $cat=explode('o',substr($offer->offercat,1,-1));
                $ccc = '';
                if($cat){
                    foreach($cat as $cat){                                       
                        @$ccc .= $oc_arr[$cat]->offercat.', ';
                       
                    }
                 }
                @$dt['category'] =substr($ccc,0,-2);

                $dt['description'] = $offer->description;
                $dt['convert_on'] = $offer->convert_on;
                $dt['traffic_source'] = $offer->traffic_source;
                $dt['restriced_traffics'] = $offer->restriced_traffics;
                $mdata[] = $dt;
            }
        }        
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