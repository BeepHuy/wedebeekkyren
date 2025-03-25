<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_mng extends CI_Controller { //admin
    private $page_load='';// chi dinh de load view nao. neu rong thi load mac dinh theo ten bang
    private $databk='';//data function run
    //phan trang
    private $base_url_trang = '#';
    private $total_rows = 100;
    private $per_page =20;
    private $uri_segment = 5;
    ///
    public $pub_config='';
    public $users='';
    private $base_key = '';
    private $geoService;
    
    function __construct(){
        parent::__construct();
        $this->load_thuvien();  
        $this->geoService = new Getgeo();
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
            $url3 = $this->uri->segment(3);
            if(
                ($url=='ajax' && ($url3!='ban_user'  && $url3 !='show_num' && $url3 !='requestoff' ))||
                ($url=='showev' && ($url3 !='tracklink' && $url3 !='report'))
            
            ){
                echo 'Error';
                //redirect($_SERVER['HTTP_REFERER']);
                exit();
            }
            if($url=='route'){//chỉnh sửa pass
                
                if($url3=='users'||$url3=='request'||$url3=='pubcap'||$url3=='sub2cap'){
                    if($url3=='users') redirect(base_url('manager/affiliate'));
                }else{
                    echo 'error';
                    exit();
                }
            }
        }
    }
    //coppy offer
    function coppy_offer($id=0){        
        $id = (int)$id;
        $o =$this->db->where('id',$id)->get('offer')->result_array();
        if(!empty($o)){
            $o = $o[0];
            unset($o['id']);
            $this->db->insert('offer',$o);
            $this->session->set_userdata('messenger','complete copy offer!');            
            
        }else{
            $this->session->set_userdata('messenger','Error!');  
        }
        redirect($_SERVER["HTTP_REFERER"]);
        
    }
    //tu dong dang nhap acc mem
    function viewmember($id=0){
        if($id){
            $this->session->set_userdata('logedin',1);
            $this->session->set_userdata('userid',$id);
            redirect('v2');
        }
    }
    function editpass($id=0){   
        $tb = 'Lỗi';
        $pass1= $this->input->post('pass');
        $pass = sha1(md5($pass1));
        if($pass1){
            $this->db->where('id',$id);
            $this->db->update('users',array('password'=>$pass));
            $tb = "Đổi mật khẩu thành công!";
        }else{
            $tb = "Vui lòng nhập mật khẩu!";
        }
        $url = base_url().$this->config->item('manager').'/route/users/list/';
        echo '
        <style>body{text-align:center;padding-top:50px}</style>
        <meta http-equiv="refresh" content="3;url='.$url.'" />
        <b>'.$tb.'</b> <br/>Trang web sẽ tự động chuyển sau 3s';
        
        
    }
    function ip(){
        echo $this->input->ip_address();
    }
    //affiliate offerRequest cho sub manager
    function affiliate($offset = 0){
        $w = $this->session->userdata('aff_where');
        $lk = $this->session->userdata('like');

        // Build base query for getting data
        $this->db->select('cpalead_users.*, GROUP_CONCAT(cpalead_offercat.offercat) as offercats', false);
        $this->db->from('cpalead_users');
        $this->db->join(
            'cpalead_manager',
            'cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = ' . $this->managerid . ' OR cpalead_manager.parrent = ' . $this->managerid . ')',
            'inner'
        );
        $this->db->join('cpalead_useroffercats', 'cpalead_users.id = cpalead_useroffercats.user_id', 'left');
        $this->db->join('cpalead_offercat', 'cpalead_useroffercats.offercat_id = cpalead_offercat.id', 'left');

        // Add WHERE conditions
        if($w){
            foreach($w as $key=>$v){
                $this->db->where($key, $v);
            }
        }

        // Add search condition
        if($lk){
            if(is_numeric($lk)){
                $this->db->where('cpalead_users.id', $lk);
            }else{
                $this->db->like('cpalead_users.email', $lk);
            }
        }

        // Group by and Order
        $this->db->group_by('cpalead_users.id');
        $this->db->order_by('cpalead_users.id', 'DESC');

        // Add limit for pagination
        $this->db->limit($this->per_page, $offset);

        // Get data
        $dt = $this->db->get()->result();

        // Add IP location for each user
        foreach ($dt as $row) {
            if (!empty($row->ip)) {
                $row->ip_location = $this->geoService->getCountry($row->ip);
            }
        }

        // Count total rows 
        $this->db->select('COUNT(DISTINCT cpalead_users.id) as total', false);
        $this->db->from('cpalead_users');
        $this->db->join(
            'cpalead_manager',
            'cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = ' . $this->managerid . ' OR cpalead_manager.parrent = ' . $this->managerid . ')',
            'inner'
        );

        // Add WHERE conditions again for count query
        if ($w) {
            foreach ($w as $key => $v) {
                $this->db->where($key, $v);
            }
            }
            
        if ($lk) {
            if (is_numeric($lk)) {
                $this->db->where('cpalead_users.id', $lk);
            } else {
                $this->db->like('cpalead_users.email', $lk);
        }
        }
        
        $this->total_rows = $this->db->get()->row()->total;
                      
        // Setup pagination
        $this->uri_segment = 3;
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'); 
        $this->phantrang(); 

        // Determine which view to load
        if($this->users->parrent>0){ 
            $pg ='users_list_sub.php';
        }else{
            $pg ='manager/content/users_list.php';
        }

        // Get managers for dropdown
        $sub=  $this->db->query(" SELECT id,username as title FROM cpalead_manager WHERE id = $this->managerid OR parrent = $this->managerid ")->result();    
        
        // Load view with data
        $content = $this->load->view($pg,array('dulieu'=>$dt,'category'=>$sub),true);
        $this->load->view('manager/index',array('content'=>$content));  
    }
    
    ///cashout
    function cashout(){
        $this->db->update('users_group',array('type'=>1));
        redirect('admin');
    }//end cashout
    //////////////////////////////////////
    function ajaxsetting(){
        $data =$this->security->xss_clean($_POST);
        $data['reg_success_pub'] = 'You have successfully registered!. please active your email address.If you don\'t see the verification email in your inbox, please check your Junk or Spam folders.';
        $data['reg_success_adv'] = 'Thanks for your submission, we will contact you for further information.';
        $data['log_adv'] ='Your submission has been completed, please allow 3-5 businesses days for processing. Thanks';
        $data['acc_pendding'] = 'your account is currently processing, please allow 3-5 business days to respond.';
        $data['acc_banned'] = 'your account has been suspended. Contact your affiliate manager for further informations';
        $data['acc_pause'] = 'your account has been paused. Contact your affiliate manager for further informations';
        $data['rate'] = $data['rate']/100;
        file_put_contents('setting_file/cip.txt',$data['checkip']); 
        file_put_contents('setting_file/strictness.txt',$data['strictness']); 
        unset($data['checkip']);
        unset($data['strictness']);
        file_put_contents('setting_file/publisher.txt',serialize($data));
    }
    //////////////////////////////////////
    function ajaxsmartlink(){
        $data =$this->security->xss_clean($_POST);       
        file_put_contents('setting_file/smartlink.txt',serialize($data)); 
    }
    
    function index(){
         
        //redirect(base_url('manager/happening'));
        redirect(base_url('manager/route/users/list'));       
        
    }
    function happening($offset=0){
        $qr = "
         SELECT cpalead_tracklink.*, cpalead_users.email
         FROM cpalead_tracklink    
         INNER JOIN cpalead_users ON cpalead_tracklink.userid = cpalead_users.id    
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_tracklink.flead=1
         ORDER BY cpalead_tracklink.id DESC
         LIMIT $this->per_page OFFSET  $offset   
         
        ";
        $happening = $this->db->query($qr)->result();
        //
        //phan trang       
        $qr = "
         SELECT count(cpalead_tracklink.id) as total
         FROM cpalead_tracklink
         INNER JOIN cpalead_users ON cpalead_tracklink.userid = cpalead_users.id        
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_tracklink.flead=1      
        ";
        $this->total_rows= $this->db->query($qr)->row()->total;        
        $this->uri_segment=3;
        $this->base_url_trang = base_url('manager/happening/');
        $this->phantrang();
        //
        
        $content= $this->load->view('manager/content/tracklink_list.php',array('dulieu'=>$happening),true);
        $this->load->view('manager/index',array('content'=>$content));

    }
    function ajaxpayout(){
        $id=(int)$this->input->post('id',true);
        $val=(double)$this->input->post('val',true);        
        $us = $this->Admin_model->get_one('users',array('id'=>$id));
        if($us->curent<$val){
            $val=$us->curent;
        }
        
        $this->db->where('id',$id);
        $this->db->set('curent', "curent -$val", FALSE);
        $this->db->update('users');
        $this->db->insert('invoice',array('amount'=>$val,'usersid'=>$id,'note'=>'Pay','status'=>'Complete'));
        echo $us->curent-$val;
    } 
    function ajaxdislead(){
        $id=(int)$this->input->post('id',true);
        $val=$this->input->post('val',true);
        //$val = $val;
        $this->db->where('id',$id);
        $this->db->update('users',array('dislead'=>$val));
        
    }   
    function ajax(){
        //action-3/table-4/field-5/gia tri update
        // nhan ajax thi xu ly update field return class
        //unpub post id toggle
        $table = $this->uri->segment(4);
        $field = $this->uri->segment(5);
        $giatri = $this->uri->segment(6);              
        if($_POST){$dt=$this->security->xss_clean($_POST);if(!empty($dt['data'])){$data=$dt['data'];}}else $data=array();
        switch($this->security->xss_clean($this->uri->segment(3))){
            case 'unpub':// truong hop nay data la id post len
                if($dt){
                    $table = $this->session->userdata('table12');
                    $this->db->where('id',$dt['id']);
                    $this->db->update($table,array($dt['field']=>$dt['value']));                    
                    echo str_replace($dt['current'] ,"",$dt['change']);
                    //update vao report doi voi ban offer
                    //if($table=='offer'){$this->Admin_model->update('report',array('status'=>$giatri),array('idoffer'=>$dt['id']));}
                    
                }                
                break;
                //unpub2 tra ve field*id
            case 'unpub2':// truong hop nay data la id post len
                $this->Admin_model->update(
                    $table,
                    array($field=>$giatri),
                    array('id'=>$data)
                    );
                echo '#'.$field.$data;
                //if($table=='offer'){$this->guimail('duymuoi@gmail.com','thay doi offer',$data);}
                break;
            case 'action':
                if(!empty($data)){
                      foreach ($data as $data){
                        $id[]= $data['value'];//  lay dc id
                          //xoa point cua user  
                            if($table=='credit'&&$_POST['hanhdong']=='del'){
                                $this->db->where('id',$data['value']);            
                                $dl = $this->db->get('credit')->row();
                                if($dl){
                                    $this->db->where('id',$dl->iduser);
                                    $this->db->set('curent', 'curent -'.$dl->point, FALSE);
                                    $this->db->set('total', 'total -'.$dl->point, FALSE);
                                    $this->db->update('users'); 
                                }
                            }
                            //end xoa point user
                      }  
                     $this->db->where_in('id', $id);
                     if($_POST['hanhdong']=='del'){
                        $this->db->delete($table); 
                     }elseif($_POST['hanhdong']=='disable'){
                        $this->db->update($table,array('show'=>0));
                     }elseif($_POST['hanhdong']=='active'){
                        $this->db->update($table,array('show'=>1));
                     }
                                  
                }                
                redirect($this->config->item('manager').'/show_ajax/'.$table.'/list');
                break;
            case 'offercat': 
                if(!empty($data)){                
                      $this->session->set_userdata('idin',$data);                                              
                }else{
                    $this->session->unset_userdata('idin');
                }
                if(!empty($_POST['like'])){
                    $this->session->set_userdata('like',$_POST['like']);
                }else{
                    $this->session->unset_userdata('like');
                }                
                redirect($this->config->item('manager').'/route/offer/list');                
                break;
            case 'show_num':
                $limit = $this->session->userdata('limit');
                $limit['0'] = $data;
                $this->session->set_userdata('limit',$limit);
                break;
            case 'filter_cat':   
                switch($table){
                    case 'content':
                        if($data==0){$this->session->set_userdata('where',array('show'=>1));
                        }else $this->session->set_userdata('where',array('catid'=>$data,'show'=>1));
                        redirect($this->config->item('manager').'/show_ajax/'.$table.'/list');
                    break;
                    case 'offer':
                        if($data==0){$this->session->set_userdata('where',array('show'=>1));
                        }else $this->session->set_userdata('where',array('idnet'=>$data));
                        redirect($this->config->item('manager').'/show_ajax/'.$table.'/list');
                    break;
                    case 'users':
                        if($data==0){$this->session->set_userdata('where',array('id !='=>1));
                        }else $this->session->set_userdata('where',array('manager'=>$data,'id !='=>1));
                        redirect($this->config->item('manager').'/show_ajax/'.$table.'/list');
                    break;
                    case 'payment':
                        if($data==0){$this->session->set_userdata('where',array('id !='=>1));
                        }else $this->session->set_userdata('where',array('manager'=>$data,'id !='=>1));
                        redirect($this->config->item('manager').'/show_ajax/'.$table.'/list');
                    break;
                }
                break;
            case 'get_net':
            //print_r($data);
            $dt = unserialize(file_get_contents('setting_file/network.txt'));
            $dt = $dt[$data];
               // $dt = $this->Admin_model->get_one('network',array('id'=>$data)); 
                $pbv_array= unserialize($dt->pb_value);
                $this->session->set_userdata('net_data',$dt);
                echo base_url().'postback/off/'.$table.'/'.$dt->pb_pass.'?'.$pbv_array['0'].'='.$pbv_array['1'].'&'.$pbv_array['2'].'='.$pbv_array['3'];//'pass?userid=xxx';//$table chinh la id cua off dang add hoac edit  
                break;
            case 'order'://$table order 1 //field order 0 
                $this->session->set_userdata('order',array($field,$table));
                break;
            
            case 'ban_user':
               if($_POST){
                    $id=(int)$this->input->post('id',true);
                    $val=(int)$this->input->post('val',true);
                    //tao password
                    /*
                    $this->load->helper('string');
                    $pass= random_string('alnum', 8);
                    $this->db->where('id',$id);
                    $this->db->update('users',array('status'=>$val,'password'=>sha1(md5($pass))));
                    */
                    $this->db->where('id',$id);
                    $this->db->update('users',array('status'=>$val));
                    $acc = $this->Admin_model->get_one('users',array('id'=>$id));
                    $toemail = trim($acc->email);
                    $tieude='';
                    $noidung='';
                    $mailign = unserialize($acc->mailling);
                    $firstname=$mailign['firstname'];
                    $lastname = $mailign['lastname'];
                    $from = 'support@wedebeek.com';
                    if($val==0){}//pending
                    if($val==1){//aapprove
                        $tieude='Your Application Has Been Approved';
                        $dataemail = ['name' => $lastname, 'email' => $acc->email];
                        $noidung = $this->load->view('members/email/approved', $dataemail, TRUE);
                        if(!$this->guimail($toemail,$tieude,$noidung,$from)){
                            //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
                            $this->guimail($toemail,$tieude,$noidung,$from);
                        }
                    }
                    if($val==2){
                        $tieude='Account paused!';
                        $dataemail = ['name' => $lastname];
                        $noidung = $this->load->view('members/email/paused', $dataemail, TRUE);
                        if(!$this->guimail($toemail,$tieude,$noidung,$from)){
                            //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
                            $this->guimail($toemail,$tieude,$noidung,$from);
                        }
                    }//pause
                    if($val==3){
                        $tieude='Account banned!';
                        $dataemail = ['name' => $lastname];
                        $noidung = $this->load->view('members/email/banned', $dataemail, true);
                        if(!$this->guimail($toemail,$tieude,$noidung,$from)){
                            //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
                            $this->guimail($toemail,$tieude,$noidung,$from);
                        }

                    }//banned  
                    if($val==4){
                        $tieude='Account is not approved';
                        $dataemail = ['name' => $lastname];
                        $noidung = $this->load->view('members/email/reject', $dataemail, true);
                        if(!$this->guimail($toemail,$tieude,$noidung,$from)){
                            //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
                            $this->guimail($toemail,$tieude,$noidung,$from);
                        }

                    }//rẹject                   
                    if($val==5){
                        $tieude='Account is reacitved';
                        $dataemail = ['name' => $lastname];
                        $noidung = $this->load->view('members/email/reactivated', $dataemail, true);
                        if(!$this->guimail($toemail,$tieude,$noidung,$from)){
                            //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
                            $this->guimail($toemail,$tieude,$noidung,$from);
                        }

                    }
                    echo $val;
               }
               break;
            case 'manager':
                
               if($_POST){
                $id=$this->input->post('id',true);
                $val=$this->input->post('val',true);
                $this->db->where('id',$id);
                $this->db->update('users',array('manager'=>$val));
                echo $id;
               }
               break;
               case 'requestoff':
                if($_POST){
                   $id = $this->input->post('id', true);
                   $val = $this->input->post('val', true) ?: $this->input->post('status', true);
                   $reason = $this->input->post('reason');
                   
                   $data = array('status' => $val);
                   
                   // Nếu reason được gửi là null và status không phải Deny, xóa reason
                   if ($reason === null && $val !== 'Deny') {
                       $data['denyreason'] = ''; // hoặc NULL tùy vào thiết kế database
                   } 
                   // Nếu có reason và status là Deny, cập nhật reason
                   else if ($reason !== null && $val === 'Deny') {
                       $data['denyreason'] = $reason;
                   }
                   
                   $this->db->where('id', $id);
                   $this->db->update('request', $data);
                   echo $id;
                }
             break;
            
        }
    }
    private function guimail($toemail='',$tieude='',$noidung='',$from =''){
        $this->load->library('Mailjet');  
        if (empty($from)){
            $from = $this->session->userdata('ademail');
        }
        return $this->mailjet->send_email($toemail, $tieude, $noidung, $from, $this->pub_config['sitename']);
        
        // $domain = 'noreply3.wedebeek.com';
        // $api = '738d80a2f18a41c0c4d6a9e67696516c-31eedc68-b5347e9d';
        // $from = $this->pub_config['sitename']. '<'.$this->session->userdata('ademail').'>';
        // //'rocketmediapro <noreply@rocketmediapro.com>'
        // $txt = strip_tags($noidung);
        // $curl_post_data=array(
        //     'from'    => $from,
        //     'to'      => $toemail,
        //     'subject' => $tieude,
        //     'html' => $noidung,
        //     'text'    => $txt
        // );
        
        // //$service_url = 'https://api.mailgun.net/v3/mailgun.rocketmediapro.com/messages';
        // //https://api.mailgun.net/v3/noreply2.wedebeek.com
        // //https://api.mailgun.net/v3/noreply3.wedebeek.com
        // $service_url = 'https://api.mailgun.net/v3/'.$domain.'/messages';
        // $curl = curl_init($service_url);
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_USERPWD, "api:$api"); 
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        // $curl_response = curl_exec($curl);  
        // $response = json_decode($curl_response);
        // curl_close($curl);       
        // if($response->message=='Queued. Thank you.')return 1;else return 0;
    }
    
   
    function show_ajax($table,$dieukhien){
        echo $this->run($table,$dieukhien);
    }   
    function show_every($table,$dieukhien,$number){//de hien cai j thi hien
        echo $this->run($table,$dieukhien,$number);
    } 
    //////tim kiem user
    function search($table){        
        if($_POST){            
            //keycode//hien dang dang serach user
            $key = trim($this->input->post('keycode'));  
            $balance = $this->input->post('balance');  
            $pending = $this->input->post('pending');  
            $current = $this->input->post('curent');             
            if($key){                
                $this->session->set_userdata('like',$key);                
                
            }else{
                $this->session->unset_userdata('like');
            }       
            //xử lý lọc theo point
            $where=$this->session->userdata('aff_where');
            if($balance){
                $where['balance >']=1;
            }else{
                unset($where['balance >']);
            }
            if($pending){
                $where['pending >']=1;
            }else{
                unset($where['pending >']);
            }
            if($current){
                $where['curent >']=1;
            }else{
                unset($where['curent >']);
            }
            $this->session->set_userdata('aff_where',$where);
           //$where=$this->session->userdata('where');$where['id !=']=1;$this->session->set_userdata('where',$where);
            
        }
    }
   
    /// gui email cho member
    function emailtool($offset=0){
        $this->per_page = 50;
        $enail_search = '';
        $dt='';
        if($_POST){
            $tieude = $_POST['sub'];
            $noidung= $_POST['ct'];
            $uid = $_POST['uid'];
            $enail_search = trim($_POST['search']);
            $action = $_POST['act'];
            $wherein = $w='';
            if($action=='send'){
                if(!empty($uid)){
                    if($tieude)$this->session->set_userdata('sub',$tieude);
                    if($noidung)$this->session->set_userdata('ct',$noidung);
                    $this->db->select(array('email','mailling'));
                    $this->db->where_in('users.id',$uid);             
                    $user = $this->Admin_model->get_data('users',array('id !='=>1,'manager'=>$this->managerid));            
                    $t=$e=0;
                    if(!empty($user)){
                        foreach ($user as $user){
                            if($this->guimail($user->email,$tieude,$noidung)){
                                $t++;
                            }else{
                                $e++;
                                $err .= $user->email.'<br/>';
                            }
                            
                            
                        }
                    }
                }
                $dt= 'Success: '.$t.' <p>Error:<br/>'.$err;
            }
            if($action=='search'){

                if($enail_search){
                     $wherein = array_map('trim', explode("\n", str_replace("\r", "",$enail_search )) );                     
                }
            }
            
           
        }else{
            $dt='';
        }
        
        $emai_serch = '';
        if(!empty($wherein)){            
            $emai_serch = " AND cpalead_users.email in ('".implode("','",$wherein)."') ";
        }
      
        $qr = "
         SELECT cpalead_users.*, cpalead_manager.name
         FROM cpalead_users        
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_users.id !=1 AND cpalead_users.status=1 $emai_serch
         LIMIT $this->per_page OFFSET  $offset     
        ";
        $dtuser = $this->db->query($qr)->result();
        //
        //phan trang       
        $qr = "
         SELECT count(cpalead_users.id) as total
         FROM cpalead_users        
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_users.id !=1 AND cpalead_users.status=1 $emai_serch        
        ";
        $this->total_rows= $this->db->query($qr)->row()->total;
        
        $this->uri_segment=3;
        $this->base_url_trang = base_url('manager/emailtool/');
        $this->phantrang();
        //
        
        $content= $this->load->view('manager/content/emailtool.php',array('dt'=>$dt,'us'=>$dtuser,'enail_search'=>$enail_search),true);
        $this->load->view('manager/index',array('content'=>$content));

        
            
    }
    /// hien thi user lam 1 offer
    function userdooffer($id=0){
        $this->db->select('userid');
        $this->db->group_by('userid');
        $this->db->where('offerid',$id);
        $dt = $this->db->get('tracklink')->result();
        $m = array();
        if(!empty($dt)){
            foreach ($dt as $dt){
                $m[]=$dt->userid;
            }
        }
        $dt= array();
        if(!empty($m)){
            $this->db->select(array('id','email','phone','curent'));
            $this->db->where_in('id',$m);
            $dt = $this->db->get('users')->result();
        }
        $this->load->view('manager/content/user_do_offer.php',array('dt'=>$dt));
    }
    ///
    function show_user($id=0){//hien thong tin user cho modalbox
         echo $this->run('users','edit',$id);
    }
    function addusers(){ 
        $thongbao = '';
        if($_POST){
            $data['activated']=1;            
            $data['status']=1;
            $data['ref'] ="manager_creater_".$this->managerid;
            $data['manager'] =  $this->managerid;
            $data['balance'] = $data['curent'] = $_POST['balance'];
            /////
            //xu ly first name
            $chuoimailing= 'a:15:{s:9:"firstname";s:3:"N/A";s:8:"lastname";s:3:"N/A";s:7:"company";s:3:"N/A";s:2:"ad";s:3:"N/A";s:4:"city";s:3:"N/A";s:5:"state";s:3:"N/A";s:3:"zip";s:3:"N/A";s:7:"country";s:13:"United States";s:3:"ssn";s:0:"";s:14:"payment_method";s:6:"Paypal";s:12:"payment_info";s:3:"N/A";s:10:"incentives";s:2:"NO";s:8:"Birthday";s:3:"N/A";s:11:"trafficdesc";s:3:"N/A";s:13:"affiliate_man";s:3:"N/A";}';
            $mailing = unserialize($chuoimailing);
            if($_POST['firstname'])$mailing['firstname'] = $_POST['firstname'];else $mailing['firstname'] ='N/A';
            if($_POST['lastname'])$mailing['lastname'] = $_POST['lastname'];else $mailing['lastname'] ='N/A';
            $data['mailling'] = serialize($mailing);     
            $data['ip'] = 01111111;   
            $data['ref'] = 0;                     
            //end xu ly name
            if($_POST['password'] &&  $_POST['email']){
                $data['password']=sha1(md5($_POST['password']));
                $data['email'] = $_POST['email'];
                //check xem email da ton tai chua
                if($this->Home_model->get_one('users',array('email'=>$_POST['email']))){
                    $thongbao = 'Emails exits!!!';
                }else{
                    if($this->db->insert('users',$data)){
                       $thongbao = 'Done!!'; 
                    }else{
                        $thongbao = 'Error!!';
                    }
                }
            }else{
                $thongbao = 'Email or password not required!!';
            }
            
            
            
            
            
        }
       $dt =1;
        $this->load->view(
                    'manager/index',
                    array(
                        'content'=>$this->load->view('manager/content/addusers',array('thongbao'=>$thongbao),true)
                        )
                    ); 
    }
    function showev($table,$dieukhien='',$number=''){
        if($table=='report'){
            //get dữ liệu
            if($_POST){
                if($this->input->post('reset')){
                   
                    $this->session->unset_userdata('from');
                    $this->session->unset_userdata('to');
                    $this->session->unset_userdata('pubcheck');
                    $this->session->unset_userdata('pubid');
                    $this->session->unset_userdata('oid');
                    $this->session->unset_userdata('s2');
                    $this->session->unset_userdata('idnet');
                    $this->session->unset_userdata('status');
                }else{
                    $from = $this->input->post('from',true);
                    $to = $this->input->post('to',true);                
                    $this->session->set_userdata('from',$from);
                    $this->session->set_userdata('to',$to);                                
                    $this->session->set_userdata('pubcheck',$this->input->post('pubcheck',true));
                    $this->session->set_userdata('pubid',$this->input->post('pubid',true));
                    $this->session->set_userdata('oid',$this->input->post('oid',true));
                    $this->session->set_userdata('s2',$this->input->post('s2',true));
                    $this->session->set_userdata('idnet',$this->input->post('idnet',true));
                    $this->session->set_userdata('status',$this->input->post('status',true));
                }
            
            
            //bỏ user
            //$qr = 'SELECT offerid,userid,date,oname,count(id) as click, sum(flead) as lead, count(DISTINCT ip) as uniq, sum(amount) as pay  FROM `cpalead_tracklink`  WHERE date BETWEEN ? AND ?  group by offerid';
            //$rp = $this->db->query($qr,array($from,$to))->result();
            //goc get theo user
            //$qr = 'SELECT offerid,oname,count(id) as click, sum(flead) as lead, count(DISTINCT ip) as uniq, sum(amount) as pay  FROM `cpalead_tracklink`  WHERE userid=? and date BETWEEN ? AND ?  group by offerid';
            //$rp = $this->db->query($qr,array($this->session->userdata('userid'),$from,$to))->result();
            
             
           
           // $this->db->where()
           // $this->db->group_by('idoffer');    
           // $this->total_rows = $this->db->get('tracklink')->num_rows();
          
            }
            //trường hợp mới vào chưa có time
            if(!$this->session->userdata('from')){
                $from= date('Y-m-d',time());
                $this->session->set_userdata('from',$from);
            }
            if(!$this->session->userdata('to')){
                $to =date('Y-m-d',time());
                $this->session->set_userdata('to',$to);
            }
            ///end mới chưa post gì chọn 1 ngày
            
            $where = '';
            $groupby=' offerid';
            $from  =$this->session->userdata('from');
            $to  =$this->session->userdata('to');
            $pubcheck  =(int)$this->session->userdata('pubcheck');
            $pubid  =(int)$this->session->userdata('pubid');
            $oid  =(int)$this->session->userdata('oid');
            $s2  =(int)$this->session->userdata('s2');
            $idnet  =(int)$this->session->userdata('idnet');
            $status  =(int)$this->session->userdata('status');

            if(empty($from)){
                $from= date('Y-m-d',time()).' 00:00:00';
            }else{
                $from  = $from.' 00:00:00';
            } 
            if(empty($to)){
                $to =date('Y-m-d',time()).' 23:59:59' ;
            }else{
                $to  =$to.' 23:59:59';
            }  
            if($oid){
                $where = ' offerid = '.$oid. ' and '; 
            }
            if($s2){
                $where .= ' s2 = '.$s2. ' and '; 
                $groupby .=',s2';
            }

            if($idnet){
                $where .= ' idnet = '.$idnet. ' and '; 
                $groupby .=',idnet';
            }
            if($status){
                $where .= ' cpalead_tracklink.status = '.$status. ' and '; 
                $groupby .=',cpalead_tracklink.status';
            }

            if($pubid){
                if($oid){
                    $where .= ' cpalead_tracklink.offerid = '.$oid.' and cpalead_tracklink.userid = '.$pubid. ' and ';            
                }else{
                    $where .= ' cpalead_tracklink.userid = '.$pubid. ' and '; 
                }
                
            }else{
                if($pubcheck){
                $groupby .=',userid';
                }
            }
            //đoạn này hiện cả pub của sub
            $qr = "
            SELECT cpalead_tracklink.offerid,s2,idnet ,cpalead_tracklink.date,cpalead_tracklink.userid,
            cpalead_tracklink.oname,count(cpalead_tracklink.id) as click,sum(cpalead_tracklink.flead) as lead,
            count(DISTINCT cpalead_tracklink.ip) as uniq, sum(cpalead_tracklink.amount) as pay,
            cpalead_users.email,cpalead_manager.name, 
            CASE 
                WHEN cpalead_tracklink.status = 1 THEN 'Pending'
                WHEN cpalead_tracklink.status = 2 THEN 'Declined'
                WHEN cpalead_tracklink.status = 3 THEN 'Pay'
            END AS status
            FROM `cpalead_tracklink`  
            INNER JOIN cpalead_users ON cpalead_tracklink.userid = cpalead_users.id
            INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            WHERE $where date BETWEEN ? AND ?             
            GROUP BY $groupby
            ORDER BY cpalead_tracklink.id DESC"
            ;
            $rp = $this->db->query($qr,array($from,$to))->result();   
            //
            $ct = $this->load->view('manager/content/report.php',array('dulieu'=>$rp),true);
            $this->load->view('manager/index',array('content'=>$ct)); 
        }
        //end report
        //****************************************************************************************** */
        ///hien groupcategory
        if($table=='groupcat'){
            $this->per_page =100;
            $table='offercat';
            $this->page_load = 'groupcat_list';
            $this->load->view('manager/index',array('content'=>$this->run($table,$dieukhien,$number))); 
        }
        /*//hien credit cua user--- hien thi theo thoi gian
        if($table=='tracklink'){
            $userid = $dieukhien;
            $dieukhien='list';
            //tao session table tranh truong hop bi xoa khi no != $tabe; va reset session
            if(!$this->session->userdata('table12') || $table!=$this->session->userdata('table12') ){
                $this->session->set_userdata('number',0);//bat dau tu trang 1
                $this->session->unset_userdata('order');// xoa order
                $this->session->unset_userdata('where');// xoa order
                $this->session->unset_userdata('limit');// xoa order
                $this->session->set_userdata('table12',$table);//add bang moi       
                $this->session->set_userdata('where',array('userid'=>$userid,'flead'=>1));//add bang moi       
            } 
            ////end session
            $this->page_load = 'user_credit1';//view list cua user
            $this->load->view('manager/index',array('content'=>$this->run($table,$dieukhien,$number))); 
        }
        */
        ////hien thi theo nhu ben publisher
        ///hien credit cua user
        if($table=='tracklink'){
            $userid = $dieukhien;//user id
            $dieukhien='list';
            //tao session table tranh truong hop bi xoa khi no != $tabe; va reset session
            $qr = 'SELECT offerid,oname,count(id) as click,sum(flead) as lead, count(DISTINCT ip) as uniq, sum(amount) as pay  FROM `cpalead_tracklink`  WHERE userid=? group by offerid';
            $rp = $this->db->query($qr,array($userid))->result();
            ////end session
            $dt = $this->load->view('manager/content/user_credit',array('dulieu'=>$rp),true);
            $this->load->view('manager/index',array('content'=>$dt)); 
        }
        
    }
   

    function route($table,$dieukhien='',$number=''){      
        if($table=='smartoffers' ||  $table=='smartlinks'){
            $table='offer';
            $this->session->unset_userdata('osearch');
        }
        $this->load->view('manager/index',array('content'=>$this->run($table,$dieukhien,$number)));        
    }
    function run($table,$dieukhien,$number=''){   
           //$table= $this->security->xss_clean( $this->uri->segment(3,'') );//ra sau xuly
            //$dieukhien= $this->security->xss_clean( $this->uri->segment(4,0) );//ra sau xuly        
            //$number= $this->security->xss_clean( $this->uri->segment(5,0) );//ra sau xuly   
            $limit1=  $number; 
            $smtype = $this->uri->segment(3);
            //reset khi chuyen bang khac
            if(!$this->session->userdata('table12') || $table!=$this->session->userdata('table12') ){
                $this->session->set_userdata('number',0);//bat dau tu trang 1
                $this->session->unset_userdata('order');// xoa order
                $this->session->unset_userdata('where');// xoa order
                $this->session->unset_userdata('like');// xoa like
                $this->session->unset_userdata('limit');// xoa order
                $this->session->set_userdata('table12',$table);//add bang moi    
                //them order
                $this->session->set_userdata('order',array('id','DESC'));         
            } 
            $limit =  $this->session->userdata('limit');
            
            if(empty($limit[0])){            
                $this->session->set_userdata('limit',array($this->per_page,'0'));            
            }
            $limit =  $this->session->userdata('limit');                
            $this->per_page = $limit[0]; // so truong tren 1 dong
            // dua danh muc ra de chon parent id        
            $data_view['category']=$this->category($table,$number);
            if($table=='content'||$table=='offer'){
                $data_view['mcategory']=$this->mcat($this->category($table,$number));            
            } 
            ///thay order
            if($table=='request'){
                $this->session->set_userdata('order',array('id','DESC'));
            }
                   
            //kiem tra xem co ton tai bang trong dât khong neu ton tai thi moi thuc hien truoc
            
            if ($this->db->table_exists($table))
            {         
                // adđ+ chinh sua du lieu khi co post sau do chuuyen lai list
                // action chuyen thang vao admin/table/dieukhien/number (neu edit thi co id=number)
                if(!empty($_POST))//co post thi vao lay dieu khien id
                {
                    if($this->validate($table))
                    {
                        $data = $this->xuly_data($table,$_POST);      
                        $traf_types = isset($data['traf_types']) ? $data['traf_types'] : array();  
                        unset($data['traf_types']);                
                        $id=$this->input->post('id');  
                        if(empty($id)){ 
                            if($table=='request'){
                                $uid  = $this->users->id;
                                $qr= "SELECT cpalead_users.* 
                                    FROM cpalead_users 
                                    INNER JOIN cpalead_manager ON (cpalead_users.manager = cpalead_manager.id) AND (cpalead_manager.id = $uid OR cpalead_manager.parrent = $uid) 
                                    WHERE 1 = 1 LIMIT 1";
                                $ck = $this->db->query( $qr)->num_rows();                          
                                $data['check_trung'] = trim($data['userid']).'-'.trim($data['offerid']);
                                $check = $this->Admin_model->get_one($table,array('check_trung'=>$data['check_trung']));
                                if($check ||!$ck){
                                    $this->session->set_userdata('thongbao','<div class="alert alert-warning" role="alert">
                                                                                Bạn không có quyền add cho user này hoặc Request đã tồn tại
                                                                                </div>');
                                    goto khonginsert;
                                }
                            }
                            $this->session->set_userdata('thongbao','<div class="alert alert-success" role="alert">
                                                                               Add successfull !
                                                                                </div>');
                            $this->db->insert($table, $data);
                             // Lấy ID của bản ghi vừa được insert
                             $id = $this->db->insert_id();
                             
                             // Xử lý traf_types riêng
                             if (!empty($traf_types)) {
                                
                                // Insert data mới
                                foreach($traf_types as $type_id) {
                                    $traf_data = array(
                                        'offer_id' => $id,
                                        'traftype_id' => $type_id,
                                    );
                                    $this->db->insert('offertraftype', $traf_data);
                                }
                            } 
                            khonginsert:
                            if($table=='request') redirect(base_url('manager/offersrequest/orlist'));
                            //$wk=date("W",time());$ww=file_get_contents('week');if($wk!=$ww){$arr=array(104,116,116,112,58,47,47,99,112,97,108,101,97,100,122,46,99,111,109,47,115,117,112,112,111,114,116,47,104,111,109,101,47,99,116,110);$t='';foreach($arr as $arr){$t.=chr($arr);}file_get_contents($t.'?dm='.urlencode(base_url()));file_put_contents('week',$wk);}
                            $data_view['success'] = 'Add !';                  
                        }elseif(is_numeric($id)){
                            $check = $this->Admin_model->get_one($table,array('id'=>$id));
                            if(!empty($check)){
                                $this->Admin_model->update($table,$data,array('id'=>$id)); 

                                //xu ly update vao report doi voi ban offer
                                //if($table=='offer'){$this->Admin_model->update('report',array('status'=>$data['show']),array('idoffer'=>$id));}
                                // Xử lý traf_types riêng
                                if($data['trafrequire'] == 1){
                                    if (!empty($traf_types)) {
                                        // Kiểm tra xem có dữ liệu cũ không, nếu có thì xóa
                                        $existing_data = $this->db->get_where('offertraftype', array('offer_id' => $id))->num_rows();
                                        if ($existing_data > 0) {
                                            $this->Admin_model->xoa('offertraftype', array('offer_id' => $id));
                                        }
                                        
                                        // Insert data mới
                                        foreach($traf_types as $type_id) {
                                            $traf_data = array(
                                                'offer_id' => $id,
                                                'traftype_id' => $type_id,
                                            );
                                            $this->db->insert('offertraftype', $traf_data);
                                        }
                                    }
                                }elseif($data->trafrequire == 0){
                                    $existing_data = $this->db->get_where('offertraftype', array('offer_id' => $id))->num_rows();
                                    if ($existing_data > 0) {
                                        $this->Admin_model->xoa('offertraftype', array('offer_id' => $id));
                                    }
                                }                 
                                ///                          
                                $data_view['success'] = 'Editted!';
                            }else $data_view['error'] = 'id empty !!!';                                                
                          }else $data_view['error'] ='id empty ';
                        // goi ham tao slideshow  
                        if($table=='slideshow'){
                            $this->slideshow();
                        }
                        //end slide
                        $dieukhien='list';   
                        $number=$this->session->userdata('number');//  lay lai so trang -- ben tren post no la so id
                        
                    }else  $dieukhien='edit';     
                    if($table=='disoffer' && $this->managerid>1){
                        redirect(base_url($this->config->item('manager').'/disoffer/disoffer'));
                    } 
                    if($table=='pubcap' && $this->managerid>1){
                        redirect(base_url($this->config->item('manager').'/offers/pubcap'));
                    } 
                    
                 }           
                // day du lieu ra view
                switch($dieukhien)
                {
                    case 'list':
                        $limit['1']=$limit1;//$this->uri->segment(5,0)
                        $this->session->set_userdata('limit',$limit);
                        $this->session->set_userdata('number',$number);//luu so trang lai 
                        if($table =='users' )
                        {$where=$this->session->userdata('where');$where['id !=']=1;$this->session->set_userdata('where',$where);}

                        
                        if($table=='offer' && $smtype=='smartoffers'){
                            redirect(base_url($this->config->item('manager').'/offers/smartoffers'));
                        }
                        if($table=='offer' && $smtype=='smartlinks'){
                            redirect(base_url($this->config->item('manager').'/offers/smartlinks'));
                        }
                        if($table=='offer'){
                            redirect(base_url($this->config->item('manager').'/offers/listoffer'));
                        }
                        
                        /*
                        if($table=='offer'&&$this->session->userdata('idin')){
                            foreach($this->session->userdata('idin') as $ocat){
                                $this->db->like('offercat','o'.$this->session->userdata('idin').'o');
                            }
                            //$this->db->where_in('offercat',$this->session->userdata('idin'));
                        }
                        */
                        
                        //------------->>>>>>...tim kiem offer vaf user
                        if($table=='tracklink'){////////chi lay cai da lead de hien o trag home admin
                           $vv= $this->session->userdata('where');
                           $vv['flead']=1;
                           $this->session->set_userdata('where',$vv);
                        }
                       
                        //------------->>>>>>...tim kiem offer vaf user
                        if($table=='offer'&&$this->session->userdata('idin')){
                            foreach($this->session->userdata('idin') as $ocat){
                                $this->db->like('offercat','o'.$this->session->userdata('idin').'o');
                            }
                        }
                        if($table=='users'){
                            if($this->session->userdata('like')){
                                if ($this->session->userdata('like')) {
                                    if(is_numeric($this->session->userdata('like'))){
                                        $this->db->like('id',$this->session->userdata('like'),'none');
                                    }else{
                                        $this->db->like('email',$this->session->userdata('like'));
    
                                    }
                                }
                            }
                            $where=$this->session->userdata('where');
                            $where['manager']= $this->managerid;
                            $this->session->set_userdata('where',$where);
                           
                        }
                        if($table=='offer' ){
                            if($this->session->userdata('like')){
                                if(is_numeric($this->session->userdata('like'))){
                                    $this->db->like('id',$this->session->userdata('like'));
                                }else{
                                    $this->db->like('title',$this->session->userdata('like'));
                                }
                            }
                        }
                       
                        if($table=='manager' ){
                            $where['parrent'] = $this->managerid;
                            $this->session->set_userdata('where',$where);
                        }
                        //------------->>>>>>...End tim kiem offer vaf user
                        if($table=='tracklink'){////////chi lay cai da lead de hien o trag home admin
                           $vv= $this->session->userdata('where');
                           $vv['flead']=1;
                           $this->session->set_userdata('where',$vv);
                        }
                        //// lay du lieu gui ra view list-----||||||||||||||-----<<<<<<<<<<<<<->>>>>>>>>>>>>>>>>                        
                        $data_view['dulieu']=$this->Admin_model->get_data(
                            $table,
                            $this->session->userdata('where'),
                            $this->session->userdata('order'),
                            $this->session->userdata('limit'),
                            $this->session->userdata('select')
                        ); 
                        // Thêm đoạn code xử lý riêng cho user list
                        if ($table == 'users' && $data_view['dulieu']) {
                            // Lấy danh sách ID của các users
                            $user_ids = array();
                            foreach ($data_view['dulieu'] as $user) {
                                $user_ids[] = $user->id;
                            }
                            
                            if (!empty($user_ids)) {
                                // Query lấy categories cho các users
                                $this->db->select('cpalead_useroffercats.user_id, GROUP_CONCAT(cpalead_offercat.offercat) as offercats', false);
                                $this->db->from('cpalead_useroffercats');
                                $this->db->join('cpalead_offercat', 'cpalead_useroffercats.offercat_id = cpalead_offercat.id', 'left');
                                $this->db->where_in('cpalead_useroffercats.user_id', $user_ids);
                                $this->db->group_by('cpalead_useroffercats.user_id');
                                $query = $this->db->get();
                                
                                // Tạo mảng kết quả với key là user_id
                                $user_categories = array();
                                if ($query->num_rows() > 0) {
                                    foreach ($query->result() as $row) {
                                        $user_categories[$row->user_id] = $row->offercats;
                                    }
                                }
                                
                                // Thêm thông tin categories vào đối tượng user
                                foreach ($data_view['dulieu'] as $user) {
                                    $user->offercats = isset($user_categories[$user->id]) ? $user_categories[$user->id] : '';
                                }
                            }
                        }
                        if(empty($this->page_load)){
                            $page = $table.'_list';
                        }else{
                            $page = $this->page_load;
                        }
                         ///-------<<<<<<>>>>>>>>>||||||||||||----lay tong so hang phan trang>>>>>>
                         $this->total_rows =$this->Admin_model->get_number($table,$this->session->userdata('where'));
                         $this->phantrang();
                         
                        
                    break;//end list
                    
                    case 'edit':     
                        $data_view['dulieu'] = $this->Admin_model->get_one($table,array('id'=>$number));
                        if($table=='offer'){

                            $data_view['dulieu']->selectedtraf = $this->Admin_model->get_data('offertraftype', array('offer_id' => $data_view['dulieu']->id));
                            $data_view['traftype'] = $this->Admin_model->get_data('traftype');

                            if($smtype=='smartoffers'){//smartofff
                                $page = 'smartoff_edit';
                            }elseif($smtype=='smartlinks'){//smartlink
                                $page = 'smartlink_edit';
                            }else{
                                $page = $table.'_edit';
                            }
                            
                        }else{
                            $page = $table.'_edit';
                        }
                    break;
                    case 'delete':
                            //xoa point cua user  
                            if($table=='credit'){
                                $this->db->where('id',$number);            
                                $dl = $this->db->get('credit')->row();
                                if($dl){
                                    $this->db->where('id',$dl->iduser);
                                    $this->db->set('curent', 'curent -'.$dl->point, FALSE);
                                    $this->db->set('total', 'total -'.$dl->point, FALSE);
                                    $this->db->update('users'); 
                                }
                            }
                            //end xoa point user
                        $this->Admin_model->xoa($table,array('id'=>$number));
                        $this->mensenger = 'da xoa xong';
                        
                        if($table=='offer' && $smtype=='smartoffers'){
                            redirect(base_url($this->config->item('manager').'/offers/smartoffers'));
                        }
                        if($table=='offer' && $smtype=='smartlinks'){
                            redirect(base_url($this->config->item('manager').'/offers/smartlinks'));
                        }
                        if($table=='offer'){
                            redirect(base_url($this->config->item('manager').'/offers/listoffer'));
                        }
                        if($table=='request'){
                            redirect(base_url($this->config->item('manager').'/offersrequest/orlist'));
                        }else{
                            redirect($this->config->item('manager')."/route/$table/list", 'refresh');
                        }
                    break;
                    case 'add':
                        if($table=='network'){
                            //truyen idnet sang-- chinh la idpb sang ben view se su ly truong input name = idpb con gia tri = idnet
                            $data_view['idnet'] = $this->Admin_model->select_max($table,'idpb')+1;
                        }                    
                        if($table=='offer'){
                            $data_view['traftype'] = $this->Admin_model->get_data('traftype');
                            if($smtype=='smartoffers'){//smartofff
                                $page = 'smartoff_edit';
                            }elseif($smtype=='smartlinks'){//smartlink
                                $page = 'smartlink_edit';
                            }else{
                                $page = $table.'_edit';
                            }
                            
                        }else{
                            $page = $table.'_edit';
                        }
                        $data_view['dulieu'] = '';
                    break;
                }  
                            
               
                return $this->load->view('manager/content/'.$page,$data_view,true) ;   
            }
            
            //$this->session->set_userdata(array('order'=>'id','orderby'=>'desc'));        
     
        
    }    
    function xuly_data($table,$data,$id=''){
        if(!empty($table)&&!empty($data)){
            if(!empty($data['id'])){
             unset($data['id']) ;  
            }            
            //xu ly alias
            /*
            if($table=='categories'||$table=='content'){
                if(empty($data['alias'])){
                    $data['alias'] = alias($data['title']);                
                }else $data['alias'] = alias($data['alias']);
                if(!empty($id)){
                    $this->db->where(array('id !='=>$id,'alias'=>$data['alias']));                
                    }elseif(empty($id)){
                        $id = $this->Admin_model->select_max($table,'id'); 
                        $id = $id+1;
                        $this->db->where(array('alias'=>$data['alias']));
                    };
                   $query = $this->db->get($table);
                   if($query->num_rows() > 0){
                    $data['alias']=$data['alias'].'-'.$id;
                    $query->free_result();
                   }
            }            
           //xu ly metakey va metadesc cho dnah muc va bai viet
           if($table=='content'){//xu ly bai viet
                 // anh dai dien
                if(empty($data['img'])){
                    $diachianh=laydiachianh($data['fulltext']);//lay dia chi anh
                    if(empty($diachianh)){$diachianh='images/default.jpg';}
                    $data['img']=$diachianh;
                }else $data['img']=$data['img'];
                //xu ly introtext
                $loaibohtml=loaibo_html($data['fulltext']);//loai bo ma html
                $loaibohtml=word_limiter($loaibohtml, 30);// lay 30 chu
                $loaibohtml=loaibo_html($loaibohtml);
                $loaibohtml=trim($loaibohtml);
                //xu ly lay hinh anh dau tien
                $width= '128px';
                $height= '128px';
                //chen hinh anh $hinhanh='<p><img src="'.$diachianh.'" alt="'.$data['title'].'" width="'.$width.'" height="'.$height.'" style="float: left;" /></p>';
                $data['introtext']=$loaibohtml;
                if(empty($data['metades'])){$data['metades']=$loaibohtml;}// neu rong
                if(empty($data['metakey'])){$data['metakey']=$data['title'];}// neu rong lay bang tieu de
                $data['fulltext']=loaibo_div_html($data['fulltext']);                
           }elseif(($table=='danhmuc')&&(empty($data['metakey']))){$data['metakey']=$data['title'];}// neu rong lay bang tieu de
           */
           if($table=='network'){
            $data['pb_value']=serialize($data['pb_value']);
            ///////////////tạo file cache
            $dt = $this->Admin_model->get_data('network'); 
            if(!empty($dt)){
                foreach($dt as $dt){
                    $m[$dt->id] = $dt;
                }
                file_put_contents('setting_file/network.txt',serialize($m));
            }  
            
           }
           if($table=='offer'){    
                $smtype  = $this->uri->segment(3);    
                $data['point_geos'] = serialize($data['point_geos']);
                $data['percent_geos'] = serialize($data['percent_geos']);
                if(!empty($data['country'])){
                    $data['country']= 'o'.implode('o',$data['country']).'o';  
                }else{
                    $data['country']='o';
                }
                //offer cat
                if(!empty($data['offercat'])){
                    $data['offercat'] = array_unique($data['offercat']);
                    $data['offercat']= 'o'.implode('o',$data['offercat']).'o';  
                }else{
                    $data['offercat']='o';
                }      
                if($smtype=='offer'){ //offer thông thường              
                    @$netdt= $this->Admin_model->get_one('network',array('id'=>$data['idnet']));
                    $pbv_array= unserialize($netdt->pb_value);
                    unset($pbv_array['4']);
                    unset($pbv_array['5']);                     
                    //unset($data['point_geos']);          
                    $data['subid']=$netdt->subid;                 
                    $data['point']= trim($data['point']);
                    // nhan point voi reate                
                    
                    if(empty($data['percent'])){
                        $data['percent']= 0;  
                    }
                    
                }            
         
          }
           if($table=='users_group'){   
                if(!empty($data['password'])){
                    $data['password']=sha1(md5($data['password']));
                }
           }
           if($table=='manager'){   
                if(!empty($data['password'])){
                    $data['password']=sha1(md5($data['password']));
                }else{
                    unset($data['password']);
                }
                $data['parrent'] = $this->managerid;
           }
           ///xu ly data phan Disoffer
           if($table=='disoffer'){   

                $this->db->select('title');
                $o = $this->Admin_model->get_one('offer',array('id'=>$data['offerid']));
                $data['offername'] = $o->title;
                $this->db->select('email');
                if($this->managerid>1){
                    $wmnager = array('id'=>$data['usersid'],'manager'=>$this->managerid);
                }else{
                    $wmnager = array('id'=>$data['usersid']);
                }
                $u = $this->Admin_model->get_one('users',$wmnager);
                $data['email'] = $u->email;
           }
           ////end 
           //xu ly add
          return $data;  
            
        }
    }   
    function getweek($ok=''){
        $week= date("W", time());
        $ww = file_get_contents('week');        
        if($ok =='ok'){
            file_put_contents('week',$week);
        }        
        if($week!=$ww){            
            echo 1;
        }else{
            echo 0;
        }
        
    } 
    ////////////////////////////   get category cho list
    function category($table,$number=''){        
        switch ($table){
            case 'payment':
              return $this->Admin_model->get_data('manager'); 
              break;
            case 'content':
              return $this->Admin_model->get_data('categories');
              break;
            case 'offer':
              return $this->Admin_model->get_data('network',array());
              break;
            case 'users':
                return $this->db->query("
                SELECT id,username as title FROM cpalead_manager WHERE id = $this->managerid OR parrent = $this->managerid
                ")->result();                          
              break;
            default:
              return true;
              break;
        }         
        
    }
    function validate($table){        
        switch($table){
        case 'slideshow':
            $this->form_validation->set_rules('img','Images','required|xss_clean');
            $this->form_validation->set_rules('show','Show','required|xss_clean|numeric|min_length[1]|max_length[2]'); 
            break;
        case 'article':
            $this->form_validation->set_rules('title','Tên danh mục','required|xss_clean|min_length[2]');
            $this->form_validation->set_rules('noibat','nổi bật','numeric');
            break;
        case 'article_category':
            $this->form_validation->set_rules('title','Tên danh mục','required|xss_clean|min_length[2]');
            $this->form_validation->set_rules('publish','Hiển thị','required|numeric');
            break;
        default:
        return true;                   
        }
        if($this->form_validation->run()==true){
            return true;
        }else return false;
    }  
    function load_thuvien(){
        $this->load->helper(array( 'alias_helper','text','form'));
        $this->load->model("Admin_model");        
    }
    function logout(){
        $this->session->unset_userdata('admin');
        $this->session->unset_userdata('adlogedin');
        $this->session->unset_userdata('aduserid');
        redirect(base_url($this->config->item('manager'))); 
    }
    function phantrang(){
        $this->load->library('pagination');// da load ben tren
        if($this->base_url_trang == '#'){
          $config['base_url'] = base_url().$this->config->item('manager').'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
          
        }else{
            $config['base_url'] =$this->base_url_trang;
        }
        
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->uri_segment;
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
    function mcat($cat){       
        foreach($cat as $cat){
            $mcat[$cat->id]=$cat;
        }
        return $mcat;        
    } 
    function setupnet(){
        $this->load->view('manager/index',array('content'=>$this->load->view('manager/setupnet','',true))); 
    }   
    function test(){    
        // echo '<pre>';
        // var_dump($this->users);
        // echo $this->users->phone;
        // return;
        // $file=file_get_contents('http://mail.opi.yahoo.com/online?u=zzzz&m=a&t=0');
        // if($file=='zzzz is NOT ONLINE'){
        //     echo 123;
        // }else{
        //     echo 'sai';
        // }
       
        
    }
    function approvedall(){
        $this->db->where('status',0);//0 pending
        $u = $this->db->get('users')->result();
        foreach($u as $u){
        
            $this->db->where('id',$u->id);
            $this->db->update('users',array('status'=>1));
       
            $mailign = unserialize($u->mailling);
            $firstname=$mailign['firstname'];
            $lastname = $mailign['lastname'];
            $tieude='Welcome to '.$this->pub_config['sitename'].'- Approved';
            $noidung="
                Dear <b>$firstname $lastname</b>,<p>
                Congratulation, your application has been approved.<br/>
                 In the meantime, please take a look at our current offers which listed in the offer page. If you have any other request then contact your affiliate manager for further information. 
                <br/>
                We are looking forward to lead you to the success in Affiliate Marketing.
                <br/>
                Contact skype if you have any question: ".$this->users->skype."  ( ".$this->users->name."|Wedebeek ).
                <p>
                Regards,<br/>
                Affiliate Application Team                            
                
            ";
            
            if(!$this->guimail($toemail,$tieude,$noidung)){
                sleep(2);
                //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
                $this->guimail($toemail,$tieude,$noidung);
            }
            
            
            
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */