<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Update extends CI_Controller{    	
    function __construct(){
		parent::__construct();		
	}
    function index(){
  
        // $this->load->dbforge();
        // $fields = array(           
        //     'block_sub2' => array(
        //                              'type' => 'TEXT',
        //                              'default' => '',
        //                               'null' => TRUE
        //                       ),
            
        // );
        // $fields = array(
        //     'api_key' => array('type' => 'VARCHAR','constraint' => '100','default' => '', 'null' => TRUE)
        // );
        //$this->dbforge->add_column('users', $fields);
        //$this->db->query('ALTER TABLE `cpalead_users` ADD INDEX( `api_key`)');

        // $dt = $this->Home_model->get_data('users',array('api_key'=>''));
        // if(!empty($dt)){
        //     foreach($dt as $dt ){
        //         $this->resetApi($dt->id);
        //     }
        // }else{
        //     echo 'done';
        // }

    }
    function resetApi($uid){
        getapikey:
        $key = substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30);
        if($this->Home_model->get_one('users',array('api_key'=>$key))){
            goto getapikey;
        }else{
            $this->db->where('id',$uid)->update('users',array('api_key'=>$key));            
        }
       
    }

}