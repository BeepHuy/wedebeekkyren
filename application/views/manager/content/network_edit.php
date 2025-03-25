 <?php
 if($dulieu){
    $idnet=$dulieu->idpb;
    @$pb_value_array= unserialize($dulieu->pb_value);
 };
 ?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-inbox"></i><span class="break"></span>Network</h2>
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
              <input type="text" class="form-control" id="title" name="title" value="<?php if($dulieu){echo $dulieu->title;} ?>" placeholder="Name"/>
            </div>
          </div>          
          
          <div class="form-group">
          <label class="col-sm-2 control-label">Tracking Follow </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="subid" name="subid" value="<?php if($dulieu){echo $dulieu->subid;} ?>" placeholder="Affsub"/>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Order</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="order" name="order" value="<?php if($dulieu){echo $dulieu->order;} ?>" placeholder="Order"/>
            </div>
          </div>
          
         
          
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <span class="box_switch<?php if($dulieu){echo $dulieu->show==1? '':' off';} ?>">
                                    <a href="">switch off</a>
                                    <input id="off_on" type='hidden' name="show" value="1"/>
                                </span> 
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Postback</label>
            <div class="col-sm-10">
            <div class="well well-lg pbcolleft">
               <div class="row"> 
                          
               <span class="col-sm-2">Pass:</span>
                 <span class="col-sm-10" style=" margin-bottom: 7px;">
                   <input style="border-radius:4px; border: 1px solid #ccc;" title="#pass" value="<?php if ($dulieu) {
                                                                                                    echo $dulieu->pb_pass;
                                                                                                  } ?>" type="text" name="pb_pass" />
                 </span>
                 <span class="col-sm-2">Click ID:</span>
                 <span class="col-sm-10" style=" margin-bottom: 7px;">
                   <input style="border-radius:4px; border: 1px solid #ccc;" title="#0" value="<?php if ($dulieu) {
                                                                                                  echo $pb_value_array[0];
                                                                                                } ?>" class="sp50" type="text" name="pb_value[0]" />
                        <span class="right">=</span>                        
                   <input style="border-radius:4px; border: 1px solid #ccc;" title="#1" value="<?php if ($dulieu) {
                                                                                                  echo $pb_value_array[1];
                                                                                                } ?>" class="sp50" type="text" name="pb_value[1]" />
                   
                   </span>
                   
                    <span class="col-sm-2">Credit:</span>   
                    <span class="col-sm-10" style=" margin-bottom: 7px;">
                   <input style="border-radius:4px; border: 1px solid #ccc;" title="#2" value="<?php if ($dulieu) {
                                                                                                  echo $pb_value_array[2];
                                                                                                } ?>" class="sp50" type="text" name="pb_value[2]" />
                        <span class="right">=</span>
                   <input style="border-radius:4px; border: 1px solid #ccc;" title="#3" value="<?php if ($dulieu) {
                                                                                                  echo $pb_value_array[3];
                                                                                                } ?>" class="sp50" type="text" name="pb_value[3]" />
                     </span>
                    
                    <span class="col-sm-2">Offer:  </span>  
                 <span class="col-sm-10" style=" margin-bottom: 7px;">
                   <input style="border-radius:4px; border: 1px solid #ccc;" title="#4" value="<?php if ($dulieu) {
                                                                                                  echo $pb_value_array[4];
                                                                                                } ?>" class="sp50" type="text" name="pb_value[4]" />
                        <span class="right">=</span>
                   <input style="border-radius:4px; border: 1px solid #ccc;" title="#5" value="<?php if ($dulieu) {
                                                                                                  echo $pb_value_array[5];
                                                                                                } ?>" class="sp50" type="text" name="pb_value[5]" />
                 </span>
                 <span class="col-sm-2">Sale Amount: </span>
                        
                 <span class="col-sm-10" style="margin-bottom: 7px;">
                    <input style="border-radius:4px; border: 1px solid #ccc;" title="#6" 
                          value="<?php echo (isset($dulieu) && $dulieu && isset($pb_value_array[6])) ? $pb_value_array[6] : ''; ?>" 
                          class="sp50" type="text" name="pb_value[6]" />
                    <span class="right">=</span>
                    <input style="border-radius:4px; border: 1px solid #ccc;" title="#7" 
                          value="<?php echo (isset($dulieu) && $dulieu && isset($pb_value_array[7])) ? $pb_value_array[7] : ''; ?>" 
                          class="sp50" type="text" name="pb_value[7]" />
                </span>
                    
                   </div>    
            
             </div>
             <div class="well well-lg pbcolright">
             
                 <input value="<?php echo $idnet;?>" class="span300" type="hidden" name="idpb" />                                   
                <div class="link_pb hide">
                    <span><?php echo base_url().'postback/<div class="type_net"></div>/'.$idnet;?>/</span>
                    <span id="pass"></span>
                    <span id="0"></span>
                    <span id="1"></span>
                    <span id="2"></span>
                    <span id="3"></span>
                    <span id="4"></span>
                    <span id="5"></span>      
                    <span id="6"></span>
                    <span id="7"></span>                          
                </div>
                <div id="linkpb" style="color: blue;"></div>
                <input value="<?php if($dulieu){echo $dulieu->linkadd;} ?>" id="linkadd" type="hidden" name="linkadd" />
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
