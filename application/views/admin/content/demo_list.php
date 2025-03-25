   <!-- warning-->
            <div class="error relative">
                <div class="error_mess messcontent">
                dgfgf
                </div>
                <span class="close"></span>
            </div>
            
            <div class="succ relative">
                <div class="succ_mess messcontent">
                dgfgf
                </div>
                <span class="close"></span>
            </div>
            
            <div class="war relative">
                <div class="war_mess messcontent">
                dgfgf
                </div>
                <span class="close"></span>
            </div>
            <!-- end warning-->
   
   <!-- box-->
             <div class="box">
                <div class="box_header clearfix">
                    <h3 class="left">List</h3>
                    <a href="<?php echo base_url().'admin/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/add/';?>" class="right">add</a>
                </div>
                <div class="box_content clearfix">
                    <table class="tb_content clearfix">
                        <tr>
                            <th class="first_id">id</th>
                            <th>title</th>
                            <th>status</th>
                            <th>edit</th>
                            <th>delete</th>
                            <th class="tb_check"><input type="checkbox" /></th>
                        </tr>
                        <tr>
                            <td class="first_id">1</td>
                            <td>fdsfd</td>
                            <td class="status"><a href="#">status</a></td>
                            <td class="edit"><a href="#">edit</a></td>
                            <td class="del"><a href="#">del</a></td>
                            <td class="tb_check"><input type="checkbox" /></td>
                        </tr>
                        
                         <tr>
                            <td class="first_id">2</td>
                            <td>fdsfd</td>
                            <td class="status"><a href="#">status</a></td>
                            <td class="edit"><a href="#">edit</a></td>
                            <td class="del"><a href="#">del</a></td>
                            <td class="tb_check"><input type="checkbox" /></td>
                        </tr> 
                    </table><!-- end table content-->
                    <div class="filter">
                        <div class="show_num left">
                            Show
                                <select name="show_num" size="1">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                            entries
                        </div>
                        <!-- loc theo danh muc-->
                        <div class="filter_cat left">
                            Filter:
                                <select name="filter_cat">
                                    <option value="0">danh muc goc</option>
                                    <option value="contact">contact</option>
                                </select>                            
                        </div>
                        <!--end loc theo danh muc-->
                        <!-- phan trang-->
                        <div class="Pagination left">
                                 1 2                    
                        </div>
                        <!-- end phan trang-->
                        <!-- xoa,chuyen tat ca-->
                        <div class="action right">
                            Action:
                                <select name="action_item">
                                    <option value="0">delete all</option>
                                    <option value="contact">move all</option>
                                </select>                            
                        </div>
                        <!--end xoa tat ca-->
                        
                    </div>
                </div>           
            </div><!--end box-->
            
            <!----------------------------------------------------------------------------
            edit
            -------------------------------------------------------------------------------------->
            
            
              
            <!-- box-->
             <div class="box">
                <div class="box_header add_edit clearfix">
                    <h3 class="left">Edit</h3>
                    <a href="<?php $limit=$this->session->userdata('limit'); echo base_url().'admin/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/list/'.$limit['0'];?>" class="right cancel">cancel</a>
                </div>
                <div class="box_content clearfix">
                    <table class="tb_content clearfix">                       
                        <tr>
                            <td >tieu de</td>
                            <td>
                                <input class="span300" type="text" />
                            </td>
                            
                        </tr>                        
                        <tr>
                            <td >noi dung</td>
                            <td>
                                <input class="span300" type="text" />
                            </td>                            
                        </tr> 
                        <tr>
                        <td colspan="2" class="submit_td"><input type="submit" value="Submit" /></td>
                        </tr> 
                                            
                        
                    
                    </table>
                
                </div>
           
            </div><!--end box-->