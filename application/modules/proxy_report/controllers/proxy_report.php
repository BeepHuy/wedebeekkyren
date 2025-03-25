<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proxy_report extends CI_Controller { //admin
    private $page_load='';// chi dinh de load view nao. neu rong thi load mac dinh theo ten bang
    private $databk='';//data function run
    //phan trang
    private $base_url_trang = '#';
    private $total_rows = 100;
    private $per_page =50;
    ///
    public $pub_config='';
    private $base_key = '';

    function __construct(){
        parent::__construct();
        $this->load_thuvien();
        $this->base_key =$this->config->item('base_key');
        $this->load->helper('excel');
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
    function search(){
        $searchSubid  = $this->input->post('searchSubid');
        $uid = array_unique(array_values(array_filter(explode(PHP_EOL, $searchSubid))));
        $ac = $this->input->post('action');

    }
    function rvdata(){
        $ac = $this->input->post('action');
        $uid = $this->input->post('uid');
        $this->action($ac,$uid);
    }
    function action($ac,$uid){//chuyển trạng thái declined và approved
    // do ref chỉ cộng vào avaiable nên sẽ có trường hợp à số tổng total(balance đang hiện ở acc mem) sẽ bị lệch dữ liệu
    //do tự nhiên có thằng từ ref cộng vào avaiable
        //khong cho sub manager thực thi mục này
        $this->db->trans_strict(FALSE);
        if(!empty($uid)){
            if($ac=='approved') $status = 1;
            elseif($ac=='declined') $status = 2;
            elseif($ac=='pay') $status = 3;

            $this->db->where(array('status !='=>$status));
            $this->db->where_in('id',$uid);
            $dt = $this->db->get('tracklink')->result();//lấy dữ liệu lead cần sửa
            $this->updateData($dt,$ac);

        }
        $this->session->set_userdata('updatedone','<div class="alert alert-success" role="alert"><a href="#" class="alert-link">Successfully updated</a></div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    function randomPay($randomPay,$ac){
        if($ac=='approved') $status = 1;
        elseif($ac=='declined') $status = 2;
        elseif($ac=='pay') $status = 3;

        $data =  $this->getData(null,$status,1);
        if(!empty($data['dulieu'])){
            $total_amount = 0;
            $arrData = array();
            foreach($data['dulieu'] as $tempdata){
                $total_amount += $tempdata->amount2;
                //pay: số tiền phải nhỏ hơn random pay, decline thì ngược lại
                //khi chạm ngưỡng 
                if($total_amount > $randomPay){
                    //decline thì cộng thêm 1 data này
                    if($ac == 'declined'){
                        $arrData []  = $tempdata;
                    }
                    //thoát vòng lặp
                    break;
                }
                $arrData []  = $tempdata;
                
            }
             $this->updateData($arrData,$ac);
             $this->session->set_userdata('updatedone','<div class="alert alert-success" role="alert"><a href="#" class="alert-link">Successfully updated</a></div>');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    function updateData($dt,$ac){
        //start action
        if($ac=='approved'){
            //==> chính là nút pending
            //get những cái chưa approved (pending)
            //pendng:status= 1, Declined status=2 , 3 pay//lấy status !=1;

            if($dt){
                $Aruserid =$ArtrackID= array();
                foreach($dt as $dt){
                    $avaialbe = $curent= $balance = 0;
                    $curent = $dt->amount2;
                    if($dt->status==3){//chuyển từ pay sang pending - avaialbe, +current
                        $avaialbe=  $dt->amount2;
                    }elseif($dt->status==2){//chuyển từ decline sang pending + balance, +current
                        $balance =$dt->amount2;
                    }

                    @$Aruserid[$dt->userid]['balance'] +=$balance;
                    @$Aruserid[$dt->userid]['curent'] +=$curent;
                    @$Aruserid[$dt->userid]['avaialbe'] +=$avaialbe;

                    $ArtrackID[$dt->userid][]=$dt->id;
                }
                if($Aruserid){
                    foreach($Aruserid as $Userid=>$amount){//$Userid là id của user
                        $this->db->trans_start();
                        $balance = (double)$amount['balance'];
                        $curent = (double)$amount['curent'];
                        $avaialbe = (double)$amount['avaialbe'];
                        //update vào user
                        $this->db->where('id', $Userid)
                            ->set('balance', "balance +$balance", FALSE)
                            ->set('curent', "curent +$curent", FALSE)
                            ->set('available', "available -$avaialbe", FALSE)
                            ->update('users');
                        ///update ref
                        $pref = $avaialbe*0.3;
                        $qr =  "
                            UPDATE cpalead_users
                                INNER JOIN cpalead_users t ON cpalead_users.id = t.ref
                                SET cpalead_users.available = cpalead_users.available - $pref
                                WHERE t.id = $Userid
                                ";
                        $this->db->query($qr);

                        //update vào tracklink
                        $this->db->where_in('id',$ArtrackID[$Userid]);
                        $this->db->update('tracklink',array('status'=>1));
                        $this->db->trans_complete();

                    }
                }
            }

        }elseif($ac=='declined'){//status=2 declined               
            if($dt){
                $Aruserid =$ArtrackID= array();

                foreach($dt as $dt){
                    $avaialbe = $curent= $balance = 0;
                    $balance = $dt->amount2;
                    if($dt->status==3){//chuyển từ pay sang pending - avaialbe, +current
                        $avaialbe=  $dt->amount2;
                    }elseif($dt->status==1){//chuyển từ decline sang pending + balance, +current
                        $curent =$dt->amount2;
                    }

                    @$Aruserid[$dt->userid]['balance'] +=$balance;
                    @$Aruserid[$dt->userid]['curent'] +=$curent;
                    @$Aruserid[$dt->userid]['avaialbe'] +=$avaialbe;


                    $ArtrackID[$dt->userid][]=$dt->id;
                }
                if($Aruserid){
                    foreach($Aruserid as $Userid=>$amount){//$Userid là id của user
                        $this->db->trans_start();
                        $balance = (double)$amount['balance'];
                        $curent = (double)$amount['curent'];
                        $avaialbe = (double)$amount['avaialbe'];
                        //update vào user
                        $this->db->where('id', $Userid)
                            ->set('balance', "balance -$balance", FALSE)
                            ->set('curent', "curent -$curent", FALSE)
                            ->set('available', "available -$avaialbe", FALSE)
                            ->update('users');
                            ///update ref
                            $pref = $avaialbe*0.3;
                            $qr =  "
                                UPDATE cpalead_users
                                    INNER JOIN cpalead_users t ON cpalead_users.id = t.ref
                                    SET cpalead_users.available = cpalead_users.available - $pref
                                    WHERE t.id = $Userid
                                    ";
                            $this->db->query($qr);

                        //update vào tracklink
                        $this->db->where_in('id',$ArtrackID[$Userid]);
                        $this->db->update('tracklink',array('status'=>2));
                        $this->db->trans_complete();

                    }
                }
            }
        }elseif($ac=='pay'){                
            if($dt){
                $Aruserid =$ArtrackID= array();
                foreach($dt as $dt){
                    $avaialbe = $curent= $balance = 0;

                    $avaialbe = $dt->amount2;
                    if($dt->status==2){//decline sang pay
                        $balance =  $dt->amount2;
                    }elseif($dt->status==1){//chuyển từ pending sang pay
                        $curent =$dt->amount2;
                    }

                    @$Aruserid[$dt->userid]['balance'] +=$balance;
                    @$Aruserid[$dt->userid]['curent'] +=$curent;
                    @$Aruserid[$dt->userid]['avaialbe'] +=$avaialbe;


                    $ArtrackID[$dt->userid][]=$dt->id;
                }
                if($Aruserid){
                    foreach($Aruserid as $Userid=>$amount){//$Userid là id của user
                        $this->db->trans_start();
                        $balance = (double)$amount['balance'];
                        $curent = (double)$amount['curent'];
                        $avaialbe = (double)$amount['avaialbe'];
                        //update vào user
                        $this->db->where('id', $Userid)
                            ->set('balance', "balance +$balance", FALSE)
                            ->set('curent', "curent -$curent", FALSE)
                            ->set('available', "available +$avaialbe", FALSE)
                            ->update('users');
                        //update cho ref
                        $pref = $avaialbe*0.3;
                        $qr =  "
                            UPDATE cpalead_users
                                INNER JOIN cpalead_users t ON cpalead_users.id = t.ref
                                SET cpalead_users.available = cpalead_users.available+$pref
                                WHERE t.id = $Userid
                                ";
                        $this->db->query($qr);

                        //update vào tracklink
                        $this->db->where_in('id',$ArtrackID[$Userid]);
                        $this->db->update('tracklink',array('status'=>3));
                        $this->db->trans_complete();

                    }
                }


            }

        }
        //End action
    }
    function index($offset=0){
        $data = $this->getData($offset);
        $this->renderView($data);

    }
    function renderView($data){
        $this->total_rows = $data['totalRows'];
        $this->pagina_uri_seg =3;
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/';
        $this->phantrang();
        //end phan trangs
        $data['networks'] = $this->Home_model->get_data('network',array(),array(),array('title','ASC'));
        $content= $this->load->view('proxy_report',$data,true);
        if($this->managerid==1){
            $this->load->view('admin/index',array('content'=>$content));
        }else{
            $this->load->view('manager/index',array('content'=>$content));
        }
    }
    function exportExcel(){
        $alldata = $this->getData();
        if(!empty($alldata['dulieu'])){
            // Chuyển đổi dữ liệu thành mảng
            $data = array();
            foreach ($alldata['dulieu'] as $row) {
                $data[] = (array) $row;  // Chuyển đổi từng đối tượng thành mảng
            }
            // Định nghĩa tên cột
            $column_names = array('ID', 'S2', 'User ID', 'Offer ID', 'Offer Name', 'IP', 'Date', 'Amount', 'Fraud Score', 'Proxy', 'Referrer',
            'Status', 'User Language', 'OS Name', 'Browser', 'Device Type', 'Device Manufacturer');
            // Xuất dữ liệu ra Excel
            export_to_excel(date('Y-m-d').'_convert_Report.xlsx', $data, $column_names);
        }else{
            echo 'data empty!';
        }
        
    }
    private function getData($offset=null,$status = Null,$randomOrder = false){
        $data =$this->locdulieu();
        $where_manager = '';
        $manager_join = '';
        $where = ' AND flead =1 ';      
        if(!empty($data['userid'])){
            $where .= " AND userid =". (int)$data['userid'];
        }
        if(!empty($data['offerid'])){
            $where .= " AND offerid =". (int)$data['offerid'];
        }
        if(!empty($data['amount2'])){
            $where .= " AND amount2 >". (int)$data['amount2'];
        }
        if(!empty($data['fraud_score'])){
            $where .= " AND fraud_score >". (int)$data['fraud_score'];
        }
        if(!empty($data['status']&&$data['status']!='all')){
            $where .= " AND tl.status =". (int)$data['status'];
        }
        //lấy khác nó để chuyển sang nó
        if(!empty($status)){
            $where .= " AND tl.status !=". (int)$status;
        }
        if(!empty($data['network']&&$data['status']!='all')){
            $where .= " AND tl.idnet =". (int)$data['network'];
        }
        //xử lý cho manager//hiện giới hạn theo manager và sub
        // if($this->managerid>1){
        //     $manager_join  = "
        //     INNER JOIN cpalead_users ON cpalead_tracklink.userid = cpalead_users.id
        //     INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)

        //     ";
        // }
        //hiện full
        if($this->managerid>1){
            $manager_join  = "
            INNER JOIN cpalead_users ON tl.userid = cpalead_users.id
            INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id
            ";
        }
        $listSearchUid = $this->session->userdata('listSearchUid');
        $listSearchUid2 = $this->session->userdata('listSearchUid2');
        if(!empty($listSearchUid)){
            $where .= " AND tl.id IN {$listSearchUid}";
        }
        if(!empty($listSearchUid2)){
            $where .= " AND tl.s2 IN {$listSearchUid2}";
        }       
        if(!is_null($offset)) $limit = " LIMIT $offset,$this->per_page";
        else $limit = "";

       $duplicateSql = "";
        if(!empty($data['dupips']) && $data['dupips']==1){         
            $fr =  $data['from'].' 00:00:00';
            $t = $data['to'].' 23:59:59';
            $duplicateSql = " AND tl.ip IN (
                SELECT ip
                FROM cpalead_tracklink
                WHERE date BETWEEN '$fr' AND '$t' $where
                GROUP BY ip
                HAVING COUNT(ip) > 1
            )";
            $qr = "
            SELECT tl.id,tl.s2,tl.userid,tl.offerid,tl.oname,tl.ip,tl.date,tl.amount2,tl.saleAmount,tl.fraud_score,tl.proxy,tl.referrer,tl.countries
            ,tl.status,tl.user_language,tl.os_name,tl.browser,tl.device_type,tl.device_manuf
            FROM `cpalead_tracklink` tl
            $manager_join
            WHERE date BETWEEN ? AND ? $where
            $duplicateSql
            ORDER BY tl.ip, tl.id DESC
            $limit
            ";
        }else{
            $order_by = isset($randomOrder) && $randomOrder ? "ORDER BY RAND()" : "ORDER BY tl.id DESC";
            $qr = "
            SELECT tl.id,tl.s2,tl.userid,tl.offerid,tl.oname,tl.ip,tl.date,tl.amount2,tl.saleAmount,tl.fraud_score,tl.proxy,tl.referrer,tl.countries
            ,tl.status,tl.user_language,tl.os_name,tl.browser,tl.device_type,tl.device_manuf
            FROM `cpalead_tracklink` tl
            $manager_join
            WHERE date BETWEEN ? AND ? $where
            $order_by
            $limit
            ";
        }
        
        $data['dulieu'] = $this->db->query($qr,array($data['from']." 00:00:00",$data['to']." 23:59:59"))->result();
        //phan trang
        $qr  = "
        SELECT COUNT(*) as total  FROM `cpalead_tracklink` tl
        $manager_join
         WHERE date BETWEEN ? AND ? $where $duplicateSql";
        $data['totalRows'] = $this->db->query($qr,array($data['from']." 00:00:00",$data['to']." 23:59:59"))->row()->total;
        return  $data;
    }
    private function convertArrayToString($searchSubid){
        $listSearchUid = array_unique(array_values(array_filter(explode(PHP_EOL, trim($searchSubid)))));
        if(!empty($listSearchUid)){
            $v = '';
            $ct = count($listSearchUid);
            $i=0;
            foreach($listSearchUid as $listSearchUid){
                $i++;
                $v .='"'.trim($listSearchUid).'"';
                if($i!=$ct){
                    $v .=',';
                }

            }
            if($v){
                $listSearchUid = "({$v})";
            }

        }
        return $listSearchUid;
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
            $dupips= $this->input->post('dupips');
            $network= $this->input->post('network');
            $searchSubid = trim($this->input->post('searchSubid'));
            $listSearchUid= $this->convertArrayToString($searchSubid);
            
            $searchSubid2 = trim($this->input->post('searchSubid2'));
            $listSearchUid2 = $this->convertArrayToString($searchSubid2);

            if($fr){
                $this->session->set_userdata('from',$fr );
            }
            if($to){
                $this->session->set_userdata('to',$to );
            }

            if($listSearchUid){
                $this->session->set_userdata('searchSubid',$searchSubid);
                $this->session->set_userdata('listSearchUid',$listSearchUid);
            }else{
                $this->session->unset_userdata('listSearchUid');
                $this->session->unset_userdata('searchSubid');
            }
            if($listSearchUid2){
                $this->session->set_userdata('searchSubid2',$searchSubid2);
                $this->session->set_userdata('listSearchUid2',$listSearchUid2);
            }else{
                $this->session->unset_userdata('listSearchUid2');
                $this->session->unset_userdata('searchSubid2');
            }

            if($dupips){
                $this->session->set_userdata('dupips',$dupips);
            }else{
                $this->session->unset_userdata('dupips');
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
            }else{
                $this->session->set_userdata('status',$status);
            }
            if($network=='all'){
                $this->session->unset_userdata('network');
            }else{
                $this->session->set_userdata('network',$network);
            }
        }elseif(!empty($_POST['reset'])){
            $this->session->unset_userdata('userid');
            $this->session->unset_userdata('offerid');
            $this->session->unset_userdata('from');
            $this->session->unset_userdata('to');
            $this->session->unset_userdata('amount2');
            $this->session->unset_userdata('fraud_score');
            $this->session->unset_userdata('status');
            $this->session->unset_userdata('listSearchUid');
            $this->session->unset_userdata('dupips');
            $this->session->unset_userdata('network');
        }

        if(!empty($_POST['actionPay'])){
            $this->randomPay((int)$_POST['randomPay'],$_POST['actionPay']);
        }elseif(!empty($_POST['export'])){
            $this->exportExcel();
        }else
        redirect($_SERVER['HTTP_REFERER']);
    }
    function locdulieu(){
        if($this->session->userdata('table12')!='proxy_report'){
            $this->session->set_userdata('table12','proxy_report');
            $this->session->unset_userdata('userid');
            $this->session->unset_userdata('offerid');
            $this->session->unset_userdata('from');
            $this->session->unset_userdata('to');
            $this->session->unset_userdata('amount2');
            $this->session->unset_userdata('fraud_score');
            $this->session->unset_userdata('status');
            $this->session->unset_userdata('listSearchUid');
            $this->session->unset_userdata('dupips');
            $this->session->unset_userdata('network');
        }
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

        $dupips = $this->session->userdata('dupips');
        if($dupips){
            $data['dupips']= $dupips;
        }
        
        

        $status = $this->session->userdata('status');
        if($status=='all'){
            unset($data['status']);
        }elseif($status==1||$status==2||$status==3){
            $data['status']= $status;
        }else{
            $data['status']= '';
        }

        $network = $this->session->userdata('network');
        if($status=='all'){
            unset($data['network']);
        }else{
            $data['network']= $network;
        }
       // $data['to'] = date('Y-m-d', strtotime('+1 day', strtotime($data['to'])));

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
        $config['uri_segment'] = 2;
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