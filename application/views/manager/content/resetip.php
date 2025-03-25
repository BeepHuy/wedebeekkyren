
<div class="content_article">
<div class="wrapnd">
    <div class="wbox_header">Reset IP</div>
    <div class="wbox_content offer">

  <div id="acct">  
    <div class="rp_fitter">
    <form action="" method="post">
    <!--
    Nhập ngày giờ theo định dạng: (Năm-Tháng-Ngày Giờ:Phút:Giây ví dụ  <b>2012-11-22 23:05:48</b> )<br />
       <span class="inputrepr"><label>Start Date</label> <input id="startdate" type="text" name="startdate" value="<?php echo $start;?>" /></span>
       <span class="inputrepr"><label>End Date</label> <input id="enddate" type="text" name="enddate"  value="<?php echo $end;?>" /></span>
      
  -->
      <input id="idoffer" type="text" name="idoff" value="<?php echo $idoff;?>" /></span>
      <input type="submit" value="Run" /><br />
      <span style="color: red;"><?php echo $thongbao;?></span>
      
    </form>
    </div>   
   </div><!--end .acc-->    
   </div><!-- ecnd wbox_content-->
  </div><!-- ecnd wrapnd-->
                 
 </div> 
 <style>
 .Pagination{
    display:block;
}
.Pagination li{
    float:left;
    display:block;
    padding:3px;
    margin:0 2px;
    background:#E8E9EA;
    border:1px solid #CCCDCE
}
.Pagination li a{
    display:block;
}
.activep{
    background:#D3CFF9 !important;
}
.o_acti{color:#00C40B;}
.o_pause{color:red}
 .content_article th{font-size:13px;}
 .content_article{font-size:14px;}
 .pointr{color:#fb9402;}
 .clickr{color:#5B6904;}
 .inputrepr{padding-right: 15px;margin: 5px !important;}
 .iio{margin-left:10px !important;width:50px}
.inputrepr input{margin:5px;}
 </style>