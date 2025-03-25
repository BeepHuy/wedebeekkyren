<!-- hien thi giong publisher--->
<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-inbox"></i><span class="break"></span>Credit</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/add/';?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-inline filter">                                                        
                       
                        <label>records per page</label>                                            
                    </div>
                </div>
                <!--form class="form-inline col-md-6" role="form">
                    <label>Search: 
                    <input class="form-control input-sm" type="text"/></label>
                    <button type="submit" class="btn btn-default input-sm">Sign in</button>
                </form-->
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>Id</th>
                        
                        <th>Offer</th>
                        <th>Click</th>
                        <th>Unique</th>
                        <th>Leads</th>
                        <th>Total</th>    
                        <th>Conversion</th>   
                        <th>Avg. CPA</th> 
                        <th>EPC</th>                    
                        
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($dulieu)){
                            foreach($dulieu as $dulieu){?>    
                    <tr>
                        <td><?php echo $dulieu->offerid;?></td>                        
                        <td><?php echo $dulieu->oname;?></td>
                        <td><?php echo $dulieu->click;?></td>
                        <td><?php echo $dulieu->uniq;?></td>
                        <td><?php echo $dulieu->lead;?></td>
                        <td>$<?php echo round($dulieu->pay,2);?></td>                       
                        <td><?php echo round(100*$data->lead/$data->uniq,2);?></td> 
                        <td><?php echo round($data->pay/$data->uniq,2);?></td>   
                        <td><?php if($data->lead){echo  round($data->pay/$data->lead,2);}else{echo  0.00;}?></td>   
                      
                    </tr>
                    <?php    }
                        }
                        ?>
                    
                </tbody>
            </table>
            <div class="row">
                <!--div class="col-md-12">
                    Showing 1 to 10 of 32 entries
                </div--->
                
                <div class="col-md-6">
                    <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3);?>" name="filter_cat" size="1" class="form-control input-sm">
                            <option value="0">all</option>
                          
                        </select>
                        <label></label>                                            
                    </div>
                </div>
                <div class="col-md-6">
                   
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div>
