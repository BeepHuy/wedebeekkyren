             
           <div class="mota">
            <div class="img_list_group">
                Contact
            </div>
           </div>   
              
                <table class="tb_content clearfix">
                     <form>
                        <tr>
                           <th class="first_id"><a title="id" href="#" class="order">id</a></th>
                            <th><a title="ten" href="#" class="order">Name</a></th>
                            <th><a title="email" href="#" class="order">Email</a></th>
                            <th><a title="inquirytype" href="#" class="order">Inquiry</a></th>
                            <th><a title="dienthoai" href="#" class="order">Phone</a></th>
                            <th><a title="trangthai" href="#" class="order">Status</a></th>
                            <th><a title="ngay" href="#" class="order">Date</a></th>
                            <th>view</th> 
                            <th>delete</th>
                            <th class="tb_check"><input class="checkall" type="checkbox" /></th>
                        </tr>
                        <?php
                        if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>                                
                         <tr>
                            <td class="first_id"><?php echo $dulieu->id;?></td>
                            <td><?php echo $dulieu->ten;?></td>
                            <td><?php echo $dulieu->email;?></td>
                            <td><?php echo $dulieu->inquirytype;?></td>
                            <td><?php echo $dulieu->dienthoai;?></td>
                            <td><?php if(!$dulieu->trangthai){echo '<img src="'.base_url().'temp/admin/images/email.png"/>';}else{echo '<img src="'.base_url().'temp/admin/images/email_o.gif"/>';};?></td>
                            <td><?php echo $dulieu->ngay;?></td>
                            <td class="view span30"><a href="<?php echo base_url().$this->config->item('manager').'/route/'.$this->uri->segment(3).'/edit/'.$dulieu->id;?>">edit</a></td>
                            <td class="del span30"><a href="<?php echo base_url().$this->config->item('manager').'/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id;?>">del</a></td>
                            <td class="tb_check"><input type="checkbox" name="checkb[]" value="<?php echo $dulieu->id;?>" /></td>
                        </tr>   
                                
                        <?php    }
                        }
                        ?>
                       </form>                          
                    </table><!-- end table content--> 
               
           <!-- fancyboox-->
    <script type="text/javascript" src="<?php echo base_url();?>temp/admin/js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>temp/admin/js/jquery.fancybox.pack.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>temp/admin/css/jquery.fancybox.css?v=2.1.5" media="screen" />
    <script type="text/javascript">
		$(document).ready(function() {			
			$('.fancybox').fancybox({
			 openEffect : 'elastic',
				openSpeed  : 150,
				closeEffect : 'elastic',
				closeSpeed  : 150,
				closeClick : true,
			});
		});
	</script>
    
    <!--end fancyboxx-->
          
          