<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Crontab extends CI_Controller
{
    private $redis;
    function __construct()
    {
        parent::__construct();
        $this->redis = new Redis(); 
        $this->redis->connect('127.0.0.1', 6379);    
    }
    
    function index(){
        /*
        echo $yesterday =  date('Y-m-d 23:59:59',strtotime('-1day'));
        $pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        echo $minpay = $pub_config['minpay'];
        */
     
    }
    //hiện tại chỉ dùng crontab month
    //0 0 1 * * curl -s "http://wedebeek.com/crontab/cronmonth"
   

    function cronmonth(){
        return 1;//tạm thời dừng
        $text =  ' Invoice: '.date('M Y',strtotime('-2 month'));
        $pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        $minpay = (int)$pub_config['minpay'];
        $endate =  date('Y-m-01 00:00:00',strtotime('-1 month'));//trừ 1 tháng do lấy mùng 1 tháng đó. vì vậy <01 là k lấy tháng đó vậy invoice tháng 2 sẽ lấy đến tháng 3        
        //để test thì k lấy trừ -month nữa
        // sau khi get user đủ min pay thì tạo vinceoi và update - current và cộng pending và update date_invoice chính là enddate
        $yesterday =  date('Y-m-d 23:59:59',strtotime('-1day'));//ngày lưu vào invoice date//ngày tạo invoice
        $qr = "
            SELECT SUM(amount2) as pay,userid
            from cpalead_tracklink
            inner join cpalead_users
                on cpalead_tracklink.userid = cpalead_users.id
            WHERE cpalead_tracklink.status =1 and cpalead_tracklink.date>cpalead_users.date_invoice and date< '$endate'
            GROUP BY userid
            HAVING pay >=$minpay
        ";
        $data =$this->db->query($qr)->result();
        $this->db->trans_strict(FALSE);
        if(!empty($data)){
            foreach($data as $data){//log
                $this->db->trans_start();
                 $point = $data->pay;
                 $this->db->where('id',$data->userid);            
                 $this->db->set('curent', "curent - $point", FALSE);
                 $this->db->set('pending', "pending + $point", FALSE);
                 $this->db->set('log', "invoice: $yesterday - $point");
                 $this->db->set('date_invoice', $endate);
                 $this->db->update('users');
                 if($this->db->affected_rows()>0){
                     $this->db->insert('invoice',array(
                         'status'=>'Pending',
                         'amount'=>$point,
                         'note'=>$text,
                         'usersid'=>$data->userid,
                         'date'=>$yesterday
                     ));
                 }
                 $this->db->trans_complete();
                 
            }          
        }


    }
    function cron24h(){    
        //update epc vaf cr offer
        $qr = "
        UPDATE `cpalead_offer` 
            SET cr= ROUND((lead/click)*100, 2),
                epc =  ROUND((revenue/click),2)     
            WHERE revenue>0 AND auto_cr=0
        ";
        $this->db->query($qr);
        /*
        $ytd = date('Y-m-d', strtotime('-1 day', time()));// date('Y-m-d H:i:s',time()
        $std = $ytd.' 7:00:00';// date('Y-m-d H:i:s',time()
        $ed = date('Y-m-d').' 7:00:00';// date('Y-m-d H:i:s',time()
         //
         $where = '`date` >= "'.$std.'" AND `date` <= "'.$ed.'"';         
         $groupby = 'offerid,userid';       
         $qr = 'INSERT INTO cpalead_dreport (userid, offerid, date,oname,lead,click,unqine) SELECT userid,offerid,"'.$ytd.'" as date,oname,sum(flead) as lead,count(id) as click, count(DISTINCT ip) as uniq  FROM `cpalead_tracklink`  WHERE '.$where.' group by '.$groupby;
         $rp = $this->db->query($qr);
         */
         /*
        
         $yeah = date('Y');
         $month = date('m');
         $day = date('d');
         $day = $day-1;
         $where = "DAY(date)=$day AND MONTH(date) = $month AND YEAR(date) = $yeah";         
         $groupby = 'offerid,userid,DATE(date)';
         $qr = 'INSERT INTO cpalead_dreport (userid, offerid, date,oname,lead,click,unqine) SELECT userid,offerid,DATE(date),oname,sum(flead) as lead,count(id) as click, count(DISTINCT ip) as uniq  FROM `cpalead_tracklink`  WHERE '.$where.' group by '.$groupby;
         $this->db->query($qr);
         */
         
         
    }
    //cront capped member and capped offer
    function cron24h_capped(){   
        $this->load->library('TracklinkDistributor', array('redis' => $this->redis));
        $this->tracklinkdistributor->clearTracklinkByOffer(); 
        //update epc vaf cr offer
        $qr = "
        UPDATE `cpalead_pubcap` 
            SET capcount=0   
            WHERE 1
        ";
        $this->db->query($qr);  

        $qr = "
        UPDATE `cpalead_sub2cap` 
            SET capcount=0   
            WHERE 1
        ";
        $this->db->query($qr);   

        $qr = "
        UPDATE `cpalead_offer` 
            SET capcount=0   
            WHERE 1
        ";
        $this->db->query($qr);           
         
    }
        
         


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
