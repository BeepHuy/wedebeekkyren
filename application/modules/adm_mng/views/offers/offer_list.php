
<?php
$osearch = $this->session->userdata('osearch');//arrray
?>
<div class="row">
    <div class="col-md-12">
     <?php
    $mes = $this->session->userdata('messenger');
    if($mes){        
        $class='alert-success';
        if($mes=='Error!'){$class='alert-warning';}
        echo '<div class="alert '.$class.'" role="alert">'.$mes.'</div>';
        $this->session->unset_userdata('messenger');
    }
    
    
    ?>
 <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Offer Cat</div>
  <div class="panel-body">
   

       <!-- loc offer type-->  
                <form method="post" class="form-inline" action="<?php echo base_url($this->uri->segment(1));?>/offers/search/" >                        
                        <?php                        
                        $wherein = array();
                        if(!empty($osearch['offercat']))$wherein = $osearch['offercat'];                                     
                            $typeo = $this->Admin_model->get_data('offercat');
                            if(!empty($typeo)){
                                
                                foreach ($typeo as $typeo){
                                    
                                    echo '
                                    <div class="form-group col-sm-3">
                                        <label class="checkbox-inline">
                                        <input type="checkbox" id="inlineCheckbox1" name="data[]" value="'.$typeo->id.'" ';
                                        if(in_array($typeo->id,$wherein)){
                                            echo ' checked'; 
                                        }
                                        
                                        echo '>'.$typeo->offercat.'
                                        </label>
                                    </div>
                                    ';
                                   
                                }
                            }        
                        ?>  
                        
                        <div class="form-group col-sm-12" style="margin:5px;">
                        Search 
                            <input name="key" class="form-control input-sm" id="keys" placeholder="ID or Name" value="<?php if(!empty($osearch['key'])){echo $osearch['key'];}?>" />
                            <button id="guioffertype" type="submit" class="btn btn-primary input-sm">Search</button>
                        </div>
                      
                  </form>                
                <!--end loc theo offer type-->
                  </div>
