<!--link href="<?php echo base_url('temp/default/fselect');?>/fSelect.css" rel="stylesheet">
<script src="<?php echo base_url('temp/default/fselect');?>/fSelect.js"></script-->
<style>
   .catscroll{
   height:200px;
   overflow:scroll;
   padding:15px;
   border:1px solid #ddd;   
   }
   .catscroll p{margin:1px;float:left}
   .pppp p{width:49%}
   .geocontent p{margin-right:30px}
   .point_ct{
      display:inline-block;
      width:80px;
   }
   .title_keycode{
      width:25px;
      display:inline-block;
   }
</style>
<?php
$moc =array();
   
   $country = $this->Admin_model->get_data('country',array('show'=>1));
   $type = $this->Admin_model->get_data('offertype',array('show'=>1));
   $offercat = $this->Admin_model->get_data('offercat',array('show'=>1));
   $device = $this->Admin_model->get_data('device',array('show'=>1));
   $paymterm = $this->Admin_model->get_data('paymterm',array('show'=>1));
     //xu ly chia offer cat
     if(!empty($dulieu)){$moc=explode('o',$dulieu->offercat);}
     if(!empty($offercat)){
        $cat = '';
        foreach ($offercat as $offercat){
            
            $cat.=offercatdt($offercat,'offercat[]',$moc); 
        }
     }
     function offercatdt($offercat,$name='',$moc=''){
        //noi dung hien thie
            
            $dt = '
            <p><input type="checkbox" size="40" value="'.$offercat->id.'" name="'.$name.'" ';
            if(!empty($moc)){
                if(in_array($offercat->id,$moc)){
                     $dt.= ' checked'; 
                 }
            }
            
            $dt.= '
            />
            '.$offercat->offercat.'</p>
            ';
            //end noi dung hien thi
            return $dt;
     }
   
   
   ?>
