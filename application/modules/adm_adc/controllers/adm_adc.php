<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_adc extends CI_Controller { //admin
    private $page_load='';// chi dinh de load view nao. neu rong thi load mac dinh theo ten bang
    private $databk='';//data function run
    //phan trang
    private $base_url_trang = '#';
    private $total_rows = 100;
    private $per_page =10;
    private $uri_segment = 5;
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
        if(!($this->session->userdata('admin'))){           
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        }else{
            $this->session->set_userdata('upanh',1);
        }
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
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
    function viewmng($id=0){
        if($id){
           $log = $this ->Home_model->get_one('manager',array('id'=>$id));
           $this->session->set_userdata('adlogedin',1);
           $this->session->set_userdata('aduserid',$log->id);
           $this->session->set_userdata('ademail',$log->email);
           $this->session->set_userdata('adavata',$log->images);
           redirect(base_url('manager'));
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
        $url = base_url().$this->config->item('admin').'/route/users/list/';
        echo '
        <style>body{text-align:center;padding-top:50px}</style>
        <meta http-equiv="refresh" content="3;url='.$url.'" />
        <b>'.$tb.'</b> <br/>Trang web sẽ tự động chuyển sau 3s';
        
        
    }
    function ip(){
        echo $this->input->ip_address();
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
    function blockSub2($id=0){
        $us = $this->Admin_model->get_one('users',array('id'=>$id));        
        $this->load->view('block_sub2',['blockSub2' => $us->block_sub2?:'']);
    }
    function actionBlockSub2(){
        $id = (int)$this->input->post('id');
        $sub2data = $this->input->post('sub2data');
        if($id && $sub2data){
            $this->db->where('id',$id)->update('users',['block_sub2'=>$sub2data]);
        }
       
    }
    function index(){
        
        $this->base_url_trang = base_url($this->config->item('admin').'/route/tracklink/list/');;
        $content=''; //$this->run('tracklink','list',0);
        $this->load->view('admin/index',array('content'=>$content));        
        
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
                redirect($this->config->item('admin').'/show_ajax/'.$table.'/list');
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
                redirect($this->config->item('admin').'/route/offer/list');                
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
                        redirect($this->config->item('admin').'/show_ajax/'.$table.'/list');
                    break;
                    case 'offer':
                        if($data==0){$this->session->set_userdata('where',array('show'=>1));
                        }else $this->session->set_userdata('where',array('idnet'=>$data));
                        redirect($this->config->item('admin').'/show_ajax/'.$table.'/list');
                    break;
                    case 'users':
                        if($data==0){$this->session->set_userdata('where',array('id !='=>1));
                        }else $this->session->set_userdata('where',array('manager'=>$data,'id !='=>1));
                        redirect($this->config->item('admin').'/show_ajax/'.$table.'/list');
                    break;
                    case 'payment':
                        if($data==0){$this->session->set_userdata('where',array('id !='=>1));
                        }else $this->session->set_userdata('where',array('manager'=>$data,'id !='=>1));
                        redirect($this->config->item('admin').'/show_ajax/'.$table.'/list');
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
        // $from = $this->pub_config['sitename']. '<'.$this->pub_config['emailadmin'].'>';
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
    
    /*
    function guimail($toemail='',$tieude='',$noidung=''){
        $this->load->library('email');
        $this->email->clear(TRUE);
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
         
        $this->email->from($this->pub_config['emailadmin'], $this->pub_config['sitename']);
        $this->email->to($toemail); 
        //$this->email->cc('another@another-example.com'); 
        //$this->email->bcc('them@their-example.com'); 
        
        $this->email->subject($tieude);
        $this->email->message($noidung);	
        
        //$this->email->send();
        if ( ! $this->email->send())
        {
            return false;
        }else{
            return true;
        }
       // echo $this->email->print_debugger();
    }*/

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
            $key = $this->input->post('keycode');  
            $balance = $this->input->post('balance');  
            $pending = $this->input->post('pending');  
            $current = $this->input->post('curent');             
            if($key){
                $this->session->set_userdata('like',$key);
            }else{
                $this->session->unset_userdata('like');
            }       
            //xử lý lọc theo point
            $where=$this->session->userdata('where');
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
            $this->session->set_userdata('where',$where);
           //$where=$this->session->userdata('where');$where['id !=']=1;$this->session->set_userdata('where',$where);
            
        }
    }
   
    /// gui email cho member
    function emailtool($offset=0){
        $this->per_page = 50;
        if($_POST){
            $tieude = $_POST['sub'];
            $noidung= $_POST['ct'];
            $uid = $_POST['uid'];
            $enail_search = $_POST['search'];
            $action = $_POST['act'];
            $wherein = $w='';
            if($action=='send'){
                if(!empty($uid)){
                    if($tieude)$this->session->set_userdata('sub',$tieude);
                    if($noidung)$this->session->set_userdata('ct',$noidung);
                    $this->db->select(array('email','mailling'));
                    $this->db->where_in('users.id',$uid);           
                    $user = $this->Admin_model->get_data('users',array('id !='=>1));            
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
        if($wherein)$this->db->where_in('email',$wherein);
        $this->db->limit($this->per_page,$offset);
        $dtuser = $this->Admin_model->get_data('users',array('id !='=>1,'status'=>1));
        //
        //phan trang
        if($wherein){
            $this->db->where_in('email',$wherein);
        } 
        $this->db->from('cpalead_users');
        $this->total_rows= $this->db->count_all_results();
        
        $this->uri_segment=3;
        $this->base_url_trang = base_url('admin/emailtool/');
        $this->phantrang();
        //
        
        $content= $this->load->view('admin/content/emailtool.php',array('dt'=>$dt,'us'=>$dtuser),true);
        $this->load->view('admin/index',array('content'=>$content));

        
            
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
        $this->load->view('admin/content/user_do_offer.php',array('dt'=>$dt));
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
            $data['ref'] ="admin"; 
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
                    'admin/index',
                    array(
                        'content'=>$this->load->view('admin/content/addusers',array('thongbao'=>$thongbao),true)
                        )
                    ); 
    }
    function showev($table,$dieukhien='',$number=''){
        $this->load->helper('excel');

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
           
            }
            //trường hợp mới vào chưa có time
            if(!$this->session->userdata('from')){
            $from= date('Y-m-d');
            $this->session->set_userdata('from',$from);
            }
            if(!$this->session->userdata('to')){
            $to =date('Y-m-d');
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
                $where .= ' status = '.$status. ' and '; 
                $groupby .=',status';
            }
            
            if($pubid){           
                $where .= ' userid = '.$pubid. ' and ';                
            }else{
                if($pubcheck){
                $groupby .=',userid';
                }
            }
            $qr = "
            SELECT date,offerid,userid,idnet,oname,count(id) as click,sum(flead) as lead, count(DISTINCT ip) as uniq,s2,
            sum(cpalead_tracklink.amount) as pay,
              CASE 
                WHEN status = 1 THEN 'Pending'
                WHEN status = 2 THEN 'Declined'
                WHEN status = 3 THEN 'Pay'
            END AS status
            FROM `cpalead_tracklink`  
            WHERE $where date BETWEEN ? AND ?  group by $groupby";
            $rp = $this->db->query($qr,array($from." 00:00:00",$to." 23:59:59"))->result();   
            if($this->input->post('export')){
                // Chuyển đổi dữ liệu thành mảng
                $epData = array();
                foreach ($rp as $row) {
                    $epData[] = (array) $row;  // Chuyển đổi từng đối tượng thành mảng
                }
                // Định nghĩa tên cột
                $column_names = array('Date', 'Offer ID', 'Offer Name',  'PublisherId', 'Click', 'Lead', 'Unique', 'S2', 'Amount');
                // Xuất dữ liệu ra Excel
                export_to_excel(date('Y-m-d').'_offer_report.xlsx', $epData, $column_names);
            }else{
                $ct = $this->load->view('admin/content/report.php',array('dulieu'=>$rp),true);
                $this->load->view('admin/index',array('content'=>$ct)); 
            }
           
        }//end report
        ///hien groupcategory
        if($table=='groupcat'){
            $this->per_page =100;
            $table='offercat';
            $this->page_load = 'groupcat_list';
            $this->load->view('admin/index',array('content'=>$this->run($table,$dieukhien,$number))); 
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
            $this->load->view('admin/index',array('content'=>$this->run($table,$dieukhien,$number))); 
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
            $dt = $this->load->view('admin/content/user_credit',array('dulieu'=>$rp),true);
            $this->load->view('admin/index',array('content'=>$dt)); 
        }
        
    }


    function resetip($offset=0){  
        $startdate=$endate=$thongbao=$idoff='';
        
        if($_POST){   
            $idoff =trim($this->input->post('idoff',true));
            /*
            $country =trim($this->input->post('country',true));
            $startdate =trim($this->input->post('startdate',true));
            $endate = trim($this->input->post('enddate',true));
            if(!empty($country)){
                $where['country'] =$country;
            }
            
            if(!empty($startdate)){
                $where['date >='] = date('Y-m-d H:i:s',strtotime( $startdate ));
            }
            if(!empty($endate)){
                $where['date <='] = date('Y-m-d H:i:s',strtotime( $endate ));
            }
            */
            $where['offerid']= $idoff;
            $this->db->where($where);
            $this->db->update('tracklink',array('ip'=>0));
            $thongbao = 'Reset Done ! <br/> Offer Id: '.$idoff;
        }
        
         
        $content=$this->load->view('admin/content/resetip',
                        array(
                        //'start'=>$startdate,
                        //'end'=>$endate,
                        'thongbao'=>$thongbao   ,
                        'idoff'=>$idoff                            
                        ),true);        
        
        $this->load->view('admin/index',array('content'=>$content));
        
    }

    function route($table,$dieukhien='',$number=''){
        if($table=='smartoffers' ||  $table=='smartlinks'){
            $table='offer';
            $this->session->unset_userdata('osearch');
        }
        $this->load->view('admin/index',array('content'=>$this->run($table,$dieukhien,$number)));        
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
                                $data['check_trung'] = trim($data['userid']).'-'.trim($data['offerid']);
                                $check = $this->Admin_model->get_one($table,array('check_trung'=>$data['check_trung']));
                                if($check){
                                    $this->session->set_userdata('thongbao','<div class="alert alert-warning" role="alert">
                                                                                Request đã tồn tại
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
                            redirect(base_url($this->config->item('admin').'/offers/smartoffers'));
                        }
                        if($table=='offer' && $smtype=='smartlinks'){
                            redirect(base_url($this->config->item('admin').'/offers/smartlinks'));
                        }
                        if($table=='offer'){
                            redirect(base_url($this->config->item('admin').'/offers/listoffer'));
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
                        ///-------<<<<<<>>>>>>>>>||||||||||||----lay tong so hang phan trang>>>>>>
                        $this->total_rows =$this->Admin_model->get_number($table,$this->session->userdata('where'));
                        $this->phantrang();
                        
                        //------------->>>>>>...tim kiem offer vaf user
                        if($table=='offer'&&$this->session->userdata('idin')){
                            foreach($this->session->userdata('idin') as $ocat){
                                $this->db->like('offercat','o'.$this->session->userdata('idin').'o');
                            }
                        }
                        if($table=='users'){
                            if($this->session->userdata('like')){
                                if(is_numeric($this->session->userdata('like'))){
                                    $this->db->like('id', $this->session->userdata('like'), 'none');
                                }else{
                                    $this->db->like('email', $this->session->userdata('like'));
                                }
                            }
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
                            redirect(base_url($this->config->item('admin').'/offers/smartoffers'));
                        }
                        if($table=='offer' && $smtype=='smartlinks'){
                            redirect(base_url($this->config->item('admin').'/offers/smartlinks'));
                        }
                        if($table=='offer'){
                            redirect(base_url($this->config->item('admin').'/offers/listoffer'));
                        }if($table=='request'){
                            redirect(base_url($this->config->item('admin').'/offersrequest/orlist'));
                        }else{
                            redirect($this->config->item('admin')."/route/$table/list", 'refresh');
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
               
                return $this->load->view('admin/content/'.$page,$data_view,true) ;   
            }
            
            //$this->session->set_userdata(array('order'=>'id','orderby'=>'desc'));        
     
        
    }    
    function xuly_data($table,$data,$id=''){
        if(!empty($table)&&!empty($data)){
            if(!empty($data['id'])){
             unset($data['id']) ;  
            }            
                  
          
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
           }
           ///xu ly data phan Disoffer
           if($table=='disoffer'){   
                $this->db->select('title');
                $o = $this->Admin_model->get_one('offer',array('id'=>$data['offerid']));
                $data['offername'] = $o->title;
                $this->db->select('email');
                $u = $this->Admin_model->get_one('users',array('id'=>$data['usersid']));
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
               return $this->Admin_model->get_data('manager','','','',array('id','username as title'));              
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
        redirect(base_url($this->config->item('admin'))); 
    }
    function phantrang(){
        $this->load->library('pagination');// da load ben tren
        if($this->base_url_trang == '#'){
          $config['base_url'] = base_url().$this->config->item('admin').'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
          
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
        $this->load->view('admin/index',array('content'=>$this->load->view('admin/setupnet','',true))); 
    }   
    function test(){        
        
       $domain = 'noreply3.wedebeek.com';
        $api = '738d80a2f18a41c0c4d6a9e67696516c-31eedc68-b5347e9d';
        $from = $this->pub_config['sitename']. '<'.$this->pub_config['emailadmin'].'>';
        //'rocketmediapro <noreply@rocketmediapro.com>'
        //$txt = strip_tags($noidung);
        $curl_post_data=array(
            'from'    => $from,
            'to'      => 'duymuoi@gmail.com',
            'subject' => 'thử nghiệm gửi mail từ site',
            'html' => "xin chao",
            'text'    => "xin chao"
        );
        
        //$service_url = 'https://api.mailgun.net/v3/mailgun.rocketmediapro.com/messages';
        //https://api.mailgun.net/v3/noreply2.wedebeek.com
        $service_url = 'https://api.mailgun.net/v3/'.$domain.'/messages';
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "api:$api"); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        $curl_response = curl_exec($curl);  
        $response = json_decode($curl_response);
        curl_close($curl);       
        echo $response->message;
        
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
                Contact skype if you have any question: live:.cid.dc3f3f4d372582ea  ( Bi Phan|Wedebeek ).
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