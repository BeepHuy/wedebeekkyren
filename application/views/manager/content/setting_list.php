<?php if($dulieu){$dulieu=$dulieu[0];} ?>
 
                    <table class="tb_content clearfix">                       
                        <tr>
                            <td>Title</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->title;} ?>
                            </td>
                            
                        </tr>    
                        
                        <tr>
                            <td>Master</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->master;} ?>                                
                            </td>                            
                        </tr>
                        
                        <tr>
                            <td>Email</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->email;} ?>                                
                            </td>                            
                        </tr> 
                        
                        <tr>
                            <td>Address</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->address;} ?>                                
                            </td>                            
                        </tr>          
                        
                        <tr>
                            <td>Phone</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->phone;} ?>                                
                            </td>                            
                        </tr>       
                                     
                        <tr>
                            <td>Metadesc</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->metades;} ?>                                
                            </td>                            
                        </tr> 
                        
                          
                        
                        <tr>
                            <td>Metakey</td>
                            <td>
                                <?php if($dulieu){echo $dulieu->metakey;} ?>
                            </td>
                            
                        </tr> 
                                             
                        <tr>
                            <td>Logo</td>
                            <td style="background: #2E2E2E;">
                                <?php if($dulieu){echo '<img src="'.$dulieu->logo.'"/>';} ?>
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <a style="color: red;" class="eidt" href="<?php echo base_url();?>admin/route/setting/edit/1">EDIT</a>
                            </td>
                            
                            
                        </tr>
                        
 </table>
 <script>
 $(document).ready(function(){
    $('.box_header a').hide();
    $('.filter').hide();
 })
 
 </script> 
 <style>
 .eidt{
    border:1px solid #cacaca;
    background:#39C5EF;
    padding:5px 15px;    
    font-weight:bold;
 }
  
 </style>               
               


