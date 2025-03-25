<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-phone-alt"></i><span class="break"></span>Manager</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/add/';?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group form-inline filter">                                                        
                        <select title="<?php echo $this->uri->segment(3);?>" name="show_num" size="1" class="form-control input-sm">
                        <?php 
                            $limit = $this->session->userdata('limit');
                            for($i=1;$i<11;$i++){
                                echo '
                                <option value="'.$i*(10).'"';
                                echo $i*(10)==$limit['0']?' selected="selected"':'';
                                echo 
                                '>'.$i*(10).'</option>
                                ';
                            }
                            ?>
                        </select>
                        <label>records per page</label>                                            
                    </div>
                </div>
                
            </div>
               <?php $mcategory['0']->title= 'none';?>  
                <?php 
                    if(!empty($dulieu)){
                        //ger mangr name
                            $marrmg[0] = '';
                            foreach($dulieu as $dt1){
                                $marrmg[$dt1->id] = $dt1->name;
                            }
                            $tbadmin = $tbmanager = $tbsub='';
                            foreach($dulieu as $dulieu){  
                                $bien = $tdmanager=''; 
                                if($dulieu->id ==1){
                                    $bien = 'tbadmin';                                    
                                }elseif($dulieu->parrent ==0){
                                    $bien = 'tbmanager';                                    
                                }elseif($dulieu->id >0){
                                    $bien = 'tbsub';
                                    $tdmanager ='<td><b>'.$marrmg[$dulieu->parrent].'</b></td>';
                                }
                                $$bien .=
                                '<tr>
                                    <td>'.$dulieu->id.'</td>
                                    <td><img src="'.$dulieu->images.'" width="50px" height="50px"/></td>
                                    <td>'.$dulieu->name.'</td>
                                    <td>'.$dulieu->username.'</td>
                                    '.$tdmanager.'
                                    <td>'.$dulieu->email.'</td>
                                    <td>'.$dulieu->phone.'</td>
                                    <td>'.$dulieu->aim.'</td>
                                    <td>'.$dulieu->skype.'</td>
                                    
                                    <td>
                                        <a href="'.base_url().$this->config->item('admin').'/viewmng/'.$dulieu->id.'" class="btn btn-success btn-xs" target=_blank>
                                            <i class="glyphicon glyphicon-eye-open glyphicon-white"></i>                                            
                                        </a>
                                        <!--edit>>>-->
                                        <a href="'.base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/edit/'.$dulieu->id.'" class="btn btn-info btn-xs">
                                        <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>                                            
                                        </a>
                                        <!--delete>>>-->
                                        <a href="'.base_url().$this->config->item('admin').'/route/'.$this->uri->segment(3).'/delete/'.$dulieu->id.'" class="btn btn-danger btn-xs">
                                        <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i> 
                                        </a>
                                    </td>
                                </tr> ';
                            }
                    }
                ?>
            <h4>Admin</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Images</th>
                        <th>name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>AIM</th> 
                        <th>Skype</th>                     
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $tbadmin;?>                    
                </tbody>
            </table>
            <hr/>
            <h4>Manager</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Images</th>
                        <th>name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>AIM</th> 
                        <th>Skype</th>                     
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $tbmanager;?>                    
                </tbody>
            </table>
            <hr/>
            <h4>Sub Manager</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Images</th>
                        <th>name</th>
                        <th>Username</th>
                        <th>Manager</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>AIM</th> 
                        <th>Skype</th>                     
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $tbsub;?>                    
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
                        <?php echo $this->pagination->create_links();?>     
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div>
