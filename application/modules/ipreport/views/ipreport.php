<script src="<?php echo base_url();?>/temp/default/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/temp/default/css/jquery-ui.css"/>
<script>
   $(function() {	   
          $( "#startdate" ).datepicker({dateFormat: "yy-mm-dd"});
   	//$( "#startdate" ).datepicker( "option", "dateFormat","yy-mm-dd");
          $( "#enddate" ).datepicker({dateFormat: "yy-mm-dd"});
         // $( "#enddate" ).datepicker("option", "dateFormat","yy-mm-dd");        
   });
</script>
<style>
   .rp_fitter{width:640px;margin: 10px auto;}
</style>
<div class="row">
<div class="box col-md-12">
   <div data-original-title="" class="box-header">
      <h2><i class="glyphicon glyphicon-signal"></i><span class="break"></span>Report</h2>
      <div class="box-icon">
         <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
         <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
         <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
   </div>
   <div class="box-content">
      <div class="row">
         <style>
            .inputrepr label{width:80px;display:inline-block;font-size:small;color:#151390}
            .inputrepr{margin-right: 50px;}
         </style>
         <div class="col-md-12">
            <form class="" method="post" role="form" action="">
               <br />
               <div class="form-group col-md-6">
                  <label>Start Date</label>
                  <input id="startdate" type="text" class="form-control" name="from" value="<?php if($this->session->userdata('dtfrom')){echo $this->session->userdata('dtfrom');}?>" />
               </div>
               <div class="form-group col-md-6">
                  <label>End Date</label>
                  <input id="enddate" type="text" class="form-control" name="to"  value="<?php if($this->session->userdata('dtto')){echo $this->session->userdata('dtto');}?>" />
               </div>               
               <div class="form-group col-md-6">
                  <input name="pubid" type="text" class="form-control" value="<?php echo $this->session->userdata('dtpubid')?>"  placeholder="Publisher Id"/>
               </div>
               <div class="form-group col-md-6">
                  <input name="oid" type="text" class="form-control" value="<?php echo $this->session->userdata('dtoid')?>"  placeholder="Offer Id"/>
               </div>
               <div class="form-group col-md-12">
                  <label for="ips">Ips</label>
                  <textarea type="text" class="form-control" id="ips" rows="5" name="ips"><?php echo $this->session->userdata('ips')?></textarea>
               </div>
               <div class="form-group col-md-2">
                  <label for="ips">Duplicate IP</label>
                  <input type = "checkbox" value="1" name="dtcheckdup" <?php $this->session->userdata('dtcheckdup')==1?' checked':''?>>
               </div>
               <div class="form-group col-md-2">
                  <label for="ips">Useragent</label>
                  <input type = "checkbox" value="1" name="useragent" <?php $this->session->userdata('dtcheckdup')==1?' checked':''?>>
               </div> 
               <div class="form-group col-md-12">                     
                    <button type="submit" name="submit" value="1" class="btn btn-primary btn-sm ">Submit</button>
                    <button type="submit" name="reset" value="1" class="btn btn-warning btn-sm ">Reset</button>
               </div>
               <hr />
            </form>
         </div>
        
         <div class="col-md-12">
            <!--
               <a class="timkiem btn btn-danger" href="<?php echo base_url().$this->config->item('admin').'/export/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);?>" target="_blank">Export</a>
               -->
         </div>
         <div class="col-md-12 table-wrapper">         
            <table class="table table-bordered table-fixed-header" id="data_table">
               <thead>
                  <tr class="info">
                     <th>#</th>
                     <th style="width:50px">Point</th>
                     <th style="width:50px">Sale Amount</th>
                     <th>SubID</th>
                     <th>S</th>
                     <th>Users</th>
                     <th>OfferId</th>
                     <th>OferName</th>
                     <th>Ip</th>
                     <th>Date</th>
                     <th>Payout</th>
                     <th  style="width:200px">Device</th>
                     <th>UserAgent / Referrer</th>                      
                  </tr>
               </thead>
               <tbody>
                  <?php 
                     if(!empty($dulieu)){
                         $class = ['odd','even'];
                         $currentIP = '';
                         $i = 0;
                         foreach($dulieu as $dulieu){
                             $mid[]=$dulieu->userid;                        
                             if($dulieu->ip != $currentIP){  
                                 $currentIP =  $dulieu->ip;                         
                                 $i++;
                             }
                             $clll = $class[$i%2];
                             
                     ?>    
                  <tr class="<?php echo $clll;?>">
                     <td><?php if($dulieu->flead!=1):?><input type="checkbox" value="1" name="sendLead[]" class="checkboxWide"><?php  endif; ?></td>
                     <td style="width:50px"><?php if ($dulieu->flead!=1): ?><input name="amount2" style="width:50px" type="text" data-trackid="<?php echo $dulieu->id; ?>" value="<?php echo (float)$dulieu->amount2 ?: ''; ?>"><?php endif; ?></td>
                     <td style="width:50px"><?php if ($dulieu->flead != 1): ?><input name="saleAmount" style="width:50px" type="text"><?php endif; ?></td>
                     <td><?php echo $dulieu->id;?></td>
                     <td>
                        S1: <?php echo $dulieu->s1;?><br/>
                        S2: <?php echo $dulieu->s2;?><br/>
                        S3: <?php echo $dulieu->s3;?><br/>
                        S4: <?php echo $dulieu->s4;?>
                     </td>
                     <td><?php echo $dulieu->userid;?></td>
                     <td><?php echo $dulieu->offerid;?></td>
                     <td><?php echo $dulieu->oname;?></td>
                     <td><?php echo $dulieu->ip;?></td>
                     <td><?php echo $dulieu->date;?></td>
                     <td><?php echo $dulieu->amount2;?></td>
                     <td>
                        Language: <?php echo $dulieu->user_language;?><br/>
                        Os_name: <?php echo $dulieu->os_name;?><br/>
                        Browser: <?php echo $dulieu->browser;?><br/>
                        Device_type: <?php echo $dulieu->device_type;?><br/>
                        Device_manuf: <?php echo $dulieu->device_manuf;?><br/>
                     </td>
                     <td>
                        <?php echo $dulieu->useragent;?><br/>
                        <?php echo $dulieu->referrer;?>
                     </td>
                  </tr>
                  <?php    
                     }
                         }
                      
                     ?>
               </tbody>
            </table>
            Total: <?php echo !empty($total) ? round($total, 2) : " "; ?> $
         </div>
         
         <div class="row">
            <!--div class="col-md-12">
               Showing 1 to 10 of 32 entries
               </div--->
            <div class="col-md-6">
               <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                  <select title="<?php echo $this->uri->segment(3);?>" name="filter_cat" size="1" class="form-control input-sm">
                     <option value="0">all</option>
                     <?php 
                        if(!empty($category)){
                            $where = $this->session->userdata('where');
                           
                            foreach($category as $category1){
                                echo '
                                    <option value="'.$category1->id.'"';
                                    if(!empty($where['manager'])){
                                        echo $where['manager']==$category1->id?' selected':'';
                                    }                                                
                                    echo '>'.$category1->title.'</option>
                                ';
                            }
                        }
                        ?>
                  </select>
                  <label></label>                                            
               </div>
            </div>
            <div class="col-md-6">
               <ul class=" pagination">                       
                  <?php echo $this->pagination->create_links();
                     ?>     
               </ul>
            </div>
         </div>
        <?php if($this->session->userdata('aduserid')==1):;?>                
         <div class="fixed-bottom-bar">
            <button type="button" class="btn btn-primary" id="pushconversion" data-loading-text="<i class='spinner-border'></i> Loading...">Push Conversions</button>
            <button type="button" class="btn btn-success scroll-to-top">
                  <i class="glyphicon glyphicon-arrow-up"></i>
            </button>            
         </div>
         <?php endif;?>
      </div>
   </div>
   <!--/span-->
</div>
<!-- phan modal--->
<!-- Large modal -->
<!--end modal--->
<style>
   .odd{
   background:#e7e7e7;
   }
   .checkboxWide{
      width: 20px;
      height: 20px;
   }
   .fixed-bottom-bar {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      text-align: center;
      padding: 10px 0;
      background-color: #f8f8f8;
      border-top: 1px solid #ddd;
      z-index: 1000;
      background-color: #343a40; /* Đổi màu nền ở đây */
   }
   .scroll-to-top {
      position: absolute;
      right: 20px;
      bottom: 10px;
      display: none;
      cursor: pointer;
   }
   .spinner-border {
      width: 1rem;
      height: 1rem;
      border: 0.2em solid currentColor;
      border-right-color: transparent;
      border-radius: 50%;
      display: inline-block;
      animation: spinner-border 0.75s linear infinite;
   }
   @keyframes spinner-border {
      to { transform: rotate(360deg); }
   }
   /*tabl;e scroll*/
   .table-wrapper {
      position: relative;
      max-height: 700px; /* Đặt chiều cao tối đa cho bảng */
      overflow-y: auto;
   }
   .table-fixed-header {
      width: 100%;
      position: relative;
   }
   .table-fixed-header thead {
      position: sticky;
      top: -1px;
      background-color: #f8f9fa; /* Đặt màu nền cho header */
      z-index: 1;
   }
   .table-fixed-header th {
         background-color: #f8f9fa; /* Đổi màu nền của các ô tiêu đề */
      }
</style>
<script>
        $(document).ready(function(){
            //push conversion
            var talbeDt = '#data_table '
            $('#pushconversion').on('click',function(){
                  //hiện loading
                  var $btn = $(this);
                  $btn.data('original-text', $btn.html());
                  $btn.html('<i class="spinner-border"></i> Loading...').prop('disabled', true);                 
      
                
                  var checkbox = $(talbeDt +' input[name="sendLead[]"]:checked')
                  if(checkbox.length>0){
                     sendLead(checkbox)
                     $btn.html($btn.data('original-text')).prop('disabled', false);
                  }else{
                     $btn.html($btn.data('original-text')).prop('disabled', false);
                     alert('Please check checkbox')
                  }
                  
            })
            function sendLead(checkbox){
               var postData = []
               checkbox.each(function(){
                  var tr = $(this).closest('tr')
                  var cInput1 = tr.find('input[name="amount2"]')
                  var trackId = cInput1.data('trackid')
                  var amount2 = cInput1.val()
                  var cInput2 = tr.find('input[name="saleAmount"]')
                  var saleAmount = cInput2.val()
                  postData.push({
                     trackId: trackId,
                     amount2: amount2,
                     saleAmount: saleAmount,
                  })
               })               
               $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('postback/admin_add_lead');?>",
                  data: {data:postData} ,
                  success:function(data,status){
                     location.reload();
                  }                        
               });
              
            }
           
            // Show or hide the scroll-to-top button
            $(window).scroll(function(){
                if ($(this).scrollTop() > 200) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });

            // Scroll to top when the button is clicked
            $('.scroll-to-top').click(function(){
                $('html, body').animate({scrollTop : 0}, 800);
                return false;
            });
        });
    </script>