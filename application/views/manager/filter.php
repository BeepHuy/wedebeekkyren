  <div class="filter">
                        <div class="show_num left">
                            Show
                                <select title="<?php echo base_url().'admin/ajax/show_num/'.$this->uri->segment(3);?>" name="show_num" size="1">
                                <?php 
                                $limit = $this->session->userdata('limit');
                                for($i=1;$i<11;$i++){
                                    echo '
                                    <option value="'.$i*(10).'"';
                                    echo $i*(10)==$limit['0']?' selected':'';
                                    echo 
                                    '>'.$i*(10).'</option>
                                    ';
                                }
                                ?>
                                </select>
                            entries
                        </div>
                        <!-- loc theo danh muc-->
                        <div class="filter_cat left">
                            Filter:
                                <select title="<?php echo base_url().'admin/ajax/filter_cat/'.$this->uri->segment(3);?>" name="filter_cat">
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
                        </div>
                        <!--end loc theo danh muc-->
                        <!-- phan trang-->
                        <ul class="Pagination left">
                              <?php echo $this->pagination->create_links();?>             
                        </ul>
                        <!-- end phan trang-->
                        <!-- xoa,chuyen tat ca-->
                        <div class="action right">
                            Action:
                                <select title="<?php echo $this->uri->segment(3);?>" name="action_item">
                                    <option value="0">chose action</option>
                                    <option value="del">Delete all</option>
                                    <option value="disable">Disable all</option>
                                    <option value="active">Active all</option>
                                </select>                            
                        </div>
                        <!--end xoa tat ca-->
                        
                    </div>
                    