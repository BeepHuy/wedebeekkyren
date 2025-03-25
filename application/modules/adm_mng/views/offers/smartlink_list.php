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
   </div>
   <div class="box col-md-12">
      <div class="box-header">
         <h2><i class="glyphicon glyphicon-gift"></i><span class="break"></span>Smart Links</h2>
         <div class="box-icon">
            <a class="btn-add" href="<?php echo base_url().$this->config->item('manager').'/route/'.$this->uri->segment(3).'/add/';?>"><i class="glyphicon glyphicon-plus"></i></a>
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
                  <th>Category</th>
                  <th>Geo</th>
                  <th>Type</th>
                  <th>OfferID</th>
                  <th>EPC</th>
                  <th>CR</th>
                  <th style="width: 50px;">Request</th>
                  <th style="width: 50px;">Status</th>
                  <th style="width: 100px;">Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php if(!empty($dulieu)){
                  $mcat =$mgeo= array();
                  $cat = $this->Home_model->get_data('offercat');   
                  if($cat){
                      foreach($cat as $cat){
                          $mcat[$cat->id]= $cat->offercat;
                      }
                  } 
                  $geo = $this->Home_model->get_data('country');   
                  if($geo){
                      foreach($geo as $geo){
                          $mgeo[$geo->id]= $geo->country;
                      }
                  }                          
                  foreach($dulieu as $dulieu){
                      
                  ?>    
               <tr>
                  <td><?php echo $dulieu->id;?></td>
                  <td><?php echo $dulieu->title;?></td>
                  <td><?php 
                     $mIdCat=explode('o',substr($dulieu->offercat,1,-1));
                     if($mIdCat){
                         $t=0;
                         foreach($mIdCat as $mIdCat){
                             $t++;
                             if($t==1){
                                 echo  $mcat[$mIdCat];
                             }else{
                                 echo  ', '.$mcat[$mIdCat];
                             }
                             
                         }
                     }
                     ?></td>
                  <td><?php 
                     $mgeo['all'] = "All";
                     $mIdCat=explode('o',substr($dulieu->country,1,-1));
                     if($mIdCat){
                         $t=0;
                         foreach($mIdCat as $mIdCat){
                             $t++;
                             if($t==1){
                                 echo  $mgeo[$mIdCat];
                             }else{
                                 echo  ', '.$mgeo[$mIdCat];
                             }
                             
                         }
                     }
                     ?></td>
                     <td>
                     <?php
                      if($dulieu->type==2){
                         echo 'Redirect';
                      }else{
                        echo 'Custom';
                      }
                      ?>

                     </td>
                     <td>
                      <?php
                      echo $dulieu->idoffers;
                      ?>

                     </td>
                     <td>$<?php echo round($dulieu->epc,2);?></td>
                     <td><?php echo $dulieu->percent;?>%</td>
                     <td>

                     <?php 
                        if($dulieu->request==0){echo '<span data="id='.$dulieu->id.'&field=request&change=OnOff" class="label label-warning ajaxst">Off</span>';}
                        if($dulieu->request==1){echo '<span data="id='.$dulieu->id.'&field=request&change=OnOff" class="label label-success ajaxst">On</span>';}
                                                  
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
                     <a href="<?php echo base_url().$this->config->item('manager').'/route/'.$this->uri->segment(3).'/edit/'.$dulieu->id;?>" class="btn btn-info btn-xs"  data-toggle="tooltip" data-placement="top" title="Edit offer">
                     <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>                                            
                     </a>
                     <!--delete>>>-->
                     <a href="<?php echo base_url().$this->config->item('manager').'/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id;?>" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Delete offer">
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
               <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                  <select title="<?php echo $this->uri->segment(3);?>" name="filter_cat" size="1" class="form-control input-sm">
                     <option value="0">all</option>
                     <?php 
                        if(!empty($category)){
                            $where = $this->session->userdata('where');
                           
                            foreach($category as $category1){
                                echo '
                                    <option value="'.$category1->id.'"';
                                    if(!empty($where['manager'])){
                                        echo $where['manager']==$category1->id?' selected':'';
                                    }                                                
                                    echo '>'.$category1->title.'</option>
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