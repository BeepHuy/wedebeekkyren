<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $per_page = 30;
    public $total_rows = 6;
    public $pub_config= '';
    public $data_sitekey='6Lc-NLsZAAAAAAt3usWbXBkPdVsbjFqKtaGYcXkY';//sử dụng recaptcha

    private $pindex='';

    function  __construct(){
        parent::__construct();
        $this->load->model('Country_model'); // Tải model
        $this->load->library('form_validation');
        $this->load->model('Home_model');
        // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        if ($this->session->userdata('id') && $this->uri->segment(3) != 'logout') {
            redirect('v3');
        }
        /*
        elseif($this->uri->segment(2)!='panels_login.php' && $this->uri->segment(2)!='panels_register.php' && $this->uri->segment(2)!='forgotpass.php'){
            redirect('admin/panels_login.php');
        }*/
        // $this->setting= unserialize(file_get_contents('setting_file/setting.txt'));
        //$this->Home_model->get_one('adv',array('id'=>$this->session->userdata('advid')));

    }
    function index()
    {
        echo 'hello';
    }
    function regm($managerid = 0)
    {
        if ($managerid) {
            $this->session->set_userdata('managerid', $managerid);
        }
        redirect(base_url('v3/sign/up'));
    }
    function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('logedin');
        $this->session->unset_userdata('userdata');

        $this->session->sess_destroy();

        redirect(base_url('v3/sign/in'));
    }
    function resetpass()
    {
        if ($_POST) {
            $err = 1;
            $dt = '';
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $email = $this->security->xss_clean($_POST['email']);
                $user = $this->Home_model->get_one('advertiser', array('email' => $email));
                if ($user) {
                    $user = unserialize($user->mailling);
                    //thuwcj thien gui mail reset pass work
                    $this->load->helper('string');
                    $pass = random_string('alnum', 8);
                    $password = sha1(md5($pass));
                    $this->db->where('email', $email);
                    $this->db->update('advertiser', array('password' => $password));
                    $sitename = $this->pub_config['sitename'];
                    $tieude = ' Your new password for ' . $sitename;
                    $name =   $user['firstname'] . $user['lastname'];
                    $noidung = "
                        <b>Dear $name ,</b><br/>
                        As you requested, your password has now been reset. Your new details are as follows:<br/>
                        Email: $email<br/>
                        Password: $pass<br/>

                        Regards,<br/>
                        Affiliate Application Team.
                        ";

                    $this->guimail($email, $tieude, $noidung);
                    ///ok men
                    $err = 0;
                    $dt .= 'Reset Instructions Sent. Please check your email.';
                    //$this->form_validation->set_message('email_exist', 'An Email has been sent to '.$email );

                } else {
                    $dt .= 'Specified email does not exist<br/>';
                }
            } else {
                $dt = form_error('email');
            }
            //gửi kết quả về cliend
            echo json_encode(array('error' => $err, 'data' => $dt));
            return;
        }

        $this->load->view('advertiser/auth/losspass', '');
    }
    function login()
    {
        if ($this->session->userdata('logedin')) {
            redirect('v3');
            return;
        }
        //Reset Instructions Sent. Please check your email.
        $action  = $this->input->get_post('action', TRUE);

        $dem = 0;
        if (isset($_COOKIE['attempts'])) {
            $dem = $_COOKIE['attempts'];
        }
        if ($dem) {
            setcookie("attempts", $dem + 1, time() + 300);
        } else {
            setcookie("attempts", 1, time() + 300);
        }
        
        if ($_POST) {
            //thuc hien login
            $err = 1;
            $dt = '';
            $act = $this->security->xss_clean($_POST['login']);
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

            if ($this->form_validation->run() == TRUE) {
                $email = $this->security->xss_clean($_POST['email']);
                $password = sha1(md5($_POST['password']));
                $log = $this->Home_model->get_one('advertiser', array('email' => $email, 'password' => $password));
                //get_number
                if ($log) {
                    //login thanh cong
                    if ($log->status == 0) {
                        $dt =  $this->pub_config['acc_pendding'];
                    } elseif ($log->status == 3) { //baned
                        $dt = $this->pub_config['acc_banned'];
                    } elseif ($log->status == 2) { //pause
                        $dt = $this->pub_config['acc_pause'];
                    } elseif ($log->status == 1) { //active

                        $this->db->where('id', $log->id);
                        $this->db->update('advertiser', array('ip_login' => $this->input->ip_address()));
                        $this->session->set_userdata('logedin', 1);

                        $this->session->set_userdata('advid', $log->id);
                        $this->session->set_userdata('advdata', array('id' => $log->id, 'chatuser' => $log->chatuser, 'balance' => $log->balance, 'email' => $log->email));
                        $err = 0;
                        $dt = ' Login successfully';
                    }
                    ///end login thanh cong
                } else {

                    $dt = 'The email or password is incorrect!';
                }
            } else {

                $dt = form_error('email') . ' ' . form_error('advertiser');
            }

            //gửi kết quả về cliend
            echo json_encode(array('error' => $err, 'data' => $dt));
            return;
            ///end thuc hien login
        }
        // }

        $this->load->view('advertiser/auth/login', '');
    }
    function approved($name = '', $toemail = '')
    {
        $tieude = 'Welcome to ' . $this->pub_config['sitename'] . '- Approved';
        $noidung = "
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
        if (!$this->guimail($toemail, $tieude, $noidung)) {
            //gui mail k thanh cong co the luwu lai mail roi de cronjob gui
            $this->guimail($toemail, $tieude, $noidung);
        }
    }
    function register($ref = 0)
    {
        $managerid = 0;
        $err = 1;
        $dt = '';
        $sitename = $this->pub_config['sitename'];

        //Nếu người dùng đã đăng nhập rồi thì chuyển hướng 
        if ($this->session->userdata('logedin')) {
            redirect('v3');
            return;
        }
        // Kiểm tra phương thức HTTP
        $method = $this->input->server('REQUEST_METHOD');

        if ($method === 'POST') {
            // Xử lý AJAX POST
            $ref = (int)$this->input->get_post('ref');
            if ($ref) {
                $this->session->set_userdata('ref', $ref);
            } else {
                $ref = $this->session->userdata('ref');
            }

            $data = $this->input->post(NULL, TRUE);

            //Validate
            if ($this->validate() == FALSE) {
                // Trả về JSON lỗi
                $errors = validation_errors('<li>', '</li>');
                echo json_encode(array('error' => 1, 'data' => "<ul>" . $errors . "</ul>"));
                return;
            } else {
                // Validate OK, tiến hành insert
                if ($this->session->userdata('managerid')) {
                    $managerid = $this->session->userdata('managerid');
                } else {
                    $qr = "
                    UPDATE cpalead_manager SET id = @id := id, pub_count=pub_count+1
                    WHERE id >1 AND parrent = 0
                    ORDER BY pub_count ASC
                    LIMIT 1";
                    $this->db->query($qr);
                    $qr = ' SELECT @id as id';
                    $dtt = $this->db->query($qr)->row();
                    if ($dtt) {
                        $managerid = $dtt->id;
                    }
                }

                $firstname = $data['mailling']['firstname'];
                $lastname = $data['mailling']['lastname'];

                $this->load->helper('string');
                $mangaunhien = random_string('alnum', 16);
                $data['mailling']['aff_type']  = serialize($data['aff_type']);
                $idata['mailling'] = serialize($data['mailling']);
                $idata['manager'] = $managerid;
                $idata['password'] = sha1(md5($data['password']));
                $idata['email'] = $data['email'];
                $idata['status'] = 0;
                $idata['ip'] = $this->input->ip_address();
                $idata['key_active'] = $mangaunhien;
                $idata['ref'] = (int)$ref;
                $idata['phone'] = $data['phone'];
                $idata['payout'] = $data['payout'];
                $idata['biz_desc'] = $data['biz_desc'];

                //Xử lý upload file reg_cert
                if (isset($_FILES['reg_cert'])) {
                    $image_names = $this->img_handle($_FILES['reg_cert']);
                    if ($image_names) {
                        $images_string = implode(',', $image_names);
                        $idata['reg_cert'] = $images_string;
                    }
                }

                if ($this->pub_config['activate']) {
                    $idata['activated'] = 0;
                    $noidung = "
                        <b>Dear $firstname $lastname,</b><p>
                        Thanks for interested with $sitename. Your application is completed and will be process within 3-5 business days.
                        </p>
                        <p>
                        In the meantime, please active your account by the following link:
                        <a href=" . base_url() . "confirmation/$mangaunhien>Active</a>
                        </p>
                        If the active does not work well with your end then please copy and paste the url below for activate your account
                        " . base_url() . "confirmation/$mangaunhien
                        <br/>
                        Regards,<br/>
                        Affiliate Application Team.
                    ";
                } else {
                    $idata['activated'] = 1;
                    $noidung = "
                        <b>Dear $firstname $lastname,</b><p>
                        Thanks for interested with $sitename. Your application is completed and will be process within 3-5 business days.
                        </p>
                        <br/>
                        Regards,<br/>
                        Affiliate Application Team.
                    ";
                }

                //Tạo API key duy nhất
                getapikey:
                $key = substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30);
                if ($this->Home_model->get_one('advertiser', array('api_key' => $key))) {
                    goto getapikey;
                }
                $idata['api_key'] = $key;
                $this->db->insert('advertiser', $idata);
                $err = 0;
                $dt = $this->pub_config['reg_success_pub'];

                $tieude = $sitename . ' Please verify your email address.';
                $toemail = $data['email'];
                @$this->guimail($toemail, $tieude, $noidung);

                // Trả về JSON success
                echo json_encode(array('error' => 0, 'data' => $dt));
                return;
            }
        } elseif ($method === 'GET') {
            $data['country'] = $this->Country_model->get_country();
            $data['category'] = $this->Country_model->get_categories(); // Lấy danh sách category
            $data['traftype'] = $this->Country_model->get_traftype(); // Lấy danh sách category
            $this->load->view('auth/signup', array(
                'pubconfig' => $this->pub_config['termsinfo'],
                'country' => $data['country'],
                'category' => $data['category'], // Truyền dữ liệu category sang view
                'traftype' => $data['traftype'] // Truyền dữ liệu traftype sang view
            ));
        }
    }

    function img_handle($newimg)
    {

        // Xác định đường dẫn thư mục lưu ảnh
        $path = FCPATH . 'upload/adv/';

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
    function validate()
    {

        $this->form_validation->set_rules('mailling[firstname]', 'First Name', 'trim|required|xss_clean|callback_check_name');
        $this->form_validation->set_rules('mailling[lastname]', 'Last Name', 'trim|required|xss_clean|callback_check_name');
        $this->form_validation->set_rules('phone', 'Your Phone Number', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_check_email');
        $this->form_validation->set_rules('password', 'Password', 'equired|callback_validate_password');
        $this->form_validation->set_rules('confirm_pass', 'Repeat Password', 'required|matches[password]');
        $this->form_validation->set_message('matches', 'Repeat Password does not match Password.');
        $this->form_validation->set_rules('mailling[im_service]', 'Your Skype ID/ Telegram', 'required');
        $this->form_validation->set_rules('mailling[company]', 'Company Name', 'required');
        $this->form_validation->set_rules('mailling[street]', 'Your Street', 'required');
        $this->form_validation->set_rules('mailling[city]', 'Your City', 'required');
        $this->form_validation->set_rules('reg_cert', 'Your Company Registration Certificate', 'callback_validate_file');
        $this->form_validation->set_rules('mailling[country]', 'Your Country', 'required');
        $this->form_validation->set_rules('mailling[state]', 'Your State/Region', 'required');
        $this->form_validation->set_rules('mailling[category]', 'Your Category', 'required');
        $this->form_validation->set_rules('mailling[zip]', 'Your Zip Code', 'required|alpha_numeric');
        $this->form_validation->set_rules('payout', 'Payout', 'Required|callback_check_payout');
        $this->form_validation->set_rules('mailling[website]', 'Website URL', 'required|callback_check_website');
        $this->form_validation->set_rules('mailling[offername]', 'Your offername', 'required');
        $this->form_validation->set_rules('biz_desc', 'Briefly Describe Your Business Activities', 'required');
        $this->form_validation->set_rules('aff_type', 'Traffic Source', 'required');
        $this->form_validation->set_rules('mailling[terms]', 'Terms and Conditions', 'required');
        $this->form_validation->set_rules('agree2', 'Terms and Conditions', 'required');
        return $this->form_validation->run(); // Trả về kết quả true/false
    }
    public function check_name($str)
    {
        // Cho phép các chữ cái Unicode (có dấu) và không giới hạn ngôn ngữ
        if (!preg_match("/^\p{L}+$/u", $str)) {
            $this->form_validation->set_message('check_name', 'The %s field must be letter..');
            return FALSE;
        } else {
            return TRUE;
        }
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
    public function validate_file() {

        // Nếu không có file được upload, coi như hợp lệ (tùy chọn)
        if (!isset($_FILES['reg_cert']['name'][0]) || $_FILES['reg_cert']['error'][0] === UPLOAD_ERR_NO_FILE) {
            $this->form_validation->set_message('validate_file', 'Please enter your Company Registration Certificate.');
            return FALSE; // Không có file hoặc có lỗi khi upload
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
    function check_website($website)
    {
        // Kiểm tra nếu URL bắt đầu bằng "https://"
        if (preg_match('/^https:\/\/.+$/', $website)) {
            return TRUE; // Hợp lệ
        } else {
            $this->form_validation->set_message('check_website', 'The Website URL must start with "https://".');
            return FALSE; // Không hợp lệ
        }
    }
    function check_payout($payout)
    {
        // Chỉ cho phép số và các ký tự đặc biệt
        if (preg_match('/^[0-9\@\#\$\%\^\&\*\(\)\_\+\!\-\=\[\]\{\}\|\;\:\'\"\,\.\/\<\>\?]+$/', $payout)) {
            return TRUE; // Hợp lệ
        } else {
            $this->form_validation->set_message('check_payout', 'Please enter The Payout field contains invalid characters!');
            return FALSE; // Không hợp lệ
        }
    }
    function check_email($email)
    {
        if ($this->Home_model->get_one('advertiser', array('email' => $email))) {
            $this->form_validation->set_message('check_email', 'Email already exists!');
            return FALSE;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->form_validation->set_message('check_email', 'The %s field must contain a valid email address.');
            return FALSE;
        }
        return TRUE;
    }
    private function guimail($toemail = '', $tieude = '', $noidung = '')
    {
        $this->load->library('Mailjet');
        $this->mailjet->send_email($toemail, $tieude, $noidung, $this->pub_config['emailadmin'], $this->pub_config['sitename']);

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

    function activate($key = '')
    {
        $log = $this->Home_model->get_one('advertiser', array('key_active' => $key));
        if (!empty($log)) {
            if (!$log->activated) {
                if ($log->key_active != $key) {
                    echo 'your activation code is not right, please correct them';
                } else {
                    //xu ly kich hoat
                    $this->db->where('key_active', $key);
                    $this->db->update('advertiser', array('activated' => 1));
                    //$this->db->update('adv',array('activated'=>1,'status'=>1));   //khong cần chờ admin duyệt
                    echo 'Thanks for interested with ' . $this->pub_config['sitename'] . '. Your application is completed and will be process within 3-5 business days'; //noi dugn thong bao sau khi kich hoat mail
                    $mailling = unserialize($log->mailling);
                    $name = $mailling['firstname'] . ' ' . $mailling['lastname'];
                    //$this->approved($name,$log->email);//gửi email nếu duyệt luôn
                }
            } else {
                echo 'activated!';
            }
        } else {
            echo 'Your Activation key is experied !';
        }
    }

    private function callApi($ckey)
    {
        $url = 'https://api.countrystatecity.in/v1/countries/' . $ckey . '/states';
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
    function ajax()
    {
        $key = $this->input->post('ckey');
        $state = $this->callApi($key);
        header('Content-Type: application/json'); // Đảm bảo header JSON
        echo json_encode($state);
    }
    function hienthi()
    {
        $this->load->view('default/index' . $this->pindex, array('content' => $this->content));
    }
}
