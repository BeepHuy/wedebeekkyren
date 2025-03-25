<form class="clearfix" method="POST" action="<?php echo base_url().'admin/route/'.$this->uri->segment(3);?>/list">
<?php if($dulieu){echo '<input class="hide" value="'.$dulieu->id.'" name="id"/>';} ?>
 
                    <table class="tb_content clearfix">                       
                        <tr>
                            <td>Type</td>
                            <td>
                                <input class="span300" value="<?php if($dulieu){echo $dulieu->type;} ?>" type="text" name="type" />
                            </td>
                            
                        </tr>  
                        
                        <tr>
                            <td>Show / Hide</td>
                            <td>
                                <span class="box_switch<?php if($dulieu){echo $dulieu->publish==1? '':' off';} ?>">
                                    <a href="#">switch off</a>
                                    <input id="off_on" type='hidden' name="publish" value="1"/>
                                </span>                                
                            </td>                            
                        </tr> 
                                             
                        <tr><td colspan="2" class="submit_td"><input type="submit" value="Submit" /></td></tr> 
                    </table>
                
               
</form>

