<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertiser extends CI_Controller {
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
        //$this->load->model('Home_model');
       // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        if($this->session->userdata('advid')){
            $this->member=$this->Home_model->get_one('adv',array('id'=>$this->session->userdata('advid')));
            $this->member_info = unserialize($this->member->mailling);
        }elseif($this->uri->segment(3)!='in'&&$this->uri->segment(3)!='up'){
            redirect('advertiser/signin');
        }
       // $this->setting= unserialize(file_get_contents('setting_file/setting.txt'));
        //$this->Home_model->get_one('adv',array('id'=>$this->session->userdata('advid')));

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
        $data['manager']= $this->Home_model->get_one('manager',array('id'=>1));
        //Top Country Breakdown - click lead -unqine
        //$qr = 'SELECT offerid,oname,count(id) as click, sum(flead) as lead, count(DISTINCT ip) as uniq, sum(amount) as pay  FROM `cpalead_tracklink`  WHERE userid=? and date BETWEEN ? AND ?  group by offerid';
        //dayli sstatic
        $qr = 'SELECT count(id) as click, sum(flead) as lead, count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and DATE(date)=?';
        $qq = $this->db->query($qr,array($this->member->id,date("Y-m-d")));
        if($qq){
            $data['dayli_static'] = $qq->row();
        }else{
            $data['dayli_static']= 0;
        }

         //end đayli static

         $qr = 'SELECT count(id) as click, sum(flead) as lead, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve , DATE(date) as dayli  FROM `cpalead_tracklink`  WHERE date > DATE_SUB(NOW(), INTERVAL 10 DAY) AND userid=? GROUP BY DATE(date) ';
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
        if($this->Home_model->get_one('adv',array('api_key'=>$key))){
            goto getapikey;
        }else{
            $this->db->where('id',$this->member->id)->update('adv',array('api_key'=>$key));            
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
                if($this->Home_model->get_number('adv',array('id'=>$this->member->id,'password'=>$password))==1){
                    $this->db->where('id',$this->member->id);
                    $this->db->update('adv',array('password'=>sha1(md5($data['password']))));
                    return '<strong>SUCCESS: </strong>Your password has been updated successfully.';
                }else{
                    return '<strong>FAILURE: </strong>"Current password" does not match account';
                }

                }else{
                    return '<strong>FAILURE: </strong>'.validation_errors();
                }
            }

    }
    function update_info(){//gửi ajxx về để update thông tin
        if($_POST){
            // [im_service] [firstname][lastname]  [company]
            //[ad] [ad2] [city]  [country] [state] [zip] [phone] [hear_about] => )

            //im_service im_name ///mailling[im_service]  mailling[im_info]
            $this->form_validation->set_rules('im_service', 'Skype ID/Telegram', 'trim|xss_clean');
            $this->form_validation->set_rules('avartar', 'Avartar', 'trim|xss_clean');
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|xss_clean');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|xss_clean');
            $this->form_validation->set_rules('company', 'Сompany Name', 'trim|xss_clean');

            $this->form_validation->set_rules('ad', 'Address Line 1', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ad2', 'Address Line 2', 'trim|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'country', 'trim|xss_clean');
            $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zipcode', 'trim|required|xss_clean');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean'); //phone và email là trường riêng
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean'); //phone và email là trường riêng
            $this->form_validation->set_rules('hear_about', 'How did you find us?', 'trim|xss_clean');
            if ($this->form_validation->run() == TRUE){
                $data = $this->security->xss_clean($_POST);// du lieu gui ve tu form

                $member_info = $this->member_info;
                $member_info['im_service'] = trim($data['im_service']);
                $member_info['avartar'] = trim($data['avartar']);
                $member_info['firstname'] = trim($data['firstname']);
                $member_info['lastname'] = trim($data['lastname']);
                $member_info['company'] = trim($data['company']);
                $member_info['ad'] = trim($data['ad']);
                $member_info['ad2'] = trim($data['ad2']);
                $member_info['city'] = trim($data['city']);
                $member_info['country'] = trim($data['country']);
                $member_info['state'] = trim($data['state']);
                $member_info['zip'] = trim($data['zip']);
                $member_info['hear_about'] = trim($data['hear_about']);

               // $member_info['timezone'] = trim($data['timezone']);//phone
                //$member_info['website'] = trim($data['website']);//phone
                //kiểm tra email
                $this->db->where(array('email'=>$data['email'],'id !='=>$this->session->userdata('advid')));
                $check = $this->db->get('adv')->row();
                if($check){
                    return '<strong>FAILURE: </strong>This email address is already being used!';
                }
                $this->db->where('id',$this->session->userdata('advid'));
                if($this->db->update('adv',array('mailling'=>serialize($member_info),'phone'=>trim($data['phone']),'email'=>trim($data['email'])))){
                    return '<strong>SUCCESS: </strong> Successfully edited profile.';
                }else{
                    return '<strong>FAILURE: </strong>Update error!';
                }

            }else{
                return '<strong>FAILURE: </strong>'.validation_errors();
            }
        }

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

                if($this->db->update('adv',array('mailling'=>serialize($member_info)))){
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
                $this->db->where('id',$this->session->userdata('advid'));
                if($this->db->update('adv',array('mailling'=>serialize($member_info)))){
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
                $this->db->where('id',$this->session->userdata('advid'));
                if($this->db->update('adv',array('mailling'=>serialize($member_info)))){
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

    //****************************************************************** */

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
            $content =$this->load->view('default/payments.php',array('payment'=>$this->Home_model->get_data('payment',array('userid'=>$this->session->userdata('advid')),array(20),array('id','DESC'))),true);
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
                $this->db->where('id',$this->session->userdata('advid'));
                if($this->db->update('adv',array('mailling'=>serialize($member_info)))){
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
                $this->db->where(array('userid'=>$this->session->userdata('advid'),'type'=>'w9'));
                $this->db->update('tax',array('content'=>serialize($data),'type'=>'w9'));
                if($this->db->affected_rows()){
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                }else{
                    $this->db->insert('tax',array('content'=>serialize($data),'userid'=>$this->session->userdata('advid'),'type'=>'w9'));
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }

                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>'.validation_errors().'</p></div>');
                }
        }
        $this->db->where(array('userid'=>$this->session->userdata('advid'),'type'=>'w9'));
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
                $this->db->where(array('userid'=>$this->session->userdata('advid'),'type'=>'w8'));
                $this->db->update('tax',array('content'=>serialize($data),'type'=>'w8'));
                if($this->db->affected_rows()){
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                }else{
                    $this->db->insert('tax',array('content'=>serialize($data),'userid'=>$this->session->userdata('advid'),'type'=>'w8'));
                    $this->session->set_userdata('warn','<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }

                }else{
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>'.validation_errors().'</p></div>');
                }
        }
        $this->db->where(array('userid'=>$this->session->userdata('advid'),'type'=>'w8'));
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
                $this->db->where('id',$this->session->userdata('advid'));
                if($this->db->update('adv',array('mailling'=>serialize($member_info)))){
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
        $this->db->where('id',$this->session->userdata('advid'));
        $this->db->update('adv',array('mailling'=>serialize($member_info)));

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
                if($this->db->get('adv')->row()){
                    //user data ton tai
                    $this->session->set_userdata('warn','<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>The Chan Handle already exists, please choose another one.!</p></div>');
                }else{
                    $this->db->where('id',$this->session->userdata('advid'));
                    if($this->db->update('adv',array('chatuser'=>$chatuser))){
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
        $log = $this->Home_model->get_one('adv',array('key_active'=>$key));
        if(!empty($log)){
            if(!$log->activated){
                if($log->key_active!=$key){
                    echo 'your activation code is not right, please correct them';
                }else{
                    //xu ly kich hoat
                    $this->db->where('key_active',$key);
                    $this->db->update('adv',array('activated'=>1));
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
