<div class="row">
    <div class="box col-md-12">
        <div data-original-title="" class="box-header">
            <h2><i class="glyphicon glyphicon-user"></i><span class="break"></span>Members</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('admin').'/addusers/';?>"><i class="glyphicon glyphicon-plus"></i></a>
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
                <?php $where=$this->session->userdata('where');?>
                <div class="col-md-9">
                   <form class="form-inline" role="form" id="sdt">
                   <label class="checkbox-inline">
                    <input type="checkbox" name="balance" value="1"  <?php if(!empty($where['balance >'])) echo ' checked ';?>> Balance
                    </label>
                    <label class="checkbox-inline">
                    <input type="checkbox" name="pending" value="1"  <?php if(!empty($where['pending >'])) echo ' checked ';?>> Pending
                    </label>
                    <label class="checkbox-inline">
                    <input type="checkbox" name="curent" value="1" <?php if(!empty($where['curent >'])) echo ' checked ';?>> Current
                    </label>
                     <input name="keycode" class="form-control" id="keys" placeholder="ID or Email" <?php if($this->session->userdata('like')){echo 'value="'.$this->session->userdata('like').'"';}?> />
                    <a class="timkiem btn btn-default">Search</a>
                  </form>
                </div>  
                <div class="col-md-2 showstatus" style="color: #5cb85c;">
                
                </div>
                
               
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>Id</th>
                        <th>Email address</th>
                        <th>Website</th>
                        <th>IP</th>
                        <th>Skype</th>
                        <th>Date</th>
                        <th>Manager</th>
                        <th>Balance</th> 
                        <th>Pending</th> 
                        <th>Current</th>                           
                         
                        <th style="width: 97px;">Offer Categories</th>
                        <th style="width: 97px;">Verification state</th>
                        <th style="width: 105px;">Status</th>                        
                        <th style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>    
                    <tr>
                        <td><?php echo $dulieu->id;?></td>
                        <td><?php echo $dulieu->email;?></td>
                        <td style="width: 250px; min-width: 250px; max-width: 250px; word-wrap: break-word; ">
                            <?php 
                            $info = unserialize($dulieu->mailling);
                            echo empty($info['website'])?'':$info['website'];
                            ?>
                        </td>
                        <td style="height: 40px; line-height: 40px;">
                                    <div style="display: flex; align-items: center;">
                                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icons/6.11.0/flags/4x3/<?php echo empty($dulieu->ip_location) ? '' : strtolower($dulieu->ip_location); ?>.svg"
                                            style="width: 1em; height: 1em; margin-right: 5px;">
                                        <span><?php echo empty($dulieu->ip) ? '' : $dulieu->ip; ?></span>
                                    </div>
                                </td>
                        <td><?php echo empty($info['im_service'])?'':$info['im_service'];?></td>
                        <td><?php echo date('d-m-Y',strtotime($dulieu->created));?></td>                       
                        
                         <td class="manager">                                
                                 <select id="<?php echo $dulieu->id;?>" class="manager">
                                 <option value="0">None</option>
                                    <?php foreach($category as $manager){
                                        echo '
                                            <option value="'.$manager->id.'" '; 
                                             echo $manager->id==$dulieu->manager?' selected ':'';
                                        echo ' >'.$manager->title.'</option>
                                        ';
                                    }?>
                                
                                 </select>
                        </td>
                        <td>$
                            <span class="s-<?php echo $dulieu->id;?>">
                                <?php echo round($dulieu->balance,2);?>
                            </span>
                            <span style="color: #5cb85c;" class="sl-<?php echo $dulieu->id;?>"></span>
                        </td>
                        <td>$
                            <span class="s-<?php echo $dulieu->id;?>">
                                <?php echo round($dulieu->pending,2);?>
                            </span>
                            <span style="color: #5cb85c;" class="sl-<?php echo $dulieu->id;?>"></span>
                        </td> 
                        <td>$
                            <span class="s-<?php echo $dulieu->id;?>">
                                <?php echo round($dulieu->curent,2);?>
                            </span>
                            <span style="color: #5cb85c;" class="sl-<?php echo $dulieu->id;?>"></span>
                        </td>
                        
                        
                        
                        <td style="width: 250px; min-width: 250px; max-width: 250px; word-wrap: break-word; "> <?php echo $dulieu->offercats ?> </td>
                        
                        <td>
                            <?php
                            if($dulieu->activated == 1){
                                echo '<span style="color: green; font-weight: bold;">✓ Verified</span>';
                            } else {
                                echo '<span style="color: orange;">Pending</span>';
                            }
                            ?>
                        </td>

                        <td class="approv">
                            <?php 
                            if($dulieu->status==0){echo '<span class="label label-warning">Pending</span>';}
                            if($dulieu->status==1){echo '<span class="label label-success">Approved</span>';}
                            if($dulieu->status==2){echo '<span class="label label-default">Pause</span>';}
                            if($dulieu->status==3){echo '<span class="label label-danger">Banned</span>';}  
                            if($dulieu->status==4){echo '<span class="label label-danger">Rejected</span>';}
                            if($dulieu->status==5){echo '<span class="label label-info">Reactivated</span>';}                                 
                            ?>                            
                            <span class="glyphicon glyphicon-cog approved" style="float: right;position:relative;cursor: pointer;"></span>
                            <select id="<?php echo $dulieu->id;?>" class="sapproved" style="display: none;">
                                <option value="0">Pending</option>
                                <option value="1" <?php echo $dulieu->status==1?'selected':'';?>>Approved</option>
                                <option value="2" <?php echo $dulieu->status==2?'selected':'';?>>Pause</option>
                                <option value="3" <?php echo $dulieu->status==3?'selected':'';?>>Banned</option>
                                <option value="4" <?php echo $dulieu->status==4?'selected':'';?>>Reject</option>
                                <option value="5" <?php echo $dulieu->status==5?'selected':'';?>>Reactivated</option>
                            </select>
                        </td>
                        
                      
                        <td>
                            <!--invoicebhhhhhhhhhn>>>-->
                            <a data-email="<?php echo $dulieu->email;?>" title="<?php echo $dulieu->id;?>" class="btn btn-success btn-xs invoice">
                                <i class="glyphicon glyphicon-euro glyphicon-white"></i>                                            
                            </a>
                            <!--login acc membert>>>-->
                            <a href="<?php echo base_url().$this->config->item('admin').'/viewmember/'.$dulieu->id;?>" class="btn btn-success btn-xs" target=_blank>
                            <i class="glyphicon glyphicon-eye-open glyphicon-white"></i>                                            
                            </a>
                            <!--block sub2>>>-->
                            <a class="btn btn-info btn-xs block_sub2" data-id="<?php echo $dulieu->id;?>">
                            <i class="glyphicon glyphicon-minus-sign glyphicon-white"></i>                                            
                            </a>
                            <!--show credit>>>-->
                            <a href="<?php echo base_url().$this->config->item('admin').'/showev/tracklink/'.$dulieu->id;?>" class="btn btn-success btn-xs">
                            <i class="glyphicon glyphicon-zoom-in glyphicon-white"></i>                                            
                            </a>
                            <!--edit>>>-->
                            <a class="btn btn-info btn-xs usermodal" title="<?php echo $dulieu->id;?>">
                            <i class="glyphicon glyphicon-edit glyphicon-white"></i>                                            
                            </a>
                            <!--delete>>>-->
                            <a href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id;?>" class="btn btn-danger btn-xs del">
                            <i class="glyphicon glyphicon-trash glyphicon-white"></i> 
                            </a>
                        </td>
                    </tr>
                    <?php    }
                        }
                        ?>
                    
                </tbody>
            </table>
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
<!-- phan modal--->

<!-- Large modal -->


<!--end modal--->