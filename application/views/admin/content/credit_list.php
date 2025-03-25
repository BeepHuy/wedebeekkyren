           <?php 
           
           $g=$this->Admin_model->get_one('users',array('id'=>$this->uri->segment(4,0)));
           ?>   
           <div class="mota">
            <div class="img_list_group">
                Danh sách Offer credit của account <span style="color: #FCCE00;"><?php if(!empty($g))echo $g->username;?></span>
            </div>
           </div>   
              
                <table class="tb_content clearfix">
                     <form>
                        <tr>
                           <th class="first_id"><a title="id" href="#" class="order">id</a></th>
                            <th><a title="point" href="#" class="order">Point</a></th>
                            <th><a title="created" href="#" class="order">Date</a></th>
                            <th><a title="name" href="#" class="order">Offer</a></th> 
                            <th>delete</th>
                            <th class="tb_check"><input class="checkall" type="checkbox" /></th>
                        </tr>
                        <?php
                        if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>                                
                         <tr>
                            <td class="first_id"><?php echo $dulieu->id;?></td>
                            <td><?php echo $dulieu->point;?></td>
                            <td><?php echo date("d m Y - h:i:s A",$dulieu->created);?></td>
                            <td><?php echo $dulieu->name;?></td>
                            <td class="del span30"><a href="<?php echo base_url().'admin/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id;?>">del</a></td>
                            <td class="tb_check"><input type="checkbox" name="checkb[]" value="<?php echo $dulieu->id;?>" /></td>
                        </tr>   
                                
                        <?php    }
                        }
                        ?>
                       </form>                          
                    </table><!-- end table content--> 
                   
                 