<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offersrequest extends CI_Controller { //admin
    private $page_load='';// chi dinh de load view nao. neu rong thi load mac dinh theo ten bang
    private $databk='';//data function run
    //phan trang
    private $base_url_trang = '';
    private $total_rows = 100;
    private $per_page =30;
    private $pagina_uri_seg=4;
    ///
    public $pub_config='';
    private $base_key = '';
    
    function __construct(){
        parent::__construct();
        $this->load_thuvien();    
        $this->base_key =$this->config->item('base_key');
        /*
        //tạo memcached
        $m = new Memcached();
        $m->addServer('127.0.0.1', 11211);
        if($this->uri->segment(3)=='offer'){
            $m->set($this->base_key.'_offer_admin_edit','ok',300);
        }        
        //end memcached
          */  
        //$this->check_admin();
        
        if(!$this->session->userdata('adlogedin')){           
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        }else{
            $this->session->set_userdata('upanh',1);
        }
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->managerid=$this->session->userdata('aduserid');
       
    }
    
    function search(){         
        if($_POST){            
            //keycode//hien dang dang serach user
            $oid = $this->input->post('oid');  
            $pid = $this->input->post('pid');  
                       
            if($oid){
                $orsearch['offerid'] = $oid;
            }else{
                unset($orsearch['offerid']);
            }
            if($pid){
                $orsearch['userid'] = $pid;
            }else{
                unset($orsearch['userid']);
            }
           
            if($orsearch) {
                $this->session->set_userdata('orsearch',$orsearch);
            }else{
                $this->session->unset_userdata('orsearch');
            } 
                           
            redirect($this->uri->segment(1).'/offersrequest/orlist');
             
        }
        
        
    } 
    
    function orlist($offset=0){
        $this->loffersRequest($offset);
    }
    //offer reqeust 
   
    function loffersRequest($offset=0){
        
        //kieerm tra session
        if($this->session->userdata('table12')!='request'){           
            $this->session->unset_userdata('orsearch');
            $this->session->set_userdata('table12','request');
        }
        $dk=1;       
        $where ='WHERE 1 = 1';
      
        $orsearch = $this->session->userdata('orsearch');//arrray
        
        if($orsearch){
           foreach($orsearch as $key => $value){
                $where .=" AND $key = $value";
           }
        }
       //////////////////////////////
       $qr = "
            SELECT cpalead_request.*
            FROM cpalead_request
            INNER JOIN cpalead_users ON cpalead_users.id = cpalead_request.userid            
            INNER JOIN cpalead_manager ON (cpalead_users.manager = cpalead_manager.id) AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            $where
            ORDER BY cpalead_request.id DESC 
            LIMIT $offset,$this->per_page
        ";          
        $dt = $this->db->query($qr)->result();   
        //lay soos luong trang
        $qr = "
            SELECT COUNT(*) as total
            FROM cpalead_request
            INNER JOIN cpalead_users ON cpalead_users.id = cpalead_request.userid
            INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            
            $where            
        "; 

        //////////////////////    

        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'); 
        $this->phantrang();  

        $this->users = $this ->Home_model->get_one('manager',array('id'=>$this->managerid));
        if($this->users->parrent>0){ 
            $pg ='manager/content/request_list_sub.php';
        }else{
            $pg ='manager/content/request_list.php';
        }        
        $content= $this->load->view($pg,array('dulieu'=>$dt),true);        
        $this->load->view('manager/index',array('content'=>$content));
        
        
    }
    
 

      
    function load_thuvien(){
        $this->load->helper(array( 'alias_helper','text','form'));
        $this->load->model("Admin_model");        
    }
    function phantrang(){
        $this->load->library('pagination');// da load ben tren
        $config['base_url'] =$this->base_url_trang;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->pagina_uri_seg;
        $config['num_links'] = 7;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_page">';//div cho chu <<
        $config['first_tag_close'] = '</li>';//div cho chu <<
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<li class="last_page">';
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
        $config['cur_tag_open'] = '<li class="active"><a href=#>';
        $config['cur_tag_close'] = '</a></li>';
        //--so 
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //-----
        $this->pagination->initialize($config);
    
    }
   
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */