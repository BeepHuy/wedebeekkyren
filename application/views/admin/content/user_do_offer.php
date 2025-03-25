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
            <th>Id</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Blance</th>
        </tr>
         
         
       <?php
      if(!empty($dt)){
        foreach($dt as $dt){
            echo '<tr>';
            echo '    <td>'.$dt->id.'</td>';
            echo '    <td><a href="'.base_url($this->config->item('admin')).'/viewmember/'.$dt->id.'">'.$dt->email.'</a></td>';
            echo '    <td>'.$dt->phone.'</td>';
            echo '    <td> $ '.$dt->curent.'</td>';//curent
            echo '</tr>';
        }
      }
       ?>
     
    </table><!-- end table content--> 
                                     
 
                 