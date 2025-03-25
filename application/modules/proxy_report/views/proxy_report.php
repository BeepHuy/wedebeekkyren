<script src="<?php echo base_url();?>temp/default/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>temp/default/css/jquery-ui.css"/>
<script>
   $(document).ready(function(){      
      $( "#startdate" ).datepicker({dateFormat: "yy-mm-dd"});
     //$( "#startdate" ).datepicker( "option", "dateFormat","yy-mm-dd");
      $( "#enddate" ).datepicker({dateFormat: "yy-mm-dd"});
     // $( "#enddate" ).datepicker("option", "dateFormat","yy-mm-dd");
   
     //check all
     $('#checkAll').click(function () {
          $('.tbdata_check input:checkbox').prop('checked', this.checked);
      });
      $('.action_pay_random input[name="randomPay"]').on('change',function(){
         let randomPay = $(this).val();         
         if(randomPay > 0){
            $('.action_pay_random button').prop('disabled', false);
         }else{
            $('.action_pay_random button').prop('disabled', true);
         }
      })      
      //action click
      // $('.action_pay_random button').click(function(e){     
      //    e.preventDefault();    
      //    let randomPay = $('input[name="randomPay"]').val();
      //    let buttonValu = $(this).val();
      //    let form = $(this).closest('form');
      //    if(randomPay){
      //       if(!confirm('Bạn có chắc chắn thực hiện ' +buttonValu+ ' với random '+randomPay))return false;
      //    }
      //    form.submit();         
      // })
   
   }) 
</script>
<style>
   .rp_fitter{width:640px;margin: 10px auto;}
