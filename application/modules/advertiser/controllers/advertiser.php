<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Advertiser extends CI_Controller
{
    private $content = '';
    private $mensenger = '';

    private $per_page = 30;
    public $total_rows = 6;
    public $pub_config = '';
    public $member = '';
    public $member_info = '';
    private $pindex = '';

    function  __construct()
    {
        parent::__construct();
        //$this->load->model('Home_model');
        // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        if ($this->session->userdata('advid')) {
            $this->member = $this->Home_model->get_one('advertiser', array('id' => $this->session->userdata('advid')));
            $this->member_info = unserialize($this->member->mailling);
        } elseif ($this->uri->segment(3) != 'in' && $this->uri->segment(3) != 'up') {
            redirect('v3/sign/in');
        }
        // $this->setting= unserialize(file_get_contents('setting_file/setting.txt'));
        //$this->Home_model->get_one('adv',array('id'=>$this->session->userdata('advid')));

    }
    function index()
    {
        echo '<h2>404 Page Not Found</h2> <br/> The page you requested was not found.';
        //$this->account();
    }

    function dashboard()
    {
        $data = array();
        $data['newoffer'] = $this->Home_model->get_data('offer', array('show' => 1, 'smtype' => 1, 'smartlink' => 0, 'smartoff' => 0), array(6), array('id', 'DESC'));
        // $data['newoffer'] = $this->Home_model->get_data('offer', array('show' => 1, 'smtype' => 1, 'smartlink' => 0, 'smartoff' => 0, 'adverid' => $this->member->id), array(6), array('RAND()'));
        //$data['topconvert']= $this->Home_model->get_data('offer',array('show'=>1),array(9),array('lead','DESC'));
        $data['news'] = $this->Home_model->get_data('content', array('show' => 1), array(9), array('id', 'DESC'));
        // $data['manager'] = $this->Home_model->get_one('manager', array('id' => 1));
        $advertiser = $this->Home_model->get_one('advertiser', array('id' => $this->member->id));
        // Unserialize the mailling data
        if ($advertiser && !empty($advertiser->mailling)) {
            $advertiser->mailling_data = unserialize($advertiser->mailling);
        }
        $data['advertiser'] = $advertiser;
        //Top Country Breakdown - click lead -unqine
        //$qr = 'SELECT offerid,oname,count(id) as click, sum(flead) as lead, count(DISTINCT ip) as uniq, sum(amount) as pay  FROM `cpalead_tracklink`  WHERE userid=? and date BETWEEN ? AND ?  group by offerid';
        //dayli sstatic
        $qr = 'SELECT count(id) as click, sum(flead) as lead, count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE id=? and DATE(date)=?';
        $qq = $this->db->query($qr, array($this->member->id, date("Y-m-d")));
        if ($qq) {
            $data['dayli_static'] = $qq->row();
        } else {
            $data['dayli_static'] = 0;
        }

        //end đayli static
        $qr = 'SELECT count(id) as click, sum(flead) as lead, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve , DATE(date) as dayli  FROM `cpalead_tracklink`  WHERE date > DATE_SUB(NOW(), INTERVAL 10 DAY) AND userid=? GROUP BY DATE(date) ';
        $data['chart'] = $this->db->query($qr, array($this->member->id))->result();

        $content = $this->load->view('vdashboard.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }
    function post_payment()
    {
        $thongbao = '';
        if ($_POST) {
            if ($this->input->post('action')) {
                if ($_POST['payment_method'] == 'paypal') {
                    $thongbao .= $this->savepaypal();
                }
                if ($_POST['payment_method'] == 'payoneer') {
                    $thongbao .= $this->savepayoneer();
                } elseif ($_POST['payment_method'] == 'wire' || $_POST['payment_method'] == 'Bank Wire') {
                    $thongbao .= $this->savewire();
                }
            }
        }

        $this->session->set_userdata('thongbao', '<div class="my-3"><p>' . $thongbao . '</p></div>');

        redirect(base_url('v3/profile/payment'));
    }
    function profile()
    {

        if ($_POST) {
            if ($this->input->post('action')) {
                if ($_POST['action'] == 'Update Password') { //change passsưord
                    echo $this->changepass();
                } elseif ($_POST['action'] == 'update_info') { //profile
                    echo $this->update_info();
                } elseif ($_POST['action'] == 'deletePostBack') { //del posstback
                    echo $this->deletePostBack();
                } elseif ($_POST['action'] == 'addPostback') { //addpostback savepayoneer
                    echo $this->addPostback();
                } elseif ($_POST['payment_method'] == 'paypal') {
                    echo $this->savepaypal();
                } elseif ($_POST['payment_method'] == 'wire' || $_POST['payment_method'] == 'Bank Wire (VN Only)') {
                    echo $this->savewire();
                } elseif ($_POST['payment_method'] == 'payoneer') {
                    echo $this->savepayoneer();
                }
            }
            return;
        } else{
            $data['postBack'] = $this->Home_model->get_data('postback', array('affid' => $this->member->id));
            $data['userData'] = $this->member;
            $data['userData']->reg_cert = explode(',', $data['userData']->reg_cert);

            // Lấy tất cả categories, country, traffic types
            $data['all_categories'] = $this->db->select('id, offercat')->from('offercat')->get()->result();
            $data['all_traftype'] = $this->db->select('id, name')->from('traftype')->get()->result();
            $data['all_countries'] = $this->db->select('id, country, keycode')->from('cpalead_country')->where('show', 1)->get()->result();
            // Giải mã dữ liệu mailing
            $mailing_data = unserialize($this->member->mailling);

            // Lấy country state đã chọn (từ mailing_data)
            $data['selected_country'] = isset($mailing_data['country']) ? $mailing_data['country'] : '';
            $data['selected_state'] = isset($mailing_data['state']) ? $mailing_data['state'] : '';

            // Lấy danh sách traffic sources đã chọn
            $selected_traffic_sources = [];
            if (!empty($mailing_data['aff_type'])) {
                $aff_type = unserialize($mailing_data['aff_type']);
                if (is_array($aff_type)) {
                    $selected_traffic_sources = $aff_type;
                }
            }

            // Lấy danh sách offer categories đã chọn
            $selected_categories = [];
            if (!empty($mailing_data['offercat'])) {
                $offercat = unserialize($mailing_data['offercat']);
                if (is_array($offercat)) {
                    $selected_categories = $offercat;
                }
            }

            // Thêm vào data để sử dụng trong view
            $data['selected_traffic_sources'] = $selected_traffic_sources;
            $data['selected_categories'] = $selected_categories;

        $content =$this->load->view('profile/profile.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
        }
    }
    function ajax_test_postback()
    {

        if ($_POST) {
            $url = $this->input->post('url');
            /*
            if($pb->password){
                $url = $pb->postback.'&password='.$pb->password;
            }else{
                $url = $pb->postback;
            }
            */
            if (strpos($url, '{sum}')) {
                //
                $url = str_replace('{sum}', $this->input->post('payout'), $url);
            } else {
                $url .= '&payout=' . $this->input->post('payout');
            }
            if (strpos($url, '{offerid}')) {
                //
                $url = str_replace('{offerid}', $this->input->post('offerid'), $url);
            } else {
                $url .= '&offerid=' . $this->input->post('v');
            }
            if (strpos($url, '{sub1}')) {
                //
                $url = str_replace('{sub1}', $this->input->post('sub1'), $url);
            } else {
                $url .= '&sub1=' . $this->input->post('sub1');
            }


            $result = $this->curl_senpost($url);
            echo json_encode(array('url' => $url, 'result' => $result));
        }

        /*
        echo $bodytag = str_replace("%body%", "black", "<body text='%body%'>");
        $url = str_replace('#s1#',$track->s1,$url);
                            $url = str_replace('#s2#',$track->s2,$url);
                            $url = str_replace('#status#',$congtien,$url);
                            $url = str_replace('#amount#',$track->amount2,$url);
                            $url = str_replace('#ip#',$track->ip,$url);
                            $url = str_replace('#name#',rawurlencode($track->oname),$url);
                            */
    }
    function curl_senpost($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);  // grab URL and pass it to the variable.
        curl_close($ch);
        return $result;
    }
    function resetApi()
    {
        getapikey:
        $key = substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30);
        if ($this->Home_model->get_one('cpalead_advertiser', array('api_key' => $key))) {
            goto getapikey;
        } else {
            $this->db->where('id', $this->member->id)->update('cpalead_advertiser', array('api_key' => $key));
        }
        echo $key;
    }

    function deletePostBack()
    {
        if ($_POST) {
            $id = (int)$this->input->post('pbid');
            if ($this->Home_model->get_one('postback', array('id' => $id, 'affid' => $this->member->id))) {
                $this->db->where('id', $id);
                $this->db->delete('postback');
                echo 1;
            } else {
                echo 0;
            }
        }
    }
    function addPostback()
    {
        if ($_POST) {
            $this->form_validation->set_rules('url', 'Postback URL', 'trim|required');
            if ($this->form_validation->run() == TRUE) {

                $url = $this->input->post('url');
                $this->db->insert('postback', array('affid' => $this->member->id, 'postback' => $url, 'enable' => 1, 'ip' => $this->input->ip_address()));
                return 1;
            } else {
                return 0;
            }
        }
    }
    private function changepass()
    {
        if ($_POST) {
            $this->form_validation->set_rules('oldpassword', 'Current password', 'trim|required|xss_clean|min_length[6]');
            $this->form_validation->set_rules('newpassword', 'New password', 'trim|required|matches[confirmpassword]|xss_clean|min_length[6]|max_length[18]');
            $this->form_validation->set_rules('confirmpassword', 'Confirm New password', 'trim|required|xss_clean|min_length[6]');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                $password = sha1(md5($data['oldpassword']));
                if ($this->Home_model->get_number('cpalead_advertiser', array('id' => $this->member->id, 'password' => $password)) == 1) {
                    $this->db->where('id', $this->member->id);
                    $this->db->update('cpalead_advertiser', array('password' => sha1(md5($data['password']))));
                    return '<strong>SUCCESS: </strong>Your password has been updated successfully.';
                } else {
                    return '<strong>FAILURE: </strong>"Current password" does not match account';
                }
            } else {
                return '<strong>FAILURE: </strong>' . validation_errors();
            }
        }
    }
    function update_info()
    { //gửi ajxx về để update thông tin
        if ($_POST) {

            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_check_email');
            $this->form_validation->set_rules('im_service', 'Skype ID/Telegram', 'trim|required|xss_clean');
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean|callback_check_name');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean|callback_check_name');
            $this->form_validation->set_rules('company', 'Сompany Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zip code', 'trim|required|alpha_numeric|xss_clean');
            $this->form_validation->set_rules('payout', 'Payout', 'trim|required|xss_clean|callback_check_payout');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('street', 'Street', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('offername', 'Offer Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('aff_type[]', 'Traffic Source', 'required');
            $this->form_validation->set_rules('offercat[]', 'Offer Categories', 'required');
            $this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean|callback_check_website');
            $this->form_validation->set_rules('biz_desc', 'Briefly Describe Your Business Activities', 'required|max_length[3000]');


            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                $member_info = $this->member_info;

                // $member_info['email'] = trim($data['email']);
                $member_info['im_service'] = trim($data['im_service']);
                $member_info['firstname'] = trim($data['firstname']);
                $member_info['lastname'] = trim($data['lastname']);
                $member_info['company'] = trim($data['company']);
                $member_info['street'] = trim($data['street']);
                $member_info['city'] = trim($data['city']);
                $member_info['country'] = trim($data['country']);
                $member_info['state'] = trim($data['state']);
                $member_info['zip'] = trim($data['zip']);
                $member_info['offername'] = trim($data['offername']);
                $member_info['website'] = trim($data['website']);
                // Xử lý Traffic Source
                $aff_type = $this->input->post('aff_type', true);
                if (!empty($aff_type) && is_array($aff_type)) {
                    $member_info['aff_type'] = serialize(array_filter($aff_type));
                } else {
                    $member_info['aff_type'] = serialize([]);
                }
                // Xử lý Offer Categories
                $offercat = $this->input->post('offercat', true);
                if (!empty($offercat) && is_array($offercat)) {
                    $member_info['offercat'] = serialize(array_filter($offercat));
                } else {
                    $member_info['offercat'] = serialize([]);
                }
                //Code xử lý hình ảnh
                $oldimg = [];
                if (!empty($this->member->reg_cert)) {
                    $oldimg = explode(',', $this->member->reg_cert);
                }

                // Xóa file cũ nếu có yêu cầu
                $delete = $this->input->post('imageToDelete');
                if (isset($delete) && is_array($delete)) {
                    foreach ($delete as $image) {
                        if (($key = array_search($image, $oldimg)) !== false) {
                            unset($oldimg[$key]);
                        }
                    }
                    $oldimg = array_values($oldimg); // Sắp xếp lại key mảng sau khi xóa
                }

                // Upload file mới (nếu có)
                if (isset($_FILES['reg_cert']) && !empty($_FILES['reg_cert']['name'][0])) {
                    $newImages = $this->img_handle($_FILES['reg_cert']);
                    if ($newImages && is_array($newImages)) {
                        $oldimg = array_merge($oldimg, $newImages);
                    }
                }

                //kiểm tra email
                $this->db->where(array('email' => $data['email'], 'id !=' => $this->session->userdata('advid')));
                $check = $this->db->get('cpalead_advertiser')->row();
                if ($check) {
                    return '<strong>FAILURE: </strong>This email address is already being used!';
                }
                $this->db->where('id', $this->session->userdata('advid'));
                if ($this->db->update(
                    'cpalead_advertiser',
                    array(
                        'mailling' => serialize($member_info),
                        'phone' => trim($data['phone']),
                        'email' => trim($data['email']),
                        'payout' => trim($data['payout']),
                        'reg_cert' => implode(',', $oldimg),
                        'biz_desc' => $data['biz_desc']
                    )
                )) {
                    return '<strong>SUCCESS: </strong> Successfully edited profile.';
                } else {
                    return '<strong>FAILURE: </strong>Update error!';
                }
            } else {
                return '<strong>FAILURE: </strong>' . validation_errors();
            }
        }
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
            $this->form_validation->set_message('check_payout', 'Please enter the Payout field Accept only numbers and special characters !');
            return FALSE; // Không hợp lệ
        }
    }
    function img_handle($newimg)
    {

        $path = FCPATH . 'upload/adv/';

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $image_names = [];

        foreach ($newimg['name'] as $key => $name) {
            //Log từng file
            error_log("Processing file: " . $name);
            error_log("File error status: " . $newimg['error'][$key]);
            error_log("File temp name: " . $newimg['tmp_name'][$key]);

            if ($newimg['error'][$key] === UPLOAD_ERR_OK) {
                $tmp_name = $newimg['tmp_name'][$key];

                // Kiểm tra file tồn tại
                if (!is_uploaded_file($tmp_name)) {
                    error_log("File not found in temp directory: " . $tmp_name);
                    continue;
                }

                // Thêm prefix vào tên file
                $prefix = uniqid();
                $new_filename = $prefix . '_' . $name;

                // Log trước khi move file
                error_log("Attempting to move file from {$tmp_name} to {$path}{$new_filename}");

                if (move_uploaded_file($tmp_name, $path . $new_filename)) {
                    error_log("Successfully moved file: " . $new_filename);
                    $image_names[] = $new_filename;  // Lưu tên file mới có prefix
                } else {
                    error_log("Failed to move file: " . $new_filename);
                    error_log("PHP upload error: " . error_get_last()['message']);
                }
            } else {
                error_log("Upload error for file {$name}: " . $newimg['error'][$key]);
            }
        }

        // Log kết quả cuối cùng
        error_log("Final image_names array: " . print_r($image_names, true));

        return !empty($image_names) ? $image_names : false;
    }
    // Hàm kiểm tra tùy chỉnh
    public function check_name($str)
    {
        // Cho phép các chữ cái Unicode (có dấu) và không giới hạn ngôn ngữ
        if (!preg_match("/^\p{L}+$/u", $str)) {
            $this->form_validation->set_message('check_name', 'The %s field must contain only letters (including accented letters).');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_email($email)
    {
        // Lấy email và id hiện tại từ session
        $current_email = $this->session->userdata('email');
        $current_id    = $this->session->userdata('advid');

        // Nếu email nhập vào trùng (so sánh không phân biệt chữ hoa thường) với email hiện tại, cho phép update
        if (strcasecmp($email, $current_email) === 0) {
            return TRUE;
        }

        // Loại trừ bản ghi của user hiện tại khi kiểm tra email trong CSDL
        $this->db->where('id !=', $current_id);
        if ($this->Home_model->get_one('advertiser', ['email' => $email])) {
            $this->form_validation->set_message('check_email', 'Email already exists!');
            return FALSE;
        }

        // Kiểm tra định dạng email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->form_validation->set_message('check_email', 'The %s field must contain a valid email address.');
            return FALSE;
        }

        return TRUE;
    }

    private function savewire()
    {
        if ($_POST) {
            //payment_method

            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('payment_wire_bankname', ' Bank Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_wire_purpose', 'Purpose of Payment', 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_wire_bankaddress', 'Bank Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_wire_accountnum', 'Account', 'trim|required|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                ///payment_wire_checking
                $member_info = $this->member_info;
                $member_info['payment_wire_bankname'] = trim($data['payment_wire_bankname']);
                $member_info['payment_wire_purpose'] = trim($data['payment_wire_purpose']);
                $member_info['payment_wire_bankaddress'] = trim($data['payment_wire_bankaddress']);
                $member_info['payment_wire_accountnum'] = trim($data['payment_wire_accountnum']);
                $member_info['payment_wire_country'] = trim($data['payment_wire_country']);
                $member_info['payment_method'] = 'wire';


                $this->db->where('id', $this->member->id);

                if ($this->db->update('cpalead_advertiser', array('mailling' => serialize($member_info)))) {
                    return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
                } else {
                    return '<strong>FAILURE: </strong>Update error!';
                }
            } else {
                return '<strong>FAILURE: </strong>' . validation_errors();
            }
        }
    }
    private function savepaypal()
    {
        if ($_POST) {
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('payment_paypal_email', 'Paypal Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                $member_info = $this->member_info;
                $member_info['payment_method'] = 'paypal';
                $member_info['payment_paypal_email'] = trim($data['payment_paypal_email']);
                $this->db->where('id', $this->session->userdata('advid'));
                if ($this->db->update('cpalead_advertiser', array('mailling' => serialize($member_info)))) {
                    return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
                } else {
                    return '<strong>FAILURE: </strong>Update error!';
                }
            } else {
                return '<strong>FAILURE: </strong>' . validation_errors();
            }
        }
    }
    private function savepayoneer()
    {
        if ($_POST) {
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('payment_payoneer_email', 'payoneer Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                $member_info = $this->member_info;
                $member_info['payment_method'] = 'payoneer';
                $member_info['payment_payoneer_email'] = trim($data['payment_payoneer_email']);
                $this->db->where('id', $this->session->userdata('advid'));
                if ($this->db->update('cpalead_advertiser', array('mailling' => serialize($member_info)))) {
                    return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
                } else {
                    return '<strong>FAILURE: </strong>Update error!';
                }
            } else {
                return '<strong>FAILURE: </strong>' . validation_errors();
            }
        }
    }
    /////////*******************************news****************************************************** */



    ////////*********************************************************************************************** */

    //****************************************************************** */

    function account()
    {
        if ($_POST) {
            if ($this->input->post('action')) {
                if ($_POST['action'] == 'Update Password') {
                    $this->changepass();
                } elseif ($_POST['action'] == 'Update Messaging') {
                    $this->changemess();
                } elseif ($_POST['action'] == 'Save Details') {
                    $this->update_info();
                } elseif ($_POST['action'] == 'Save Settings') {
                    $this->save_settings();
                } elseif ($_POST['action'] == 'Update ChatHandle') {
                    $this->chathandle();
                }
            }
            redirect(base_url('admin/panels_account.php'));
        } else {
            $content = $this->load->view('mod_publishers/default/account', array('content' => $this->member), true);
            $this->load->view('default/main.php', array('content' => $content));
        }
    }

    function payments()
    {
        if ($_POST) {
            if ($this->input->post('action')) {
                if ($_POST['action'] == 'Save Payment Preferences') {
                    if ($_POST['payment_method'] == 'paypal') {
                        $this->savepaypal();
                    } elseif ($_POST['payment_method'] == 'wire') {
                        $this->savewire();
                    }
                }
            }
            redirect(base_url('admin/panels_payments.php'));
        } else {
            $content = $this->load->view('default/payments.php', array('payment' => $this->Home_model->get_data('payment', array('userid' => $this->session->userdata('advid')), array(20), array('id', 'DESC'))), true);
            $this->load->view('default/main.php', array('content' => $content));
        }
    }
    /**************function phụ&************** */

    private function changemess()
    {
        if ($_POST) {
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('im_name', 'IM Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('im_service', 'Im Service', 'trim|required|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form

                $member_info = $this->member_info;
                $member_info['im_service'] = trim($data['im_service']);
                $member_info['im_info'] = trim($data['im_name']);
                $this->db->where('id', $this->session->userdata('advid'));
                if ($this->db->update('cpalead_advertiser', array('mailling' => serialize($member_info)))) {
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Instant Messenger Settings have been updated successfully.</p></div>');
                } else {
                    $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Update error!</p></div>');
                }
            } else {
                $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
            }
        }
    }
    function w9()
    {
        if ($_POST) {
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            //tax_name,business_name,
            $this->form_validation->set_rules('tax_name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('entity_type', 'Type of Entity', 'trim|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'Sity', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zipcode', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tin_type', 'Tax Identification Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('signature', 'Signature of U.S. person', 'trim|required|xss_clean');

            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                $this->db->where(array('userid' => $this->session->userdata('advid'), 'type' => 'w9'));
                $this->db->update('tax', array('content' => serialize($data), 'type' => 'w9'));
                if ($this->db->affected_rows()) {
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                } else {
                    $this->db->insert('tax', array('content' => serialize($data), 'userid' => $this->session->userdata('advid'), 'type' => 'w9'));
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }
            } else {
                $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
            }
        }
        $this->db->where(array('userid' => $this->session->userdata('advid'), 'type' => 'w9'));
        $dt = $this->db->get('tax')->row();
        if ($dt) {
            $dt =  unserialize($dt->content);
        }
        $this->load->view('default/w9', array('content' => $dt));
    }
    function w8()
    {
        if ($_POST) {
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            //tax_name,business_name,
            $this->form_validation->set_rules('tax_name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bus_country', 'Country of citizenship', 'trim|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'Sity', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zipcode', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tin_type', 'Tax Identification Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('signature', 'Signature of U.S. person', 'trim|required|xss_clean');

            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                $this->db->where(array('userid' => $this->session->userdata('advid'), 'type' => 'w8'));
                $this->db->update('tax', array('content' => serialize($data), 'type' => 'w8'));
                if ($this->db->affected_rows()) {
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                } else {
                    $this->db->insert('tax', array('content' => serialize($data), 'userid' => $this->session->userdata('advid'), 'type' => 'w8'));
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }
            } else {
                $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
            }
        }
        $this->db->where(array('userid' => $this->session->userdata('advid'), 'type' => 'w8'));
        $dt = $this->db->get('tax')->row();
        if ($dt) {
            $dt =  unserialize($dt->content);
        }
        $this->load->view('default/w8', array('content' => $dt));
    }

    private function save_settings()
    {
        if ($_POST) {
            $this->form_validation->set_rules('chat_enabled', 'chat_enabled', 'trim|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form
                $member_info = $this->member_info;
                if (empty($data['chat_enabled'])) {
                    $data['chat_enabled'] = 0;
                }
                if (empty($data['chat_sound'])) {
                    $data['chat_sound'] = 0;
                }
                if (empty($data['earn_sound'])) {
                    $data['earn_sound'] = 0;
                }
                if (empty($data['referral_sound'])) {
                    $data['referral_sound'] = 0;
                }

                $member_info['chat_enabled'] = trim($data['chat_enabled']);
                $member_info['chat_sound'] = trim($data['chat_sound']);
                $member_info['earn_sound'] = trim($data['earn_sound']);
                $member_info['referral_sound'] = trim($data['referral_sound']);
                $this->db->where('id', $this->session->userdata('advid'));
                if ($this->db->update('cpalead_advertiser', array('mailling' => serialize($member_info)))) {
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"> <p><strong>SUCCESS: </strong>Your User Experience Settings have been updated successfully.</p></div>');
                } else {
                    $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Update error!</p></div>');
                }
            } else {
                $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
            }
        }
    }

    function save_chat_sound()
    {
        $member_info = $this->member_info;

        if ($this->input->post('chat_sound_enabled') == 'true') {
            $member_info['chat_sound'] = 1;
        } else {
            $member_info['chat_sound'] = 0;
        }
        if ($this->input->post('chat_showspam') == 'true') {
            $member_info['chat_showspam'] = 1;
        } else {
            $member_info['chat_showspam'] = 0;
        }
        $this->db->where('id', $this->session->userdata('advid'));
        $this->db->update('cpalead_advertiser', array('mailling' => serialize($member_info)));
    }
    private function chathandle()
    {
        if ($_POST) {
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('chathandle', 'Chat Handle', 'trim|required|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST); // du lieu gui ve tu form

                $chatuser = trim($data['chathandle']);
                //kieemr tra nick chat da ton tai chua
                $this->db->where('chatuser', $chatuser);
                if ($this->db->get('cpalead_advertiser')->row()) {
                    //user data ton tai
                    $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>The Chan Handle already exists, please choose another one.!</p></div>');
                } else {
                    $this->db->where('id', $this->session->userdata('advid'));
                    if ($this->db->update('cpalead_advertiser', array('chatuser' => $chatuser))) {
                        $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your ChatHandle have been updated successfully.</p></div>');
                    }
                }
            } else {
                $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
            }
        }
    }

    //**************************************************************** */

    function terms()
    {
        $this->content =  $this->pub_config['termsinfo'];
        $this->hienthi();
    }

    function activate($key = '')
    {
        $log = $this->Home_model->get_one('cpalead_advertiser', array('key_active' => $key));
        if (!empty($log)) {
            if (!$log->activated) {
                if ($log->key_active != $key) {
                    echo 'your activation code is not right, please correct them';
                } else {
                    //xu ly kich hoat
                    $this->db->where('key_active', $key);
                    $this->db->update('cpalead_advertiser', array('activated' => 1));
                    echo 'Thanks for interested with ' . $this->pub_config['sitename'] . '. Your application is completed and will be process within 3-5 business days'; //noi dugn thong bao sau khi kich hoat mail
                }
            } else {
                echo 'activated!';
            }
        }
    }


    function logout()
    {
        $this->session->unset_userdata('logedin');
        $this->session->unset_userdata('user');
        redirect(base_url());
    }


    function phantrang()
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/';
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 3;
        $config['num_links'] = 6;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_pag">'; //div cho chu <<
        $config['first_tag_close'] = '</li>'; //div cho chu <<
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
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';
        //--so
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }
}
