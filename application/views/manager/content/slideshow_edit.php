<form class="clearfix" method="POST" action="<?php echo base_url().'admin/route/'.$this->uri->segment(3);?>/list">
<?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>
 
                    <table class="tb_content clearfix">                       
                        <tr>
                            <td>Title</td>
                            <td>
                                <input class="span300" value="<?php if($dulieu){echo $dulieu->title;} ?>" type="text" name="title" />
                            </td>
                            
                        </tr>    
                                            
                        <tr>
                            <td>Images</td>
                            <td>
                                <input type="text" id="xFilePath" name="img" style="width:300px" value="<?php if($dulieu){echo $dulieu->img;} ?>"/>
                                <input type="button" value="Upload" onclick="BrowseServer();" />
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
                            <td>Link</td>
                            <td>
                                <input value="<?php if($dulieu){echo $dulieu->url;} ?>" class="span300" type="text" name="url" />
                            </td>
                            
                        </tr> 
                        
                        <tr>
                            <td>Text</td>
                            <td>
                                <textarea id="soanthao1" name="text"><?php if($dulieu){echo $dulieu->text;}?></textarea>
                            </td>                            
                        </tr>
                                             
                        <tr><td colspan="2" class="submit_td"><input type="submit" value="Submit" /></td></tr> 
                    </table>
                
               
</form>

