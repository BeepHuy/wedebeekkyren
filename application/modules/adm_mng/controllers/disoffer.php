<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disoffer extends CI_Controller { //admin
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
            exit();
        }else{
            $this->session->set_userdata('upanh',1);
        }
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->managerid=$this->session->userdata('aduserid');
       
    } 
   
    function index($table='',$offset=0){
        $dk=1;       
        $where =$like= '';
        $wsearch = $this->session->userdata('wsearch');
        $key = $this->session->userdata('likedsearch');
        if($key){
            if(is_numeric($key)){ 
                $where .= " WHERE usersid=$key";//xử lý chung nếu k có iduser 
            }else{ //tamj thoiwf k co tim theo email
                //$like .= 
                //$cat_Like .='offercat LIKE \'%o'.$cat.'o%\'';          
            }
        }
        if($wsearch) {
            if($where) $where .=" AND ($wsearch)";
            else $where .= "WHERE $wsearch ";
        }
        /*
        $qr = "
            SELECT * 
            FROM cpalead_disoffer
            $where
            ORDER BY `id` DESC 
            LIMIT $offset,$this->per_page
        "; 
        */ 
        $qr = "
            SELECT cpalead_disoffer.*,cpalead_users.email
            FROM cpalead_disoffer
            INNER JOIN cpalead_users ON cpalead_users.manager = $this->managerid AND cpalead_users.id = cpalead_disoffer.usersid
            $where
            ORDER BY cpalead_disoffer.id DESC 
            LIMIT $offset,$this->per_page
        ";          
        $dt = $this->db->query($qr)->result();   
        //lay soos luong trang
        $qr = "
            SELECT COUNT(*) as total
            FROM cpalead_disoffer
            INNER JOIN cpalead_users ON cpalead_users.manager = $this->managerid AND cpalead_users.id = cpalead_disoffer.usersid
            $where            
        "; 
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'); 
        $this->phantrang();    
        $content= $this->load->view('manager/content/disoffer_list.php',array('dulieu'=>$dt,'dk'=>$dk),true);        
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