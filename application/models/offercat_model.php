<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offercat_model extends CI_Model
{
    public function get_offercat()
    {
        $query = $this->db->get('cpalead_offercat'); // Lấy tất cả dữ liệu từ bảng country
        return $query->result();
    }
}
