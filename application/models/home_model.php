<?php
class Home_model extends CI_Model {
    
    private $table_setting='setting';
    function __construct()
    {
        parent::__construct();
    }    
    function select_max($table,$file){
         $this->db->select_max($file);
         $query1 = $this->db->get($table);
         $row = $query1->row(); 
         if(empty($row)){
            return false;
         }else  return $row->$file;
    }
    function get_one($table,$where=''){
        if($where){
            $this->db->where($where);
        }        
        $query = $this->db->get($table);
        if($query->num_rows() > 0 ){
            $data = $query->row();
            $query->free_result();
           return $data;
        }else return false;
    }    
    function get_number($table,$where=''){
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->num_rows();
    }
    function get_data($table,$where='',$limit=array(),$order=array(),$where_in='',$select=''){
        if(!empty($select)){
            $this->db->select($select);
        }
        if(!empty($where_in)){
            $this->db->where_in($where_in[0],$where_in[1]);
        }
        if(!empty($limit)){
            if(empty($limit[1])){
                $this->db->limit($limit[0]);
            }else $this->db->limit($limit[0],$limit[1]);  //$limit[1] start limie de phan trang          
        }
        if(!empty($order)){
            $this->db->order_by($order['0'],$order['1']);
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
            return $data;
        }else return false;
    }
}