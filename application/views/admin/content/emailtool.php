<?php echo $dt;?>
<form class="row checkemail" role="form" method="post" action="#">

  <div class="col-md-6">
    <div class="form-group">
        <label for="exampleInputEmail1">Subject</label>
        <input type="text" class="form-control" name="sub" value="<?php echo $this->session->userdata('sub');?>" placeholder="Subject">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Message</label>
        <textarea id="soanthao"  class="form-control" rows="10" name="ct"><?php echo $this->session->userdata('ct');?></textarea>
      </div>
      <button type="submit" name="act"  class="btn btn-default" value="send">Send</button>
      <hr/>

      <div class="form-group">
        <label for="exampleInputEmail1">Search Email</label>
        <textarea class="form-control" rows="10" name="search">
          <?php //echo $this->session->userdata('search');
        ?></textarea>
      </div>
      <button type="submit" name="act" class="btn btn-default" value="search">Search Email</button>
  </div>


  <div class="col-md-6 table-responsive">
  <h4>Chose Member</h4>
    <table  class="table table-striped table-bordered table-condensed">
      <tr>
        <th width="20"><input id="checkAll" type="checkbox"></th>
        <th>Email</th>
        <th>Status</th>
      </tr>
      <?php
     if(!empty($us)){
          foreach($us as $us){
            if($us->status==1){
                $staus = "<span class='label label-success hidden-xs'>ativate</span>";
                
            }elseif($us->status==2){
                $staus = "<span class='label label-info hidden-xs'>pause</span>";
            }elseif($us->status==3){
                $staus = "<span class='label label-danger hidden-xs'>banned</span>";
            }else{
                $staus = "<span class='label label-warning  hidden-xs'>pending</span>";
            }

            echo '
            <tr>
              <td><input value="'.$us->id.'" name="uid[]" type="checkbox"></td>
              <td>'.$us->email.'</td>
              <td>'.$staus.'</td>
            </tr>
            ';
          }
        }
        //0->pending 1->ativate 2->pause 3->banned	
      ?>
     
    </table>
     <!-- pagination-->
   <div class="col-md-12 my-2">
      <ul class=" pagination">                       
         <?php echo $this->pagination->create_links();?>     
      </ul>
   </div>
   <!-- end pagination-->

  </div>
</form>

<script>
  $('document').ready(function(){
      $('#checkAll').click(function () {    
        $('.checkemail input:checkbox').prop('checked', this.checked);    
    });
  })

</script>




