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
                        if($dulieu->request==0){echo '<span data="id='.$dulieu->id.'&field=request&change=OnOff" class="label label-warning st">Off</span>';}
                        if($dulieu->request==1){echo '<span data="id='.$dulieu->id.'&field=request&change=OnOff" class="label label-success st">On</span>';}
                                                  
                        ?> 
                  </td>
                  <td>

                     <?php 
                        if($dulieu->show==0){echo '<span data="id='.$dulieu->id.'&field=show&change=ShowHide" class="label label-warning st">Hide</span>';}
                        if($dulieu->show==1){echo '<span data="id='.$dulieu->id.'&field=show&change=ShowHide" class="label label-success st">Show</span>';}
                                                  
                        ?> 
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