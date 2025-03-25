<div class="row">
    <div class="box col-md-12">
        <div data-original-title="" class="box-header">
            <h2><i class="glyphicon glyphicon-user"></i><span class="break"></span>Members</h2>
            <div class="box-icon">
                <a class="btn-close" href="<?php echo base_url().'admin/route/'.$this->uri->segment(3).'/add/';?>"><i class="glyphicon glyphicon-plus"></i></a>
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
                <form class="form-inline col-md-6" role="form">
                    <label>Search: 
                    <input class="form-control input-sm" type="text"/></label>
                    <button type="submit" class="btn btn-default input-sm">Sign in</button>
                </form>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>Id</th>
                        <th>Email address</th>
                        <th>Date</th>
                        <th>Manager</th>
                        <th>Balance</th>
                        <th style="width: 80px;">Status</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>    
                    <tr>
                        <td><?php echo $dulieu->id;?></td>
                        <td><?php echo $dulieu->email;?></td>
                        <td><?php echo date('d m y',strtotime($dulieu->created));?></td>
                        
                         <td class="manager">                                
                                 <select name="manager" id="<?php echo $dulieu->id;?>" class="manager">
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
                        <td><?php echo $dulieu->curent;?></td>
                        <td>
                            <?php 
                            if($dulieu->status==0){echo '<span class="label label-warning">Pending</span>';}
                            if($dulieu->status==1){echo '<span class="label label-success">Approved</span>';}
                            if($dulieu->status==2){echo '<span class="label label-default">Pause</span>';}
                            if($dulieu->status==3){echo '<span class="label label-danger">Banned</span>';}
                            ?>
                        </td>
                        <td>
                            <!--show credit>>>-->
                            <a href="<?php echo base_url().'admin/usergroup/credit/'.$dulieu->id;?>" class="btn btn-success btn-xs">
                            <i class="glyphicon glyphicon-zoom-in glyphicon glyphicon-white"></i>                                            
                            </a>
                            <!--edit>>>-->
                            <a href="<?php echo base_url().'admin/route/users/edit/'.$dulieu->id;?>" class="btn btn-info btn-xs">
                            <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>                                            
                            </a>
                            <!--delete>>>-->
                            <a href="<?php echo base_url().'admin/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id;?>" class="btn btn-danger btn-xs">
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
                <div class="col-md-12">
                    Showing 1 to 10 of 32 entries
                </div>
                <div class="col-md-6">
                    <ul class=" pagination">
                        <li class="prev disabled"><a href="#">←</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li class="next"><a href="#"> → </a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div style="margin: 20px;float:right" class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3);?>" name="filter_cat" size="1" class="form-control input-sm">
                            <option value="0">all</option>
                            <?php 
                                if(!empty($category)){
                                    $where = $this->session->userdata('where');
                                    foreach($category as $category1){
                                        echo '
                                            <option value="'.$category1->id.'"';
                                            if(!empty($where['catid'])){
                                                echo $where['catid']==$category1->id?' selected':'';
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
            </div>
        </div>
    </div>
    <!--/span-->
</div>
