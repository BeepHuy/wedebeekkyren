<script src="<?php echo base_url();?>temp/default/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>temp/default/css/jquery-ui.css"/>
	<script>
	$(function() {
        $( "#startdate" ).datepicker({dateFormat: "yy-mm-dd"});
		//$( "#startdate" ).datepicker( "option", "dateFormat","yy-mm-dd");
        $( "#enddate" ).datepicker({dateFormat: "yy-mm-dd"});
       // $( "#enddate" ).datepicker("option", "dateFormat","yy-mm-dd");

       //check all
       $('#checkAll').click(function () {
            $('.tbdata_check input:checkbox').prop('checked', this.checked);
        });
        /*//action click
        $('.action_clk button').click(function(){
            alert($('.form_lead').serialize());
        })
        */


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
               .inputrepr label{width:90px;display:inline-block;font-size:small;color:#151390}
               .inputrepr{margin-right: 40px;}
               </style>
                <div class="col-md-12">
                   <form class="form-inline" method="post" role="form" action="<?php echo base_url('mng_report/filtdata');?>">

                    <br />

                       <span class="inputrepr"><label>Start Date</label> <input id="startdate" type="text" name="from" value="<?php if($this->session->userdata('from')){echo $this->session->userdata('from');}?>" /></span>
                       <span class="inputrepr"><label>End Date</label> <input id="enddate" type="text" name="to"  value="<?php if($this->session->userdata('to')){echo $this->session->userdata('to');}?>" /></span>
                       <select class="form-control input-sm stat" name="status">
                            <option value="all">All</option>
                            <option value="1">Pending </option>
                            <option value="2">Declined</option>
                        </select>
                       <hr/>
                        <span class="inputrepr"><label>Campaign Id</label> <input name="offerid" type="text" value="<?php echo $this->session->userdata('offerid')?>" /></span>
                        <span class="inputrepr"><label>Publisher Id</label> <input name="userid" type="text" value="<?php echo $this->session->userdata('userid')?>" /></span>
                        <!--span class="inputrepr"><label>Payout ></label> <input name="amount2" type="text" value="<?php echo $this->session->userdata('amount2')?>" /></span>
                        <span class="inputrepr"><label>FraudScore ></label> <input name="fraud_score" type="text" value="<?php echo $this->session->userdata('fraud_score')?>" /></span-->
                        <span class="label label-success">Group by Offers:</span>
                        <div class="checkbox">
                            <label>
                            <input type="checkbox" name="group_oid" <?php if($this->session->userdata('group_oid'))echo 'checked'; ?> value="1"  >
                            </label>
                        </div>

                        <div class="col-md-2 pull-right">
                            <button type="submit" name="submit" value="1" class="btn btn-primary btn-sm ">Submit</button>
                            <button type="submit" name="reset" value="1" class="btn btn-warning btn-sm ">Reset</button>
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

                    $('.stat').val(<?php echo $this->session->userdata('status') ?>);

                })

                </script>


                <form class="form_lead" method="post" action="<?php echo base_url('mng_report/rvdata');?>">
                <?php
                $tb= $this->session->userdata('updatedone');
                    if($tb){
                        echo $tb;
                        $this->session->unset_userdata('updatedone');
                    }
                ?>
           <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>OfferId</th>
                        <th>Offers</th>
                        <th>UsersId</th>
                        <th>Click</th>
                        <th>Lead</th>
                        <th>Unique</th>
                        <th>Cr</th>
                        <th>Earning</th>

                    </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($dulieu)){

                   foreach($dulieu as $dulieu){
                       echo ' <tr>';
                       echo '    <td>'.$dulieu->offerid.'</td>';
                       echo '    <td>'.$dulieu->oname.'</td>';
                       echo '    <td>'.$dulieu->userid.'</td>';
                       echo '    <td>'.$dulieu->click.'</td>';
                       echo '    <td>'.$dulieu->lead.'</td>';
                       echo '    <td>'.$dulieu->uniq.'</td>';
                       echo '    <td>'.round($dulieu->pay/$dulieu->uniq,2).'</td>';
                       echo '    <td> $'.round($dulieu->pay,2).'</td>';
                       echo '</tr>';
                   }
                }
                ?>

                </tbody>
            </table>
            <div class="col-md-2 1pull-right action_clk">
                <button type="submit" name="action" value="approved" class="btn btn-success btn-sm " disabled >Approved</button>
                <button type="submit" name="action" value="declined" class="btn btn-danger btn-sm " disabled >Declined</button>
            </div>

            </div>
            </form>
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
                        <?php echo $this->pagination->create_links();
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
