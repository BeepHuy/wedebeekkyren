 <style>
 .tb_content th{
    text-align:center;
    background:#EEEEEE;
    padding:5px;
}
.tb_content{
    width:100%;
    border-collapse: separate;
    border-spacing: 2px;
    margin-top:0px;
    position:relative;
}
.tb_content td {
    display: table-cell;
    border-bottom: 1px dotted #CCCCCC;
    color: #000000;
    padding: 10px 0px 10px 10px;
    background-color:#f7f7fb;
     vertical-align: middle;
}
.tb_content .tb_check{
    width:20px;
    text-align:center;
    padding:5px;
    background:#EEEEEE;
}
.tb_content .span30{    
    width:30px;    
    cursor:pointer;
}
 
 </style>
 
  <?php @$mailling = unserialize($dulieu->mailling);?>    
  
    <table class="tb_content clearfix">    
        <tr>         
            <th></th>
            <th></th>
            
        </tr>
        <tr>
            <td class="dd">Change password</td>
            <td>
                <form action="<?php echo base_url().$this->config->item('admin').'/editpass/'.$dulieu->id;?>" method="POST">
                    <input name="pass" type="text" /> <input type="submit" />
                </form>
            </td>
         </tr> 
         <tr>
            <td class="dd">First Name</td>
            <td><?php echo $mailling['firstname'];?></td>
         </tr>  
         <tr>
            <td class="dd">Last Name</td>
            <td><?php echo $mailling['lastname'];?></td>
         </tr>
       
         <tr>
            <td class="dd">Email</td>
            <td><?php echo $dulieu->email;?></td>
         </tr>
         <tr>
            <td class="dd">Address 1</td>
            <td><?php echo $mailling['ad1'];?></td>
         </tr>
         <tr>
            <td class="dd">Address 2</td>
            <td><?php echo $mailling['ad2'];?></td>
         </tr>
         <tr>
            <td class="dd">City</td>
            <td><?php echo $mailling['city'];?></td>
         </tr>
         <tr>
            <td class="dd">Zip/Postal Code</td>
            <td><?php echo $mailling['zip'];?></td>
         </tr>
         <tr>
            <td class="dd">State/Province</td>
            <td><?php echo $mailling['state'];?></td>
         </tr>
         <tr>
            <td class="dd">Country</td>
            <td><?php echo $mailling['country'];?></td>
         </tr>
         <tr>
            <td class="dd">Incentives?</td>
            <td><?php echo $mailling['incentives'];?></td>
         </tr>
         
         <tr>
            <td class="dd">Birthday?</td>
            <td><?php echo $mailling['Birthday'];?></td>
         </tr>
         <tr>
            <td class="dd">Traffic Information</td>
            <td><?php echo $mailling['trafficdesc'];?></td>
         </tr>
         <tr>
            <td class="dd">Payment Info</td>
            <td><?php echo $mailling['payment_info'];?></td>
         </tr>
         
       
     
    </table><!-- end table content--> 
                                     
 
                 