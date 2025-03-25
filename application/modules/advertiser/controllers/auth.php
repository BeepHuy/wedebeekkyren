<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $per_page = 30;
    public $total_rows = 6;
    public $pub_config= '';
    public $data_sitekey='6Lc-NLsZAAAAAAt3usWbXBkPdVsbjFqKtaGYcXkY';//sử dụng recaptcha
    //public $reg_sitekey='6Lc-NLsZAAAAAAt3usWbXBkPdVsbjFqKtaGYcXkY';//sử dụng recaptcha

    private $pindex='';

    function  __construct(){
        parent::__construct();
        //$this->load->model('Home_model');
       // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        if($this->session->userdata('advid')&& $this->uri->segment(2)!='logout'){
            redirect('v2');
        }
        /*
        elseif($this->uri->segment(2)!='panels_login.php' && $this->uri->segment(2)!='panels_register.php' && $this->uri->segment(2)!='forgotpass.php'){
            redirect('admin/panels_login.php');
        }*/
       // $this->setting= unserialize(file_get_contents('setting_file/setting.txt'));
        //$this->Home_model->get_one('adv',array('id'=>$this->session->userdata('advid')));

    }
    function index(){
        echo 'hello';
    }
    function regm($managerid=0){
        if($managerid){
            $this->session->set_userdata('managerid',$managerid);
        }
        redirect(base_url('advertiser/signup'));
    }
    function logout(){
        $this->session->unset_userdata('advid');
        $this->session->unset_userdata('advid');
        $this->session->unset_userdata('advdata');
        redirect(base_url('advertiser/signin'));

    }
    function resetpass(){
        if($_POST){
            $err = 1;
            $dt = '';
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $email = $this->security->xss_clean($_POST['email']);
                $user = $this->Home_model->get_one('adv',array('email'=>$email));
                if( $user){
                    $user = unserialize($user->mailling);
                    //thuwcj thien gui mail reset pass work
                    $this->load->helper('string');
                    $pass= random_string('alnum', 8);
                    $password =sha1(md5($pass));
                    $this->db->where('email',$email );
                    $this->db->update('adv',array('password'=>$password));
                    $sitename = $this->pub_config['sitename'];
                        $tieude=' Your new password for '.$sitename;
                        $name =   $user['firstname']. $user['lastname'];
                        $noidung="
                        <b>Dear $name ,</b><br/>
                        As you requested, your password has now been reset. Your new details are as follows:<br/>
                        Email: $email<br/>
                        Password: $pass<br/>

                        Regards,<br/>
                        Affiliate Application Team.
                        ";

                        $this->guimail($email ,$tieude,$noidung);
                    ///ok men
                    $err = 0;
                    $dt .='Reset Instructions Sent. Please check your email.';
                    //$this->form_validation->set_message('email_exist', 'An Email has been sent to '.$email );

                }else{
                    $dt .='Specified email does not exist<br/>';
                }

            }else{
                $dt= form_error('email');
            }
            //gửi kết quả về cliend
            echo json_encode(array('error'=>$err,'data'=>$dt));
            return;
        }

        $this->load->view('advertiser/auth/losspass','');


    }
    function login(){
        //Reset Instructions Sent. Please check your email.
        $action  = $this->input->get_post('action', TRUE);

        $dem=0;
        if(isset($_COOKIE['attempts'])){
            $dem = $_COOKIE['attempts'];
        }
        if($dem){
            setcookie("attempts",$dem+1,time()+300);

        }else{
            setcookie("attempts",1,time()+300);

        }
            /**************************làm xong thì xóa biên sdêm */
            //$dem =0;
            /**************************làm xong thì xóa biên sdêm */
           // if($dem>=8 && empty($action)){
            //    $this->session->set_userdata('loidn','Please try again for 5 minutes');
            //}else{
                //check spam
                if($_POST){
                 //thuc hien login
                    $err =1;
                    $dt = '';
                    $act = $this->security->xss_clean($_POST['login']);
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
                    $this->form_validation->set_rules('pwd', 'Password', 'trim|required|xss_clean');

                    if ($this->form_validation->run() == TRUE){
                        $email = $this->security->xss_clean($_POST['email']);
                        $password = sha1(md5($_POST['pwd']));                      
                        $log = $this->Home_model->get_one('adv',array('email'=>$email,'password'=>$password));
                        //get_number
                        if($log){
                            //login thanh cong
                            if($log->status==0){
                                $dt =  $this->pub_config['acc_pendding'];                              
                            }elseif($log->status==3){//baned
                                $dt = $this->pub_config['acc_banned'];                               
                            }elseif($log->status==2){//pause
                                $dt = $this->pub_config['acc_pause'];
                            }elseif($log->status==1){//active
                               
                                // $this->db->where('id',$log->id);
                                // $this->db->update('adv',array('ip_login'=>$this->input->ip_address()));                      
                
                                $this->session->set_userdata('advid',$log->id);
                                $this->session->set_userdata('advdata',array('id'=>$log->id,'chatuser'=>$log->chatuser,'balance'=>$log->balance,'email'=>$log->email));
                                $err =0;
                                $dt =' Login successfully';
                            }
                            ///end login thanh cong
                        }else{

                            $dt = 'The email or password is incorrect!';
                        }

                       }else{

                        $dt= form_error('email').' '. form_error('pwd');
                       }

                       //gửi kết quả về cliend
                       echo json_encode(array('error'=>$err,'data'=>$dt));
                       return;
                       ///end thuc hien login
                }
           // }

        $this->load->view('advertiser/auth/login','');


	}
    function approved($name = '',$toemail=''){
        $tieude='Welcome to '.$this->pub_config['sitename'].'- Approved';
        $noidung="
            Dear <b>$name</b>,<p>
            Congratulation, your application has been approved. In the meantime, please take a look at our current offers which listed in the offer page. If you have any other request then contact your affiliate manager for further information.
            <br/>
            We are looking forward to lead you to the success in Affiliate Marketing.
            <br/>
            Contact skype if you have any question: live:longht604.  ( Maxpointmedia ).
            <p>
            Regards,<br/>
            Affiliate Application Team

        ";
        if(!$this->guimail($toemail,$tieude,$noidung)){
            //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
            $this->guimail($toemail,$tieude,$noidung);
        }
    }
    function register($ref=0){            
            $err =1;
            $dt = '';
            $ref = (int)$this->input->get_post('ref');
            if($ref){
                $this->session->set_userdata('ref',$ref);
            }else{
                $ref = $this->session->userdata('ref');
            }
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_check_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]|max_length[20]|matches[confirm_pass]');
            $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'trim|required|xss_clean');
            $data =$this->security->xss_clean($_POST);
            if($data){
                //**************************** */
                $this->mailling = $data['mailling'];
                $loi = '';
                if(empty($data['mailling']['firstname'])){$loi.='Please enter a valid <strong>firstname</strong><br/>';}
                if(empty($data['mailling']['lastname'])){$loi.='Please enter a valid <strong>Lastname</strong><br/>';}
                if(empty($data['mailling']['ad'])){$loi.='Please enter a valid <strong>Address</strong><br/>';}
                if(empty($data['mailling']['website'])){$loi.='Please enter a valid <strong>Website</strong><br/>';}
                /*
                if(empty($data['mailling']['aff_type'])){$loi.='Please enter a valid <strong>Affiliate Type</strong><br/>';}

                if(empty($data['mailling']['country'])){$loi.='Please enter a valid <strong>Country</strong><br/>';}
                if(empty($data['mailling']['city'])){$loi.='Please enter a valid <strong>City</strong><br/>';}
                if(empty($data['mailling']['state'])){$loi.='Please enter a valid <strong>State / Region.</strong><br/>';}
                if(empty($data['mailling']['zip'])){$loi.='Please enter a valid <strong>Zip / Postal Code.</strong><br/>';}
                */
                if(empty($data['mailling']['im_service'])){$loi.='Please enter a valid <strong>IM Name.</strong><br/>';}
                if(empty($data['mailling']['terms'])){$loi.='You must agree and accept the <strong>Terms and Conditions.</strong><br/>';}
                $data['mailling']['aff_type']  = serialize($data['aff_type']);
                ////noi dung registet
                if (($this->form_validation->run() == FALSE)||$loi){
                    if($loi&&$data){
                        $dt = $loi;
                    }
                    if(form_error('email')) $dt .=  '<br/>'.form_error('email').'<br/>';
                    if(form_error('password')) $dt .=  form_error('password').'<br/>';
                //	$this->session->set_userdata('loidn',1);
                }else{
                    

                    $firstname= $data['mailling']['firstname'];
                    $lastname = $data['mailling']['lastname'];

                    $this->load->helper('string');
                    $mangaunhien= random_string('alnum', 16);
                    //lấy dữ liệu để inser
                    $idata['mailling']= serialize($data['mailling']);
                    //$idata['phone']=$data['phone'];
                    $idata['password']=sha1(md5($data['password']));
                    $idata['email']=$data['email'];
                    $idata['username']=$data['username'];
                    $idata['status']=0;
                    $idata['ip']=$this->input->ip_address();
                    $idata['key_active']=$mangaunhien;
                    $idata['ref'] = (int)$ref;                                 
                    //check  active config
                    $sitename = $this->pub_config['sitename'];
                    if($this->pub_config['activate']){
                        $noidung="
                            <b>Dear $firstname $lastname,</b><p>
                            Thanks for interested with $sitename. Your application is completed and will be process within 3-5 business days.
                            </p>
                            <p>
                            In the meantime, please active your account by the following link:
                            <a href=".base_url()."confirmation/$mangaunhien>Active</a>
                            </p>
                            If the active does not work well with your end then please copy and paste the url below for activate your account
                            ".base_url()."confirmation/$mangaunhien
                            <br/>
                            Regards,<br/>
                            Affiliate Application Team.
                            ";

                    }else{
                        $idata['activated']=1;
                        $noidung="
                        <b>Dear $firstname $lastname,</b><p>
                        Thanks for interested with $sitename. Your application is completed and will be process within 3-5 business days.
                        </p>
                        <br/>
                        Regards,<br/>
                        Affiliate Application Team.
                        ";
                    }               

                    $this->db->insert('adv',$idata);
                    $err = 0;
                    $dt .=  $this->pub_config['reg_success_pub'];
                    $toemail=$data['email'];
                    $tieude=$sitename.' Please verify your email address.';
                   @$this->guimail($toemail,$tieude,$noidung);
                    // ham check user da tao $this->mensenger
                }
                ///end noi dung regiset ************************
                echo json_encode(array('error'=>$err,'data'=>$dt));
                return;
            }

            $this->load->view('auth/signup',array('pubconfig'=>$this->pub_config['termsinfo']));

    }

    //kiem tra xem email da ton tai chua. neu ton tai thi thong bao k cho dang ky
    function check_email($email ){
        if($this->Home_model->get_one('adv',array('email'=>$email ))){
            $this->form_validation->set_message('check_email', 'Email already exists!');
			return FALSE;

	    }else{
	       return TRUE;
	    }

    }
    private function guimail($toemail='',$tieude='',$noidung=''){
        $this->load->library('Mailjet');  
        $this->mailjet->send_email($toemail ,$tieude,$noidung,$this->pub_config['emailadmin'],$this->pub_config['sitename']);
        
        // $domain = 'noreply1.maxpointmedia.com';
        // $api = 'ec97c46338119f90db04cf6def88255c-3750a53b-bd3a59f5';
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

    function activate($key=''){
        $log = $this->Home_model->get_one('adv',array('key_active'=>$key));
        if(!empty($log)){
            if(!$log->activated){
                if($log->key_active!=$key){
                    echo 'your activation code is not right, please correct them';
                }else{
                    //xu ly kich hoat
                    $this->db->where('key_active',$key);
                    $this->db->update('adv',array('activated'=>1));
                    //$this->db->update('adv',array('activated'=>1,'status'=>1));   //khong cần chờ admin duyệt
                    echo 'Thanks for interested with '.$this->pub_config['sitename'].'. Your application is completed and will be process within 3-5 business days';//noi dugn thong bao sau khi kich hoat mail
                    $mailling = unserialize($log->mailling);
                    $name =$mailling['firstname'] .' '.$mailling['lastname'];
                    //$this->approved($name,$log->email);//gửi email nếu duyệt luôn
                }
            }else{
                echo 'activated!';
            }
        }else{
            echo 'Your Activation key is experied !';
        }

    }


    function hienthi(){
       $this->load->view('default/index'.$this->pindex,array('content'=>$this->content));
    }




}
