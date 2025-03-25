<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mng_report extends CI_Controller { //admin
    private $page_load='';// chi dinh de load view nao. neu rong thi load mac dinh theo ten bang
    private $databk='';//data function run
    //phan trang
    private $base_url_trang = '#';
    private $total_rows = 100;
    private $per_page =30;
    private $pagina_uri_seg=3;
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

    }


    //end get all user
    function rvdata(){//chuyển trạng thái declined và approved
        $ac = $this->input->post('action');
        $uid = $this->input->post('uid');
        if(!empty($uid)){
            if($ac=='approved'){
                $this->db->where(array('status !='=>1));
                $this->db->where_in('id',$uid);
                $dt = $this->db->get('tracklink')->result();//lấy dữ liệu lead cần sửa
                if($dt){
                    $Aruserid =$ArtrackID= array();
                    foreach($dt as $dt){
                        if(!empty($Aruserid[$dt->userid])){
                            $Aruserid[$dt->userid] +=$dt->amount2;
                            $ArtrackID[$dt->userid][]=$dt->id;
                        }else{
                            $Aruserid[$dt->userid] =$dt->amount2;
                            $ArtrackID[$dt->userid][]=$dt->id;
                        }
                    }
                    if($Aruserid){
                        foreach($Aruserid as $Userid=>$amount){//$Userid là id của user
                            //update vào user
                            $this->db->where('id', $Userid)
                                ->set('curent', "curent +$amount", FALSE)
                                ->set('balance', "balance +$amount", FALSE)
                                ->update('users');

                            //update vào tracklink
                            $this->db->where_in('id',$ArtrackID[$Userid]);
                            $this->db->update('tracklink',array('status'=>1));

                        }
                    }
                }
            }elseif($ac=='declined'){//status=2 declined
                $this->db->where(array('status !='=>2));
                $this->db->where_in('id',$uid);
                $dt = $this->db->get('tracklink')->result();//lấy dữ liệu lead cần sửa
                if($dt){
                    $Aruserid =$ArtrackID= array();
                    foreach($dt as $dt){
                        if(!empty($Aruserid[$dt->userid])){
                            $Aruserid[$dt->userid] +=$dt->amount2;
                            $ArtrackID[$dt->userid][]=$dt->id;
                        }else{
                            $Aruserid[$dt->userid] =$dt->amount2;
                            $ArtrackID[$dt->userid][]=$dt->id;
                        }
                    }
                    if($Aruserid){
                        foreach($Aruserid as $Userid=>$amount){//$Userid là id của user
                            //update vào user
                            $this->db->where('id', $Userid)
                                ->set('curent', "curent -$amount", FALSE)
                                ->set('balance', "balance -$amount", FALSE)
                                ->update('users');

                            //update vào tracklink
                            $this->db->where_in('id',$ArtrackID[$Userid]);
                            $this->db->update('tracklink',array('status'=>2));

                        }
                    }
                }
            }

        }
        $this->session->set_userdata('updatedone','<div class="alert alert-success" role="alert"><a href="#" class="alert-link">Successfully updated</a></div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    function index($offset=0){
        $mid = $this->session->userdata('aduserid');//idmanagẻ
        $data =$this->locdulieu();
        $groupby = '';
        $where = ' AND flead =1 ';
        if(!empty($data['offerid'])){
            $where .= " AND offerid =". (int)$data['offerid'];
        }
        if(!empty($data['userid'])){
            $where .= " AND userid =". (int)$data['userid'];
        }
        if(!empty($data['amount2'])){
            $where .= " AND amount2 >". (int)$data['amount2'];
        }
        if(!empty($data['fraud_score'])){
            $where .= " AND fraud_score >". (int)$data['fraud_score'];
        }
        if(!empty($data['status']&&$data['status']!='all')){
            $where .= " AND cpalead_tracklink.status =". (int)$data['status'];
        }
        // group by thì phải lấy view khác do nhóm và count
        $view = '';
        if(!empty($data['group_oid'])){
            //querry khác và láy view khác
            $view = '_group';

            $qr = "
                SELECT offerid,oname,userid,count(id) as click,sum(flead) as lead, count(DISTINCT ip) as uniq, sum(amount) as pay
                FROM `cpalead_tracklink`
                WHERE userid IN (SELECT `id` FROM `cpalead_users` WHERE `manager` =$mid) AND date>=? AND date<? $where
                group by offerid,userid
                LIMIT $offset,$this->per_page
                ";

            $data['dulieu'] = $this->db->query($qr,array($data['from'],$data['to']))->result();

            //phân trang
            $qr  = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE  userid IN (SELECT `id` FROM `cpalead_users` WHERE `manager` =$mid) AND date>=? AND date<? $where";
            $this->total_rows = $this->db->query($qr,array($data['from'],$data['to']))->row()->total;
        }else{
            //query gốc lấy view gốc
            $qr = "
            SELECT *  FROM `cpalead_tracklink`
            WHERE userid IN (SELECT `id` FROM `cpalead_users` WHERE `manager` =$mid) AND date>=? AND date<? $where
            ORDER BY id DESC
            LIMIT $offset,$this->per_page
            ";
            $data['dulieu'] = $this->db->query($qr,array($data['from'],$data['to']))->result();
            //phân trang
            $qr  = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE  userid IN (SELECT `id` FROM `cpalead_users` WHERE `manager` =$mid) AND date>=? AND date<? $where";
            $this->total_rows = $this->db->query($qr,array($data['from'],$data['to']))->row()->total;
        }


        //phan trang
        $this->pagina_uri_seg =2;
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/';
        $this->phantrang();
        //end phan trangs
        $content= $this->load->view('mng_report'.$view,$data,true);
        $this->load->view('adm_mng/index',array('content'=>$content));
    }
    function filtdata(){//nhận post lọc dữ liệu
        if($_POST['from'] && !empty($_POST['submit'])){
            $fr = $this->input->post('from');
            $to = $this->input->post('to');
            $offerid= $this->input->post('offerid');
            $userid= $this->input->post('userid');
            $amount2= $this->input->post('amount2');
            $fraud_score= $this->input->post('fraud_score');
            $status= $this->input->post('status');
            $group_oid= $this->input->post('group_oid');
            if($fr){
                $this->session->set_userdata('from',$fr );
            }
            if($to){
                $this->session->set_userdata('to',$to );
            }

            if($userid){
                $this->session->set_userdata('userid',$userid);
            }else{
                $this->session->unset_userdata('userid');
            }

            if($offerid){
                $this->session->set_userdata('offerid',$offerid);
            }else{
                $this->session->unset_userdata('offerid');
            }
            if($amount2){
                $this->session->set_userdata('amount2',$amount2);
            }else{
                $this->session->unset_userdata('amount2');
            }
            if($fraud_score){
                $this->session->set_userdata('fraud_score',$fraud_score);
            }else{
                $this->session->unset_userdata('fraud_score');
            }
            if($status=='all'){
                $this->session->unset_userdata('status');
            }elseif($status==1||$status==2){
                $this->session->set_userdata('status',$status);
            }
            if($group_oid){
                $this->session->set_userdata('group_oid',$group_oid);
            }else{
                $this->session->unset_userdata('group_oid');
            }
        }elseif(!empty($_POST['reset'])){
            $this->session->unset_userdata('userid');
            $this->session->unset_userdata('offerid');
            $this->session->unset_userdata('from');
            $this->session->unset_userdata('to');
            $this->session->unset_userdata('amount2');
            $this->session->unset_userdata('fraud_score');
            $this->session->unset_userdata('status');
            $this->session->unset_userdata('group_oid');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    function locdulieu(){
        //lấy giữu liệu cho bộ lọc
        if($this->session->userdata('from')){
            $data['from']  = $this->session->userdata('from');
            $data['to']  = $this->session->userdata('to');
        }else{
            $data['from']   = date("Y-m-d",strtotime('6 days ago'));//cách đây 1 tuần;
            $data['to']  = date("Y-m-d");//ngay hoom nay
            $this->session->set_userdata('from',$data['from'] );
            $this->session->set_userdata('to',$data['to']);
        }
        $group_oid = $this->session->userdata('group_oid');
        if($group_oid){
            $data['group_oid']= $group_oid;
        }
        $offerid = $this->session->userdata('offerid');
        if($offerid){
            $data['offerid']= $offerid;
        }
        $userid = $this->session->userdata('userid');
        if($userid){
            $data['userid']= $userid;
        }

        $amount2 = $this->session->userdata('amount2');
        if($amount2){
            $data['amount2']= $amount2;
        }
        $fraud_score = $this->session->userdata('fraud_score');
        if($fraud_score){
            $data['fraud_score']= $fraud_score;
        }
        $status = $this->session->userdata('status');
        if($status=='all'){
            unset($data['status']);
        }elseif($status==1||$status==2){
            $data['status']= $status;
        }else{
            $data['status']= '';
        }
        $data['to'] = date('Y-m-d', strtotime('+1 day', strtotime($data['to'])));

        return $data;
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