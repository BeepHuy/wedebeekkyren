<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Add Users <?php if($thongbao){echo ' <span style="color:red;font-weight:bold"> '.$thongbao.'</span>';} ?></h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('manager').'/route/users/list/';?>"><i class="glyphicon glyphicon-list-alt"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
        <!--- noi dung--->
        <form class="form-horizontal" method="POST" action="<?php echo base_url().$this->config->item('manager').'/addusers/';?>">     
            
        <div class="form-group">
            <label class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="firstname" value="" placeholder="First Name"/>
            </div>
          </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="lastname" value="" placeholder="LastName"/>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="email" value="" placeholder="Email"/>
            </div>
          </div>          
          
          <div class="form-group">
            <label class="col-sm-2 control-label">PassWord</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="keycode" name="password" value="" placeholder="PassWord"/>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Balance $</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="keycode" name="balance" value="" placeholder="$"/>
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
