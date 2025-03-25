<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offers extends CI_Controller {   
   
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
        $this->load->model('Admin_model'); 
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
    function test(){
        
        echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";

        $browser = get_browser(null, true);
        print_r($browser);
    }
    function list_offers($offset=0){   
        $uid = $this->member->id;
        $where = "`show` = 1";
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
            $oName =mysql_real_escape_string($oName);            
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
                    WHERE $where $ct_Like $cat_Like $oName_Like $disoff AND smartoff =0 AND smartlink=0  
                    ORDER BY $qr_sort 
                    LIMIT $offset,$this->per_page
                    ";
        $data['offer'] = $this->db->query($qr)->result();
        
        //phan trang
        $qr  = "SELECT COUNT(*) as total
                FROM `cpalead_offer`
                WHERE $where $ct_Like $cat_Like $oName_Like $disoff AND smartoff =0 AND smartlink=0  
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
        $content =$this->load->view('offers/list_offers.php',$data,true); 
        $this->load->view('default/vindex.php',array('content'=>$content)); 
    }
    function listOfferByStatus($offset=0){  
        $rt = $this->uri->segment(3,''); 
        $uid = $this->member->id;
        $where = "`show` = 1";
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
            $oName =mysql_real_escape_string($oName);            
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
        // get pending or approved ofer
        $having = '';
        if($rt == 'pending'){
            $strSql = 'Pending';
            $where2 = " AND (cpalead_offer.request = 1 AND id in (SELECT offerid FROM cpalead_request WHERE userid =  $uid AND status = 'Pending' )) "; 
        } 
        else{
            $where2 = " AND (cpalead_offer.request = 0 OR (cpalead_offer.request = 1 AND id in (SELECT offerid FROM cpalead_request WHERE userid =  $uid AND status = 'Approved' ))) ";
            $strSql = 'Approved';
        }
        //get offer//
        $qr = "
        SELECT *, '$strSql' as status
        FROM cpalead_offer 
        WHERE $where $where2 $ct_Like $cat_Like $oName_Like $disoff AND smartoff =0 AND smartlink=0
        ORDER BY $qr_sort 
        LIMIT $offset,$this->per_page
        ";
        $data['offer'] = $this->db->query($qr)->result();
       
        //phan trang      
        $qr = "
        SELECT COUNT(*) as total
        FROM cpalead_offer 
        WHERE $where $where2 $ct_Like $cat_Like $oName_Like $disoff AND smartoff =0 AND smartlink=0       
        ";
        $tt = $this->db->query($qr)->row();        
        $this->total_rows = $tt->total;
        $this->pagina_baseurl = base_url('v2/offers/approved/');
        $this->pagina_uri_seg = 4;
        $this->phantrang();
        //end phan trang
        //$this->db->limit($this->per_page,$offset);
        $data['category'] = $this->Home_model->get_data('offercat',array('show'=>1));
        $data['country'] = $this->Home_model->get_data('country',array('show'=>1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm',array('show'=>1));  
        $data['totals'] = $this->total_rows;
        $content =$this->load->view('offers/list_offers.php',$data,true); 
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
                WHERE `show` = 1 AND smartoff =0 AND smartlink=0   $ct_Like $cat_Like $oName_Like $where  $disoff AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid) ELSE 'Approved' END)='Approved'
                ORDER BY `id` DESC 
                LIMIT $offset,$this->per_page
                ";
        $data['offer'] = $this->db->query($qr)->result();
        //phan trang
        $qr  = "SELECT COUNT(*) as total
                FROM `cpalead_offer`
                WHERE `show` = 1 AND smartoff =0 AND smartlink=0   $ct_Like $cat_Like $oName_Like $where  $disoff AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid) ELSE 'Approved' END)='Approved'
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
        $content =$this->load->view('offers/list_offers.php',$data,true); 
        $this->load->view('default/vindex.php',array('content'=>$content)); 
    }
    function live(){
        $this->phantrang();
        $data['category'] = $this->Home_model->get_data('offercat',array('show'=>1));
        $data['country'] = $this->Home_model->get_data('country',array('show'=>1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm',array('show'=>1));  
        $content =$this->load->view('offers/list_offers.php',$data,true); 
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
    function request($id = 0) {
        $url = $_SERVER['HTTP_REFERER'];
        if ($id) {
            if ($_POST) {
                // Bắt đầu transaction
                $this->db->trans_start();

                try {
                    $crequest = $this->input->post('crequest', true);
                    // Nếu là mảng, chuyển thành chuỗi
                    if (is_array($crequest)) {
                        $crequest = implode(', ', $crequest);
                    }
    
                    // Lấy dữ liệu các trường
                    $trafficurl = implode(', ', $this->input->post('trafficurl', true));
                    $subject    = $this->input->post('subject', true);
                    $message    = $this->input->post('message');
                    // Chuyển đổi các ký tự đặc biệt của tiếng Việt sang dạng phù hợp
                    $message    = $this->save_images_from_html($message);
    
                    $data = array(
                        'crequest'    => $crequest,
                        'status'      => 'Pending',
                        'userid'      => $this->member->id,
                        'offerid'     => $id,
                        'check_trung' => $this->member->id . '-' . $id,
                        'ip'          => $this->input->ip_address(),
                        'trafficurl'  => $trafficurl,
                        'subject'     => $subject,
                        'message'     => $message, // Lưu message dưới dạng HTML
                    );
    
                    // Thêm dữ liệu vào bảng request
                    $this->db->insert('request', $data);
    
                    // Kết thúc transaction
                    $this->db->trans_complete();
    
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception('Transaction Failed');
                    }
                } catch (Exception $e) {
                    // Rollback transaction nếu có lỗi
                    $this->db->trans_rollback();
                    log_message('error', $e->getMessage());
                    // Redirect với thông báo lỗi
                    redirect($url . '?error=1');
                }
            }
        }
        
        redirect($url);
    }
    function save_images_from_html($html) {
        $dom = new DOMDocument();
        // Chuyển đổi encoding sang HTML-ENTITIES với UTF-8 trước khi load
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $images = $dom->getElementsByTagName('img');
    
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, 'data:image') === 0) {
                // Xử lý base64 image
                list($type, $data) = explode(';', $src);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
    
                // Đảm bảo thư mục uploads tồn tại
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }
    
                $image_name = 'uploads/' . uniqid() . '.png';
                if (!file_put_contents($image_name, $data)) {
                    log_message('error', 'Failed to save image: ' . $image_name);
                    continue;
                }
    
                // Thay thế src bằng URL thực tế
                $img->setAttribute('src', base_url($image_name));
            }
        }
    
        return $dom->saveHTML();
    }
    function offer_view($id = 0)
    {
        $id = (int)$id;

        if (!$id){
            $id = (int)$this->input->get_post('offer_id');
        }

        $off = $this->Home_model->get_one('offer', array('show' => 1, 'id' => $id));
        if ($off) {

            $country = 'VN';
            $traftype ='';
            $status = 'Approved';
            $rq_data = null;

            if ($off->request) {
                $status = 'none';
                $this->db->select('*');
                $rq_data = $this->Home_model->get_one('request', array(
                    'userid'  => $this->session->userdata('userid'),
                    'offerid' => $off->id
                ));
                if (!empty($rq_data)) {
                    $status = $rq_data->status;
                }
            }
            if ($off->trafrequire == 1) {
                $this->db->select('traftype.id, traftype.name')
                         ->from('offertraftype')
                         ->join('traftype', 'traftype.id = offertraftype.traftype_id')
                         ->where('offertraftype.offer_id', $off->id);
                $traftype = $this->db->get()->result();
            }

            $offercat = $this->Home_model->get_data('offercat');
            foreach ($offercat as $offercat) {
                $moffercat[$offercat->id] = $offercat->offercat;
            }
        
            $trafficurl = isset($rq_data->trafficurl) ? explode(', ', $rq_data->trafficurl) : [];
            $content = $this->load->view('offers/campaign_view.php', array(
                'offer' => $off, 'offercat' => $moffercat, 
                'status' => $status, 'traftype' => $traftype,
                'rq'=> $rq_data, 'trafficurl' => $trafficurl), 
            true);
        } else {
            $content = 'Offer now found!';
        }

        $this->load->view('default/vindex.php', array('content' => $content));
    }
    
    function requpdate($rqid = 0) {
        $url = $_SERVER['HTTP_REFERER'];
        $rqid = (int)$rqid;
        
        if (!$rqid) {
            redirect($url); // Chuyển hướng về trang trước nếu không có rqid
        }
        
        $rq = $this->Admin_model->get_one('request', array('id' => $rqid));
        $reapplied = $rq->reapplied;
        $original_status = $rq->status; // Lưu trạng thái gốc để kiểm tra
        
        if($original_status == 'Deny'){
            $reapplied++;
        } else {
            $reapplied = 0;
        }
        $status = 'Pending';
        
        if ($_POST) {
            // Bắt đầu transaction
            $this->db->trans_start();
            
            try {
                // Xử lý crequest
                $crequest = $this->input->post('crequest', true);
                // Nếu là mảng, chuyển thành chuỗi
                if (is_array($crequest)) {
                    $crequest = implode(', ', $crequest);
                }
                
                // Xử lý trafficurl
                $trafficurl_data = $this->input->post('trafficurl', true);
                $trafficurl = is_array($trafficurl_data) ? implode(', ', $trafficurl_data) : $trafficurl_data;
                
                // Xử lý subject và message
                $subject = '';
                $message = '';
                
                if (strpos($crequest, 'Email Traffic') !== false) {
                    $subject = $this->input->post('subject', true);
                    $message = $this->input->post('message');
                    $message = $this->save_images_from_html($message);
                }
                
                // Chuẩn bị dữ liệu cập nhật
                $update_data = [
                    'crequest' => $crequest,
                    'trafficurl' => $trafficurl,
                    'subject' => $subject,
                    'message' => $message,
                    'reapplied' => $reapplied,
                    'status' => $status
                ];
                
                // Nếu trạng thái gốc là 'Deny', cập nhật thêm trường date
                if ($original_status == 'Deny') {
                    $update_data['date'] = date('Y-m-d H:i:s'); // current_timestamp
                }
                
                // Cập nhật dữ liệu trong bảng request
                $this->db->where('id', $rqid);
                $this->db->update('request', $update_data);
                
                // Kết thúc transaction
                $this->db->trans_complete();
                
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception('Transaction Failed');
                }
            } catch (Exception $e) {
                // Rollback transaction nếu có lỗi
                $this->db->trans_rollback();
                log_message('error', $e->getMessage());
                redirect($url . '?error=1');
            }
        }
        
        redirect($url);
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