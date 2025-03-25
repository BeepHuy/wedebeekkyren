  <style>
.catscroll{
    height:200px;
    overflow:scroll;
    padding:15px;
    border:1px solid #ddd;
}
.catscroll p{margin:1px;}
</style>
 <?php
 if($dulieu){
    $idnet=$dulieu->idnet;    
 }else $idnet=0;
 $country = $this->Home_model->get_data('country',array('show'=>1));
 $net = $this->Home_model->get_data('network',array('show'=>1));
 $type = $this->Home_model->get_data('offertype',array('show'=>1));
 $offercat = $this->Home_model->get_data('offercat',array('show'=>1));
 $device = $this->Home_model->get_data('device',array('show'=>1));
 
 //xu ly chia offer cat
if(!empty($dulieu)){$moc=explode('o',$dulieu->offercat);}
if(!empty($dulieu)){$mconverton=explode('o',$dulieu->converton);}
if(!empty($dulieu)){$mtraffictype=explode('o',$dulieu->traffictype);}
if(!empty($offercat)){
    $cat =$converton = $traffictype= '';
    foreach ($offercat as $offercat){
        if($offercat->cat==1){
            @$cat.=offercatdt($offercat,'offercat[]',$moc);
        }
        if($offercat->converton==1){
            @$converton.=offercatdt($offercat,'converton[]',$mconverton);
        }
        if($offercat->traffictype==1){
            @$traffictype.=offercatdt($offercat,'traffictype[]',$mtraffictype);
        }        
        
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
 <div class="container">
<div class="row">
    <div class="box col-md-12">
     
        <div class="box-content">
        <!--- noi dung--->
        <form style="color: cecece;" method="POST" action="<?php echo base_url().'api/apieach';?>">
      
         <?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>
          <div class="row">
              <div class="col-md-12">   
                       
                <input type="hidden" name="url" value="<?php echo $url;?>" />
                
                <div class="form-group row">                
                
                    <div class="col-md-4">
                        <label>Network</label>                    
                        <select name="idnet" class="form-control net_change">                            
                            <?php if($net){
                                foreach ($net as $net){
                                    echo '<option value="'.$net->id.'"';
                                    if(!empty($dulieu)){
                                        echo $dulieu->idnet==$net->id?' selected':'';
                                    }
                                    echo '>';
                                    echo $net->title;
                                    echo '</option>';
                                }                                        
                            }?>
                        </select> 
                    </div>
                    
                    <div class="col-md-4">
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
                
                    <div class="col-md-4">
                    <label>% Credit</label>    
                    <div class="input-group"> 
                        <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>               
                        <input type="text" class="form-control" id="point" name="percent" placeholder="Point"/>
                        <span class="input-group-addon" id="pointrate">%</span></span>
                        
                    </div>
                    </div>
             
                    
                </div>  
                
               
             
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Request</label>                    
                            <span class="box_switch<?php if($dulieu){echo $dulieu->show==1? '':' off';} ?>">
                                <a href="">switch off</a>
                              <input id="off_on" type='hidden' name="request" value="1"/>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <label>Show / Hide</label>                    
                            <span class="box_switch<?php if($dulieu){echo $dulieu->show==1? '':' off';} ?>">
                                <a href="">switch off</a>
                              <input id="off_on" type='hidden' name="show" value="1"/>
                            </span> 
                        </div>
                        
                        <div class="col-md-3">
                            <label>Device</label>
                            <div class="input-group"> 
                                <select name="device" class="form-control">
                                    <option value="ALL">ALL</option>
                                    
                                    <?php if($device){
                                foreach ($device as $device){
                                    echo '<option value="'.$device->device.'"';
                                    if(!empty($dulieu)){
                                        echo $dulieu->device==$device->device?' selected':'';
                                    }
                                    echo '>';
                                    echo $device->device;
                                    echo '</option>';
                                }                                        
                            }?>
                           
                                </select>                        
                            </div>
                        </div>
                        
                        
                        <div class="col-md-3">
                            <label>Incent / Non</label>
                            <div class="input-group"> 
                                <select name="incent" class="form-control">
                                    <option value="1">Incent</option>
                                    <option value="0" <?php if($dulieu){echo $dulieu->incent==0?' selected':'';} ?>>Non-Incent</option>
                                </select>                        
                            </div>
                        </div>
                    </div>
                </div>
               
           
                <div class="row">
                    
                    <div class="col-md-4">
                    <div class="panel panel-default">
  <div class="panel-body">
                    <label>offercattegory</label> 
                        <div class="catscroll"> 
                                <?php
                                 if(!empty($cat)){echo $cat;}                                 
                                ?>
                                    
                        </div>
                    </div></div>
                    </div>
                    <div class="col-md-4">
                    <div class="panel panel-default">
  <div class="panel-body">
                    <label>Convert On</label>
                        <div class="catscroll"> 
                                <?php
                                 if(!empty($converton)){echo $converton;}                                 
                                ?>
                                    
                        </div>
                    </div></div>
                    </div>
                    <div class="col-md-4">
                    <div class="panel panel-default">
  <div class="panel-body">
                    <label>Traffic Type</label>
                        <div class="catscroll"> 
                                <?php
                                 if(!empty($traffictype)){echo $traffictype;}                                 
                                ?>
                                    
                        </div>
                    
                    </div>
                </div></div>
                </div>
                    
                <div class="alert alert-success posbacklink" role="alert">
                List offer
                </div>
                <div class="table-responsive" style="width: 100%">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Country</th>
                        <th>Payout</th>
                        <th>Platform</th>
                        <th>#</th>
                    </tr>
                  
                    <?php
                    if(!empty($offer)){
                        foreach($offer as $offer){
                          
                            echo '<tr>';
                            echo '    <td>'.$offer->offer_id.'</td>';
                            echo '    <td><div class="name">'.$offer->offer_name.'</div></td>';
                            echo '    <td>'.$offer->pricing_type.'</td>';
                            
                            echo '    <td>';
                            if(!empty($offer->country)){
                                if($offer->country=='All'){
                                    echo 'All';
                                }else{
                                    foreach($offer->country as $country){
                                        echo $country->country .'('.$country->code. ')<br/>';
                                    }
                                }
                                
                            }                            
                           
                            echo '</td>';
                            
                            echo '    <td>'.$offer->offer_payout.'</td>';
                            echo '    <td>';
                            
                            if(!empty($offer->platform)){
                                if($offer->platform=='All'){
                                    echo 'All';
                                }else{
                                    foreach($offer->platform as $platform){
                                        echo $platform->platform .'('.$platform->system. ') '.$platform->min_version.'<br/>';
                                    }
                                }
                                
                            } 
                            echo '</td>';
                            echo '    <td><input type="checkbox" name="offerrid[]" value="'.$offer->offer_id.'"> </td>';
                            echo '</tr>';
                            
                        }
                    }
                    
                    ?>
                
                </table>
                </div>
                
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
          
          
          </div>
        
        </form>
        
           
      
      <!--noi dung --->
        </div>
    </div>
    <!--/span-->
</div>
</div>
<style>
.name{
    width: 250px;
}
</style>