<div class="row">
   <div class="box col-md-12">
      <div class="box-header">
         <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Smart Offers</h2>
         <div class="box-icon">
            <a class="btn-add" href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/list/';?>"><i class="glyphicon glyphicon-list-alt"></i></a>
            <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
            <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
            <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
         </div>
      </div>
      <div class="box-content">
         <!--- noi dung--->
         <form style="color: cecece;" method="POST" action="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>">
            <?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>
            <input class="hide" value="2" name="smtype"/>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group alert alert-info">
                     <label>Title</label>
                     <input type="title" class="form-control" id="title" name="title" value="<?php if($dulieu){echo $dulieu->title;} ?>" placeholder="Title"/>
                  </div>
                  <div class="form-group row">
                   
                    
                     <div class="col-md-2">
                        <label>Offer type</label>                    
                        <select name="type" class="form-control">
                           <option value="0">None</option>
                           <?php if($type){
                              foreach ($type as $type){
                                  echo '<option value="'.$type->id.'"';
                                  if(!empty($dulieu)){
                                      echo $dulieu->type==$type->id?' selected':'';
                                  }
                                  echo '>';
                                  echo $type->type;
                                  echo '</option>';
                              }                                        
                              }?>
                        </select>
                     </div>
                     <div class="col-md-2">
                        <label>Payment Term</label>                    
                        <select name="paymterm" class="form-control">
                           <option value="0">None</option>
                           <?php if($paymterm){
                              foreach ($paymterm as $paymterm){
                                  echo '<option value="'.$paymterm->id.'"';
                                  if(!empty($dulieu)){
                                      echo $dulieu->paymterm==$paymterm->id?' selected':'';
                                  }
                                  echo '>';
                                  echo $paymterm->payment_term;
                                  echo '</option>';
                              }                                        
                              }?>
                        </select>
                     </div>
                     <div class="col-md-2">
                        <label>Device</label>
                        <select name="device" class="form-control">
                           <option value="0">ALL</option>
                           <?php if($device){
                              foreach ($device as $device){
                                    echo '<option value="'.$device->id.'"';
                                    if(!empty($dulieu)){
                                       echo $dulieu->device==$device->id?' selected':'';
                                    }
                                    echo '>';
                                    echo $device->device;
                                    echo '</option>';
                              }                                        
                              }?>
                        </select>
                     </div>
                     <!--div class="col-md-2">
                        <label>Credit</label>    
                        <div class="input-group"> 
                           <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>               
                           <input type="text" class="form-control" id="point" name="point" value="<?php if($dulieu){echo $dulieu->point;} ?>" placeholder="Point"/>
                           <span class="input-group-addon" id="pointrate">$</span></span>
                        </div>
                     </div-->
                     
                     <!--div class="col-md-2">
                           <label>Dis lead/100</label>
                           <div class="input-group"> 
                              <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span> 
                              <input type="text" class="form-control" id="url" name="dislead" value="<?php if(!empty($dulieu->dislead)){echo $dulieu->dislead;}else echo 0;?>" placeholder="S? l�?ng lead ch?n /100 lead"/>
                           </div>
                        </div-->
                        
                        <div class="col-md-2">
                           <label>CR</label>
                           <div class="input-group"> 
                              <span class="input-group-addon"><span class="glyphicon glyphicon-leaf"></span></span> 
                              <input type="text" class="form-control" id="url" name="cr" value="<?php if(!empty($dulieu->cr)){echo $dulieu->cr;}else echo 0;?>" placeholder="CR"/>
                           </div>
                     </div>
                     <div class="col-md-2">
                           <label>EPC</label>
                           <div class="input-group"> 
                              <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span> 
                              <input type="text" class="form-control" id="url" name="epc" value="<?php if(!empty($dulieu->epc)){echo $dulieu->epc;}else echo 0;?>" placeholder="EPC"/>
                           </div>
                     </div>
                     <div class="col-md-1">
                           <label>Request</label>                    
                           <span class="box_switch<?php if($dulieu){echo $dulieu->request==1? '':' off';}else{ echo ' off';} ?>">
                           <a href="">switch off</a>
                           <input id="off_on" type='hidden' name="request" value="<?php if(!empty($dulieu->request)){echo $dulieu->request;}else{echo 0;}?>"/>
                           </span>
                        </div>   
                        <div class="col-md-1">
                           <label>Show / Hide</label>                    
                           <span class="box_switch<?php if($dulieu){echo $dulieu->show==1? '':' off';}else{ echo ' off';} ?>">
                           <a href="">switch off</a>
                           <input id="off_on" type='hidden' name="show" value="<?php if(!empty($dulieu->show)){echo $dulieu->show;}else{echo 0;}?>"/>
                           </span> 
                        </div>

                  </div>

                  <div class="form-group  has-success">
                     <label>Offer ID</label>
                     <div class="input-group "> 
                        <span class="input-group-addon"><span class="glyphicon glyphicon-tasks success"></span></span> 
                        <input type="text" class="form-control" id="preview" name="idoffers" value="<?php if($dulieu){echo $dulieu->idoffers;} ?>" placeholder="id1,id2,id3...."/>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label>Preview offer</label>
                     <div class="input-group"> 
                        <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span> 
                        <input type="text" class="form-control" id="preview" name="preview" value="<?php if($dulieu){echo $dulieu->preview;} ?>" placeholder="Preview URL"/>
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Landing Page</label>
                     <div class="input-group"> 
                        <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span> 
                        <input type="text" class="form-control" id="landingpage" name="landingpage" value="<?php if($dulieu){echo $dulieu->landingpage;} ?>" placeholder="Landing Page"/>
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Image</label>
                     <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-camera"></span></span>
                        <input type="text" name="img" value="<?php if($dulieu){echo $dulieu->img;}?>" placeholder="Logo" id="xFilePath" class="form-control"/>
                        <span class="input-group-btn">
                        <button onclick="BrowseServer();" type="button" class="btn btn-default">upload</button>
                        </span>                                                    
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">                        
                        <!--div class="col-md-2">
                           <label>Capped</label>
                           <div class="input-group"> 
                              <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span> 
                              <input type="text" class="form-control" id="url" name="capped" value="<?php if(!empty($dulieu->capped)){echo $dulieu->capped;}else echo 0;?>" placeholder="Limit lead"/>
                           </div>
                        </div-->
                        <!--div class="col-md-2">
                           <div class="form-group">
                              <label>Order</label>
                              <div class="input-group"> 
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-alphabet"></span></span> 
                                 <input type="text" class="form-control" id="order" name="order" value="<?php if($dulieu){echo $dulieu->order;} ?>" placeholder="Order"/>
                              </div>
                           </div>
                        </div-->
                        <!--div class="col-md-2">
                           <label>Request</label>                    
                           <span class="box_switch<?php if($dulieu){echo $dulieu->show==1? '':' off';} ?>">
                           <a href="">switch off</a>
                           <input id="off_on" type='hidden' name="request" value="1"/>
                           </span>
                        </div-->
                       
                     </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                         <div class="form-group alert alert-info">
                             <label>Description</label>                  
                             <textarea name="description" class="form-control" rows="3"><?php if($dulieu){echo $dulieu->description;} ?></textarea>
                          </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group alert alert-info">
                             <label>Conversion Flow</label>                  
                             <textarea name="convert_on" class="form-control" rows="3"><?php if($dulieu){echo $dulieu->convert_on;} ?></textarea>
                          </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group alert alert-success">
                             <label>Allowed Traffic Sources</label>                  
                             <textarea name="traffic_source" class="form-control" rows="3"><?php if($dulieu){echo $dulieu->traffic_source;} ?></textarea>
                          </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group alert alert-success">
                             <label>Restricted Traffic Sources</label>                  
                             <textarea name="restriced_traffics" class="form-control" rows="3"><?php if($dulieu){echo $dulieu->restriced_traffics;} ?></textarea>
                          </div>
                    </div>
                  </div>  
                  
                  <div class="row">
                     <div class="col-md-6">
                        <div class="panel panel-default">
                           <div class="panel-body">
                              <label>country</label> 
                              <input type="text" class="form-control input-sm" id="sgeo"  placeholder="Search GEOS">
                              <!-- chon ca list country-->
                              <div class="catscroll geocontent d-flex"> 
                               
                                 <?php
                                    $mangnsx=$pointgeo = array();
                                       if(!empty($dulieu)) $pointgeo = unserialize($dulieu->point_geos);
                                       if(!empty($dulieu)) $percent_geos = unserialize($dulieu->percent_geos);
                                       if(!empty($dulieu)){$mangnsx=explode('o',$dulieu->country);}
                                       if(!empty($pointgeo['all'])){
                                          $pp = $pointgeo['all'];
                                         }else{
                                          $pp ='';
                                         }
                                       echo '<p><input type="checkbox" value="all" name="country[]" ';
                                          if(in_array('all',$mangnsx)){
                                             echo ' checked'; 
                                          }
                                       echo ' />
                                       <span class="title_keycode"> All</span>
                                       <input name="point_geos[all]" type="text" class="form-control input-sm amount point_ct"
                                       value="'.$pp.'"
                                       placeholder="Payout" />';  
                                       if(!empty($percent_geos['all'])){
                                          $pp = $percent_geos['all'];
                                         }else{
                                          $pp ='';
                                         }                                 
                                       echo
                                       '<input name="percent_geos[all]" type="text" class="form-control input-sm amount point_ct"
                                       value="'.$pp.'"
                                       placeholder="%" />
                                       </p>
                                       ';
                                       //xử lý point geo
                                       

                                       if(!empty($country)){
                                           foreach ($country as $country){
                                               echo '
                                               <p><input type="checkbox" value="'.$country->id.'" name="country[]" ';
                                               if(!empty($mangnsx)){
                                                   if(in_array($country->id,$mangnsx)){
                                                        echo ' checked'; 
                                                    }
                                               }
                                               if(!empty($pointgeo[$country->keycode])){
                                                $pp = $pointgeo[$country->keycode];
                                               }else{
                                                $pp ='';
                                               }
                                               echo '
                                               />
                                               <span class="title_keycode">'.$country->keycode.'</span>
                                               <input name="point_geos['.$country->keycode.']" type="text" class="form-control input-sm amount point_ct"
                                               value ="'.$pp.'"
                                               placeholder="Payout"/>';

                                               if(!empty($percent_geos[$country->keycode])){
                                                $pp = $percent_geos[$country->keycode];
                                               }else{
                                                $pp ='';
                                               }

                                               echo
                                               '<input name="percent_geos['.$country->keycode.']" type="text" class="form-control input-sm amount point_ct"
                                               value ="'.$pp.'"
                                               placeholder="%"/>
                                               </p>
                                               ';
                                           }
                                       }
                                    ?>
                              </div>
                              <!-- end chon ca list country-->
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="panel panel-default">
                           <div class="panel-body">
                              <label>offercattegory</label> 
                              <input type="text" class="form-control input-sm"  placeholder="">
                              <div class="catscroll pppp"> 
                                 <?php
                                    if(!empty($cat)){echo $cat;}                                 
                                    ?>
                              </div>
                           </div>
                        </div>
                     </div>
                 
                     
                     
                  </div>
                  <div class="alert alert-success posbacklink" role="alert"></div>
                  <button type="submit" class="btn btn-default">Submit</button>
               </div>
            </div>
         </form>
         <!--noi dung --->
      </div>
   </div>
   <!--/span-->
</div>
<script>
   $(document).ready(function(){
      // timf kiem geos
      $("#sgeo").on("keyup", function() {
         var value = $(this).val().toLowerCase();
         $(".geocontent p").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
         });
      });
  //end tim kiem geo
       //---ham offer
       var id = $('.net_change').val();
       getlinkpb(id);
       $('.net_change').change(function(){
           id = $(this).val();
           getlinkpb(id);
       }); 
      
   })
   
   /**ham offer gom get point rate va get link postback*/
   
   function getlinkpb(id=0){
       /*
       var diachi = adminurl+'ajax/get_net/'+id;
       $.ajax({
               type:"POST",
               url:diachi,
               data:{data:id},
               success:function(data, status){
                   $(".posbacklink").html(data);
               },
               error:err        
           }); 
           */   
   }
   ///en offer
   
</script>