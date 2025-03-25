<div class="row">
    <div class="box col-md-12">
        <div data-original-title="" class="box-header">
            <h2><i class="glyphicon glyphicon-user"></i><span class="break"></span>Members</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/add/';?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-6">
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
                        <th>Email address</th>
                        <th>Date</th>                        
                        <th>Balance</th>
                        <th style="width: 105px;">Pay</th>     
                        <th style="width: 105px;">Status</th>                        
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>    
                    <tr>
                        <td><?php echo $dulieu->id;?></td>
                        <td><?php echo $dulieu->email;?></td>
                        <td><?php echo date('d-m-Y',strtotime($dulieu->created));?></td>
                        
                      
                         
                        <td>$
                            <span class="s-<?php echo $dulieu->id;?>">
                                <?php echo $dulieu->curent;?>
                            </span>
                            <span style="color: #5cb85c;" class="sl-<?php echo $dulieu->id;?>"></span>
                        </td>
                        
                        <td>                        
                            <input style="width: 50px;"/>
                            <button id="<?php echo $dulieu->id;?>" class="btn btn-info btn-xs pay" title="OK">
                                <i class="glyphicon glyphicon-thumbs-up glyphicon-white"></i>  
                            </button>  
                        
                        </td>
                        <td class="approv">
                            <?php 
                            if($dulieu->status==0){echo '<span class="label label-warning">Pending</span>';}
                            if($dulieu->status==1){echo '<span class="label label-success">Approved</span>';}
                            if($dulieu->status==2){echo '<span class="label label-default">Pause</span>';}
                            if($dulieu->status==3){echo '<span class="label label-danger">Banned</span>';}                            
                            ?>                            
                            <span class="glyphicon glyphicon-cog approved" style="float: right;position:relative;cursor: pointer;"></span>
                            <select id="<?php echo $dulieu->id;?>" class="sapproved" style="display: none;">
                                <option value="0">Pending</option>
                                <option value="1" <?php echo $dulieu->status==1?'selected':'';?>>Approved</option>
                                <option value="2" <?php echo $dulieu->status==2?'selected':'';?>>Pause</option>
                                <option value="3" <?php echo $dulieu->status==3?'selected':'';?>>Banned</option>
                            </select>
                        </td>
                        
                      
                        <td>
                            <!--show credit>>>-->
                            <a href="<?php echo base_url().$this->config->item('manager').'/showev/tracklink/'.$dulieu->id;?>" class="btn btn-success btn-xs">
                            <i class="glyphicon glyphicon-zoom-in glyphicon glyphicon-white"></i>                                            
                            </a>
                            <!--edit>>>-->
                            <a class="btn btn-info btn-xs usermodal" title="<?php echo $dulieu->id;?>">
                            <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>                                            
                            </a>
                            <!--delete>>>-->
                            <a href="<?php echo base_url().$this->config->item('manager').'/'.$this->uri->segment(2).'/delete/'.$dulieu->id;?>" class="btn btn-danger btn-xs del">
                            <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i> 
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
                            <option value="all">all</option>
                            <?php 
                                $t=10;
                                $where = $this->session->userdata('where');
                               if(!empty($where['status'])){
                                    $t=$where['status'];
                               }
                               echo '     <option value="0"';
                              echo $t==0?' selected = "selected" ':'';
                              echo '     >Pending</option>';
                              
                              echo '     <option value="1"';
                              echo $t==1?' selected = "selected" ':'';
                              echo '     >Approved</option>';
                              
                              echo '     <option value="2"';
                              echo $t==2?' selected = "selected" ':'';
                              echo '     >Pause</option>';
                              
                              echo '     <option value="3"';
                              echo $t==3?' selected = "selected" ':'';
                              echo '     >Banned</option>';
                              
                               
                                    
                               
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
