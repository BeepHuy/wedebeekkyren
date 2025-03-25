<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends CI_Controller {   
   
    private $mensenger='';    
    private $per_page = 30;
    public $total_rows = 6;   
    public $pub_config= '';
    public $member = '';
    public $member_info = '';
    private $pagina_uri_seg =3;
    private $pagina_baseurl = 's';
    
    function  __construct(){
        parent::__construct();
        //$this->load->model('Home_model'); 
       // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';
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
        echo 1234;
        //$this->account();
    }
    function payment_list(){     
        $this->db->where('advid',$this->member->id);
        //layas payment owr bangw invoice- không dùng bảng payment
        $data['payment']= $this->db->order_by('id','DESC')->get('invoice')->result();        
        $content =$this->load->view('payments/listpm.php',$data,true); 
        $this->load->view('default/vindex.php',array('content'=>$content)); 
    }
    function request_payouts(){
        //check min pay va balance        
        $point = floatval($this->input->post('amount'));        
        $pmethod = $this->input->post('payment_method');
        $paymentId = (int)$this->input->post('pid');   
        $note = '';
        if($pmethod=="pmchose"){
            $this->session->set_userdata('err_po','Please select a payment method!');
            goto ketthuc;            
        }elseif($pmethod=='PayPal'){
            $note = $this->input->post('payment_paypal_email');
        }elseif($pmethod=='Payoneer'){
            $note = $this->input->post('payment_payoneer_email');
        }elseif($pmethod=='Crypto'){
            $note = $this->input->post('payment_Crypto');
        }elseif($pmethod=='Bank Wire'){
            $BankWire = $this->input->post('BankWire');
            $note =serialize($BankWire);
        }
        
        $uid = $this->member->id;
        $date = date("Y-m-d H:i:s"); 
        if($uid){
            if($point>floatval($this->member->available))$point=floatval($this->member->available);
            if($paymentId){//sửa thông tin
                // //check xem no postd đúng user k tạm dừng sửa thông tin
                // $this->db->where(array('id'=>$paymentId,'advid'=>$uid));
                // $this->db->update('invoice',array('note'=>$note,'method'=>$pmethod));
                // if($this->db->affected_rows()>0){
                //     $this->session->set_userdata('succ_po','Updated!');
                // }else{
                //     $this->session->set_userdata('err_po','Error!');
                // }
                
            }else{
                //kiểm tra minpay
                if(floatval($this->pub_config['minpay'])>floatval($this->member->available)){
                    redirect(base_url('v2/payments'));
                    return;
                }
                //$this->db->trans_start();
                $this->db->where('id',$uid);            
                $this->db->set('available', "available - $point", FALSE);
                $this->db->set('pending', "pending + $point", FALSE);
                $this->db->set('log', "invoice: $date - $point");
                $this->db->update('adv');
                if($this->db->affected_rows()>0){
                    $this->db->insert('invoice',array(
                        'status'=>'Pending',
                        'amount'=>$point,
                        'method'=>$pmethod,
                        'note'=>$note,
                        'advid'=>$uid,
                        'date'=>$date,
                        'type'=>3
                    ));
                }
                //$this->db->trans_complete();
            }
            
        }
            //$this->session->set_userdata('err_po','The amount is not null!');
            
        
        ketthuc:
        redirect(base_url('v2/payments'));

    }
    
}