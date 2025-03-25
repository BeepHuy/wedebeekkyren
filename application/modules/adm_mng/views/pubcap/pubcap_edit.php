<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Disoffer</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('manager').'/'.$this->uri->segment(2).'/pubcapList/';?>"><i class="glyphicon glyphicon-list-alt"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
        <!--- noi dung--->
        <form class="form-horizontal" method="POST" action="<?php echo base_url().$this->config->item('manager').'/'.$this->uri->segment(2).'/store';?>">
      
         <?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">OfferId</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="offerid" value="<?php if($dulieu){echo $dulieu->offerid;} ?>" <?php echo $dulieu?'readonly':'';?> placeholder="OfferId"/>
            </div>
          </div>          
          
          <div class="form-group">
            <label class="col-sm-2 control-label">UsersID</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="usersid" name="usersid" value="<?php if($dulieu){echo $dulieu->usersid;} ?>" <?php echo $dulieu?'readonly':'';?> placeholder="UsersID"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Sub2</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="sub2" name="sub2" value="<?php if($dulieu){echo $dulieu->sub2;}else echo 0;?>" placeholder="sub2"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Cap</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="capped" name="capped" value="<?php if($dulieu){echo $dulieu->capped;} ?>" placeholder="Cap"/>
            </div>
          </div>
          
       
     
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </div>
        </form>
        
           
      
      <!--noi dung --->
        </div>
    </div>
    <!--/span-->
</div>
