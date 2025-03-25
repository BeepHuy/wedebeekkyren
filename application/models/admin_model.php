<?php
require 'application/libraries/GeoService.php';
class Admin_model extends CI_Model {
    
    private $table_setting='setting';
    private $geoService;

    function __construct()
    {
        parent::__construct();
        $this->geoService = new Getgeo();  // Khởi tạo Getgeo service
    }
    //$query->free_result(); 
    
    function select_max($table,$file){
         $this->db->select_max($file);
         $query1 = $this->db->get($table);
         $row = $query1->row(); 
         if(empty($row)){
            return false;
         }else  return $row->$file;
    }
    function get_one($table,$where){
        $this->db->where($where);
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
    function get_data($table,$where='',$order='',$limit='',$select=''){
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($order)){
            $this->db->order_by($order['0'],$order['1']);
        }
        if(!empty($limit)){
            if(empty($limit['1'])){
                $this->db->limit($limit['0']);                
            }else $this->db->limit($limit['0'],$limit['1']);
            
        }
        if(!empty($select)){
            $this->db->select($select);
        }
        
        $query = $this->db->get($table);
        if($query->num_rows() > 0){
            $data = $query->result();
            if ($table == 'users') {
                foreach ($data as $row) {
                    if (!empty($row->ip)) {
                        $row->ip_location = $this->geoService->getCountry($row->ip);
                    }
                }
            }
            $query->free_result();
            return $data;
        }else return false;
    }       
    function check_trung($nd,$table){
        $this->db->where($nd);
        $query = $this->db->get($table);
        if($query->num_rows()>0){
            $query->free_result();
            return true;
        }return false;
    }
    
    function xoa($table,$where=''){
        if(!empty($where)){
        $this->db->where($where);
        $this->db->delete($table,$where);
        return true;
        }else return false;
    }
    function update($table,$data,$where=''){        
        $this->db->where($where);
        $this->db->update($table, $data);             
    }
}