<?php 
if($dk=='taoinvoice'|| $dk=='doitrangthai'){
   echo '<tr>
            <th>Id</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Note</th>
            <th>Date</th>
            <th>Action</th>
</tr>';
   
      if(!empty($dt)){
        foreach($dt as $dt){
            $dis='';
            if($dt->status!='Pending')$dis = 'disabled';
            echo '
            <tr>
            <td>'.$dt->id.'</td>
            <td>'.$dt->amount.' $</td>
            <td>'.$dt->status.'</td>
            <td>'.$dt->note.'</td>
            <td>6'.$dt->date.'</td>
            <td>
            
            <button '.$dis.' type="button" data-id="'.$dt->id.'" data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=Complete" class="btn btn-success btn-xs xuly">Complete</button>
            <button '.$dis.' type="button" data-id="'.$dt->id.'" data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=Reverse" class="btn btn-warning btn-xs xuly">Reverse</button>
           <button data-a="usersid='.$dt->usersid.'&uid='.$dt->id.'&status=delete"  class="btn btn-danger btn-xs del xuly2">
            <i class="glyphicon glyphicon-trash glyphicon-white"></i> 
            </button>
            <i class="loading'.$dt->id.'"></i>
          </tr>
            
            ';
        }
      }
      
      
    
    
}else{
?>
<form id="tao-invoice" method="post"class="form-inline" role="form" style="margin-bottom:10px;">
  <input id="user" type="hidden" name="usersid" id="uid<?php echo $this->uri->segment(4);?>" value="<?php echo $this->uri->segment(4);?>"/>
  
  <div class="form-group">
    <label class="sr-only" for="">$</label>
    <input name="amount" type="text" class="form-control amount" placeholder="amount"/>
  </div>
  <div class="form-group">
    <label class="sr-only" >Note</label>
    <input name="note" type="text" class="form-control note" placeholder="Note..."/>
    
  </div>
 <select class="form-control" name="status">
      <option value="Pending">Pending</option>
      <option value="Reverse">Reverse</option>
   </select>
  <a type="submit" name="dk" value="taoinvoice" class="btn btn-primary tiv">Make New Invoice </a><i class="xoad"></i>
</form>

<script>
  $(document).ready(function(){
      hinh = '<?php echo base_url();?>temp/manager/images/loading.gif';
      diachi= '<?php echo base_url($this->uri->segment(1).'/'.'invoice/'.$this->uri->segment(3));?>';
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
            success:function(data,status){
              $('.okdt').html(data);
            }
                    
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
            success:function(data,status){
              $('.okdt').html(data);
              $('.loading'+id).html('');
            }
                    
          });
      });
      $('.xuly2').click(function(){
          var dt = $(this).attr('data-a')+"&dk=xoa";
        $('.xoad').html('<img src="'+hinh+'"/>');
        $.ajax({
            type: "POST",
            url: diachi,
            data: dt ,
            success:function(data,status){
              $('.okdt').html(data);
              $('.xoad').html('');
            }
                    
          });
      })
      return;
  })

</script>

<table class="table table-striped table-hover table-bordered okdt">
<tr>
            <th>Id</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Note</th>
            <th>Date</th>
            <th>Action</th>
</tr>
      <?php
      if(!empty($dt)){
        foreach($dt as $dt){
            $dis='';
            if($dt->status!='Pending')$dis = 'disabled';
            echo '
            <tr>
            <td>'.$dt->id.'</td>
            <td>'.$dt->amount.' $</td>
            <td>'.$dt->status.'</td>
            <td>'.$dt->note.'</td>
            <td>6'.$dt->date.'</td>
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
          
</table>
<?php }?>