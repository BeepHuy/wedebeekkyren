<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pubcap extends CI_Controller { //admin
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
        $this->users = $this->Admin_model->get_one('cpalead_manager',array('id'=>$this->session->userdata('aduserid')));
    
       
    }   
    function delete($id){
        $this->db->where('id',(int)$id)->delete('pubcap');
        redirect($_SERVER['HTTP_REFERER']);
    }
    function edit($id){
        $data = $this->db->where('id',(int)$id)->get('pubcap')->row();
        $content= $this->load->view('pubcap/pubcap_edit.php',array('dulieu'=>$data),true);        
        $this->load->view('manager/index',array('content'=>$content));     
    }
    function store(){
        $urlRedirect = $_SERVER['HTTP_REFERER'];
        $data = array(
            'type' => 'success',
            'message' => ''
        );
        if($_POST){
            $id = (int)$this->input->post('id');
            $offerid = (int)$this->input->post('offerid');
            $usersid = (int)$this->input->post('usersid');
            $capped = (int)$this->input->post('capped');
            $sub2 = $this->input->post('sub2');
            $pubcapData = [
                'usersid' => $usersid,
                'offerid' => $offerid,
                'capped' => $capped,
                'sub2' => $sub2                
            ];
            if($id){
                $this->db->where('id',$id)->update('pubcap', $pubcapData);               
                $data = array(
                    'type' => 'success',
                    'message' => 'Update success!'
                );
                $urlRedirect = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/pubcapList');
            } else{                
                $condition = ['offerid' => $offerid,'usersid' => $usersid];
                if($sub2) $condition['sub2'] = $sub2;
                $check = $this->db->where($condition)->from('pubcap')->count_all_results();
                if($check>0){
                    $mess = 'Duplicate UserId and Offerid';
                    $data = array(
                        'type' => 'danger',
                        'message' => 'Duplicate UserId and Offerid'
                    );
                    $urlRedirect = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/pubcapList');
                }else{
                    $this->db->insert('pubcap',$pubcapData);
                    $data = array(
                        'type' => 'success',
                        'message' => 'Insert Success'
                    );
                }               
            }
                
        }
        $this->session->set_flashdata('alert',$data);
        redirect($urlRedirect);
    }    
    function pubcapList($offset=0){
        $dk=1;       
        $where =$like= '';
        // $wsearch = $this->session->userdata('wsearch');
        // $key = $this->session->userdata('likedsearch');
        if(!empty($key)){
            if(is_numeric($key)){ 
                $where .= " WHERE usersid=$key";//xử lý chung nếu k có iduser 
            }else{ //tamj thoiwf k co tim theo email
                //$like .= 
                //$cat_Like .='offercat LIKE \'%o'.$cat.'o%\'';          
            }
        }
        if(!empty($wsearch)) {
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
            SELECT cpalead_pubcap.*,cpalead_users.email,cpalead_offer.title as offername
            FROM cpalead_pubcap
            INNER JOIN cpalead_users ON (cpalead_users.manager = $this->managerid OR cpalead_users.manager IN (SELECT id FROM cpalead_manager WHERE cpalead_manager.parrent = $this->managerid)) AND cpalead_users.id = cpalead_pubcap.usersid
            LEFT JOIN cpalead_offer ON cpalead_offer.id = cpalead_pubcap.offerid
            $where
            ORDER BY cpalead_pubcap.id DESC 
            LIMIT $offset,$this->per_page
        ";          
        $dt = $this->db->query($qr)->result();   
        //lay soos luong trang
        $qr = "
            SELECT COUNT(*) as total
            FROM cpalead_pubcap
            INNER JOIN cpalead_users ON (cpalead_users.manager = $this->managerid OR cpalead_users.manager IN (SELECT id FROM cpalead_manager WHERE cpalead_manager.parrent = $this->managerid)) AND cpalead_users.id = cpalead_pubcap.usersid
            $where            
        "; 
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'); 
        $this->phantrang();    
        $content= $this->load->view('pubcap/pubcap.php',array('dulieu'=>$dt,'dk'=>$dk),true);        
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