</div>
    </div>
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-gift"></i><span class="break"></span>Offers</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('manager').'/route/offer/add/';?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group form-inline filter">                                                        
                        <select title="<?php echo $this->uri->segment(3);?>" name="show_num" size="1" class="form-control input-sm">
                        <?php 
                            $limit = $this->session->userdata('limit');
                            for($i=1;$i<11;$i++){
                                echo '
                                <option value="'.$i*(10).'"';
                                echo $i*(10)==$limit['0']?' selected="selected"':'';
                                echo 
                                '>'.$i*(10).'</option>
                                ';
                            }
                            ?>
                        </select>
                        <label>records per page</label>                                            
                    </div>
                </div>
                
                    
                
            </div>               
            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Network</th>
                        <th>DisLead</th>
                        <th>Point</th>
                        <th>Cap</th>
                        <th>Click</th>
                        <th>Lead</th>
                        <th>CR</th>
                        <th>EPC</th>
                        <th>Percent</th>
                        <th>Soff</th>
                        <th>Slink</th>
                        <th>ApiOn</th>
                        <th>Home</th>
                        <th>Top</th>
                        <th>New</th>
                        <th style="width:10px;">request</th>                        
                        <th style="width: 50px;">Status</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>    
                    <tr>
                        <td><?php echo $dulieu->id;?></td>
                        <td><?php echo $dulieu->title;?></td>
                        <td><?php echo $dulieu->nettitle;?></td>
                        <td><?php echo $dulieu->dislead;?></td>
                        <td>
                        <?php 
                        //xử lý point
                        $point_geo = unserialize($dulieu->point_geos);
                        if($point_geo){
                            $dem = 0;
                            foreach($point_geo as $key=>$value){
                                
                                if($value>0){
                                    $dem++;
                                    if($dem==1){
                                        $phay = '';
                                    }else{
                                        $phay = ', ';
                                    }
                                    echo $phay. $key.': $'.$value;
                                }
                            }
                        }
                        ?></td>
                        <td><?php echo $dulieu->capped;?></td>
                        <td><?php echo $dulieu->click;?></td>
                        <td><?php echo $dulieu->lead;?></td>
                        <td><?php echo round($dulieu->cr,2);?>%</td>
                        <td>$<?php echo round($dulieu->epc,2);?></td>
                        <td><?php echo $dulieu->percent;?></td>
                        <td>
                            <?php 
                            if($dulieu->smartoff==0){echo '<span data="id='.$dulieu->id.'&field=smartoff&change=OnOff" class="label label-warning ajaxst">Off</span>';}
                            if($dulieu->smartoff==1){echo '<span data="id='.$dulieu->id.'&field=smartoff&change=OnOff" class="label label-success ajaxst">On</span>';}
                                                      
                            ?> 
                        </td>
                        <td>
                            <?php 
                            if($dulieu->smartlink==0){echo '<span data="id='.$dulieu->id.'&field=smartlink&change=OnOff" class="label label-warning ajaxst">Off</span>';}
                            if($dulieu->smartlink==1){echo '<span data="id='.$dulieu->id.'&field=smartlink&change=OnOff" class="label label-success ajaxst">On</span>';}
                                                      
                            ?> 
                        </td>
                        <td>
                            <?php 
                            if($dulieu->apion==0){echo '<span data="id='.$dulieu->id.'&field=apion&change=OnOff" class="label label-warning ajaxst">Off</span>';}
                            if($dulieu->apion==1){echo '<span data="id='.$dulieu->id.'&field=apion&change=OnOff" class="label label-success ajaxst">On</span>';}
                                                      
                            ?> 
                        </td>

                        <td>
                            <?php 
                            if($dulieu->home==0){echo '<span data="id='.$dulieu->id.'&field=home&change=OnOff" class="label label-warning ajaxst">Off</span>';}
                            if($dulieu->home==1){echo '<span data="id='.$dulieu->id.'&field=home&change=OnOff" class="label label-success ajaxst">On</span>';}
                                                      
                            ?> 
                        </td>
                        <td>
                            <?php 
                            if($dulieu->top==0){echo '<span data="id='.$dulieu->id.'&field=top&change=OnOff" class="label label-warning ajaxst">Off</span>';}
                            if($dulieu->top==1){echo '<span data="id='.$dulieu->id.'&field=top&change=OnOff" class="label label-success ajaxst">On</span>';}
                                                      
                            ?> 
                        </td>
                        <td>
                            <?php 
                            if($dulieu->new==0){echo '<span data="id='.$dulieu->id.'&field=new&change=OnOff" class="label label-warning ajaxst">Off</span>';}
                            if($dulieu->new==1){echo '<span data="id='.$dulieu->id.'&field=new&change=OnOff" class="label label-success ajaxst">On</span>';}
                                                      
                            ?> 
                        </td>

                        <td style="text-align:center">
                            <?php 
                            if($dulieu->request==0){echo '<span data="id='.$dulieu->id.'&field=request&change=YesNo" class="label label-warning ajaxst">No</span>';}
                            if($dulieu->request==1){echo '<span data="id='.$dulieu->id.'&field=request&change=YesNo" class="label label-success ajaxst">Yes</span>';}
                                                      
                            ?> 
                        </td>
                            
                        <td>
                            <?php 
                            if($dulieu->show==0){echo '<span data="id='.$dulieu->id.'&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';}
                            if($dulieu->show==1){echo '<span data="id='.$dulieu->id.'&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';}
                                                      
                            ?> 
                        </td>
                        <td class="aaction">
                            <!--view user>>> tạm ẩn. site netbaner có. hiện danh sách affiliate đang làm off này
                            <a  class="btn btn-info btn-xs offermodal" title="<?php echo $dulieu->id;?>">
                            <i class="glyphicon glyphicon-list-alt glyphicon-white"></i>                                            
                            </a>
                           -->
                           
                            <!--edit>>>-->
                            <a href="<?php echo base_url().$this->config->item('manager').'/route/offer/edit/'.$dulieu->id;?>" class="btn btn-info btn-xs"  data-toggle="tooltip" data-placement="top" title="Edit offer">
                            <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>                                            
                            </a>
                            
                            <!--Coppy offer>>>-->
                            <a href="<?php echo base_url().$this->config->item('manager').'/coppy_offer/'.$dulieu->id;?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Coppy offer">
                            <i class="glyphicon glyphicon-retweet glyphicon glyphicon-white"></i> 
                            </a>
                            
                            <!--delete>>>-->
                            <a href="<?php echo base_url().$this->config->item('manager').'/route/offer/delete/'.$dulieu->id;?>" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Delete offer">
                            <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i> 
                            </a>
                            
                        </td>
                    </tr>
                    <?php    }
                        }
                        ?>
                    
                </tbody>
            </table>
            <style>
            .aaction a{margin-bottom:5px}
            </style>
            <script>
            $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
            </script>
            <div class="row">
                <!--div class="col-md-12">
                    Showing 1 to 10 of 32 entries
                </div--->
                
                <div class="col-md-6">
                    <div style="margin:20px 0;float:left" class="form-group form-inline">
                        <select title="<?php echo $this->uri->segment(3);?>" name="filter_cat" size="1" class="form-control input-sm netfilter">
                            <option value="all">all</option>
                            <?php 
                                if(!empty($net)){                                    
                                    if(!empty($osearch['idnet']))$idnet =$osearch['idnet'];
                                    foreach($net as $net){
                                        echo '
                                            <option value="'.$net->id.'"';
                                            if(!empty($idnet)){
                                                echo $idnet==$net->id?' selected':'';
                                            }                                                
                                            echo '>'.$net->title.'</option>
                                        ';
                                    }
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
      $('.netfilter').on('change',function(){
        data = $(this).val();//              
          $.ajax({
            type: "POST",
            url: '<?php echo base_url($this->uri->segment(1).'/'.'offers/search');?>',
            data: {idnet:data,tb:'offer'} ,
            success:success
                    
          });
          return;
      });
    
  })
  function success(){
      location.reload();
  }

</script>