</style>
<div class="panel panel-success">
   <div class="panel-heading">
      <h3 class="panel-title">Filter</h3>
   </div>
   <div class="panel-body">
      <form class="form_filter" method="post" action="<?php echo base_url('proxy_report/filtdata');?>">
         <div class="row">
            <!-- Start Date -->
            <div class="form-group col-md-6">
               <label>Start Date</label>
               <input id="startdate" type="date" class="form-control" name="from" 
                  value="<?php if($this->session->userdata('from')){echo $this->session->userdata('from');}?>" />
            </div>
            <!-- End Date -->
            <div class="form-group col-md-6">
               <label>End Date</label>
               <input id="enddate" type="date" class="form-control" name="to" 
                  value="<?php if($this->session->userdata('to')){echo $this->session->userdata('to');}?>" />
            </div>
         </div>
         <div class="row">
            <!-- Filter -->
            <div class="form-group col-md-6">
               <label>Filter</label>
               <select class="form-control" name="status">
                  <option value="all">All</option>
                  <option <?php echo $this->session->userdata('status')==1?'selected':''?> value="1">Pending</option>
                  <option <?php echo $this->session->userdata('status')==3?'selected':''?> value="3">Pay</option>
                  <option <?php echo $this->session->userdata('status')==2?'selected':''?> value="2">Declined</option>
               </select>
            </div>
            <!-- Networks -->
            <div class="form-group col-md-6">
               <label>Networks</label>
               <select class="form-control" name="network">
                  <option value="all">All</option>
                  <?php if(!empty($networks)): ?>
                  <?php foreach($networks as $network): ?>
                  <option value="<?php echo $network->id; ?>" 
                     <?php echo $this->session->userdata('network')==$network->id ? 'selected' : ''; ?>>
                     <?php echo $network->title; ?>
                  </option>
                  <?php endforeach; ?>
                  <?php endif; ?>
               </select>
            </div>
         </div>
         <div class="row">
            <!-- UserId -->
            <div class="form-group col-md-3">
               <input name="userid" type="text" class="form-control" value="<?php echo $this->session->userdata('userid'); ?>" placeholder="UserId" />
            </div>
            <!-- OfferId -->
            <div class="form-group col-md-3">
               <input name="offerid" type="text" class="form-control" 
                  value="<?php echo $this->session->userdata('offerid'); ?>" placeholder="OfferId" />
            </div>
            <div class="form-group col-md-6">
               <input name="amount2" type="text" class="form-control" 
                  value="<?php echo $this->session->userdata('amount2'); ?>" placeholder="Payout >" />
            </div>
         </div>
         <div class="row">
            <!-- SubId -->
            <div class="form-group col-md-6">
               <label for="subid">SubId</label>
               <textarea class="form-control" id="subid" rows="3" name="searchSubid"><?php echo $this->session->userdata('searchSubid'); ?></textarea>
            </div>
            <!-- SubId2 -->
            <div class="form-group col-md-6">
               <label for="subid2">SubId2</label>
               <textarea class="form-control" id="subid2" rows="3" name="searchSubid2"><?php echo $this->session->userdata('searchSubid2'); ?></textarea>
            </div>
         </div>
         <div class="row">
            <!-- Check duplicate Ip -->
            <div class="form-group col-md-6">
               <label>Check Duplicate IP</label>
               <span class="box_switch <?php echo !empty($dupips) && $dupips == 1 ? '' : 'off'; ?>">
               <a href="#">Switch Off</a>
               <input id="off_on" type="hidden" name="dupips" 
                  value="<?php echo !empty($dupips) ? $dupips : 0; ?>" />
               </span>
            </div>
         </div>
         <?php if($this->session->userdata('admin')){?>
         <hr>
         <div class="row action_pay_random">            
            <div class="form-group col-md-3">
               <input name="randomPay" type="text" class="form-control" value="" placeholder="Random Pay">
            </div>
            <div class="col-md-12">
               <button name="actionPay" value="approved" class="btn btn-success btn-sm ">Pending</button>
               <button name="actionPay" value="pay" class="btn btn-info btn-sm "> Pay </button>
               <button name="actionPay" value="declined" class="btn btn-danger btn-sm ">Declined</button>
            </div>
         </div>
         <?php }?>
         <hr/>
         <div class="row">
            <!-- Buttons -->
            <div class="form-group col-md-12 text-center">
               <button type="submit" name="submit" value="1" class="btn btn-primary btn-sm">Submit</button>
               <button type="submit" name="reset" value="1" class="btn btn-warning btn-sm">Reset</button>
               <button type="submit" name="export" value="1" class="btn btn-info btn-sm">Export Excel</button>
            </div>
         </div>   
      </form>
   </div>
