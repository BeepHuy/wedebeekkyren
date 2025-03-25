                
                    <table class="tb_content clearfix">
                    <form>
                        <tr>
                            <th class="first_id"><a title="id" href="#" class="order">id</a></th>
                            <th><a title="title" href="#" class="order">title</a></th>
                            <th>status</th>
                            <th>edit</th>
                            <th>delete</th>
                            <th class="tb_check"><input class="checkall" type="checkbox" /></th>
                        </tr>
                        <?php
                        if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>                                
                         <tr>
                            <td class="first_id"><?php echo $dulieu->id;?></td>
                            <td><?php echo $dulieu->title;?></td>
                            <td class="span30"><a class="status ajax <?php echo $dulieu->show==0? 'unpub':''; ?>" id="<?php echo $dulieu->id;?>" href="<?php echo base_url().'admin/ajax/unpub/'.$this->uri->segment(3).'/show/';?>">status</a></td>
                            <td class="edit span30"><a href="<?php echo base_url().'admin/route/'.$this->uri->segment(3).'/edit/'.$dulieu->id;?>">edit</a></td>
                            <td class="del span30"><a href="<?php echo base_url().'admin/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id;?>">del</a></td>
                            <td class="tb_check"><input type="checkbox" name="checkb[]" value="<?php echo $dulieu->id;?>" /></td>
                        </tr>   
                                
                        <?php    }
                        }
                        ?>
                       </form>   
                    </table><!-- end table content-->                   
                  