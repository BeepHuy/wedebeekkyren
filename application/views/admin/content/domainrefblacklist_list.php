<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Domain Referal Blacklist</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/add/';?>"><i class="glyphicon glyphicon-plus"></i></a>
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
               <?php $mcategory['0']->title= 'none';?>  
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>OfferID</th>
                        <th>Domain</th>
                        <th>Reason</th>                                                                   
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>    
                    <tr>
                        <td><?php echo $dulieu->id;?></td>
                        <td><?php echo $dulieu->offerid;?></td>
                        <td><?php echo $dulieu->domain;?></td>
                        <td><?php echo $dulieu->reason;?></td>
                        
                        <td>
                           
                            <!--edit>>>-->
                            <a href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/edit/'.$dulieu->id;?>" class="btn btn-info btn-xs">
                            <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>                                            
                            </a>
                            <!--delete>>>-->
                            <a href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id;?>" class="btn btn-danger btn-xs">
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
