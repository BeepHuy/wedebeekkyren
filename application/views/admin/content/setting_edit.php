<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-inbox"></i><span class="break"></span>HomePage</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/list/';?>"><i class="glyphicon glyphicon-list-alt"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
        <!--- noi dung--->
        <form class="form-horizontal" method="POST" action="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>">
        
         <?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>     
          <div class="form-group">
            <label class="col-sm-2 control-label">Content 1</label>
            <div class="col-sm-10">
                <textarea id="soanthao1" name="content01"><?php if($dulieu){echo $dulieu->content01;}?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Content 2</label>
            <div class="col-sm-10">
                <textarea id="soanthao2" name="content02"><?php if($dulieu){echo $dulieu->content02;}?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Content 3</label>
            <div class="col-sm-10">
                <textarea id="soanthao3" name="content03"><?php if($dulieu){echo $dulieu->content03;}?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Content 4</label>
            <div class="col-sm-10">
                <textarea id="soanthao4" name="content04"><?php if($dulieu){echo $dulieu->content04;}?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Content 5</label>
            <div class="col-sm-10">
                <textarea id="soanthao5" name="content05"><?php if($dulieu){echo $dulieu->content05;}?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Content 6</label>
            <div class="col-sm-10">
                <textarea id="soanthao6" name="content06"><?php if($dulieu){echo $dulieu->content06;}?></textarea>
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
