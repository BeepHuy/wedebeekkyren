<form class="clearfix" method="POST" action="<?php echo base_url().'admin/route/'.$this->uri->segment(3);?>">
<?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>
<input value="1" class="span300" type="hidden" name="postion" />
                    <table class="tb_content clearfix">                       
                        <tr>
                            <td>Title</td>
                            <td>
                                <input value="<?php if($dulieu){echo $dulieu->title;} ?>" class="span300" type="text" name="title" />
                            </td>
                            
                        </tr>    
                                            
                        <tr>
                            <td>Alias(SEO-URL)</td>
                            <td>
                                <input value="<?php if($dulieu){echo $dulieu->alias;} ?>" class="span300" type="text" name="alias" />
                            </td>                            
                        </tr> 
                        
                        <tr>
                            <td>Hiển thị</td>
                            <td>
                            <select class="hienthibaiviet">
                                <option value="0">Danh mục</option>
                                <option value="1" <?php if(!empty($dulieu->idcontent)){echo ' selected';}?>>Hiển thị 1 bài viết</option>
                            </select>
                                <input class="baivietht" value="<?php if($dulieu){echo $dulieu->idcontent;} ?>" class="span300" name="idcontent" />
                            </td>                            
                        </tr> 
                        
                        <tr>
                            <td>Metades(SEO)</td>
                            <td>
                                <textarea name="metades"><?php if($dulieu){echo $dulieu->metades;} ?></textarea>
                            </td>                            
                        </tr>
                        
                        <tr>
                            <td>MetaKey(SEO)</td>
                            <td>
                                <textarea name="metakey"><?php if($dulieu){echo $dulieu->metakey;} ?></textarea>
                            </td>                            
                        </tr>
                        
                        <tr>
                            <td>Show / Hide</td>
                            <td>
                                <span class="box_switch<?php if($dulieu){echo $dulieu->show==1? '':' off';} ?>">
                                    <a href="#">switch off</a>                                    
                                    <input id="off_on" type='hidden' name="show" value="1"/>
                                </span>                                
                            </td>                            
                        </tr>  
                        
                        <tr>
                            <td>Order</td>
                            <td>
                                <input value="<?php if($dulieu){echo $dulieu->order;} ?>" class="span300" type="text" name="order" value="0" />
                            </td>
                            
                        </tr> 
                                             
                        <tr><td colspan="2" class="submit_td"><input type="submit" value="Submit" /></td></tr> 
                    </table>
                <script>
                $(document).ready(function(){
                    t=<?php if(!empty($dulieu->idcontent)){echo 1;}else echo 0;?>;
                    if(t==1){$('.baivietht').show();}else{$('.baivietht').hide();}
                    $('.hienthibaiviet').live('change',function(){
                        t = $(this).val();
                        if(t==1){$('.baivietht').show();}else{$('.baivietht').hide();}
                        });
                });
                
                </script>
</form>

