<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
    private $allchild = array();
    private $per_page = 5;
    private $total_rows = 6;
    function  __construct(){
        parent::__construct();
        $this->load->model('Home_model');
       // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));

       // $this->setting= unserialize(file_get_contents('setting_file/setting.txt'));
        //$this->Home_model->get_one('users',array('id'=>$this->session->userdata('userid')));

    }
    function aboutus(){
        $content =array();
        $this->load->view('pages/aboutus.php',array('content'=>$content));
    }
    function advertiser(){
        $content =array();
        $this->load->view('pages/advertiser.php',array('content'=>$content));
    }
    function publisher(){
        $content =array();
        $this->load->view('pages/publisher.php',array('content'=>$content));
    }
    function products(){
        //xử lsy payment term
        $paymterm = $this->Home_model->get_data('paymterm',array('show'=>1));
        $marrpaymterm = array();
        if($paymterm){
            foreach($paymterm as $paymterm){
                $marrpaymterm[$paymterm->id] = $paymterm->payment_term;
            }
        }
        //xử lsy offer type
        $offertype = $this->Home_model->get_data('offertype',array('show'=>1));
        $marroffertype = array();
        if($offertype){
            foreach($offertype as $offertype){
                $marroffertype[$offertype->id] = $offertype->type;
            }
        }
        //xử lý country $mCountryKeycode
        $country = $this->Home_model->get_data('country',array('show'=>1));
        $mCountryKeycode = array();
        if($country){
            foreach($country as $country){
                $mCountryKeycode[$country->id] = strtolower($country->keycode);

            }
        }
        //get offer by category
        $this->db->select('offercat as catname,id');
        $cpalead_offercat = $this->Home_model->get_data('cpalead_offercat',array('show'=>1));
        $mcat_off=array();
        if($cpalead_offercat){
            foreach($cpalead_offercat as $cpalead_offercat){
                //get offer bay cateygor
                $this->db->limit(20);
                $this->db->like('offercat','o'.$cpalead_offercat->id.'o');
                $off = $this->Home_model->get_data('offer',array('show'=>1,'home'=>1));
                if($off){
                    $mcat_off[$cpalead_offercat->id]['offer']=$off;
                    $mcat_off[$cpalead_offercat->id]['cat']=$cpalead_offercat->catname;
                }
            }
        }
        $data['mcat_off']= $mcat_off;
        $data['homepage'] = $this->Home_model->get_one('setting',array('id'=>1));
        $data['marrpaymterm']= $marrpaymterm;
        $data['marroffertype']= $marroffertype;
        $data['mCountryKeycode']= $mCountryKeycode;
        $data['newoffer']= $this->Home_model->get_data('offer',array('show'=>1,'new'=>1),array(20),array('id','DESC'));
        $data['topoffer'] = $this->Home_model->get_data('offer',array('show'=>1,'top'=>1),array(20));
        $this->load->view('pages/products.php',$data);
    }
    function contact(){
        $this->load->library('form_validation');
        if(!empty($_POST)){
            $this->form_validation->set_rules('ten', 'Name', 'trim|required|min_length[3]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('thongtin', 'Message', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE){  
                   
            }
            else{            			
                $data = $this->security->xss_clean($_POST);
                $this->db->insert('contact', $data); 
                $this->load->view('pages/contact_tks.php');  
                return;     
            }
        
        } 
        $this->load->view('pages/contact.php');       
	}
    function contact_ajax(){
        $this->load->library('form_validation');
        if(!empty($_POST)){
            $this->form_validation->set_rules('ten', 'Name', 'trim|required|min_length[3]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('thongtin', 'Message', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE){  
                $array = array(
                    'error'   => true,
                    'ten_error' => form_error('ten'),
                    'email_error' => form_error('email'),
                    'thongtin_error' => form_error('thongtin')
                );
            }else{            			
                $data = $this->security->xss_clean($_POST);
                $this->db->insert('contact', $data); 
                $array = array(
                    'success' => 'Message is successfully sent!'
                );   
            }
            echo json_encode($array);
        }      
	}
}