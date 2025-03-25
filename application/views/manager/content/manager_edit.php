<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-inbox"></i><span class="break"></span>Sub Manager</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('manager').'/route/'.$this->uri->segment(3).'/list/';?>"><i class="glyphicon glyphicon-list-alt"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
        <!--- noi dung--->
        <form class="form-horizontal" method="POST" action="<?php echo base_url().$this->config->item('manager').'/route/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>">
      
         <?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="name" value="<?php if($dulieu){echo $dulieu->name;} ?>" placeholder="Name"/>
            </div>
          </div> 
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="username" value="<?php if($dulieu){echo $dulieu->username;} ?>" placeholder="Username"/>
            </div>
          </div>          
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="subid" name="email" value="<?php if($dulieu){echo $dulieu->email;} ?>" placeholder="Email"/>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="phone" name="phone" value="<?php if($dulieu){echo $dulieu->phone;} ?>" placeholder="Phone"/>
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-sm-2 control-label">AIM</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="aim" name="aim" value="<?php if($dulieu){echo $dulieu->aim;} ?>" placeholder="AIM"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Skype</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="skype" name="skype" value="<?php if($dulieu){echo $dulieu->skype;} ?>" placeholder="Skype"/>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password"/>
            </div>
          </div>
          
          <div class="form-group">   
          <label class="col-sm-2 control-label">Images</label>       
                <div class="col-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-camera"></span></span>
                      <input type="text" class="form-control" id="xFilePath" placeholder="Logo" value="<?php if($dulieu){echo $dulieu->images;} ?>" name="images"/>
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="BrowseServer();">upload</button>
                      </span>                                                    
                    </div>
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
