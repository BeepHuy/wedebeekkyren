<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country_model extends CI_Model {
    public function get_country () {
        $query = $this->db->get('cpalead_country'); // Lấy tất cả dữ liệu từ bảng country
        return $query->result();

    }
    public function get_offercat()
    {
        $query = $this->db->get('cpalead_offercat'); // Lấy tất cả dữ liệu từ bảng categories
        return $query->result();
    }
    public function get_traftype()
    {
        $query = $this->db->get('cpalead_traftype'); // Lấy tất cả dữ liệu từ bảng traftype
        return $query->result();
    }
}
?>