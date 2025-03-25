<script src="<?php echo base_url();?>/temp/default/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/temp/default/css/jquery-ui.css"/>
	<script>
	$(function() {	   
        $( "#startdate" ).datepicker({dateFormat: "yy-mm-dd"});
		//$( "#startdate" ).datepicker( "option", "dateFormat","yy-mm-dd");
        $( "#enddate" ).datepicker({dateFormat: "yy-mm-dd"});
       // $( "#enddate" ).datepicker("option", "dateFormat","yy-mm-dd");        
	});
	</script>
 <style>
 .rp_fitter{width:640px;margin: 10px auto;}
 </style>
 
<div class="row">
    <div class="box col-md-12">
        <div data-original-title="" class="box-header">
            <h2><i class="glyphicon glyphicon-signal"></i><span class="break"></span>Report</h2>
            <div class="box-icon">
               <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
            
            
               <style>
               .inputrepr label{width:80px;display:inline-block;font-size:small;color:#151390}
               .inputrepr{margin-right: 50px;}
               </style>
                <div class="col-md-12">
                   <form class="form-inline" method="post" role="form">
                    <label>
                    <span class="label label-success">Publisher</span>
                      <input name="pubcheck" class="vpub" type="checkbox" value="1" <?php if($this->session->userdata('pubcheck'))echo 'checked';?>/> 
                    </label>
                    <br />
                   
                       <span class="inputrepr"><label>Start Date</label> <input id="startdate" type="text" name="from" value="<?php if($this->session->userdata('from')){echo $this->session->userdata('from');}?>" /></span>
                       <span class="inputrepr"><label>End Date</label> <input id="enddate" type="text" name="to"  value="<?php if($this->session->userdata('to')){echo $this->session->userdata('to');}?>" /></span>
                        <hr/>
                        <span class="form-group col-md-2">
                            <label>Pub Id</label> 
                            <input  class="form-control input-sm" name="pubid" type="text" value="<?php echo $this->session->userdata('pubid')?>" /></span>
                      
                       <span class="form-group col-md-2"> 
                            <label>Offer Id </label> 
                            <input  class="form-control input-sm" name="oid" type="text"  value="<?php echo $this->session->userdata('oid')?>" /></span>
                       <span class="form-group col-md-2"> 
                            <label>Sub2 </label> 
                            <input class="form-control input-sm" name="s2" type="text"  value="<?php echo $this->session->userdata('s2')?>" />
                       </span> 
                       
                       <span class="form-group"> 
                            <label>Net ID </label> 
                            <select class="form-control input-sm" name="idnet">
                                <option value="">All</option>
                                <?php
                                    $net = $this->Home_model->get_data('network',array(),array(),array('title','ASC'));
                                    foreach($net as $net){
                                        $selected = $this->session->userdata('idnet') == $net->id?'selected':'';
                                        echo "
                                            <option $selected value='$net->id'> $net->title </option>                                        
                                        ";
                                    }
                                ?> 
                            </select>                           
                       </span>
                       <div class="form-group">
                            <label>Filter</label>
                            <select class="form-control input-sm" name="status">
                                <option value="all">All</option>
                                <option <?php echo $this->session->userdata('status')==1?'selected':''?> value="1">Pending </option>
                                <option <?php echo $this->session->userdata('status')==3?'selected':''?> value="3">Pay</option>
                                <option <?php echo $this->session->userdata('status')==2?'selected':''?> value="2">Declined</option>
                            </select>
                        </div>
                       <div class="col-md-2 pull-right">
                            <button type="submit" name="submit" class="btn btn-primary btn-sm ">Submit</button>
                            <button type="submit" name="reset" value="1" class="btn btn-warning btn-sm ">Reset</button>
                            <button type="submit" name="export" value="1" class="btn btn-info btn-sm ">Export Excel</button>
                        </div>
                        <hr />
                      
                  </form>
                   
                   </div>              
                <div class="col-md-12">
                    <!--
                    <a class="timkiem btn btn-danger" href="<?php echo base_url().$this->config->item('admin').'/export/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);?>" target="_blank">Export</a>
                  -->
                </div>  
                <div class="col-md-12">
                    
                <script>
                $(document).ready(function(){
                    if($(".vpub").is(':checked'))
                    $('.checkpub').show();
                    
                })
                
                </script>
                
               
           
            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>Date</th>
                        <th>Offers</th>
                        <th>OfferId</th>                                                
                        <th style="display: none;" class="checkpub">Publisher</th>
                        <?php 
                        if( $this->session->userdata('s2')) echo '<th>Sub2</th>';
                        if( $this->session->userdata('idnet')) echo '<th>Idnet</th>';
                        if( $this->session->userdata('status')) echo '<th>Status</th>';
                        ?>
                        <th>Click</th>
                        <th>Lead</th>  
                        <th>Unique</th>                          
                        <th>Cr</th>   
                        <th>Earning</th>    
                        
                    </tr>
                </thead>
                <tbody>
                <?php 
                $total = 0;
                if(!empty($dulieu)){ 
                    //lấy pubname
                    foreach ($dulieu as $dt1){
                        $m[] = $dt1->userid;
                    }
                    if(!empty($m)){
                        $this->db->select(array('email','id'));
                        $this->db->where_in('id',$m);
                        $u = $this->db->get('users')->result();
                        if(!empty($u)){
                            foreach($u as $u){
                                $muser[$u->id] = $u->email;
                            }
                        }
                    }
                    //
                    
                   foreach($dulieu as $dulieu){  
                       $total +=$dulieu->pay;
                       echo ' <tr>';
                       echo '    <td>'.date('d-m-Y',strtotime($dulieu->date)).'</td>';
                       echo '    <td>'.$dulieu->oname.'</td>';
                       echo '    <td>'.$dulieu->offerid.'</td>';
                       echo '    <td style="display: none;" class="checkpub">'.@$muser[$dulieu->userid].' (<i><b>'.$dulieu->userid.'</b></i>)</td>';
                       if( $this->session->userdata('s2')) echo '    <td>'.$dulieu->s2.'</td>';
                       if( $this->session->userdata('idnet')) echo '    <td>'.$dulieu->idnet.'</td>';
                       if( $this->session->userdata('status')) echo '    <td>'.$dulieu->status.'</td>';
                       echo '    <td>'.$dulieu->click.'</td>';
                       echo '    <td>'.$dulieu->lead.'</td>';
                       echo '    <td>'.$dulieu->uniq.'</td>';
                       echo '    <td>'.round($dulieu->pay/$dulieu->uniq,2).'</td>';
                       echo '    <td>$'.round($dulieu->pay,2).'</td>';
                       echo '</tr>';
                   }
                }
                ?>
                    
                </tbody>
            </table>
            Total: <?php echo round($total,2);?> $
            </div> 
            <div class="row">
                <!--div class="col-md-12">
                    Showing 1 to 10 of 32 entries
                </div--->
                
                <div class="col-md-6">
                    <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3);?>" name="filter_cat" size="1" class="form-control input-sm">
                            <option value="0">all</option>
                            <?php 
                                if(!empty($category)){
                                    $where = $this->session->userdata('where');
                                   
                                    foreach($category as $category1){
                                        echo '
                                            <option value="'.$category1->id.'"';
                                            if(!empty($where['manager'])){
                                                echo $where['manager']==$category1->id?' selected':'';
                                            }                                                
                                            echo '>'.$category1->title.'</option>
                                        ';
                                    }
                                }
                                ?>
                        </select>
                        <label></label>                                            
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class=" pagination">                       
                        <?php //echo $this->pagination->create_links();
                        ?>     
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div>
<!-- phan modal--->

<!-- Large modal -->


<!--end modal--->
