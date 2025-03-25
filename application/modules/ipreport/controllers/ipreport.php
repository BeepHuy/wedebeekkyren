<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ipreport extends CI_Controller { //admin
    private $page_load='';// chi dinh de load view nao. neu rong thi load mac dinh theo ten bang
    private $databk='';//data function run
    //phan trang
    private $base_url_trang = '#';
    private $total_rows = 100;
    private $per_page =500;
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

        if(!$this->session->userdata('adlogedin')||!$this->session->userdata('aduserid')){
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        }else{
            $this->session->set_userdata('upanh',1);
        }
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->managerid=$this->session->userdata('aduserid');
        $this->users = $this->Admin_model->get_one('cpalead_manager',array('id'=>$this->session->userdata('aduserid')));
        if($this->users->parrent>0){
            $url = $this->uri->segment(2);
            if($url=='rvdata'){
                echo 'Error Permission!!';
                //redirect($_SERVER['HTTP_REFERER']);
                exit();
            }
        }

    }
    function index(){
        redirect('ipreport/show');
    }
  
    function show($offset=0){        
        if($_POST){
            if($this->input->post('reset')){
               
                $this->session->unset_userdata('dtfrom');
                $this->session->unset_userdata('dtto');
                $this->session->unset_userdata('dtpubcheck');
                $this->session->unset_userdata('dtpubid');
                $this->session->unset_userdata('dtoid');
                $this->session->unset_userdata('ips');
                $this->session->unset_userdata('dtcheckdup');
                $this->session->unset_userdata('useragent');                
                
            }else{
                $from = $this->input->post('from',true);
                $to = $this->input->post('to',true);      
                $ips  = $this->input->post('ips');   
                $dtcheckdup  = $this->input->post('dtcheckdup');       
                $useragent  = $this->input->post('useragent');        
                $this->session->set_userdata('dtfrom',$from);
                $this->session->set_userdata('dtto',$to);                                
                $this->session->set_userdata('dtpubcheck',$this->input->post('pubcheck',true));
                $this->session->set_userdata('dtpubid',$this->input->post('pubid',true));
                $this->session->set_userdata('dtoid',$this->input->post('oid',true));               
                $this->session->set_userdata('ips',$ips);
                $this->session->set_userdata('dtcheckdup',$dtcheckdup);
                $this->session->set_userdata('useragent',$useragent);
               
                
            }
        }
        

        //trường hợp mới vào chưa có time
        if(!$this->session->userdata('dtfrom')){            
            $from= date('Y-m-d',time());
            $this->session->set_userdata('dtfrom',$from);
        }else{
            $from= $this->session->userdata('dtfrom');
        }
        if(!$this->session->userdata('dtto')){
            $to =date('Y-m-d',time());
            $this->session->set_userdata('dtto',$to);
        }else{
            $to= $this->session->userdata('dtto');
        }
        $where = "1 = 1 ";

        //managerr
        $aduserid = $this->session->userdata('aduserid');
        if($aduserid != 1){
            $where .= " AND userid in (SELECT id from cpalead_users WHERE manager = $aduserid )  ";
           
        }
        if($this->session->userdata('dtpubid')>0){
            $pubid = $this->session->userdata('dtpubid');
            $where .= " AND userid = $pubid";            
        }
        if($this->session->userdata('dtoid')>0){
            $oid = $this->session->userdata('dtoid');
            $where .= " AND offerid = $oid";
            
        }
        ///
        $ips = $this->session->userdata('ips');
        if(!empty($ips)){  
            $ips = array_unique(array_values(array_filter(explode(PHP_EOL, $ips))));                 
            $ips = '("'.implode('","',$ips).'")';       
            $where .= " AND ip IN $ips";
           
        }
        ////////////

        if(!empty($to) && !empty($from)){          
            if($this->session->userdata('dtcheckdup')){
                $uag = $sqluag = '';
                if($this->session->userdata('useragent')){
                    $uag = ',cpalead_tracklink.useragent';
                    $sqluag = ' AND cpalead_tracklink.useragent =tr1.useragent ';
                }
                $qr = "
                    SELECT * FROM 
                    (
                        SELECT COUNT(offerid) as dup,offerid,ip $uag
                        FROM cpalead_tracklink
                        WHERE $where AND date BETWEEN  '$from  00:00:00' AND '$to 23:59:59'
                        GROUP BY offerid,ip $uag HAVING COUNT(offerid)>1
                    ) tr1
                    INNER JOIN cpalead_tracklink ON tr1.offerid = cpalead_tracklink.offerid AND cpalead_tracklink.ip =tr1.ip  $sqluag
                    ORDER BY cpalead_tracklink.ip,cpalead_tracklink.id  $uag desc
                    LIMIT $offset,$this->per_page
                ";
                $data['dulieu'] = $this->db->query($qr)->result();
                $qr  = "
                SELECT COUNT(*) as total FROM 
                    (
                        SELECT COUNT(offerid) as dup,offerid,ip $uag
                        FROM cpalead_tracklink
                        WHERE $where AND date BETWEEN  '$from  00:00:00' AND '$to 23:59:59'
                        GROUP BY offerid,ip $uag HAVING COUNT(offerid)>1
                    ) tr1
                    INNER JOIN cpalead_tracklink ON tr1.offerid = cpalead_tracklink.offerid AND cpalead_tracklink.ip =tr1.ip $sqluag
                    
                ";
                $this->total_rows = $this->db->query($qr)->row()->total;

            }else{
                $qr = "
                    SELECT * 
                    FROM cpalead_tracklink
                    WHERE $where AND date BETWEEN  '$from  00:00:00' AND '$to 23:59:59'  
                    ORDER BY id desc
                    LIMIT $offset,$this->per_page
                ";
                $data['dulieu'] = $this->db->query($qr)->result();
                $qr  = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE $where AND date BETWEEN  '$from' AND '$to'  ";
                $this->total_rows = $this->db->query($qr)->row()->total;
            }
            
        }else{
            $data['dulieu'] = '';
        }        
            // print_r($data['dulieu']);return;
        ///end mới chưa post gì chọn 1 ngày
        
    
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';
        $this->phantrang();
        //end phan trangs
        $content= $this->load->view('ipreport',$data,true);
        if($this->managerid==1){
            $this->load->view('admin/index',array('content'=>$content));
        }else{
            $this->load->view('manager/index',array('content'=>$content));
        }       

    }
   
    function load_thuvien(){
        $this->load->helper(array( 'alias_helper','text','form'));
        $this->load->model("Admin_model");
    }
    function phantrang(){
        $this->load->library('pagination');// da load ben tren
        $config['base_url'] =$this->pagina_baseurl;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 3;
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