
<?php 
    if(!empty($category)){
        $where = $this->session->userdata('where');
       $fc = '';
       $mc='';
        foreach($category as $category1){
            $mc[$category1->id] = $category1->name;
            $fc.= '<option value="'.$category1->id.'"';
                if(!empty($where['manager'])){
                    $fc.= $where['manager']==$category1->id?' selected':'';
                }                                                
                $fc.= '>'.$category1->name.'</option>
            ';
        }
    }
    //getr affiliate
    $mu='';
    if($dulieu){
        foreach($dulieu as $dulieu1){
            $m[]=$dulieu1->userid;
        }
        array_unique($m);
        $this->db->select(array('id','email'));
        $this->db->where_in('id',$m);
        $user = $this->Admin_model->get_data('users');
        
        if(!empty($user)){
            foreach($user as $user){
                $mu[$user->id] = $user->email;
            }
        }
        
    }
?>

<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Payment</h2>
            <div class="box-icon">
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
                        <th>Manager</th>   
                        <th>Affiliate</th>                        
                        <th>Amount</th>
                        <th>Ip</th>
                        <th>date</th>
                        <th>Notes</th>                    
                        
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>    
                    <tr>
                        <td><?php echo $dulieu->id;?></td>
                        <td><?php if(!empty($mc[$dulieu->manager])){echo $mc[$dulieu->manager];}?></td>
                        <td><?php if(!empty($mu[$dulieu->userid])){echo $mu[$dulieu->userid];}?></td>
                        <td>$<?php echo $dulieu->amount;?></td>
                        <td><?php echo $dulieu->ip;?></td>
                        <td><?php echo $dulieu->created;?></td>
                        <td><?php echo $dulieu->notes;?></td>
                       
                        
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
                                    echo $fc;
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
