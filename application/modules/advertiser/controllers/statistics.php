<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends CI_Controller {
    private $allchild = array();
    private $per_page = 50;
    public $total_rows = 0;
    function  __construct(){
        parent::__construct();
        //$this->load->model('Home_model');
       // $this->inic->sysm();
        //$this->setting=$this->Home_model->get_one('setting',array('id'=>1));
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

    function index($article_id=0){
       echo 123;

    }
    function dayli(){
        //kiểm tra bộ lọc
        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT date,count(id) as click, SUM(CASE WHEN status=2 THEN 1 ELSE 0 END) as declined, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve,sum(flead) as lead,count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<? $where group by DATE(date)";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/dayli.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function ajax_sub_dayli(){
        $date = $this->input->post('date');
        //xử lsy bộ lọc
        $dt ='';
        //lọc theo country
        $ct = $this->session->userdata('sCountry');
        if($ct){
            $dt .=  " AND countries IN ('".implode("','",$ct)."')";
        }

        //bộ lọc offer sOffer
        $soff = $this->session->userdata('sOffer');
        if($soff){
            $dt .=  " AND offerid IN ('".implode("','",$soff)."')";
        }
        //bộ lọc OS sOs
        $sos = $this->session->userdata('sOs');
        if($sos){
            $dt ." AND os_name IN ('".implode("','",$sos)."')";
        }
         //lấy dữ liệu từ tracklink
        $qr = "SELECT date,count(id) as click, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve,sum(flead) as lead,count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and DATE(date)=?  $dt group by HOUR(date)";
        $dayli_rp = $this->db->query($qr,array($this->member->id,$date))->result();
        if($dayli_rp){
            foreach($dayli_rp as $dayli_rp){
                echo '
                           <tr role="row" class="_1xlMlIRHcfJahC1c76JzJV sub_dayli_'.$date.'" >
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _1YEl4yCJEz0C3EFWAe9CjL"><span>'.date("H:m",strtotime($dayli_rp->date)).'</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$dayli_rp->hosts.'</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$dayli_rp->click.'</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$dayli_rp->click.'</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$dayli_rp->lead.'</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$'.number_format(round($dayli_rp->reve,2),2).'</span></span></td>
                           </tr>
                           ';
            }
        }

    }
    function conversions($offset=0){

        $data =$this->locdulieu();
        $where = $data['where'];
        //lấy dữ liệu từ tracklink
        $qr = "SELECT *  FROM `cpalead_tracklink`  WHERE userid=? AND flead=1 AND date>=? AND date<? $where ORDER BY `id` DESC LIMIT $offset,$this->per_page";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();
        //phan trang
        $qr  = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE userid=? AND flead=1 AND date>=? AND date<? $where";
        $this->total_rows = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->row()->total;
        $this->pagina_uri_seg =4;
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';
        $this->phantrang();
        //end phan trangs
        $content =$this->load->view('statistics/conversions.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function offers($offset=0){

        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "
        SELECT offerid,oname,
        count(id) as click,
        SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) as approved,
        SUM(CASE WHEN status=2 THEN 1 ELSE 0 END) as declined,
        SUM(CASE WHEN status=3 THEN 1 ELSE 0 END) as payed,

        SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as mtotal,
        SUM(CASE WHEN status=1 THEN amount2 ELSE 0 END) as mpending,
        SUM(CASE WHEN status=2 THEN amount2 ELSE 0 END) as mdeclined,
        SUM(CASE WHEN status=3 THEN amount2 ELSE 0 END) as mpayed,
        sum(flead) as lead,count(DISTINCT ip) as hosts
        FROM `cpalead_tracklink`
        WHERE userid=? and date>=? and date<? $where group by offerid";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/offers.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function referrals(){
        $data =$this->locdulieu();
        $where = '';
        //$where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "
        SELECT offerid,oname,userid,
        count(id) as click,
        SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) as approved,
        SUM(CASE WHEN status=2 THEN 1 ELSE 0 END) as declined,
        SUM(CASE WHEN status=3 THEN 1 ELSE 0 END) as payed,

        SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as mtotal,
        SUM(CASE WHEN status=1 THEN amount2 ELSE 0 END) as mpending,
        SUM(CASE WHEN status=2 THEN amount2 ELSE 0 END) as mdeclined,
        SUM(CASE WHEN status=3 THEN amount2 ELSE 0 END) as mpayed,
        sum(flead) as lead,count(DISTINCT ip) as hosts
        FROM `cpalead_tracklink`
        WHERE userid IN (SELECT id FROM cpalead_adv WHERE ref = {$this->member->id}) and date>=? and date<? $where group by offerid,userid Order BY userid DESC";
        $data['data'] = $this->db->query($qr,array($data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/referrals.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));

    }
    function browsers(){
        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT browser,count(id) as click, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve,sum(flead) as lead,count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<? $where group by browser";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/browsers.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function smartlinks(){
        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.smartlink,count(cpalead_tracklink.id) as click,SUM(CASE WHEN cpalead_tracklink.status=2 THEN 1 ELSE 0 END) as declined,
                SUM(CASE WHEN cpalead_tracklink.flead=1 THEN amount2 ELSE 0 END) as reve,sum(cpalead_tracklink.flead) as lead,count(DISTINCT cpalead_tracklink.ip) as hosts ,
                cpalead_offer.title as oname
                FROM `cpalead_tracklink`
                LEFT JOIN cpalead_offer ON cpalead_tracklink.smartlink= cpalead_offer.id
                WHERE cpalead_tracklink.userid=? AND cpalead_tracklink.smartlink>0 and cpalead_tracklink.date>=? and cpalead_tracklink.date<? $where group by cpalead_tracklink.smartlink";

        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/smartlinks.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function smlinks_convert($offset=0){   //smartlink convert
        $data =$this->locdulieu();
        $where = $data['where'];
        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.* , cpalead_offer.title as smatlink_name
        FROM `cpalead_tracklink`
        LEFT JOIN cpalead_offer ON cpalead_tracklink.smartlink= cpalead_offer.id
         WHERE cpalead_tracklink.userid=? AND cpalead_tracklink.flead=1 AND cpalead_tracklink.date>=? AND cpalead_tracklink.date<? $where AND cpalead_tracklink.smartlink>0 ORDER BY cpalead_tracklink.id DESC LIMIT $offset,$this->per_page";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();
        //phan trang
        $qr  = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE userid=? AND flead=1 AND date>=? AND date<? $where AND cpalead_tracklink.smartlink>0";
        $this->total_rows = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->row()->total;
        $this->pagina_uri_seg =4;
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';
        $this->phantrang();
        //end phan trangs
        $content =$this->load->view('statistics/smlinks_convert.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function smartoffers(){
        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        //lấy dữ liệu từ tracklink
        $qr = "
        SELECT cpalead_tracklink.smartoff,
        count(cpalead_tracklink.id) as click,
        SUM(CASE WHEN cpalead_tracklink.status=1 THEN 1 ELSE 0 END) as approved,
        SUM(CASE WHEN cpalead_tracklink.status=2 THEN 1 ELSE 0 END) as declined,
         SUM(CASE WHEN cpalead_tracklink.status=3 THEN 1 ELSE 0 END) as payed,

        SUM(CASE WHEN cpalead_tracklink.flead=1 THEN amount2 ELSE 0 END) as mtotal,
        SUM(CASE WHEN cpalead_tracklink.status=1 THEN amount2 ELSE 0 END) as mpending,
        SUM(CASE WHEN cpalead_tracklink.status=2 THEN amount2 ELSE 0 END) as mdeclined,
        SUM(CASE WHEN cpalead_tracklink.status=3 THEN amount2 ELSE 0 END) as mpayed,
        sum(cpalead_tracklink.flead) as lead,
        count(DISTINCT cpalead_tracklink.ip) as hosts ,
        cpalead_offer.title as oname

        FROM `cpalead_tracklink`
        LEFT JOIN cpalead_offer ON cpalead_tracklink.smartoff= cpalead_offer.id
        WHERE cpalead_tracklink.userid=? AND cpalead_tracklink.smartoff>0 and cpalead_tracklink.date>=? and cpalead_tracklink.date<? $where
        group by cpalead_tracklink.smartoff";


        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/smartoffs.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function smoffers_convert($offset=0){   //smartoff convert
        $data =$this->locdulieu();
        $where = $data['where'];
        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.* , cpalead_offer.title as smoffers_name
        FROM `cpalead_tracklink`
        LEFT JOIN cpalead_offer ON cpalead_tracklink.smartoff= cpalead_offer.id
         WHERE cpalead_tracklink.userid=? AND cpalead_tracklink.flead=1 AND cpalead_tracklink.date>=? AND cpalead_tracklink.date<? $where AND cpalead_tracklink.smartoff>0 ORDER BY cpalead_tracklink.id DESC LIMIT $offset,$this->per_page";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();
        //phan trang
        $qr  = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE userid=? AND flead=1 AND date>=? AND date<? $where AND cpalead_tracklink.smartoff>0";
        $this->total_rows = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->row()->total;
        $this->pagina_uri_seg =4;
        $this->pagina_baseurl =  base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';
        $this->phantrang();
        //end phan trangs
        $content =$this->load->view('statistics/smoffers_convert.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function os(){
        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT os_name,count(id) as click, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve,sum(flead) as lead,count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<? $where group by os_name";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/os.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function devices(){
        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT device_type,count(id) as click, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve,sum(flead) as lead,count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<? $where group by device_type";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/devices.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function countries(){
        $data =$this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT countries,count(id) as click, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve,sum(flead) as lead,count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<? $where group by countries";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/countries.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function sub($num=1){
        $num = (int)$num;
        if($num<1 & $num >6){
            return;
        }
        $sub= 's'.$num;
        $data =$this->locdulieu();
        $where = $data['where'];
        $data['sub'] =$sub;

        //lấy dữ liệu từ tracklink
        $qr = "SELECT $sub,count(id) as click, SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve,sum(flead) as lead,count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<? $where group by $sub";
        $data['data'] = $this->db->query($qr,array($this->member->id,$data['from'],$data['to']))->result();

        $content =$this->load->view('statistics/subid.php',$data,true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }
    function locdulieu($type=0){
        $dt ='';
        //không lấy report của smartlink và smartoff
        $uri = trim($this->uri->segment(3));
        if($uri!='smartlinks'&&$uri!='smlinks_convert'&&$uri!='smartoffers'&&$uri!='smoffers_convert'){
            $dt= ' AND smartlink =0 AND smartoff=0';
        }

        //lọc theo country
        $ct = $this->session->userdata('sCountry');
        if($ct){
            $dt .=  " AND countries IN ('".implode("','",$ct)."')";
        }

        //bộ lọc offer sOffer
        $soff = $this->session->userdata('sOffer');
        if($soff){
            $dt .=  " AND offerid IN ('".implode("','",$soff)."')";
        }
        //bộ lọc OS sOs
        $sos = $this->session->userdata('sOs');
        if($sos){
            $dt ." AND os_name IN ('".implode("','",$sos)."')";
        }


        $data['where'] = $dt;
        //lấy giữu liệu cho bộ lọc
        if($this->session->userdata('from')&&$this->session->userdata('from')!='Invalid date'){
            $data['from']  = $this->session->userdata('from');
            $data['to']  = $this->session->userdata('to');
        }else{
            $data['from']   = date("Y-m-d",strtotime('6 days ago'));//cách đây 1 tuần;
            $data['to']  = date("Y-m-d");//ngay hoom nay
            $this->session->set_userdata('from',$data['from'] );
            $this->session->set_userdata('to',$data['to']);
        }
        $data['to'] = date('Y-m-d', strtotime('+1 day', strtotime($data['to'])));
        //type ='flead' //laays rieeng offerr lead

        $qr = "SELECT offerid,oname FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<?  group by offerid";
        $data['soffer'] = $this->db->query($qr,array($this->member->id,$data['from'] ,$data['to']))->result();

        $qr = "SELECT os_name FROM `cpalead_tracklink`  WHERE userid=? and date>=? and date<?  group by os_name";
        $data['os_name'] = $this->db->query($qr,array($this->member->id,$data['from'] ,$data['to']))->result();

        $data['country'] = $this->Home_model->get_data('country',array('show'=>1));

        return $data;
    }
    function ajax_static_dayli(){
        $name = $this->input->post('name');
        $gt = $this->input->post('gt');
        if($name=='date'){
           $arr =  explode("#",$gt);
           //$this->session->set_userdata($name,$gt);
           $this->session->set_userdata('from',$arr[0]);
           $this->session->set_userdata('to',$arr[1]);

        }elseif($name){
            $this->session->set_userdata($name,$gt);
        }
        echo 1;
        //Array ( [gt] => Array ( [0] => 5 [1] => 6 [2] => 7 ) [name] => cat )
        //[name] =>country

    }
    function nodata(){
        $content =$this->load->view('statistics/dayli.php',array(),true);
        $this->load->view('default/vindex.php',array('content'=>$content));
    }


    function phantrang(){
        $this->load->library('pagination');// da load ben tren
        $config['base_url'] = $this->pagina_baseurl;
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
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        //------------preview
        $config['prev_link'] = '&lt; prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
       // ------------------cu?npage
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        //--so
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        //-----
        $config['anchor_class'] = 'class="page-link" ';
        $this->pagination->initialize($config);

    }
}