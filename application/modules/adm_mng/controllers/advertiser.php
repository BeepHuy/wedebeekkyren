<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Advertiser extends CI_Controller
{
    private $per_page = 30;
    public $pub_config = '';
    public $users = '';
    public function __construct()
    {
        parent::__construct();
        $this->load_thuvien();
        if (!$this->session->userdata('adlogedin') || !$this->session->userdata('aduserid')) {
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        } else {
            $this->session->set_userdata('upanh', 1);
        }

        $this->managerid = $this->session->userdata('aduserid');
        $this->users = $this->Admin_model->get_one('cpalead_manager', array('id' => $this->session->userdata('aduserid')));
        if ($this->users->parrent > 0) {
            $url = $this->uri->segment(2);
            $url3 = $this->uri->segment(3);
            if (
                ($url == 'ajax' && ($url3 != 'ban_user'  && $url3 != 'show_num' && $url3 != 'requestoff')) ||
                ($url == 'showev' && ($url3 != 'tracklink' && $url3 != 'report'))

            ) {
                echo 'Error';
                //redirect($_SERVER['HTTP_REFERER']);
                exit();
            }
            if ($url == 'route') { //chỉnh sửa pass

                if ($url3 == 'users' || $url3 == 'request' || $url3 == 'pubcap' || $url3 == 'sub2cap') {
                    if ($url3 == 'users') redirect(base_url('manager/advertiser'));
                } else {
                    echo 'error';
                    exit();
                }
            }
        }
    }
    function index()
    {

        redirect(base_url('manager/advertiser/advertisers'));
        // $this->load->view('/advertiser_list'); // Gọi view từ module
    }

    function advertisers($offset = 0)
    {
        $w = $this->session->userdata('aff_where');
        $lk = $this->session->userdata('like');

        $mm = '';
        if ($w) {
            foreach ($w as $key => $v) {
                if ($mm) $mm .=  " AND $key= $v";
                else $mm .=  " $key= $v";
            }
        }
        if ($lk) {
            if (is_numeric($lk)) {
                if ($mm) $mm .=  " AND cpalead_advertiser.id= $lk ";
                else $mm .=  "  cpalead_advertiser.id= $lk ";
            } else {
                if ($mm) $mm .= " AND cpalead_advertiser.email LIKE '%$lk%' ";
                else $mm .= " cpalead_advertiser.email LIKE '%$lk%' ";
            }
        }
        if ($mm) {
            $mm = " WHERE $mm ";
        }

        $qr = "
    SELECT DISTINCT cpalead_advertiser.*
    FROM cpalead_advertiser
    INNER JOIN cpalead_manager 
    ON (cpalead_advertiser.manager = cpalead_manager.id) 
    OR (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
    $mm
    ORDER BY cpalead_advertiser.id DESC 
    LIMIT $offset,$this->per_page
";

        $dt = $this->db->query($qr)->result();
        // var_dump($dt);
        // exit;
        if ($this->users->parrent > 0) {
            $pg = 'advertiser.php';
        } else {
            $pg = 'manager/content/advertiser.php';
        }
        // var_dump($pg);
        // exit;
        $sub =  $this->db->query(" SELECT id,username as title FROM cpalead_manager WHERE id = $this->managerid OR parrent = $this->managerid ")->result();

        $content = $this->load->view($pg, array('dulieu' => $dt, 'category' => $sub), true);
        $this->load->view('manager/index', array('content' => $content));
    }

    function load_thuvien()
    {
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model("Admin_model");
    }
}
