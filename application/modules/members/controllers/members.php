
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends CI_Controller {
    private $content='';
    private $mensenger='';

    private $per_page = 30;
    public $total_rows = 6;
    public $pub_config= '';
    public $member = '';
    public $member_info = '';
    private $pindex='';

    function  __construct(){
        parent::__construct();
        $this->load->model('Home_model');
       // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
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
        echo '<h2>404 Page Not Found</h2> <br/> The page you requested was not found.';
        //$this->account();
    }

    function dashboard(){
        $data = array();
        $data['newoffer']= $this->Home_model->get_data('offer',array('show'=>1,'smtype'=>1,'smartlink'=>0,'smartoff'=>0),array(6),array('id','DESC'));
        //$data['topconvert']= $this->Home_model->get_data('offer',array('show'=>1),array(9),array('lead','DESC'));
        $data['news']= $this->Home_model->get_data('content',array('show'=>1),array(9),array('id','DESC'));
        $data['manager']= $this->Home_model->get_one('manager',array('id'=>$this->member->manager));
        //Top Country Breakdown - click lead -unqine
        //$qr = 'SELECT offerid,oname,count(id) as click, sum(flead) as lead, count(DISTINCT ip) as uniq, sum(amount) as pay  FROM `cpalead_tracklink`  WHERE userid=? and date BETWEEN ? AND ?  group by offerid';
        //dayli sstatic
        $qr = 'SELECT count(id) as click, sum(flead) as `lead`, count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and DATE(date)=?';
        $qq = $this->db->query($qr,array($this->member->id,date("Y-m-d")));
        if($qq){
            $data['dayli_static'] = $qq->row();
        }else{
            $data['dayli_static']= 0;
        }

         //end đayli static

         $qr = 'SELECT count(id) as click, sum(flead) as `lead`, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve , DATE(date) as dayli  FROM `cpalead_tracklink`  WHERE date > DATE_SUB(NOW(), INTERVAL 10 DAY) AND userid=? GROUP BY DATE(date) ';
         $data['chart'] = $this->db->query($qr,array($this->member->id))->result();

        $content =$this->load->view('vdashboard.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }

    function post_payment(){
        $thongbao ='';
        if($_POST){
            if($this->input->post('action')){
                if($_POST['payment_method']=='paypal'){
                    $thongbao .= $this->savepaypal();

                }if($_POST['payment_method']=='payoneer'){
                    $thongbao .= $this->savepayoneer();

                }elseif($_POST['payment_method']=='wire'||$_POST['payment_method']=='Bank Wire'){
                    $thongbao .= $this->savewire();
                }
            }

        }

         $this->session->set_userdata('thongbao','<div class="my-3"><p>'.$thongbao.'</p></div>');

        redirect(base_url('v2/profile/payment'));
    }

    function profile(){

        if($_POST){
            if($this->input->post('action')){
                if($_POST['action']=='Update Password'){//change passsưord
                    echo $this->changepass();
                }
                elseif($_POST['action']=='update_info'){//profile
                    echo $this->update_info();
                }
                elseif($_POST['action']=='deletePostBack'){//del posstback
                    echo $this->deletePostBack();
                }
                elseif($_POST['action']=='addPostback'){//addpostback savepayoneer
                    echo $this->addPostback();
                }
                elseif($_POST['payment_method']=='paypal'){
                    echo $this->savepaypal();

                }elseif($_POST['payment_method']=='wire'||$_POST['payment_method']=='Bank Wire (VN Only)'){
                    echo $this->savewire();
                }elseif($_POST['payment_method']=='payoneer'){
                    echo $this->savepayoneer();

                }
            }
           return;


        }else{
            $data['postBack'] = $this->Home_model->get_data('postback',array('affid'=>$this->member->id));
            $data['userData'] = $this->member;
            $data['userData']->reg_cert = explode(',', $data['userData']->reg_cert ); // Tách chuỗi reg_cert thành mảng
            $id = $data["userData"]->id;
            $id = $data["userData"]->id;
            $data['selected_categories'] = $this->db->select('offercat.id, offercat.offercat')
                ->from('useroffercats')
                ->join('offercat', 'useroffercats.offercat_id = offercat.id')
                ->where('useroffercats.user_id', $id)
                ->get()
                ->result();
            $data['all_categories'] = $this->db->select('id, offercat')
                ->from('offercat')
                ->get()
                ->result();
            $content =$this->load->view('profile/profile.php',$data,true);
            $this->load->view('default/vindex.php',array('content'=>$content));
        }

    }

    function ajax_test_postback(){

        if($_POST){
            $url = $this->input->post('url');
            /*
            if($pb->password){
                $url = $pb->postback.'&password='.$pb->password;
            }else{
                $url = $pb->postback;
            }
            */
            if(strpos($url,'{sum}')){
                //
                $url = str_replace('{sum}',$this->input->post('payout'),$url);
            }else{
                $url .= '&payout='.$this->input->post('payout');
            }
            if(strpos($url,'{offerid}')){
                //
                $url = str_replace('{offerid}',$this->input->post('offerid'),$url);
            }else{
                $url .= '&offerid='.$this->input->post('v');
            }
            if(strpos($url,'{sub1}')){
                //
                $url = str_replace('{sub1}',$this->input->post('sub1'),$url);
            }else{
                $url .= '&sub1='.$this->input->post('sub1');
            }


            $result = $this->curl_senpost($url);
            echo json_encode(array('url'=>$url,'result'=>$result));
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

    function curl_senpost($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        $result = curl_exec($ch);  // grab URL and pass it to the variable.
        curl_close($ch);
        return $result;
    }

    function resetApi(){
        getapikey:
        $key = substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30);
        if($this->Home_model->get_one('users',array('api_key'=>$key))){
            goto getapikey;
        }else{
            $this->db->where('id',$this->member->id)->update('users',array('api_key'=>$key));            
        }
        echo $key;
    }

    function deletePostBack(){
        if($_POST){
            $id = (int)$this->input->post('pbid');
            if($this->Home_model->get_one('postback',array('id'=>$id,'affid'=>$this->member->id))){
                $this->db->where('id',$id);
                $this->db->delete('postback');
                echo 1;
            }else{
                echo 0;
            }

        }
    }

    function addPostback(){
        
        if($_POST){
            $this->form_validation->set_rules('url', 'Postback URL', 'trim|required');
            if ($this->form_validation->run() == TRUE){

                $url = $this->input->post('url');
                $this->db->insert('postback',array('affid'=>$this->member->id,'postback'=>$url,'enable'=>1,'ip'=>$this->input->ip_address()));
                 return 1;
            }else{
                    return 0;
            }


        }

    }

    private function changepass(){
        if($_POST){
            $this->form_validation->set_rules('oldpassword', 'Current password', 'trim|required|xss_clean|min_length[6]');
            $this->form_validation->set_rules('newpassword', 'New password', 'trim|required|matches[confirmpassword]|xss_clean|min_length[6]|max_length[18]');
            $this->form_validation->set_rules('confirmpassword', 'Confirm New password', 'trim|required|xss_clean|min_length[6]');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form
                $password=sha1(md5($data['oldpassword']));
                if($this->Home_model->get_number('users',array('id'=>$this->member->id,'password'=>$password))==1){
                    $this->db->where('id',$this->member->id);
                    $this->db->update('users',array('password'=>sha1(md5($data['password']))));
                    return '<strong>SUCCESS: </strong>Your password has been updated successfully.';
                }else{
                    return '<strong>FAILURE: </strong>"Current password" does not match account';
                }

                }else{
                    return '<strong>FAILURE: </strong>'.validation_errors();
                }
            }

    }

    public function validate_traffic_format($str) {
        // 1. Kiểm tra chuỗi rỗng và loại bỏ dấu chấm, khoảng trắng ở cuối
        $str = rtrim($str, " .,");  // Loại bỏ space, dấu chấm và dấu phẩy ở cuối
        
        if (empty(trim($str))) {
            $this->form_validation->set_message('validate_traffic_format', 'The Traffic Source field cannot be empty');
            return FALSE;
        }
    
        // 2. Kiểm tra độ dài mỗi phần sau khi tách và clean
        $sources = explode(',', $str);
        $sources = array_map(function($source) {
            return trim($source, " .,");  // Loại bỏ space, dấu chấm và dấu phẩy ở đầu/cuối
        }, $sources);
        
        foreach ($sources as $source) {
            // 2.1 Kiểm tra phần tử rỗng sau khi đã clean
            if (empty($source)) {
                $this->form_validation->set_message('validate_traffic_format', 'The Traffic Source field cannot contain empty values between commas');
                return FALSE;
            }
    
            // 2.2 Kiểm tra độ dài
            if (strlen($source) < 2 || strlen($source) > 50) {
                $this->form_validation->set_message('validate_traffic_format', 'Each Traffic Source must be between 2-50 characters in length');
                return FALSE;
            }
    
            // 2.3 Kiểm tra ký tự đặc biệt và format
            if (preg_match('/[\<\>\"\'\%\;\(\)\&\+]|\.{2,}/', $source)) {  // Thêm check cho nhiều dấu chấm liên tiếp
                $this->form_validation->set_message('validate_traffic_format', 'The Traffic Source field cannot contain special characters < > " \' % ; ( ) & + or multiple dots');
                return FALSE;
            }
        }
    
        // 3. Kiểm tra số lượng sources hợp lý
        $sources = array_filter($sources); // Loại bỏ các phần tử rỗng nếu có
        if (count($sources) > 10) {
            $this->form_validation->set_message('validate_traffic_format', 'The Traffic Source field cannot contain more than 10 sources');
            return FALSE;
        }
    
        return TRUE;
    }

    function update_info(){//gửi ajxx về để update thông tin
        if($_POST){
            // [im_service] [firstname][lastname]  [company]
            //[ad] [ad2] [city]  [country] [state] [zip] [phone] [hear_about] => )

            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules(
                'email',
                'Your Email',
                'required|valid_email|callback_email_check'
            );
            $this->form_validation->set_rules('im_service', 'Skype ID/Telegram', 'trim|xss_clean');
        
            // Đặt luật kiểm tra
            $this->form_validation->set_rules(
                'firstname', 
                'First Name', 
                'trim|required|xss_clean|callback_check_name'
            );

            $this->form_validation->set_rules(
                'lastname', 
                'Last Name', 
                'trim|required|xss_clean|callback_check_name'
            );

            $this->form_validation->set_rules('company', 'Сompany Name', 'trim|xss_clean');
            $this->form_validation->set_rules('ad', 'Street', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zipcode', 'trim|required|xss_clean|alpha_numeric');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean|numeric'); //phone và email là trường riêng  
            $this->form_validation->set_rules('offercat', 'Offer Categories', 'required'); 
            $this->form_validation->set_rules('aff_type','Traffic Source','required|callback_validate_traffic_format'); 
            $this->form_validation->set_rules('biz_desc','Briefly Describe Your Business Activities','required|max_length[3000]'); 

            $this->form_validation->set_rules(
                'website', 
                'URL’s Traffic Source', 
                'required|callback_check_url'
            );

            $this->form_validation->set_rules('company', 'your Company Registration Certificate','callback_validate_file'); 

            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form

                $member_info = $this->member_info;
                $member_info['im_service'] = trim($data['im_service']);
                $member_info['firstname'] = trim($data['firstname']);
                $member_info['lastname'] = trim($data['lastname']);
                $member_info['company'] = trim($data['company']);
                $member_info['ad'] = trim($data['ad']);
                $member_info['city'] = trim($data['city']);
                $member_info['country'] = trim($data['country']);
                $member_info['state'] = trim($data['state']);
                $member_info['zip'] = trim($data['zip']);
                // Clean và chuẩn hóa traffic sources trước khi lưu
                $traffic_sources = array_map(function($source) {
                    return trim($source, " .,");
                }, explode(',', trim($data['aff_type'])));
                $traffic_sources = array_filter($traffic_sources); // Loại bỏ phần tử rỗng
                $member_info['aff_type'] = serialize($traffic_sources);
                $member_info['website'] = trim($data['website']);


                //kiểm tra email
                $this->db->where(array('email'=>$data['email'],'id !='=>$this->session->userdata('userid')));

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

                $this->member->reg_cert = implode(',',  $oldimg);
                $check = $this->db->get('users')->row();
                if($check){
                    return '<strong>FAILURE: </strong>This email address is already being used!';
                }
                $this->db->where('id',$this->session->userdata('userid'));
                if($this->db->update('users',array('mailling'=>serialize($member_info),'phone'=>trim($data['phone']),'email'=>trim($data['email']),'reg_cert'=>$this->member->reg_cert,'biz_desc'=>$data['biz_desc']))){
                    $user_id = $this->session->userdata('userid');
    
                    if (!empty($data['offercat'])) {
                        // Xóa tất cả các bản ghi cũ của user này
                        $this->db->where('user_id', $user_id);
                        $this->db->delete('cpalead_useroffercats');
                        
                        // Chèn các bản ghi mới
                        $value = [];
                        foreach ($data['offercat'] as $offercat_id) {
                            $value[] = "($user_id, $offercat_id)";
                        }
                        
                        if (!empty($value)) {
                            $sql = "INSERT INTO cpalead_useroffercats (user_id, offercat_id) VALUES " . implode(',', $value);
                            $this->db->query($sql);
                        }
                    } else {
                        // Nếu không có offercat được chọn, xóa tất cả bản ghi cũ
                        $this->db->where('user_id', $user_id);
                        $this->db->delete('cpalead_useroffercats');
                    }
                    return '<strong>SUCCESS: </strong> Successfully edited profile.';
                }else{
                    return '<strong>FAILURE: </strong>Update error!';
                }

            }else{
                return '<strong>FAILURE: </strong>'.validation_errors();
            }
        }

    }

    public function email_check($email)
    {
        $user_id = $this->session->userdata('userid'); // Lấy ID người dùng hiện tại
       /*  echo ($user_id);
        exit(); */
        $this->db->where('email', $email);
        $this->db->where('id !=', $user_id); // Loại trừ người dùng hiện tại
        $query = $this->db->get('cpalead_users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'The Email is already taken by another user.');
            return FALSE;
        }
        return TRUE;
    }

    function img_handle($newimg) {

        $path = FCPATH . 'upload/pub/ava/';
                
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
    public function check_name($str) {
        // Cho phép các chữ cái Unicode (có dấu) và không giới hạn ngôn ngữ
        if (!preg_match("/^\p{L}+$/u", $str)) {
            $this->form_validation->set_message('check_name', 'The %s field must contain only letters (including accented letters).');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    

    // Hàm kiểm tra URL
    public function check_url($str) {
        // Kiểm tra định dạng URL, hỗ trợ domain và IP
        if (!preg_match("/^(https?:\/\/([a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}|[0-9]{1,3}(\.[0-9]{1,3}){3}))?(\/\S*)?$/", $str)) {
            $this->form_validation->set_message('check_url', 'The %s field must be a valid URL starting with http:// or https://.');
            return FALSE;
        }
        return TRUE;
    }
    
        public function validate_file() {
            //Lấy danh sách ảnh hiện tại
            $oldimg = [];
            if (!empty($this->member->reg_cert)) {
                $oldimg = explode(',', $this->member->reg_cert);
            }

            // Xử lý các ảnh bị đánh dấu xóa
            $delete = $this->input->post('imageToDelete');
            $remainingImages = $oldimg; // Tạo một bản sao để xử lý
            
            if (isset($delete) && is_array($delete)) {
            foreach ($delete as $image) {
                if (($key = array_search($image, $remainingImages)) !== false) {
                    unset($remainingImages[$key]);
                }
            }
            $remainingImages = array_values($remainingImages); // Reset array keys
            }

            // Đếm số file mới được upload
            $new_file_count = 0;
            if (isset($_FILES['reg_cert']) && !empty($_FILES['reg_cert']['name'][0])) {
                $new_file_count = count(array_filter($_FILES['reg_cert']['name']));
            }

            // Kiểm tra tổng số file sau khi xóa và thêm mới
        if ((count($remainingImages) + $new_file_count) > 3) {
            $this->form_validation->set_message('validate_file', 'Total number of files cannot exceed 3.');
                return FALSE;
            }
        
            // Kiểm tra các file mới nếu có
            if (isset($_FILES['reg_cert']) && !empty($_FILES['reg_cert']['name'][0])) {
                $allowed_types = ['jpeg', 'png', 'jpg', 'pdf', 'svg'];
                $max_size = 2048;
        
                foreach ($_FILES['reg_cert']['name'] as $key => $name) {
                    if (empty($name)) continue;
                    
                    $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    if (!in_array($file_ext, $allowed_types)) {
                        $this->form_validation->set_message('validate_file', 'File must be in the following format: jpeg, png, jpg, pdf, svg.');
                        return FALSE;
                    }
        
                    if ($_FILES['reg_cert']['size'][$key] > ($max_size * 1024)) {
                        $this->form_validation->set_message('validate_file', 'Each file must not exceed ' . $max_size . ' KB.');
                        return FALSE;
                    }
                }
            }
        
            return TRUE;
        }
    
    

    private function savewire(){
        if($_POST){
            //payment_method

            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('payment_wire_bankname', ' Bank Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_wire_purpose', 'Purpose of Payment', 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_wire_bankaddress', 'Bank Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_wire_accountnum', 'Account', 'trim|required|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form
                ///payment_wire_checking
                $member_info = $this->member_info;
                $member_info['payment_wire_bankname'] = trim($data['payment_wire_bankname']);
                $member_info['payment_wire_purpose'] = trim($data['payment_wire_purpose']);
                $member_info['payment_wire_bankaddress'] = trim($data['payment_wire_bankaddress']);
                $member_info['payment_wire_accountnum'] = trim($data['payment_wire_accountnum']);
                $member_info['payment_wire_country'] = trim($data['payment_wire_country']);
                $member_info['payment_method'] = 'wire';


                $this->db->where('id',$this->member->id);

                if($this->db->update('users',array('mailling'=>serialize($member_info)))){
                    return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
                }else{
                    return '<strong>FAILURE: </strong>Update error!';
                }

                }else{
                    return '<strong>FAILURE: </strong>'.validation_errors();
                }
            }

    }
    
    private function savepaypal(){
        if($_POST){
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('payment_paypal_email', 'Paypal Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form
                $member_info = $this->member_info;
                $member_info['payment_method'] = 'paypal';
                $member_info['payment_paypal_email'] = trim($data['payment_paypal_email']);
                $this->db->where('id',$this->session->userdata('userid'));
                if($this->db->update('users',array('mailling'=>serialize($member_info)))){
                    return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
                }else{
                    return '<strong>FAILURE: </strong>Update error!';
                }

                }else{
                    return '<strong>FAILURE: </strong>'.validation_errors();
                }
            }

    }
    
    private function savepayoneer(){
        if($_POST){
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('payment_payoneer_email', 'payoneer Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form
                $member_info = $this->member_info;
                $member_info['payment_method'] = 'payoneer';
                $member_info['payment_payoneer_email'] = trim($data['payment_payoneer_email']);
                $this->db->where('id',$this->session->userdata('userid'));
                if($this->db->update('users',array('mailling'=>serialize($member_info)))){
                    return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
                }else{
                    return '<strong>FAILURE: </strong>Update error!';
                }

                }else{
                    return '<strong>FAILURE: </strong>'.validation_errors();
                }
            }

    }

    /////////*******************************news****************************************************** */



    ////////*********************************************************************************************** */

    function account(){
        if($_POST){
            if($this->input->post('action')){
                if($_POST['action']=='Update Password'){
                    $this->changepass();
                }elseif($_POST['action']=='Update Messaging'){
                    $this->changemess();
                }
                elseif($_POST['action']=='Save Details'){
                    $this->update_info();
                }
                elseif($_POST['action']=='Save Settings'){
                    $this->save_settings();
                }
                elseif($_POST['action']=='Update ChatHandle'){
                    $this->chathandle();
                }
            }
            redirect(base_url('admin/panels_account.php'));


        }else{
            $content=$this->load->view('mod_publishers/default/account',array('content'=>$this->member),true);
            $this->load->view('default/main.php',array('content'=>$content));
        }



    }

    function payments(){
        if($_POST){
            if($this->input->post('action')){
                if($_POST['action']=='Save Payment Preferences'){
                    if($_POST['payment_method']=='paypal'){
                        $this->savepaypal();

                    }elseif($_POST['payment_method']=='wire'){
                        $this->savewire();
                    }
                }
            }
            redirect(base_url('admin/panels_payments.php'));


        }else{
            $content =$this->load->view('default/payments.php',array('payment'=>$this->Home_model->get_data('payment',array('userid'=>$this->session->userdata('userid')),array(20),array('id','DESC'))),true);
            $this->load->view('default/main.php',array('content'=>$content));
        }


    }
    /**************function phụ&************** */

    private function changemess(){
        if($_POST){
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('im_name', 'IM Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('im_service', 'Im Service', 'trim|required|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form

                $member_info = $this->member_info;
                $member_info['im_service'] = trim($data['im_service']);
                $member_info['im_info'] = trim($data['im_name']);
                $this->db->where('id',$this->session->userdata('userid'));
                if($this->db->update('users',array('mailling'=>serialize($member_info)))){
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Instant Messenger Settings have been updated successfully.</p></div>');
                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Update error!</p></div>');
                }

                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>'.validation_errors().'</p></div>');
                }
            }

    }

    function w9(){
        if($_POST){
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

            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form
                $this->db->where(array('userid'=>$this->session->userdata('userid'),'type'=>'w9'));
                $this->db->update('tax',array('content'=>serialize($data),'type'=>'w9'));
                if($this->db->affected_rows()){
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                }else{
                    $this->db->insert('tax',array('content'=>serialize($data),'userid'=>$this->session->userdata('userid'),'type'=>'w9'));
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }

                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>'.validation_errors().'</p></div>');
                }
        }
        $this->db->where(array('userid'=>$this->session->userdata('userid'),'type'=>'w9'));
        $dt = $this->db->get('tax')->row();
        if($dt){
            $dt =  unserialize($dt->content);
        }
        $this->load->view('default/w9',array('content'=>$dt));

    }

    function w8(){
        if($_POST){
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

            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form
                $this->db->where(array('userid'=>$this->session->userdata('userid'),'type'=>'w8'));
                $this->db->update('tax',array('content'=>serialize($data),'type'=>'w8'));
                if($this->db->affected_rows()){
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                }else{
                    $this->db->insert('tax',array('content'=>serialize($data),'userid'=>$this->session->userdata('userid'),'type'=>'w8'));
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }

                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>'.validation_errors().'</p></div>');
                }
        }
        $this->db->where(array('userid'=>$this->session->userdata('userid'),'type'=>'w8'));
        $dt = $this->db->get('tax')->row();
        if($dt){
            $dt =  unserialize($dt->content);
        }
        $this->load->view('default/w8',array('content'=>$dt));

    }

    private function save_settings(){
        if($_POST){
            $this->form_validation->set_rules('chat_enabled', 'chat_enabled', 'trim|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form
                $member_info = $this->member_info;
                if(empty($data['chat_enabled'])){
                    $data['chat_enabled'] = 0;
                }
                if(empty($data['chat_sound'])){
                    $data['chat_sound'] = 0;
                }
                if(empty($data['earn_sound'])){
                    $data['earn_sound'] = 0;
                }
                if(empty($data['referral_sound'])){
                    $data['referral_sound'] = 0;
                }

                $member_info['chat_enabled'] = trim($data['chat_enabled']);
                $member_info['chat_sound'] = trim($data['chat_sound']);
                $member_info['earn_sound'] = trim($data['earn_sound']);
                $member_info['referral_sound'] = trim($data['referral_sound']);
                $this->db->where('id',$this->session->userdata('userid'));
                if($this->db->update('users',array('mailling'=>serialize($member_info)))){
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"> <p><strong>SUCCESS: </strong>Your User Experience Settings have been updated successfully.</p></div>');
                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Update error!</p></div>');
                }

                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>'.validation_errors().'</p></div>');
                }
            }

    }

    function save_chat_sound(){
        $member_info = $this->member_info;

        if($this->input->post('chat_sound_enabled')=='true'){
            $member_info['chat_sound'] = 1;
        }else{
            $member_info['chat_sound'] = 0;
        }
        if($this->input->post('chat_showspam')=='true'){
            $member_info['chat_showspam'] = 1;
        }else{
            $member_info['chat_showspam'] = 0;
        }
        $this->db->where('id',$this->session->userdata('userid'));
        $this->db->update('users',array('mailling'=>serialize($member_info)));

    }

    private function chathandle(){
        if($_POST){
            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('chathandle', 'Chat Handle', 'trim|required|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form

                $chatuser = trim($data['chathandle']);
                //kieemr tra nick chat da ton tai chua
                $this->db->where('chatuser',$chatuser);
                if($this->db->get('users')->row()){
                    //user data ton tai
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>The Chan Handle already exists, please choose another one.!</p></div>');
                }else{
                    $this->db->where('id',$this->session->userdata('userid'));
                    if($this->db->update('users',array('chatuser'=>$chatuser))){
                        $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your ChatHandle have been updated successfully.</p></div>');
                    }

                }
            }else{
                $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>'.validation_errors().'</p></div>');
            }
        }

    }

    //**************************************************************** */
    function terms(){
        $this->content =  $this->pub_config['termsinfo'];
        $this->hienthi();
    }

    function activate($key=''){
        $log = $this->Home_model->get_one('users',array('key_active'=>$key));
        if(!empty($log)){
            if(!$log->activated){
                if($log->key_active!=$key){
                    echo 'your activation code is not right, please correct them';
                }else{
                    //xu ly kich hoat
                    $this->db->where('key_active',$key);
                    $this->db->update('users',array('activated'=>1));
                    echo 'Thanks for interested with '.$this->pub_config['sitename'].'. Your application is completed and will be process within 3-5 business days';//noi dugn thong bao sau khi kich hoat mail
                }
            }else{
                echo 'activated!';
            }
        }
    }

    function logout(){
        $this->session->unset_userdata('logedin');
        $this->session->unset_userdata('user');
        redirect(base_url());
    }

    function phantrang(){
        $this->load->library('pagination');
        $config['base_url'] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 3;
        $config['num_links'] = 6;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_pag">';//div cho chu <<
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
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';
        //--so
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }


}