</div>
<div class="row">
<div class="box col-md-12">
   <div data-original-title="" class="box-header">
      <h2><i class="glyphicon glyphicon-signal"></i><span class="break"></span>Proxy Report</h2>
      <div class="box-icon">
         <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
         <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
         <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
   </div>
   <div class="box-content">
      <div class="row">
         <style>
            .inputrepr label{width:90px;display:inline-block;font-size:small;color:#151390}
            .inputrepr{margin-right: 40px;}
         </style>
         <div class="col-md-12">
            <!--
               <a class="timkiem btn btn-danger" href="<?php echo base_url().$this->config->item('admin').'/export/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);?>" target="_blank">Export</a>
               -->
         </div>
         <div class="col-md-12">
            <script>
               $(document).ready(function(){
                  var checkDupIp = $('input[name="dupips"]').val()
                  if(checkDupIp==1){
                     
                  }
                   $('.stat').val(<?php echo $this->session->userdata('status') ?>);
               
               })
               
            </script>
            <form class="form_lead" method="post" action="<?php echo base_url('proxy_report/rvdata');?>">
               <?php
                  $tb= $this->session->userdata('updatedone');
                      if($tb){
                          echo $tb;
                          $this->session->unset_userdata('updatedone');
                      }
                  ?>
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th><input id="checkAll" type="checkbox"/></th>
                        <th>SubID</th>
                        <th>SubID2</th>
                        <th>Users</th>
                        <th>OfferId</th>
                        <th>OferName</th>
                        <th>Ip</th>
                        <th>Date</th>
                        <th>Payout</th>
                        <th>Sale Amount</th>
                        <th>proxy</th>
                        <th>Status</th>
                        <th>Device</th>
                        <th>Referrer</th>
                        <!--th>Fraud_score</th-->
                     </tr>
                  </thead>
                  <tbody class="tbdata_check">
                     <style>
                        .danger{
                        background-color:#dc3545!important
                        }
                        .warning{
                        background-color:#ffc107!important
                        }
                     </style>
                     <?php
                        if(!empty($dulieu)){
                            //lấy pubname
                           $currentIp =0;
                           $currentClass= '';
                           foreach($dulieu as $dulieu){
                                $clll = '';
                                if($dulieu->fraud_score>=50 && $dulieu->fraud_score<=80){
                                    $clll = 'warning';
                                }
                                if($dulieu->proxy || $dulieu->fraud_score>80){
                                    $clll = 'danger';
                                }
                               if($dulieu->status==1){
                                    $stu =  '<span class="label label-success">Pending</span>';
                               }elseif($dulieu->status==2){
                                    $stu = '<span class="label label-danger">Declined</span>';
                               }elseif($dulieu->status==3){
                                    $stu = '<span class="label label-info">Pay</span>';
                               }else{
                                    $stu = '<span class="label label-info">N/A</span>';
                               }
                              
                               if($currentIp!=$dulieu->ip){
                                 $currentIp =$dulieu->ip;
                                 if($currentClass=='info')$currentClass='';
                                 else $currentClass='info';
                               }
                        
                               echo ' <tr class="'.$clll.' '.$currentClass.' cc'.$dulieu->id.'">';
                               echo '    <td><input type="checkbox" value="'.$dulieu->id.'" name="uid[]" /></td>';
                               echo '    <td>'.$dulieu->id.'</td>';
                               echo '    <td>'.$dulieu->s2.'</td>';
                               echo '    <td>'.$dulieu->userid.'</td>';
                               echo '    <td>'.$dulieu->offerid.'</td>';
                               echo '    <td>'.$dulieu->oname.'</td>';
                               echo '    <td>
                               <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/'.strtolower($dulieu->countries).'.svg" style="display: inline-block; width: 1em; height: 1em; vertical-align: middle;">
                               '.
                               
                               $dulieu->ip.
                               '</td>';
                               echo '    <td>'.$dulieu->date.'</td>';
                               echo '    <td>'.$dulieu->amount2.'</td>';
                               echo '    <td>' . $dulieu->saleAmount . '</td>';
                               if($dulieu->proxy)echo '<td>True</td>';else echo '<td>False</td>';
                               echo '    <td>'.$stu.'</td>';
                               echo '    <td>'.
                                       " 
                                       Language:  {$dulieu->user_language}<br/>
                                       Os_name:  {$dulieu->os_name}<br/>
                                       Browser:  {$dulieu->browser}<br/>
                                       Device_type:  {$dulieu->device_type}<br/>
                                       Device_manuf:  {$dulieu->device_manuf}<br/>
                                       "                               
                                 .'</td>';  
                               echo '    <td>'.$dulieu->referrer.'</td>';                             
                               echo '</tr>';
                           }
                        }
                        ?>
                  </tbody>
               </table>
               <?php
                  if($this->session->userdata('admin')==1){
                      echo '                     
                      <div class="col-md-5 1pull-right action_clk">
                          <button name="action" value="approved" class="btn btn-success btn-sm ">Pending</button>
                          <button name="action" value="pay" class="btn btn-info btn-sm "> Pay </button>
                          <button name="action" value="declined" class="btn btn-danger btn-sm ">Declined</button>
                      </div>
                  
                      ';
                  }
                  
                  ?>
         </div>
         </form>
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
      </div>
   </div>
   <!--/span-->
</div>
</div>
<!-- phan modal--->
<!-- Large modal -->
<!--end modal--->