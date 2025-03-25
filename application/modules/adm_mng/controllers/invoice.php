<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller { //admin
    private $page_load='';// chi dinh de load view nao. neu rong thi load mac dinh theo ten bang
    private $databk='';//data function run
    //phan trang
    private $base_url_trang = '';
    private $total_rows = 100;
    private $per_page =30;
    private $pagina_uri_seg=4;
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
        
        if(!$this->session->userdata('adlogedin')){           
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        }else{
            $this->session->set_userdata('upanh',1);
        }
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->managerid=$this->session->userdata('aduserid');
        $this->db->trans_strict(FALSE);
         $this->users = $this->Admin_model->get_one('cpalead_manager',array('id'=>$this->session->userdata('aduserid')));
        if($this->users->parrent>0){            
            $url = $this->uri->segment(3);
            if($url=='invoiPost'){
                echo 'Error';
                //redirect($_SERVER['HTTP_REFERER']);
                exit();
            }
        }
        
       
    } 
     //////////tạo invoice cho members qua ajax
     function aj_invoice($iduser=0,$invoiceid=0,$status=0){
        $dk=1;
        if($_POST){
           $data = $_POST;//trừ curent    
           if($data['usersid']) $iduser = $data['usersid'];
          // print_r($data);       
           if($data['dk']=='taoinvoice'){
            unset($data['dk']);  
            //kiểm tra xem user có tồn tại hay khong
            if($iduser){
                $this->db->trans_start();
                $date =  date('Y-m-d');
                $point = (float)$data['amount'];
                $this->db->where(array('id'=>$iduser,'manager'=>$this->managerid))            
                            ->set('curent', "curent - $point", FALSE)
                            ->set('pending', "pending + $point", FALSE)
                            ->set('log', "invoice: $date - $point", FALSE);
                            $check  = $this->db->update('users');                                
                            if($this->db->affected_rows()>0){
                                $data['type']=2;
                                $this->db->insert('invoice',$data);
                                //$this->session->userdata('thongbao','<div class="alert alert-success" role="alert">Insert successfully</div>');
                            }  
                $this->db->trans_complete();
                
            } 
               //$id=$this->db->insert_id();
               
           }elseif($data['dk']=='doitrangthai'){
            $iid= $data['uid'];//id của trường cần đổi trạng thái
                unset($data['dk']);
                unset($data['uid']);
                $ivdt = $this->Admin_model->get_one('invoice',array('id'=>$iid));
                if($ivdt){
                    $this->db->trans_start();
                    $this->db->where('id',$iid);
                    $this->db->update('invoice',$data);
                    if($data['status']=='Complete' ||$data['status']=='Reverse'){
                        $point = $ivdt ->amount; 
                        $this->db->where('id',$ivdt ->usersid);          
                        $this->db->set('pending', "pending - $point", FALSE);
                        $this->db->update('users');
                    }
                    $this->db->trans_complete();

                }
                
           }elseif($data['dk']=='xoa'){
            /*
            $iid= $data['uid'];
            //cong lại cho mem
            $dt = $this->db->where('id',$iid)->get('invoice')->row();
            if(!empty($dt)){ 
                
                //kiểm tra xem invoice rqeust hay invcoie do admin tạo
                if($dt->type==3){
                    $this->db->trans_start();
                    if($dt->status=='Pending'){                    
                        $this->db->where('id',$dt->usersid)            
                                ->set('available', "available + $dt->amount", FALSE)
                                ->set('pending', "pending - $dt->amount", FALSE)
                                ->update('users');
     
                     }else{
                        $this->db->where('id',$dt->usersid)            
                        ->set('available', "available + $dt->amount", FALSE)                    
                        ->update('users');
                         
                     }
                     $this->db->where('id',$iid);
                     $this->db->delete('invoice');
                     $this->db->trans_complete();

                }else{//do admin và manager tạo
                    //giữ lại như cũ
                    $this->db->trans_start();
                    if($dt->status=='Pending'){                    
                        $this->db->where('id',$dt->usersid)            
                                ->set('curent', "curent + $dt->amount", FALSE)
                                ->set('pending', "pending - $dt->amount", FALSE)
                                ->update('users');
     
                     }else{
                        $this->db->where('id',$dt->usersid)            
                        ->set('curent', "curent + $dt->amount", FALSE)                    
                        ->update('users');
                         
                     }
                     $this->db->where('id',$iid);
                     $this->db->delete('invoice');
                     $this->db->trans_complete();

                }               
                
                
            } 
            */
          }            
           
        }
        if($iduser)$this->db->where('usersid',$iduser);//xử lý chung nếu k có iduser
        $dt = $this->db->get('invoice')->result();        
        $this->load->view('invoice/aj_invoice.php',array('dt'=>$dt,'dk'=>$dk));
        
        
    }
    function search(){
        //session where_status
        if($_POST){          
            //reset sesion
            $this->session->unset_userdata('dtsearch');
            $this->session->unset_userdata('wsearch');     
            $this->session->unset_userdata('jsearch');   
            //keycode//hien dang dang serach user
            if(!$this->input->post('reset')){
                $key = $this->input->post('keycode');  
                $Pending = $this->input->post('Pending');  
                $Complete = $this->input->post('Complete');  
                $Reverse = $this->input->post('Reverse');    
                $date = $this->input->post('date');  //thang-nam
                $managerid = $this->input->post('managerid');     
                
            }
                
            if($key){
                $this->session->set_userdata('likedsearch',trim($key));
            }else{
                $this->session->unset_userdata('likedsearch');
            }       
            //xử lý lọc theo point            
            $where=$ww = $join=$status='';

            if($managerid){
                $ww['managerid']=$managerid;                
                $join ="INNER JOIN cpalead_users ON cpalead_users.manager = $managerid AND cpalead_users.id = cpalead_invoice.usersid  ";                    
                
            }
            if($date){
                $ww['date']=$date;
                $stdate = date('Y-m-01 00:00:00',strtotime($date));
                $enddate = date('Y-m-01 00:00:00',strtotime($date ."+1 month"));
                $where .= " (date between '$stdate' AND '$enddate' )";
            }

            if($Pending){
                $ww['Pending']=1;
                $status[] = 'Pending';
            }
            if($Complete){
                $ww['Complete']=1;
                $status[] ='Complete';
                
            }
            if($Reverse){
                $ww['Reverse']=1;
                $status[] ='Reverse';
                
            }
            $wstatus='';
            if($status){
                $dem = 0;
                foreach($status as $status){
                    $dem++;
                    if($dem==1){
                        $wstatus .="cpalead_invoice.status = '$status' ";
                    }else{
                        $wstatus .="OR cpalead_invoice.status = '$status' ";
                    }
                    
                }                
                if($where){
                    $where .=' AND ('.$wstatus.')';
                }else{
                    $where .='('.$wstatus.')';
                }
            }
            
           
            
            $this->session->set_userdata('dtsearch',$ww);
            $this->session->set_userdata('wsearch',$where);     
            $this->session->set_userdata('jsearch',$join); 
            //print_r($this->session->userdata('wsearch'))  ;     
            redirect($this->uri->segment(1).'/invoice/invoicedt');
            
        }
    }
    function invoiPost(){
        //session thongbao
        //<div class="alert alert-success" role="alert"></div>
        
        $iduser =0;
        if($_POST){
            $data = $_POST;//trừ curent    
            if($data['usersid']) $iduser = (int)$data['usersid'];
           // print_r($data);       
            if($data['dk']=='taoinvoice'){
                unset($data['dk']);  
                //kiểm tra xem user có tồn tại hay khong
                if($iduser){
                    $this->db->trans_start();
                    $date =  date('Y-m-d');
                    $point = (float)$data['amount'];
                    $this->db->where(array('id'=>$iduser,'manager'=>$this->managerid))            
                                ->set('curent', "curent - $point", FALSE)
                                ->set('pending', "pending + $point", FALSE)
                                ->set('log', "invoice: $date - $point", FALSE);
                                $check  = $this->db->update('users');                                
                                if($this->db->affected_rows()>0){
                                    
                                    $this->db->insert('invoice',$data);
                                    //$this->session->userdata('thongbao','<div class="alert alert-success" role="alert">Insert successfully</div>');
                                }  
                    $this->db->trans_complete();
                    
                }          
                              
                //$id=$this->db->insert_id();
                
            }elseif($data['dk']=='doitrangthai'){
                $iid= $data['uid'];//id của trường cần đổi trạng thái
                 unset($data['dk']);
                 unset($data['uid']);
                 $ivdt = $this->Admin_model->get_one('invoice',array('id'=>$iid));
                 if($ivdt){
                    $this->db->trans_start();
                     $this->db->where('id',$iid);
                     $this->db->update('invoice',$data);

                     if($data['status']=='Complete'||$data['status']=='Reverse'){//nếu chuyển từ pending sang complete
                         $point = $ivdt ->amount; 
                         $this->db->where('id',$ivdt ->usersid);          
                         $this->db->set('pending', "pending - $point", FALSE);
                         $this->db->update('users');
                     }
                     $this->db->trans_complete();
 
                 }
                 
            }elseif($data['dk']=='xoa'){
                // $iid= $data['uid'];
                // //cong lại cho mem
                // $dt = $this->db->where('id',$iid)->get('invoice')->row();
                // if(!empty($dt)){ 
                //     //kiểm tra xem invoice rqeust hay invcoie do admin tạo
                //     if($dt->type==3){
                //         $this->db->trans_start();
                //         if($dt->status=='Pending'){                    
                //             $this->db->where('id',$dt->usersid)            
                //                     ->set('available', "available + $dt->amount", FALSE)
                //                     ->set('pending', "pending - $dt->amount", FALSE)
                //                     ->update('users');
         
                //          }else{
                //             $this->db->where('id',$dt->usersid)            
                //             ->set('available', "available + $dt->amount", FALSE)                    
                //             ->update('users');
                             
                //          }
                //          $this->db->where('id',$iid);
                //          $this->db->delete('invoice');
                //          $this->db->trans_complete();
    
                //     }else{//do admin và manager tạo
                //         //giữ lại như cũ
                //         $this->db->trans_start();
                //         if($dt->status=='Pending'){                    
                //             $this->db->where('id',$dt->usersid)            
                //                     ->set('curent', "curent + $dt->amount", FALSE)
                //                     ->set('pending', "pending - $dt->amount", FALSE)
                //                     ->update('users');
         
                //          }else{
                //             $this->db->where('id',$dt->usersid)            
                //             ->set('curent', "curent + $dt->amount", FALSE)                    
                //             ->update('users');
                             
                //          }
                //          $this->db->where('id',$iid);
                //          $this->db->delete('invoice');
                //          $this->db->trans_complete();
    
                //     }
                    
                // } 
                
            }  
        }
         redirect('manager/invoice/invoicedt');
    }
    function invoicedt($offset=0){
        $dk=1;       
        $where =$like= '';
        $wsearch = $this->session->userdata('wsearch');
        $key = $this->session->userdata('likedsearch');
        if($key){
            if(is_numeric($key)){ 
                $this->per_page = 3000;
                $where .= " WHERE usersid=$key";//xử lý chung nếu k có iduser 
            }else{ //tamj thoiwf k co tim theo email
                //$like .= 
                //$cat_Like .='offercat LIKE \'%o'.$cat.'o%\'';          
            }
        }
        if($wsearch) {
            if($where) $where .=" AND ($wsearch)";
            else $where .= "WHERE $wsearch ";
        }
       
        /*
        $qr = "
            SELECT * 
            FROM cpalead_invoice
            $where
            ORDER BY `id` DESC 
            LIMIT $offset,$this->per_page
        "; 
        */ 
        $qr = "
            SELECT cpalead_invoice.*,cpalead_users.email
            FROM cpalead_invoice
            INNER JOIN cpalead_users ON cpalead_users.id = cpalead_invoice.usersid            
            INNER JOIN cpalead_manager ON (cpalead_users.manager = cpalead_manager.id) AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            
            $where
            ORDER BY cpalead_invoice.id DESC 
            LIMIT $offset,$this->per_page
        ";          
        $dt = $this->db->query($qr)->result();   
        //lay soos luong trang
        $qr = "
            SELECT COUNT(*) as total
            FROM cpalead_invoice
            INNER JOIN cpalead_users ON cpalead_users.id = cpalead_invoice.usersid
            INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            
            $where            
        "; 
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'); 
        $this->phantrang();  
        if($this->users->parrent>0){  
            $pg ='invoice/sub_invoice.php';
        }else{
            $pg ='invoice/invoice.php';
        }
        
        $content= $this->load->view($pg,array('dulieu'=>$dt,'dk'=>$dk),true);        
        $this->load->view('manager/index',array('content'=>$content));
        
        
    }
    

  
    function load_thuvien(){
        $this->load->helper(array( 'alias_helper','text','form'));
        $this->load->model("Admin_model");        
    }
    function phantrang(){
        $this->load->library('pagination');// da load ben tren
        $config['base_url'] =$this->base_url_trang;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->pagina_uri_seg;
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
   
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */