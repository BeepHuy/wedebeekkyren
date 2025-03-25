
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

                <?php $where=$this->session->userdata('dtsearch');?>
                <div class="col-md-9">
                   <form class="" role="form"  method="POST" action="<?php echo base_url($this->uri->segment(1).'/invoice/search');?>">
                   <div class="form-group form-inline">    
                        <label class="checkbox-inline">
                        <input type="checkbox" name="Pending" value="1"  <?php if(!empty($where['Pending'])) echo ' checked ';?>> Pending
                        </label>
                        <label class="checkbox-inline">
                        <input type="checkbox" name="Complete" value="1"  <?php if(!empty($where['Complete'])) echo ' checked ';?>> Complete
                        </label>
                        <label class="checkbox-inline">
                        <input type="checkbox" name="Reverse" value="1" <?php if(!empty($where['Reverse'])) echo ' checked ';?>> Reverse
                        </label>
                        <input name="keycode" class="form-control input-sm" id="keys" placeholder="User's ID" <?php if($this->session->userdata('likedsearch')){echo 'value="'.$this->session->userdata('likedsearch').'"';}?> />
                        <button class="btn btn-default btn-sm">Search</button>
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
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Note</th>
                    <th>Status</th>                    
                    <th>Date</th>
                    <th width="200px">Action</th>                  
                        
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                           foreach($dulieu as $dt){
                            $dis=$status='';
                            if($dt->status!='Pending'){$dis = 'disabled';}//chỉ trang thái pending là được enable button chuyển trạng thái
                            
                            if($dt->status=='Pending'){$status= '<span class="label label-warning">Pending</span>';}
                            if($dt->status=='Complete'){$status= '<span class="label label-success">Approved</span>';}                    
                            if($dt->status=='Reverse'){$status= '<span class="label label-danger">Reverse</span>';} 


                            echo '
                            <tr>
                            <td>'.$dt->id.'</td>
                            <td>'.$dt->usersid.'</td>
                            <td>'.$dt->email.'</td>
                            <td>'.$dt->amount.' $</td>
                            <td>'.$dt->note.'</td>
                            <td>'.$status.'</td>                            
                            <td>6'.$dt->date.'</td>
                            <td>
                            
                            <button '.$dis.' type="button" data-id="'.$dt->id.'" data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=Complete" class="btn btn-success btn-xs xuly">Complete</button>
                            <button '.$dis.' type="button" data-id="'.$dt->id.'"  data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=Reverse" class="btn btn-warning btn-xs xuly">Reverse</button>
                            !--button data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=delete"  class="btn btn-danger btn-xs del xuly2">
                            <i class="glyphicon glyphicon-trash glyphicon-white"></i> 
                            </button-->
                            <i class="loading'.$dt->id.'"></i>
                            
                            </td>
                            
                            
                          </tr>
                            
                            ';
                        }
                    }
                ?>
                    
                </tbody>
            </table>
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
      hinh = '<?php echo base_url();?>temp/manager/images/loading.gif';
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