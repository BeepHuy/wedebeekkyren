<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smartlinks extends CI_Controller {   
   
    private $mensenger='';    
    private $per_page = 30;
    public $total_rows = 6;   
    public $pub_config= '';
    public $member = '';
    public $member_info = '';
    private $pagina_uri_seg =3;
    private $pagina_baseurl = 's';
    
    function  __construct(){
        parent::__construct();
        //$this->load->model('Home_model'); 
       // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        if($this->session->userdata('logedin')){
            $this->member=$this->Home_model->get_one('users',array('id'=>$this->session->userdata('userid')));
            $this->member_info = unserialize($this->member->mailling);
        }elseif($this->uri->segment(3)!='in'&&$this->uri->segment(3)!='up'){
            redirect('v2/sign/in');            
        }
       // $this->setting= unserialize(file_get_contents('setting_file/setting.txt'));
        //$this->Home_model->get_one('users',array('id'=>$this->session->userdata('userid')));
        
    }
    function index(){
        echo 1234;
        //$this->account();
    }
    function ajorder(){
        $sort = trim($this->input->post('data'));
        if($sort){
            $this->session->set_userdata('sort_offer',$sort);
        }
    }
    function list_offers($offset=0){
        $uid = $this->member->id;
        $where = "`show` = 1";
        $where .= " AND smtype = 3";
        //xử lý bộ lọc oName oCountry oCat 
        $ct = $this->session->userdata('oCountry');
        $cat = $this->session->userdata('oCat');
        $opaymterm = $this->session->userdata('opaymterm');
        $oName = trim($this->session->userdata('oName'));
        //kieerm tra
        $oName_Like = '';
        if($opaymterm){
            $t=0;
            $mp = '(';
            foreach($opaymterm as $opaymterm){
                $t++;                
                if($t==1){
                    $mp .=$opaymterm;
                }else{
                    $mp .=','.$opaymterm;
                }                
            }
            $mp .= ')';
            $where .= " AND paymterm in $mp "; 
        }
        if($oName){
            if(is_numeric($oName)){
                $where .= " AND id = $oName ";                
            }else{
                $oName_Like .=" AND title LIKE '%$oName%' ";
            }
            
        }
        $ct_Like = '';
        if($ct){
            $count = 0;
            foreach($ct as $ct){
                $count++;
                if($count==1){
                    $ct_Like .='country LIKE \'%o'.$ct.'o%\'';
                }else{
                    $ct_Like .=' OR country LIKE \'%o'.$ct.'o%\'';
                }                
            }
            
                $ct_Like = " AND (".$ct_Like." OR country LIKE '%oallo%')";
            
        }

        $cat_Like = '';
        if($cat){
            $count = 0;
            foreach($cat as $cat){
                $count++;
                if($count==1){
                    $cat_Like .='offercat LIKE \'%o'.$cat.'o%\'';
                }else{
                    $cat_Like .=' OR offercat LIKE \'%o'.$cat.'o%\'';
                }                
            }
            
            $cat_Like = "AND (".$cat_Like.")";
            
        }        

        //end xử lý bộ lcj
        //xuwr ly order by offer
        $sort_offer = $this->session->userdata('sort_offer');
        if($sort_offer){
            $sort_offer = explode('-',$sort_offer);
            $qr_sort =" $sort_offer[0] $sort_offer[1] ";
        }else{
            $qr_sort = ' `id` DESC ';
        }

        //lọc disable offer
        $disoff = " AND id not in (SELECT distinct  offerid FROM cpalead_disoffer WHERE usersid = $uid) ";
        //get offer//
        $qr = "SELECT cpalead_offer.*,
                    CASE cpalead_offer.request 
                        WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid limit 1)
                        ELSE 'Approved'
                        END AS status
                    FROM (`cpalead_offer`) 
                    WHERE $where $ct_Like $cat_Like $oName_Like $disoff  
                    ORDER BY  $qr_sort
                    LIMIT $offset,$this->per_page
                    ";
        $data['offer'] = $this->db->query($qr)->result();
        
        //phan trang
        $qr  = "SELECT COUNT(*) as total
                FROM `cpalead_offer`
                WHERE $where $ct_Like $cat_Like $oName_Like $disoff  
        ";
        $tt = $this->db->query($qr)->row();        
        $this->total_rows = $tt->total;
        $this->phantrang();
        //end phan trang
        //$this->db->limit($this->per_page,$offset);
        $data['category'] = $this->Home_model->get_data('offercat',array('show'=>1));
        $data['country'] = $this->Home_model->get_data('country',array('show'=>1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm',array('show'=>1));  
        $data['totals'] = $this->total_rows;
        $content =$this->load->view('smartlinks/smartlinks.php',$data,true); 
        $this->load->view('default/vindex.php',array('content'=>$content)); 
    }
    function available($offset=0){
        $uid = $this->member->id;
        //$where = array('show'=>1);
        //xử lý bộ lọc oName oCountry oCat
        $ct = $this->session->userdata('oCountry');
        $cat = $this->session->userdata('oCat');
        $opaymterm = $this->session->userdata('opaymterm');
        $oName = $this->session->userdata('oName');
        //kieerm tra
        $where = '';
        if($opaymterm){
            $t=0;
            $mp = '(';
            foreach($opaymterm as $opaymterm){
                $t++;                
                if($t==1){
                    $mp .=$opaymterm;
                }else{
                    $mp .=','.$opaymterm;
                }                
            }
            $mp .= ')';
            $where .= " AND paymterm in $mp "; 
        }

        $oName_Like = '';
        if($oName){
            $oName_Like .=" AND title LIKE '%$oName%' ";
        }
        $ct_Like = '';
        if($ct){
            $count = 0;
            foreach($ct as $ct){
                $count++;
                if($count==1){
                    $ct_Like .='country LIKE \'%o'.$ct.'o%\'';
                }else{
                    $ct_Like .=' OR country LIKE \'%o'.$ct.'o%\'';
                }                
            }
            
                $ct_Like = "AND (".$ct_Like.")";
            
        }

        $cat_Like = '';
        if($cat){
            $count = 0;
            foreach($cat as $cat){
                $count++;
                if($count==1){
                    $cat_Like .='offercat LIKE \'%o'.$cat.'o%\'';                    
                }else{
                    $cat_Like .=' OR offercat LIKE \'%o'.$cat.'o%\'';
                }                
            }
            
            $cat_Like = "AND (".$cat_Like.")";
            
        }        

        //end xử lý bộ lcj
        //lọc disable offer
        $disoff = " AND id not in (SELECT distinct  offerid FROM cpalead_disoffer WHERE usersid = $uid) ";
        
        $qr = "SELECT cpalead_offer.* , 'Approved' as status
                FROM cpalead_offer
                WHERE `show` = 1 $ct_Like $cat_Like $oName_Like $where  $disoff AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid) ELSE 'Approved' END)='Approved'
                ORDER BY `id` DESC 
                LIMIT $offset,$this->per_page
                ";
        $data['offer'] = $this->db->query($qr)->result();
        //phan trang
        $qr  = "SELECT COUNT(*) as total
                FROM `cpalead_offer`
                WHERE `show` = 1 $ct_Like $cat_Like $oName_Like $where  $disoff AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid) ELSE 'Approved' END)='Approved'
        ";
        $tt = $this->db->query($qr)->row();     
        $this->pagina_uri_seg =4;   
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';
        $this->total_rows = $tt->total;

        $this->phantrang();
        //end phan trang
        //$this->db->limit($this->per_page,$offset);
        $data['category'] = $this->Home_model->get_data('offercat',array('show'=>1));
        $data['country'] = $this->Home_model->get_data('country',array('show'=>1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm',array('show'=>1));        
        $data['totals'] = $this->total_rows;
        $content =$this->load->view('smartlinks/list_offers.php',$data,true); 
        $this->load->view('default/vindex.php',array('content'=>$content)); 
    }
    function live(){
        $this->phantrang();
        $data['category'] = $this->Home_model->get_data('offercat',array('show'=>1));
        $data['country'] = $this->Home_model->get_data('country',array('show'=>1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm',array('show'=>1));  
        $content =$this->load->view('smartlinks/list_offers.php',$data,true); 
        $this->load->view('default/vindex.php',array('content'=>$content)); 
    }
    // lưu giá trị lọc offer qua jaax và get list offer mới
    function ajax_serach_offer(){
        $name = $this->input->post('name');
        $gt = $this->input->post('gt');
        if($name){
           $this->session->set_userdata($name,$gt);
        }
        echo 1;
        //Array ( [gt] => Array ( [0] => 5 [1] => 6 [2] => 7 ) [name] => cat ) 
        //[name] =>country 
    }
    function request($id=0){
        $url = $_SERVER['HTTP_REFERER'];
        //////////////reqeust offer
        if($id){
            if($_POST){                        
                $this->db->insert('request',
                array(
                    'crequest'=>$this->input->post('request',true),
                    'status' =>'Pending',
                    'userid'=>$this->member->id,
                    'offerid'=>$id,
                    'check_trung'=>'smlinks-'.$this->member->id.'-'.$id,
                    'ip'=>$this->input->ip_address()                
                )
                );
                
            }

        }
        
        redirect($url);
///end request offer 
    }
    function offer_view($id=0){          
         
        $id = (int)$id;   
        if(!$id)
           $id = (int)$this->input->get_post('offer_id');      
           $off = $this->Home_model->get_one('offer',array('show'=>1,'id'=>$id));           
           if($off){
               $country = 'VN';
               
               ///mac dinh approved
               $status = 'Approved';
               if($off->request){
                   $status = 'none';
                   $this->db->select('status');
                   $rq=$this->Home_model->get_one('request',array('userid'=>$this->session->userdata('userid'),'offerid'=>$off->id));
                   if(!empty($rq)){
                      $status =  $rq->status;
                   }
               }
               
               $offercat = $this->Home_model->get_data('offercat');
               foreach($offercat as $offercat){
                   $moffercat[$offercat->id] = $offercat->offercat;
               } 
            
               $content =$this->load->view('smartlinks/campaign_view.php',array('offer'=>$off,'offercat'=>$moffercat,'status'=>$status),true);
           }else{
               $content = 'Offer now found!';
           }
            
           $this->load->view('default/vindex.php',array('content'=>$content)); 
           
           
    }

    function phantrang(){
        $this->load->library('pagination');
        $config['base_url'] = $this->pagina_baseurl;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->pagina_uri_seg ;
        $config['num_links'] = 6;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li  class="page-item">';//div cho chu <<
        $config['first_tag_close'] = '</li>';//div cho chu <<
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<li class="last_pag">';
        $config['last_tag_close'] = '</li>';
        //-------next-
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        //------------preview
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
       // ------------------cu?npage
        $config['cur_tag_open'] = '<li class="page-item active" aria-current="page"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</li>';
        //--so 
        $config['num_tag_open'] = '<li  class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="page-link"';
        
        $this->pagination->initialize($config);
    }
 

}
