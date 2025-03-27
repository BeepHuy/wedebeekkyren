<div class="row my-3 g-4 row-cols-lg-1 ">
   <div class="col-xl-6 col-lg-12 vien">
      <div class="advertiser  db_info  py-2 px-4 d-flex flex-column align-content-between">
         <div class="row d-flex justify-content-between my-sm-3">
            <div class="d-flex col-md-8 col-sm-12 lign-items-start">
            <div class="advertiser-avatar icon-square bg-light text-dark flex-shrink-0 me-3">
               <?php 
               if (!empty($advertiser->reg_cert)) {
                  $images = explode(',', $advertiser->reg_cert);
                  foreach ($images as $image) {
                     $image_path = 'upload/adv/' . trim($image);
                     if (file_exists(FCPATH . $image_path)) {
                           echo '<img src="'.base_url($image_path).'" alt="" width="100" class="img-thumbnail">';
                     } 
                  }
               }
               ?>
            </div>
               <div class="advertiser-info">
                  <?php if (!empty($advertiser)): ?>
                        <p class="mtp">Personal advertiser</p>
                        <p class="m-name">
                           <?php echo isset($advertiser->mailling_data['firstname']) ? $advertiser->mailling_data['firstname'] : 'N/A'; ?>
                           <?php echo isset($advertiser->mailling_data['lastname']) ? ' '.$advertiser->mailling_data['lastname'] : ''; ?>
                        </p>
                        <p class="email">
                           <span>Email:</span>
                           <?php echo isset($advertiser->email) ? $advertiser->email : 'N/A'; ?>
                        </p>
                        <p class="skype">
                           <span>Skype:</span>
                           <?php echo isset($advertiser->mailling_data['im_service']) ? $advertiser->mailling_data['im_service'] : 'N/A'; ?>
                        </p>
                  <?php endif; ?>
               </div>
            </div>
            <div class="d-flex flex-md-row-reverse mb-3 col-md-4 col-sm-12">
               <div class="text-start">
                  Balance
                  <div class="diem d-flex">
                     <span class="epoint">
                        <?php
                        $balance = round($this->member->curent + $this->member->available, 2);
                        echo $balance;
                        ?></span>
                     <span class="ttusd align-self-center">USD
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="T_-OwGeVQ2tvt69C7mvbY css-4k7dfu">
                           <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                     </span>
                  </div>

               </div>
            </div>
         </div>
         <div class="row  row-cols-1 row-cols-sm-1 row-cols-md-4 balance" style="margin-top: auto;">
            <div class="col">
               <span class="text-warning">
                  Balance
               </span>
               <div class="blance_c">
                  <div class="blan_usd">
                     USD <?php echo $balance; ?>
                  </div>
               </div>
            </div>
            <div class="col">
               <span class="text-warning">
                  Hold
               </span>
               <div class="blance_c">
                  <div class="blan_usd">
                     USD <?php echo round($this->member->curent, 2); ?>
                  </div>
               </div>
            </div>
            <div class="col">
               <span class="text-warning">
                  Available
               </span>
               <div class="blance_c">
                  <div class="blan_usd">
                     USD<b> <?php echo round($this->member->available, 2); ?></b>
                  </div>
               </div>
            </div>
            <div class="col">
               <?php
               if (floatval($this->pub_config['minpay']) > floatval($this->member->available)) {
                  echo '<button style="margin-top:5px" class="btn btn btn-primary btn-sm" disabled>Withdraw</button>';
               } else {
                  echo '<a href="' . base_url('v3/payments') . '" style="margin-top:5px" class="btn btn btn-success btn-sm" disabled>Withdraw</a>';
               }
               ?>

            </div>
         </div>
      </div>
   </div>

   <div class="col-xl-6 col-lg-12 vien">
      <div class=" db_info  p-4 d-flex flex-column card-daily-static">
         <div class="col card-daily-s  flex-shrink-0">
            <p class="card-daily-sname">Daily Statistics</p>
            <p class="card-daily-sdate mb-2"><?php echo date('F d, Y'); ?></p>
         </div>
         <div class="col row align-items-start flex-grow-1 staticdb">

            <div class="col-4 d-flex justify-content-center">
               <svg direction="down" width="15px" height="27px" viewBox="0 0 9 27" version="1.1" xmlns="http://www.w3.org/2000/svg" class="muiten <?php if ($dayli_static->click) echo 'len'; ?>">
                  <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <path direction="down" id="line" d="M5,0 L5,18 L9,18 L4.5,27 L-8.8817842e-16,18 L4,18 L4,0 L5,0 Z" fill-rule="nonzero" class="maumuiten"></path>
                  </g>
               </svg>
               <div>
                  <p class="card-daily-num"><?php if ($dayli_static->click) echo $dayli_static->click;
                                             else echo 0; ?></p>
                  <p class="card-daily-num-type">Clicks</p>
               </div>
            </div>

            <div class="col-4 d-flex justify-content-center">
               <svg direction="down" width="15px" height="27px" viewBox="0 0 9 27" version="1.1" xmlns="http://www.w3.org/2000/svg" class="muiten <?php if ($dayli_static->hosts) echo 'len'; ?>">
                  <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <path direction="down" id="line" d="M5,0 L5,18 L9,18 L4.5,27 L-8.8817842e-16,18 L4,18 L4,0 L5,0 Z" fill-rule="nonzero" class="maumuiten"></path>
                  </g>
               </svg>
               <div>
                  <p class="card-daily-num"><?php if ($dayli_static->hosts) echo $dayli_static->hosts;
                                             else echo 0; ?></p>
                  <p class="card-daily-num-type">Hosts</p>
               </div>
            </div>

            <div class="col-4 d-flex justify-content-center">
               <svg direction="down" width="15px" height="27px" viewBox="0 0 9 27" version="1.1" xmlns="http://www.w3.org/2000/svg" class="muiten <?php if ($dayli_static->lead) echo 'len'; ?>">
                  <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <path direction="down" id="line" d="M5,0 L5,18 L9,18 L4.5,27 L-8.8817842e-16,18 L4,18 L4,0 L5,0 Z" fill-rule="nonzero" class="maumuiten"></path>
                  </g>
               </svg>
               <div>
                  <p class="card-daily-num"><?php if ($dayli_static->lead) echo $dayli_static->lead;
                                             else echo 0; ?></p>
                  <p class="card-daily-num-type">Conversions</p>
               </div>
            </div>


         </div>

      </div>

   </div>

