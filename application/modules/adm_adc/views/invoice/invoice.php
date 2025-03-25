<script src="<?php echo base_url();?>/temp/default/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/temp/default/css/jquery-ui.css"/>
<script>
	$(function() {	   
        $( "#month-year" ).datepicker({
            dateFormat: "yy-mm",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,           
            onClose: function(dateText, inst) { 
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            },
            beforeShow : function(input, inst) {
                var datestr;
                if ((datestr = $(this).val()).length > 0) {
                    year = datestr.substring(datestr.length-4, datestr.length);
                    month = jQuery.inArray(datestr.substring(0, datestr.length-5), $(this).datepicker('option', 'monthNamesShort'));
                    $(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            }
        });
		//$( "#startdate" ).datepicker( "option", "dateFormat","yy-mm-dd");
         
	});
	</script>

<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Invoice</h2>
            <div class="box-icon">
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <!--div class="col-md-3">
                    <div class="form-group form-inline filter">                                                        
                        <select title="<?php echo $this->uri->segment(3);?>" name="show_num" size="1" class="form-control input-sm">
                       
                        </select>
                        <label>records per page</label>                                            
                    </div>
                </div-->
        
               <div class="col-md-9">
                   <form class="" role="form"  method="POST" action="<?php echo base_url($this->uri->segment(1).'/invoice/search');?>">
                   <div class="form-group form-inline">    
                        <label class="checkbox-inline">
                        <input type="checkbox" name="Pending" value="1"  <?php if(!empty($dtsearch['Pending'])) echo ' checked ';?>> Pending
                        </label>
                        <label class="checkbox-inline">
                        <input type="checkbox" name="Complete" value="1"  <?php if(!empty($dtsearch['Complete'])) echo ' checked ';?>> Complete
                        </label>
                        <label class="checkbox-inline">
                        <input type="checkbox" name="Reverse" value="1" <?php if(!empty($dtsearch['Reverse'])) echo ' checked ';?>> Reverse
                        </label>
                        <input name="date" class="form-control input-sm" id="month-year" placeholder="Month-Year" value="<?php if(!empty($dtsearch['date'])) echo $dtsearch['date'];?>" />
                        
                        <select class="form-control input-sm" name="managerid">
                            <option value="0">All Manager</option>
                            <?php
                            $manager = $this->Home_model->get_data('manager');
                            $mid =$select= 0;
                            if(!empty($dtsearch['managerid'])){
                                $mid =$dtsearch['managerid'];
                            }
                            foreach($manager as $manager){
                                if($mid==$manager->id) $select= ' selected';else  $select='';
                                echo '<option '.$select.' value="'.$manager->id.'">'.$manager->name.'</option>';
                            }
                            ?>
                            <option value="Reverse">Reverse</option>
                        </select>

                        <input name="keycode" class="form-control input-sm" id="keys" placeholder="User's ID" <?php if($this->session->userdata('likedsearch')){echo 'value="'.$this->session->userdata('likedsearch').'"';}?> />
                        <button name="search" value="1"  class="btn btn-success btn-sm">Search</button>
                        <button name="reset" value="1" class="btn btn-warning btn-sm">Reset</button>
                    </div>
                  </form>
                </div>                                 
                
            </div>
                            <hr/>
             <!------------- form creat invoice--------------->
            <form id="tao-invoice" method="post"class="form-inline" role="form" style="margin-bottom:10px;">
                <div class="form-group">
                    <label class="sr-only" for="">User's Id</label>
                    <input name="usersid" type="text" class="form-control input-sm amount" placeholder="User's Id"/>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="">$</label>
                    <input name="amount" type="text" class="form-control input-sm amount" placeholder="amount"/>
                </div>
                <div class="form-group">
                    <label class="sr-only" >Note</label>
                    <input name="note" type="text" class="form-control input-sm note" placeholder="Note..."/>
                    
                </div>
                <select class="form-control input-sm" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Reverse">Reverse</option>
                </select>
                <a type="submit" name="dk" value="taoinvoice" class="btn btn-primary btn-sm tiv">Make New Invoice </a><i class="xoad"></i>
            </form>
            <hr/>
            <!-------------END form creat invoice--------------->
            <?php 
            echo $this->session->userdata('thongbao');
            $this->session->unset_userdata('thongbao');
            
            ?>  
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th>Id</th>
                    <th>User's Id</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Note</th>
                    <th>Status</th>                    
                    <th>Date</th>
                    <th width="200px">Action</th>                  
                        
                    </tr>
                </thead>
                <tbody>
                <?php 
                $tpending = $tapproved = $reverse = 0;
                if(!empty($dulieu)){                            
                            
                           foreach($dulieu as $dt){
                            $dis=$status=$note='';
                            if($dt->status!='Pending'){$dis = 'disabled';}//chỉ trang thái pending là được enable button chuyển trạng thái
                            
                            if($dt->status=='Pending'){$status= '<span class="label label-warning">Pending</span>';$tpending +=$dt->amount;}
                            if($dt->status=='Complete'){$status= '<span class="label label-success">Approved</span>';$tapproved +=$dt->amount;}                    
                            if($dt->status=='Reverse'){$status= '<span class="label label-danger">Reverse</span>';$reverse +=$dt->amount;} 
                            if($dt->method=='Bank Wire'){
                                $ar = unserialize($dt->note);
                                $note.= "<b>Name on Account".': </b>'.$ar['wire_name_on_card'].'<br/>';
                                $note.= "<b>Address on Account".': </b>'.$ar['wire_address'].'<br/>';
                                $note.= "<b>City on Account".': </b>'.$ar['wire_city'].'<br/>';
                                $note.= "<b>State on Account".': </b>'.$ar['wire_state'].'<br/>';
                                $note.= "<b>Zip on Account".': </b>'.$ar['wire_zip'].'<br/>';
                                $note.= "<b>Bank Name".': </b>'.$ar['wire_bankname'].'<br/>';
                                $note.= "<b>Bank Address".': </b>'.$ar['wire_bankaddress'].'<br/>';
                                $note.= "<b>Bank Country".': </b>'.$ar['wire_country'].'<br/>';
                                $note.= "<b>Account Number".': </b>'.$ar['wire_accountnum'].'<br/>';
                                $note.= "<b>Swiftcode".': </b>'.$ar['wire_purpose'].'<br/>';
                               
                                
                            }else{
                                $note =$dt->note;
                            }

                            echo '
                            <tr>
                            <td>'.$dt->id.'</td>
                            <td>'.$dt->usersid.'</td>
                            <td>'.$dt->amount.' $</td>
                            <td>'.$dt->method.'</td>
                            <td>'.$note.'</td>
                            <td>'.$status.'</td>                            
                            <td>'.$dt->date.'</td>
                            <td>
                            
                            <button '.$dis.' type="button" data-id="'.$dt->id.'" data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=Complete" class="btn btn-success btn-xs xuly">Complete</button>
                            <button '.$dis.' type="button" data-id="'.$dt->id.'"  data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=Reverse" class="btn btn-warning btn-xs xuly">Reverse</button>
                            <button data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=delete"  class="btn btn-danger btn-xs del xuly2">
                            <i class="glyphicon glyphicon-trash glyphicon-white"></i> 
                            </button>
                            <i class="loading'.$dt->id.'"></i>
                            
                            </td>
                            
                            
                          </tr>
                            
                            ';
                        }                       
                    }
                ?>
                    
                </tbody>
            </table>
            <?php
                echo "
                <table class='table table-bordered'>
                <tr>
                    <td><strong>Total</strong></td>
                    <td>
                        Complete                            
                        <span class='label label-success'> $tapproved $</span>
                    </td>
                    <td>
                        Pending                            
                        <span class='label label-warning'> $tpending $</span>
                    </td>
                    <td>
                        Reverse                            
                        <span class='label label-danger'> $reverse $</span>
                    </td>
                    
                </tr>
                </table>
                ";

            ?>
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
                                    echo $fc;
                                }
                                ?>
                        </select>
                        <label></label>                                            
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class=" pagination">                       
                        <?php echo $this->pagination->create_links();?>     
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div>
<script>
  $(document).ready(function(){
      hinh = '<?php echo base_url();?>temp/admin/images/loading.gif';
      diachi= '<?php echo base_url($this->uri->segment(1).'/'.'invoice/invoiPost');?>';
      data = $( "#tao-invoice" );//
      $('.tiv').click(function(){
          //$('#tao-invoice').submit();        
        data['amount'] = $('.amount').val();
        data['note'] = $('.note').val();
        data= data.serialize()+"&dk=taoinvoice";       
          $.ajax({
            type: "POST",
            url: diachi,
            data: data ,
            success:success
          });
          return;
      });
      $('.xuly').click(function(){
          
          var dt = $(this).attr('data-a')+"&dk=doitrangthai";
          id = $(this).attr('data-id'); 
          $('.loading'+id).html('<img src="'+hinh+'"/>');
        $.ajax({
            type: "POST",
            url: diachi,
            data: dt ,
            success:success
                    
          });
      });
      $('.xuly2').click(function(){
          var dt = $(this).attr('data-a')+"&dk=xoa";
        $('.xoad').html('<img src="'+hinh+'"/>');
        $.ajax({
            type: "POST",
            url: diachi,
            data: dt ,
            success:success
                    
          });
      })
      return;
  })
  function success(){
      location.reload();
  }

</script>