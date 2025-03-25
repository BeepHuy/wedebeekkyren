<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Happening</h2>
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
                        <th>SubID</th>
                        <th>S1</th>
                        <th>Users</th>
                        <th>OfferId</th>
                        <th>OferName</th>
                        <th>Ip</th>
                        <th>Date</th>
                        <th>Payout</th>
                        <th>proxy</th>
                        <th>fraud_score</th>
                        <th>User_language</th>
                        
                    </tr>
                </thead>
                <style>
                    .danger{
                        background-color:#dc3545!important
                    }
                    .warning{
                        background-color:#ffc107!important
                    }
                </style>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){
                                $mid[]=$dulieu->userid;
                                $clll = '';
                                if($dulieu->fraud_score>=1){
                                    $clll = 'warning';
                                }
                                if($dulieu->proxy){
                                    $clll = 'danger';
                                }
                                ?>    
                    <tr class="<?php echo $clll;?>">
                        <td><?php echo $dulieu->id;?></td>
                        <td><?php echo $dulieu->s1;?></td>
                        <td class="userid<?php echo $dulieu->userid;?>">....</td>
                        <td><?php echo $dulieu->offerid;?></td>
                        <td><?php echo $dulieu->oname;?></td>
                        <td><?php echo $dulieu->ip;?></td>
                        <td><?php echo $dulieu->date;?></td> 
                        <td><?php echo $dulieu->amount2;?></td> 
                        <td><?php if($dulieu->proxy)echo 'True';else echo 'False';?></td> 
                        <td><?php echo $dulieu->fraud_score;?></td> 
                        <td><?php echo $dulieu->user_language;?></td> 
                       
                    </tr>
                    <?php    }
                        }
                        if(!empty($mid)){
                            $this->db->select(array('id','email'));
                            $this->db->where_in('id',$mid);
                            $user = $this->db->get('users')->result();
                            if(!empty($user)){
                                ///user trung nen co the luong user it hon so voi cai kia
                                $t='';
                                foreach($user as $user){
                                    if(empty($t)){
                                        $t .= '{userid'.$user->id.':"'.$user->email.'"';
                                    }else{
                                        $t .= ',userid'.$user->id.':"'.$user->email.'"';
                                    }
                                    
                                    
                                }
                                if(!empty($t)){
                                    $t .='}';
                                    echo '
                                    <script>
                                        $(document).ready(function(){
                                            var obj = '.$t.'; 
                                        $.each( obj, function( i, val ){
                                          $( "." + i ).text( val );
                                          
                                        });    
                                        })
                                        
                                        </script>
                                    
                                    
                                    ';
                                }
                            }
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
