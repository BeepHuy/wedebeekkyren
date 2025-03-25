<?php
$marr =$dateArr= array();
$tab = $contentTab='';
$uid =  $this->member->id;
if(!$uid){
   $uid = 0;
}
$qr = "
   SELECT `time` FROM `cpalead_postback_log` WHERE `userids` = $uid Group By month(`time`),year(`time`) ORDER by time ASC limit 7
";
$dt = $this->db->query($qr)->row();
if($dt){
   $date = date('y-m-d',strtotime($dt->time));
   $qr = "
   SELECT * FROM `cpalead_postback_log` WHERE `userids` = $uid AND time>=$date;
   ";
   $data = $this->db->query($qr)->result();
   
   if($data){
      $i=0;
      foreach($data as $data){
         $date = date('y-m-d',strtotime($data->time));
         
         if(!in_array($date,$dateArr)){
            $i++;
            if($i==1){
               $cll = 'true';
               $link = 'active';
            }else{
               $cll = 'false';
               $link ='';
            }
            $dateArr[] = $date;
            $tab .= '
               <li class="nav-item" role="presentation">
                  <button class="nav-link '.$link.'" data-bs-toggle="pill" data-bs-target="#c'.$date.'" type="button" role="tab" aria-selected="'.$cll.'">'.$date.'</button>                  
               </li>
            ';
         }
         $marr[$date][] = array(
            'subid'=>$data->tracklink,
            'campaignid'=>$data->campaignid,
            'finalurl'=>$data->finalurl,
            'response'=>strip_tags($data->response),
            'date'=>$data->time
         );

      }
      


   }
}

?>
<div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent postback_log">
   <form class="sc-hycgNl hCPKEY">
      <ul class="nav mb-3 nav-tabs" id="pills-tab" role="tablist">

         
        <?php echo $tab;?>

      </ul>
      <div class="tab-content p-2" id="pills-tabContent">
         <?php
            if(!empty($dateArr)){
               $i=0;
               foreach($dateArr as $date){
                  $i++;
                  if($i==1){
                     $cll= 'active';
                     $sh = 'show';

                  }else{
                     $cll= '';
                     $sh = '';
                  }
                  echo '<div class="tab-pane fade '.$sh.' '.$cll.'" id="c'.$date.'" role="tabpanel"><pre>';
                  print_r($marr[$date]);
                  echo '</pre></div>';

               }
            }
         ?>
         
      </div>
   </form>
</div>
<style>
.tab-content{
   width:100%;    
}
</style>

