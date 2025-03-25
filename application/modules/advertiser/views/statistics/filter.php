<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="<?php echo base_url();?>/temp/default/css/statistics.css" rel="stylesheet">
<div class="card mt-5">
   <div class="card-body" >
      <!--chart-->
      <span class="card-offers-stitle"><?php echo ucfirst($this->uri->segment(3)) ?></span>
      <form id="form_loc">
         <div class="card-offers-sboxs mb-3">
            <input name="sdate" id="date_range" type="text"z placeholder="Search" class="card-offers-sinput">            
         </div>
         <div class="row">
            <div class="row">
               <div class="col-lg-2 col-sm-6 pe-1 mb-2 tttesst">
                  <select name="sOffer" data-placeholder="Offers" class="chosen-select filteroff d-none" multiple tabindex="4">
                  <?php
                     $arrOffer = $this->session->userdata('sOffer');                    
                     if($soffer){
                        foreach($soffer as $soffer){
                           
                           if(!empty($arrOffer) && in_array($soffer->offerid,$arrOffer)){
                              $sl = 'selected';
                           }else{
                              $sl = '';
                           }                           
                           echo '<option value="'.$soffer->offerid.'" '.$sl.'>'.$soffer->oname.'</option>';
                        }
                     }
                     ?>
                  </select>
               </div>
               <div class="col-lg-2 col-sm-6 pe-1 mb-2 tttesst">
                  <select name="sOs" data-placeholder="OS" class="chosen-select filteroff d-none" multiple tabindex="4">
                  <?php
                     $arrOs = $this->session->userdata('sOs');                    
                     if($os_name){
                        foreach($os_name as $os_name){
                           
                           if(!empty($arrOs) && in_array($os_name->os_name,$arrOs)){
                              $sl = 'selected';
                           }else{
                              $sl = '';
                           }                           
                           echo '<option value="'.$os_name->os_name.'" '.$sl.'>'.$os_name->os_name.'</option>';
                        }
                     }
                     ?>
                  </select>
               </div>
               <div class="col-lg-2 col-sm-6 pe-1 mb-2 tttesst">
                  <select name="dv" data-placeholder="Devices" class="chosen-select filteroff d-none" multiple tabindex="4">
                  </select>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-2 col-sm-6  pe-1 mb-2">
                  <select name="sCountry" data-placeholder="Countries..." class="chosen-select2 filteroff d-none" multiple tabindex="4">
                  <?php
                     $arrCountry = $this->session->userdata('sCountry');                    
                     if($country){
                        foreach($country as $country){
                           
                           if(!empty($arrCountry) && in_array($country->keycode,$arrCountry)){
                              $sl = 'selected';
                           }else{
                              $sl = '';
                           }                           
                           echo '<option value="'.$country->keycode.'" '.$sl.'>'.$country->country.'</option>';
                        }
                     }
                     ?>
                  </select>
               </div>
               <div class="col-lg-2 col-sm-6  pe-1 mb-2">
                  <select name="Smartlinks" data-placeholder="Smartlinks" class="chosen-select4 d-none" multiple tabindex="4">
                     <option value="1">Direct Traffic</option>
                     <option value="2">All Smartlinks</option>
                  </select>
               </div>
            </div>
         </div>
      </form>
      <link rel="stylesheet" href="<?php echo base_url();?>/temp/default/css/select2.css" />
      <script src="<?php echo base_url();?>/temp/default/js/multiple/select2.min.js"></script>  
      <script>                      
         $(document).ready(function(){
           //date ranger picker 
            $('#date_range').daterangepicker({
               "maxSpan": {
                  "year":2
               },
               minYear: 2020,
               maxYear: <?php echo date("Y"); ?>,
               ranges: {
                  'Today': [moment(), moment()],
                  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month': [moment().startOf('month'), moment().endOf('month')],
                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
               },
               "locale": {
                  "format": "YYYY/MM/DD",
                  "separator": " - "       
               },
               autoUpdateInput:true,
               "alwaysShowCalendars": true,
               "startDate": "<?php echo $this->session->userdata('from');?>",
               "endDate": "<?php echo $this->session->userdata('to');?>"
            }, 
            function(start, end, label) {
               //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
               let data = start.format('YYYY-MM-DD')+'#'+end.format('YYYY-MM-DD'); 
               var name = 'date';
               ajaxFilterO(data,name);               
            });
                        
            //tắt menu orderby
            $('body').click(function(){
               $('#menu_sapxep').removeClass('show');
               
            })
         
            $('.chosen-select').select2({
               theme: "classic",
               width:'100%'
            });
            $('.chosen-select2').select2({
               theme: "classic",
               width:'100%'
            });
            $('.chosen-select4').select2({theme: "classic", width:'100%'});
         
            //lựa chọn country hoặc category
            $('.filteroff').change(function(){
               var data= $(this).val();
               var name = $(this).attr('name');
               ajaxFilterO(data,name);
            });
         
            $('body').on('click', '.icon_plus_click', function (){
                  var date = $(this).attr('id');
                  $('.sub_dayli_'+date).toggleClass( "hide_content" );
                  //kieemr tra dang toggle class an hay hien
                  var act = $('.sub_dayli_'+date).hasClass("hide_content");
                  if(act){   //aanr                   
                     $(this).children(".icon_congtru").html('<line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>');
                     
                  }else{//show
                     $(this).children(".icon_congtru").html('<line x1="5" y1="12" x2="19" y2="12"></line>');
                  }                  
            });
            ///click mở rộng dữ liệu chi tiết
            $('body').on('click','.icon_plus',function(){
               //ajxx ấy subdata dayli_subdata  after               
               var date = $(this).attr('id');
               var ajurl = "<?php echo base_url('/v2/statistics/ajax_sub_dayli');?>";
               //var loading = '<div class="d-flex justify-content-center mt-2"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div></div>';
              // $('#list_offers').html(loading);     
              $(this).children(".icon_congtru").html('<line x1="5" y1="12" x2="19" y2="12"></line>');          
               $.ajax({
                  type:"POST",
                  url:ajurl,
                  data:{date:date},
                  success:function(data){
                     $('#data-'+date).after(data);                     
                  }
                        
               }); 
               $(this).addClass('icon_plus_click');
               $(this).removeClass('icon_plus');
            });
            
           
            
         
         })
         
         function ajaxFilterO(data,name){
               
               var ajurl = "<?php echo base_url('/v2/statistics/ajax_static_dayli');?>";
               var loading = '<div class="d-flex justify-content-center mt-2"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div></div>';
               $('#list_offers').html(loading);
               //load ajax sau khi load xong thì f5
               $.ajax({
                  type:"POST",
                  url:ajurl,
                  data:{gt:data,name:name},
                  success:function(){location.reload();}
                        
               }); 
               //$('#form_loc').submit();
         }
         
      </script>
      <style>
         .hide_content{display:none}
         .icon_plus_click{
         display:block;width:18px;height:18px;
         }
      </style>
      <!--- ------>
      <div class="border-top mt-3 pt-3 d-flex align-items-center justify-content-between">
         <div class="d-flex flex-column">
            <span class="card-offers-sresult">Result</span>
            <span><?php if(!empty($this->total_rows))echo $this->total_rows;else echo 0;?>&nbsp;Field</span>
         </div>
         <div style="position:relative" class="menu_sort">
            <button type="button" class="btn btn-secondary  btn-sm">Clear</button>
            <button type="button" class="btn btn-primary btn-sm">Refresh</button>
         </div>
      </div>
      <!--End chart-->
   </div>
</div>