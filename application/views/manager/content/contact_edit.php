<form class="clearfix" method="POST" action="<?php echo base_url();?>mod_contact/respond">
<?php 
if($dulieu){
    $this->db->where('id',$dulieu->id);
    $this->db->update('contact',array('trangthai'=>1));
    
    } 

?>
 
                    <table class="tb_content clearfix">                       
                        <tr>
                            <td>Name</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->ten;} ?>
                            </td>
                            
                        </tr> 
                        <tr>
                            <td>Email</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->email;} ?>
                            </td>
                            
                        </tr> 
                        <tr>
                            <td>Phone</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->dienthoai;} ?>
                            </td>
                            
                        </tr> 
                        <tr>
                            <td>Inquirytype</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->inquirytype;} ?>
                            </td>
                        </tr> 
                        <tr>
                            <td>Content</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->thongtin;} ?>
                            </td>
                            
                        </tr> 
                        
                       <tr>
                            <td>Tieu de email</td>
                            <td>
                                <input class="span300" value="" type="text" name="tieude" />
                            </td>
                            
                        </tr>   
                        
                            
                   
                       <tr>
                            <td>Respond</td>
                            <td>
                                <input type="hidden" value="<?php if($dulieu){echo $dulieu->email;} ?>" name="email" value="0" />
                                <textarea id="soanthao" name="moidung"></textarea>
                            </td>                            
                        </tr>
                       
                                             
                        <tr><td colspan="2" class="submit_td"><input type="submit" value="Submit" /></td></tr> 
                    </table>
                
</form>