</div>

<div class="card">
   <div class="card-header text-uppercase">
      Statistics for the last 10 days
   </div>
   <div class="card-body">
      <!--chart-->
      <canvas id="myChart" style="height:300px"></canvas>
      <div id="my-legend-con"></div>
      <!--End chart-->

   </div>
</div>

<div class="card mt-3">
   <div class="card-header text-uppercase">
      YOUR OFFERS
   </div>
   <div class="card-body">
      <!-- new offer contents-->
      <div class="card_newoffer">
         <div class="card_newoffer_ct">
            <?php
            if ($newoffer) {
               foreach ($newoffer as $newoffer) {
                  $p = '';
                  $point_geo = unserialize($newoffer->point_geos);
                  if ($point_geo) {
                     $dem = 0;
                     foreach ($point_geo as $key => $value) {
                        if ($value > 0) {
                           $dem++;
                           if ($dem == 1) {
                              $phay = '';
                           } else {
                              $phay = ', ';
                           }
                           $p .= $phay . $key . ': $' . $value;
                        }
                     }
                  }
                  if (!$p) {
                     $p = '$0';
                  }
                  echo '
                  <div class="card_noffer_item">
                     <div class="card_noffer_img">
                        <img src="' . $newoffer->img . '">
                     </div>
                     <div class="card_noffer_title_box">
                        <p class="card_noffer_title">
                           <span class="card_noffer_title_txt">(' . $newoffer->id . ')</span>
                           ' . $newoffer->title . '
                        </p>
                        <p class="card_noffer_points"><span>' . $p . '</span></p>
                     </div>
                     <div class="card_noffer_content_hv card_noffer_contents">
                        <div class="card_noffer_content_wr">
                           <div class="card_noffer_content_slide">                                            
                              <p><strong>Conversion Flow:</strong> <strong> </strong> ' . $newoffer->convert_on . '</p>
                              <p><strong>Allowed Traffic Sources:</strong> ' . $newoffer->traffic_source . '</p>
                              <p><strong>Restricted Traffic Sources:</strong> ' . $newoffer->restriced_traffics . '</p>
                              <p><strong>Description:&nbsp;&nbsp;</strong>' . $newoffer->description . '</p>
                              <p><strong>Browser</strong>: All&nbsp;</p>
                           </div>
                           <div><a class="btn btn-outline-primary btn-sm" href="' . base_url('v3/offer/' . $newoffer->id) . '">Details</a></div>
                        </div>
                     </div>
                  </div>
                  ';
               }
            }
            ?>
         </div>
      </div>
      <!-- new offer contents-->
   </div>
</div>

<div class="card my-3">
   <div class="card-header text-uppercase">
      TOP OFFERS
   </div>
   <div class="card-body">


   </div>
</div>

<!-- biểu đồ-->
<script src="<?php echo base_url(); ?>temp/default/js/chart.js"></script>
<?php
//tạo data cho chart
$lb = $click = $lead = $reve = '';
if ($chart) {
   foreach ($chart as $chart) {
      $lb[] = $chart->dayli;
      $click[] = $chart->click;
      $lead[] = $chart->lead;
      $reve[] = $chart->reve;
   }
   $lb = '\'' . implode("','", $lb) . '\'';
   $click = implode(",", $click);
   $lead = implode(",", $lead);
   $reve = implode(",", $reve);
}



?>
<script>
   var ctx = document.getElementById('myChart');
   var config = {
      type: 'line',
      data: {
         labels: [<?php echo $lb; ?>],
         datasets: [{
               label: ' Conversions',
               data: [<?php echo $lead; ?>],
               backgroundColor: [
                  'rgba(255, 99, 132, 0.2)'
               ],
               borderColor: [
                  'rgba(255, 99, 132, 1)'
               ],
               borderWidth: 1,
               tension: 0.4,
            },
            {
               label: ' Clicks',
               data: [<?php echo $click; ?>],
               backgroundColor: [
                  'rgb(61, 118, 185,0.2)'
               ],
               borderColor: [
                  'rgb(61, 118, 185,1)'
               ],
               borderWidth: 1,
               tension: 0.4,
            },
            {
               label: ' Revenue',
               data: [<?php echo $reve; ?>],
               backgroundColor: [
                  'rgb(191 189 19,0.2)'
               ],
               borderColor: [
                  'rgb(191 189 19),1'
               ],
               borderWidth: 1,
               tension: 0.4,
            }
         ]
      },
      options: {
         maintainAspectRatio: false,
         interaction: {
            intersect: false,
            mode: 'index',
         },
         scales: {
            y: {
               beginAtZero: true
            }
         },
         plugins: {
            legend: {
               position: 'bottom',
               labels: {
                  usePointStyle: true,
                  pointStyle: "line"
               },

            }
         }
      }
   }

   var myChart = new Chart(ctx, config);
</script>