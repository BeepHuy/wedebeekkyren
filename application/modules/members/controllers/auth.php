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
        $this->load->model('Country_model'); // Tải model
        $this->load->model('Offercat_model'); // Tải model
        $this->load->library('form_validation');
        $this->load->model('Home_model');
        //$this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));

        //Đọc nội dung file publisher.txt, giải mã chuỗi đã serialize và gán vào biến $this->pub_config.
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));

        if($this->session->userdata('logedin')&& $this->uri->segment(2)!='logout'){
            redirect('v2');
        }
        /*
        elseif($this->uri->segment(2)!='panels_login.php' && $this->uri->segment(2)!='panels_register.php' && $this->uri->segment(2)!='forgotpass.php'){
            redirect('admin/panels_login.php');
        }*/
       // $this->setting= unserialize(file_get_contents('setting_file/setting.txt'));
        //$this->Home_model->get_one('users',array('id'=>$this->session->userdata('userid')));

    }

    function index(){
        echo 'hello';
    }

    function regm($managerid=0){
        if($managerid){
            $this->session->set_userdata('managerid',$managerid);
        }
        redirect(base_url('v2/sign/up'));
    }

    function logout(){
        $this->session->unset_userdata('logedin');
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('userdata');
        redirect(base_url('v2/sign/in'));
    }

    function resetpass(){
        if($_POST){
            $err = 1;
            $dt = '';
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $email = $this->security->xss_clean($_POST['email']);
                $user = $this->Home_model->get_one('users',array('email'=>$email));
                if( $user){
                    $user = unserialize($user->mailling);
                    //thuwcj thien gui mail reset pass work
                    $this->load->helper('string');
                    $pass= random_string('alnum', 8);
                    $password =sha1(md5($pass));
                    $this->db->where('email',$email );
                    $this->db->update('users',array('password'=>$password));
                    $sitename = $this->pub_config['sitename'];
                        $tieude=' Your new password for '.$sitename;
                        $name = (isset($user['firstname']) ? $user['firstname'] : '') . ' ' . (isset($user['lastname']) ? $user['lastname'] : '');
                        $dataemail = [
                            'name' => $name,
                            'email' => $email,
                            'pass' => $pass
                        ];
                        $noidung = $this->load->view('email/passrecover.php',$dataemail,true);
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

        $this->load->view('members/auth/losspass','');


    }

    function login(){

        //Reset Instructions Sent. Please check your email.
        $action  = $this->input->get_post('action', TRUE);

        //Khởi tạo biến đếm bằng 0
        $dem=0;

        if(isset($_COOKIE['attempts'])){

            //Nếu có, gán giá trị của cookie attempts vào biến $dem.
            //Nếu có (nghĩa là người dùng đã có lần truy cập trước), tăng giá trị attempts lên 1 và gia hạn thêm 5 phút (time()+300).
            $dem = $_COOKIE['attempts'];
        }

        if($dem){
            //Nếu không (người dùng lần đầu), đặt cookie attempts bằng 1 với thời hạn 5 phút.
            setcookie("attempts",$dem+1,time()+300);
        }else{
            setcookie("attempts",1,time()+300);
        }
            //$dem =0;
            /**************************làm xong thì xóa biên sdêm */
           // if($dem>=8 && empty($action)){
            //    $this->session->set_userdata('loidn','Please try again for 5 minutes');
            //}else{
                //check spam
                if(!empty($_POST)){
                    //thuc hien login
                    $err =1;
                    $dt = '';

                    //Lấy và làm sạch giá trị login từ form POST để ngăn tấn công XSS.
                    $act = $this->security->xss_clean($_POST['login']);

                    //Validate
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
                    $this->form_validation->set_rules('pwd', 'Password', 'trim|required|xss_clean');

                    //Nếu validate trả về true
                    if ($this->form_validation->run() == TRUE){
                        
                        //Lấy và làm sạch giá trị email từ form POST để ngăn tấn công XSS.
                        $email = $this->security->xss_clean($_POST['email']);

                        //Mã hóa mật khẩu bằng cách áp dụng md5() trước, rồi tiếp tục mã hóa kết quả bằng sha1().
                        $password = sha1(md5($_POST['pwd']));

                        //Lấy một bản ghi từ bảng users trong cơ sở dữ liệu, nơi email và password khớp với giá trị đã cung cấp.
                        $log = $this->Home_model->get_one('users',array('email'=>$email,'password'=>$password));

                        //Nếu log tồn tại thì là login thành công
                        if ($log) {
                            //login thanh cong
                            if ($log->status==0) {
                                //Nếu acc đang pending
                                $dt =  $this->pub_config['acc_pendding'];
                            } elseif ($log->status==3) {//baned
                                //Nếu account bị banned
                                $dt = $this->pub_config['acc_banned'];
                            } elseif ($log->status==2) {//pause
                                //Nếu account bị pause
                                $dt = $this->pub_config['acc_pause'];
                            } elseif($log->status==1) {//active

                                //Nếu account ok
                                $this->db->where('id',$log->id);

                                //Dùng id người dùng để cập nhật ip_login bằng địa chỉ IP hiện tại.
                                $this->db->update('users',array('ip_login'=>$this->input->ip_address()));

                                //Đánh dấu người dùng đã đăng nhập.
                                $this->session->set_userdata('logedin',1);

                                // Lưu ID người dùng.
                                $this->session->set_userdata('userid',$log->id);

                                //Lưu thông tin người dùng gồm id, balance, email.
                                $this->session->set_userdata('userdata',array('id'=>$log->id,'balance'=>$log->balance,'email'=>$log->email));

                                //Trả về trạng thái lỗi bằng 0
                                $err =0;
                                $dt =' Login successfully';
                            }
                            ///end login thanh cong
                        } else {
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

        $this->load->view('members/auth/login','');


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
        $managerid = 0;
        $err =1;
        $dt = '';
        $sitename = $this->pub_config['sitename'];
    
        //Nếu người dùng đã đăng nhập rồi thì chuyển hướng 
        if($this->session->userdata('user')){
            redirect('v2/profile');
        }
    
        // Kiểm tra phương thức HTTP
        $method = $this->input->server('REQUEST_METHOD');
    
        if ($method === 'POST') {
            // Xử lý AJAX POST
            $ref = (int)$this->input->get_post('ref');
            if($ref){
                $this->session->set_userdata('ref',$ref);
            }else{
                $ref = $this->session->userdata('ref');
            }
    
            $data = $this->input->post(NULL, TRUE);
            $email = $this->input->post('email', TRUE);
            if ($this->Home_model->get_one('users', array('email' => $email))) {
                echo json_encode(array('error' => 1, 'data' => 'Email already exists in the system. Please use a different email.'));
                return;
            }

    
            //Validate
            if ($this->validate() == FALSE) {
                // Trả về JSON lỗi
                $errors = validation_errors('<li>', '</li>');
                echo json_encode(array('error'=>1,'data'=>"<ul>".$errors."</ul>"));
                return;
            } else {
                // Validate OK, tiến hành insert
                if($this->session->userdata('managerid')){
                    $managerid = $this->session->userdata('managerid');
                } else {
                    $qr = "
                    UPDATE cpalead_manager SET id = @id := id, pub_count=pub_count+1
                    WHERE id >1 AND parrent = 0
                    ORDER BY pub_count ASC
                    LIMIT 1";
                    $this->db->query($qr);
                    $qr=' SELECT @id as id';
                    $dtt = $this->db->query($qr)->row();
                    if($dtt){
                        $managerid =$dtt->id;
                    }
                }
    
                $firstname= $data['mailling']['firstname'];
                $lastname = $data['mailling']['lastname'];
    
                $this->load->helper('string');
                $mangaunhien= random_string('alnum', 16);
                $data['mailling']['aff_type']  = serialize($data['aff_type']);
                $idata['mailling']= serialize($data['mailling']);
                $idata['manager'] = $managerid;
                $idata['password']=sha1(md5($data['password']));
                $idata['email']=$data['email'];
                $idata['status']=0;
                $idata['ip']=$this->input->ip_address();
                $idata['key_active']=$mangaunhien;
                $idata['ref'] = (int)$ref;
                $idata['phone']=$data['phone'];
                $idata['biz_desc'] = $data['biz_desc'];
    
                //Xử lý upload file reg_cert
                if (isset($_FILES['reg_cert'])) {
                    $image_names = $this->img_handle($_FILES['reg_cert']); 
                    if ($image_names) {
                        $images_string = implode(',', $image_names);
                        $idata['reg_cert'] = $images_string;
                    }
                }
    
                if($this->pub_config['activate']){
                    $idata['activated']=0;
                    $datamail = [
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'mangaunhien' => $mangaunhien
                    ];
                    $noidung = $this->load->view('email/verifiy.php',$datamail,true); 
                } else {
                    $idata['activated']=1;
                    $datamail = [
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                    ];
                    $noidung = $this->load->view('email/acitved.php',$true); 
                }
    
                //Tạo API key duy nhất
                getapikey:
                $key = substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30);
                if($this->Home_model->get_one('users',array('api_key'=>$key))){
                    goto getapikey;
                }
                $idata['api_key']= $key;
                if ($this->Home_model->get_one('users', array('email' => $email))) {
                    echo json_encode(array('error' => 1, 'data' => 'Email already exists in the system. Please use a different email.'));
                    return;
                }

                $this->db->insert('users',$idata);
                $user_id = $this->db->insert_id(); // ID của user vừa tạo
                if (!empty($_POST['offercat'])) {
                    $value = [];
                    foreach ($_POST['offercat'] as $offercat_id) {
                        $value[] =   "($user_id, $offercat_id)";
                    }
                    if (!empty($value)) {
                        $sql = "INSERT INTO cpalead_useroffercats (user_id, offercat_id) VALUES " . implode(',', $value);
                        $this->db->query($sql);
                    }
                }
                $err = 0;
                $dt = $this->pub_config['reg_success_pub'];
    
                $tieude=$sitename.' Please verify your email address.';
                $toemail = $data['email'];
                @$this->guimail($toemail,$tieude,$noidung);
    
                // Trả về JSON success
                echo json_encode(array('error'=>0,'data'=>$dt));
                return;
            }
    
        } elseif ($method === 'GET') {
             //Nếu là GET thì trả về view
             $data['country'] =  $this->Country_model->get_country();
             $data['traftype'] = $this->db->get('traftype')->result();  // Trả về mảng các mảng liên kết
             $data['offercat'] = $this->Offercat_model->get_offercat();
             $data['pubconfig'] = $this->pub_config['termsinfo'];
            $this->load->view('auth/signup', $data);
        }
    }
    

    
    function img_handle($newimg){

        // Xác định đường dẫn thư mục lưu ảnh
        $path = FCPATH . 'upload/pub/ava/';
            
        if (!is_dir($path)) {
            mkdir($path, 0777, true); // Tạo thư mục nếu chưa tồn tại
        }
    
        $image_names = []; // Mảng lưu tên file
    
        foreach ($newimg['name'] as $key => $name) {
            if ($newimg['error'][$key] === UPLOAD_ERR_OK) { // Kiểm tra không lỗi
                $tmp_name = $newimg['tmp_name'][$key];
                
                // Tạo tên file mới với prefix
                $prefix = uniqid(); // Tạo chuỗi ngẫu nhiên
                $new_filename = $prefix . '_' . $name;

                // Di chuyển file đến thư mục lưu
                if (move_uploaded_file($tmp_name, $path . $new_filename)) {
                    $image_names[] = $new_filename; // Lưu tên file mới vào mảng
                }
            }
        }
    
        //Xử lý lưu tên file vào database 
        if (!empty($image_names)) {
            return $image_names;
        } else {
            return false;
        } 
    }

    function validate(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_email');
        $this->form_validation->set_rules('reg_cert', 'your Company Registration Certificate','callback_validate_file');
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|callback_validate_password'
        );
        $this->form_validation->set_message('matches', 'Repeat Password does not match Password.');
        $this->form_validation->set_rules('confirm_pass','Repeat Password','required|matches[password]');
        $this->form_validation->set_rules("mailling[im_service]",'your Skype ID/ Telegram','required');
        $this->form_validation->set_rules(
            "mailling[firstname]", 
            'First Name', 
            'trim|required|xss_clean|callback_check_name'
        );
        $this->form_validation->set_rules(
            "mailling[lastname]", 
            'Last Name', 
            'trim|required|xss_clean|callback_check_name'
        );
        $this->form_validation->set_rules("mailling[ad]",'your Street','required');
        $this->form_validation->set_rules("mailling[city]",'your City','required');
        $this->form_validation->set_rules("mailling[country]",'your Country','required');
        $this->form_validation->set_rules("mailling[state]",'your State/Region','required');
        $this->form_validation->set_rules("mailling[zip]",'your Zip Code','required|alpha_numeric');
        $this->form_validation->set_rules('phone','your Phone Number','required|numeric');
        $this->form_validation->set_rules('offercat','your Offer Categories','required');
        $this->form_validation->set_rules('aff_type','Traffic Source','required');
        $this->form_validation->set_rules(
            'mailling[website]', 
            'URL’s Traffic Source', 
            'required|callback_check_url'
        );
        $this->form_validation->set_rules('biz_desc','Briefly Describe Your Business Activities','required');
        $this->form_validation->set_rules('mailling[terms]', 'Terms and Conditions', 'required');
        $this->form_validation->set_rules('agree2', 'Terms and Conditions', 'required');
        return $this->form_validation->run(); // Trả về kết quả true/false
    }

    public function validate_password($password)
    {
        // Kiểm tra độ dài password (tối thiểu 6 ký tự)
        if (strlen($password) < 6) {
            $this->form_validation->set_message('validate_password', 'Password must be at least 6 characters long.');
            return false;
        }

        // Kiểm tra xem có ít nhất một số
        if (!preg_match('/[0-9]/', $password)) {
            $this->form_validation->set_message('validate_password', 'Password must include at least one number.');
            return false;
        }

        // Kiểm tra xem có ít nhất một ký tự đặc biệt
        if (!preg_match('/[\W]/', $password)) {
            $this->form_validation->set_message('validate_password', 'Password must include at least one special character.');
            return false;
        }

        // Nếu tất cả điều kiện đều thỏa mãn
        return true;
    }

    public function check_name($str) {
        // Cho phép các chữ cái Unicode (có dấu) và khoảng trắng
        if (!preg_match("/^[\p{L}\s]+$/u", $str)) {
            $this->form_validation->set_message('check_name', 'The %s field must contain only letters (including accented letters) and spaces.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_url($str) {
        // Chỉ chấp nhận URL đầy đủ bắt đầu bằng http hoặc https
        if (!preg_match("/^https?:\/\/([a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}|[0-9]{1,3}(\.[0-9]{1,3}){3})(\/\S*)?$/", $str)) {
            $this->form_validation->set_message('check_url', 'The %s field must be a valid URL starting with http:// or https://.');
            return FALSE;
        }
        return TRUE;
    }
    

    public function validate_file() {

        // Nếu không có file được upload, coi như hợp lệ (tùy chọn)
        if (!isset($_FILES['reg_cert']['name'][0]) || $_FILES['reg_cert']['error'][0] === UPLOAD_ERR_NO_FILE) {
            return TRUE; // Không có file hoặc có lỗi khi upload
        }
    
        $allowed_types = ['jpeg', 'png', 'jpg', 'pdf', 'svg']; // Các định dạng cho phép
        $max_size = 2048; // Kích thước tối đa (KB)
       
        // Kiểm tra số lượng file
        if (count($_FILES['reg_cert']['name']) > 3) {
            $this->form_validation->set_message('validate_file', 'You can upload a maximum of 3 files.');
            return FALSE;
        }
    
        // Kiểm tra từng file
        foreach ($_FILES['reg_cert']['name'] as $key => $name) {
            // Lấy phần mở rộng của file
            $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    
            // Kiểm tra định dạng file
            if (!in_array($file_ext, $allowed_types)) {
                $this->form_validation->set_message('validate_file', 'Each file must be of type: jpeg, png, jpg, pdf, svg.');
                return FALSE;
            }
    
            // Kiểm tra kích thước file
            if ($_FILES['reg_cert']['size'][$key] > ($max_size * 1024)) {
                $this->form_validation->set_message('validate_file', 'Each file size cannot exceed ' . $max_size . ' KB.');
                return FALSE;
            }
        }
    
        return TRUE; // Tất cả file hợp lệ
    }

    private function callApi($ckey){
        $url = 'https://api.countrystatecity.in/v1/countries/'.$ckey.'/states';
        $headers = [
            'X-CSCAPI-KEY: cGhRTmJ4am5YeUxSWVczbkIzZTNNQm14MWxsalg5dEw2MUxFeU5SSg==' 
        ];
        //Khởi tạo phiên làm việc
        //curl_init() tạo ra một handle mà bạn sử dụng để làm việc với cURL.
        // Handle $curl đại diện cho một phiên làm việc (session) với cURL.
        $curl = curl_init();

        curl_setopt_array($curl, [
            //Chỉ định URL của API
            CURLOPT_URL => $url,
            //Nhận kết quả trả về thay vì in ra màn hình
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 5,
            //API yêu cầu headers (API Key, Content-Type)
            CURLOPT_HTTPHEADER => $headers,
            // Chỉ cần nếu gặp lỗi SSL hoặc dev trên server tự ký chứng chỉ.
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        
        //Thực hiện yêu cầu HTTP đã được thiết lập trong $curl.
        //Nhận phản hồi từ server và lưu vào biến $response.
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return 'Error: ' . curl_error($curl); // Nếu có lỗi, trả về lỗi
        }

        //Đóng phiên làm việc cURL.
        curl_close($curl);
        return $response;
    }

    //Ajax để trả về state của country
    function ajax(){
        $key = $this->input->post('ckey');
        $state = $this->callApi($key);
        header('Content-Type: application/json'); // Đảm bảo header JSON
        echo json_encode($state);
    }

    //kiem tra xem email da ton tai chua. neu ton tai thi thong bao k cho dang ky
    function check_email($email ){
        if($this->Home_model->get_one('users',array('email'=>$email ))){
            $this->form_validation->set_message('check_email', 'Email already exists!');
			return FALSE;

	    }else{
	       return TRUE;
	    }

    }

    private function guimail($toemail='',$tieude='',$noidung=''){
        $this->load->library('Mailjet');  
        $this->mailjet->send_email($toemail ,$tieude,$noidung,'support@wedebeek.com',$this->pub_config['sitename']);
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
        $log = $this->Home_model->get_one('users',array('key_active'=>$key));
        $mailling = unserialize($log->mailling);
        if(!empty($log)){
            if(!$log->activated){
                if($log->key_active!=$key){
                    echo 'your activation code is not right, please correct them';
                }else{
                    // xu ly kich hoat
                    $this->db->where('key_active',$key);
                    $this->db->update('users',array('activated'=>1));
                    // Khong cần chờ admin duyệt
                    /* $this->db->update('users',array('activated'=>1,'status'=>1));   */ 
                    $datamail = [
                        'firstname' => $mailling['firstname'],
                        'lastname' => $mailling['lastname'],
                    ];
                    $noidung = $this->load->view('email/verified.php');
                    echo $noidung;
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