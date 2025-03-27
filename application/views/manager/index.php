<?php session_start();
   $_SESSION['upanh'] = $this->session->userdata('upanh');
   $_SESSION['url'] = '/upload/';
   /// xu ly phan mail lien he
   $lienhemoi = $this->db->where('trangthai',0)->get('contact')->num_rows();
   if(empty($lienhemoi)){
       $lienhecu = $this->db->where('trangthai',1)->get('contact')->num_rows();    
   }
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
      <meta name="viewport" content="width=device-width, initial-scale=1"/>
      <title>adminmmo</title>
      <!-- Bootstrap -->
      <link href="<?php echo base_url();?>temp/admin/css/bootstrap.min.css" rel="stylesheet"/>
      <link href="<?php echo base_url();?>temp/admin/css/bootstrap-theme.min.css" rel="stylesheet"/>
      <link href="<?php echo base_url();?>temp/admin/css/style.css" rel="stylesheet"/>
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- dat truoc vai gia tri ban dau-->    
      <script>
         var base_url = "<?php echo base_url();?>";
         var adminurl = "<?php echo base_url($this->config->item('manager'));?>/";
         var order = new Array(); 
         <?php $order = $this->session->userdata('order');?>
         order['0'] ="<?php echo @$order['0'];?>";
         order['1'] ="<?php echo @$order['1'];?>";
      </script>
      <!-- thay vao truong id-->  
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="<?php echo base_url();?>temp/admin/js/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="<?php echo base_url();?>temp/admin/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url();?>temp/admin/js/tooltip.js"></script>
   </head>
   <body>
      <!---------------------------------------------------------top menu----------------------------------------->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
         <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#anhien">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#">
               <img alt="" class="pull-left" src="<?php echo $this->session->userdata('adavata');?>"/>
               <span class="pull-left hidden-xs">
                  <?php echo isset($this->pub_config['sitename']) ? $this->pub_config['sitename'] : 'Default Site Name'; ?>
               </span>

               </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="anhien">
               <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown hidden-xs parentli">
                     <a href="<?php echo base_url();?>" class="btn dropdown-toggle">
                     <i style="color: blue;" class="glyphicon glyphicon-eye-open"></i> 
                     <span class="label label-warning hidden-xs">viewsite</span>
                     </a>
                  </li>
                 
                  <!--li class="parentli">
                     <a href="#" class="dropdown-toggle btn-setting" data-toggle="dropdown">
                     <i class=" glyphicon glyphicon-wrench"></i>
                     </a>
                  </li-->
                  <li class="parentli">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>                     
                        
                     </a>
                  </li>
                  <li><a href="<?php echo base_url($this->config->item('manager'));?>/logout"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container-fluid -->
      </nav>
      <!---------------------end top menu-------------------------------------------------------------------->
      <div class="container-fluid wrapper1">
         <div class="row">
            <!--menu left--->
            <?php 
            if($this->users->parrent==0){
               include('left_menu.php');
            }elseif($this->users->parrent>0){
               include('left_menu_sub.php');
            }
            
            ?>
            <!--end menu left---->
            <div class="col-sm-11 col-xs-11 col-md-10 noidung">
               <ul class="breadcrumb">
                  <li>
                     <a href="#">Home</a> <span class="divider">/</span>
                  </li>
                  <li>
                     <a href="#">Tables</a>
                  </li>
               </ul>
               <hr/>
               <!--------------------noi dung admin-------------------------------------------------->
               <?php if(!empty($content)){ echo $content; 
                  }?>    
               <!--------------------------end noi dung admin-------------------------------------------->     
            </div>
            <!--modal user------------------------------------->
            <div style="margin-top: 40px;" class="modal fade userview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Affiliate </h4>
                     </div>
                     <div class="modal-body cusermodal">
                     </div>
                  </div>
               </div>
            </div>
            <!--end modal user--------------------------------->
         </div>
         <!-- Modal SETTING -->
         
         <!--end modal--->
         <!--modal smartlink-->
      <div class="modal fade" id="smartlink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                     <h4 class="modal-title" id="myModalLabel">Smartlink</h4>
                  </div>
                  <div class="modal-body">
                     <!--form --->
                     <form class="form-horizontal form_smartlink" role="form" id="form_smartlink">
                        <div class="form-group">
                           <div class="col-sm-4" style="padding-right: 5px;">
                              <div class="input-group">
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-send"></span></span>
                                 <?php 
                                    $smlink = unserialize(file_get_contents("setting_file/smartlink.txt"));
                                 ?>
                                 <select class="form-control" id="atcsm" name="type">
                                    <option value="0">Off</option>
                                    <option value="1" <?php if($smlink['type']==1) echo 'selected';?>>Redirect</option>
                                    <option value="2" <?php if($smlink['type']==2) echo 'selected';?>>Custom link</option>
                                 </select>
                              </div>
                           </div>
                           <label for="atcsm" class="col-sm-3 control-label" style="padding-left: 0px;"><span class="label label-primary">Smartlink Type</span></label>                           
                        </div>

                        <div class="form-group chide">
                           <div class="col-sm-4" style="padding-right: 5px;">
                              <div class="input-group">
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-random"></span></span>                                
                                 <select class="form-control" id="network" name="network">
                                    <?php
                                       $network=$this->Home_model->get_data('network',array('show'=>1));
                                       if($network){
                                          foreach($network as $network){
                                             if($smlink['network']==$network->id){
                                                $sl = "selected";
                                             }else{
                                                $sl='';
                                             }
                                             echo '
                                             <option '.$sl.' value="'.$network->id.'">'.$network->title.'</option>
                                             ';
                                          }
                                       }
                                    ?>
                                    
                                 </select>
                              </div>
                              
                           </div>
                           
                           <div class="col-sm-4">
                              <div class="input-group">
                                 <span class="input-group-addon">%</span>
                                 <input type="text" class="form-control" id="percent" placeholder="Percent" value="100" name="percent">
                              </div>
                           </div>
                           <label for="percent" class="col-sm-2 control-label"><span class="label label-info">Network - Percent</span></label>
                        </div>                      


                        <div class="form-group chide">
                           <div class="col-sm-10">
                              <div class="input-group">
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                 <input type="text" class="form-control" id="smlink" placeholder="Sitename" value="<?php if($smlink['smlink'])echo $smlink['smlink'] ?>" name="smlink"/>
                              </div>
                           </div>
                           <label for="smlink" class="col-sm-2 control-label"><span class="label label-success">Smartlink</span></label>
                        </div>  
                     </form>
                     <!--end form -->
                  </div>
                  <div class="modal-footer">                    
                     <button type="button" class="btn btn-primary" id="smartlink_save">Save changes</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
      
         <!--end modal smartlink-->
      </div>

      <!-- end div containẻ-->
         <!--------en noi dung----------------------->
      <!--footer----------------------------------->
      <footer class="footer">
         <div class="container-fluid">
            <p class="text-muted">Wedebeek.com</p>
            <span style="text-align:left;float:left">&copy; <a href="" target="_blank">creativeLabs</a> 2015</span>
         </div>
      </footer>
      <?php
         echo '
          <!--ckeditor-->
         <script type="text/javascript" src="'.base_url().'ckeditor/ckeditor.js"></script>
         <script type="text/javascript" src="'.base_url().'ckeditor/ckfinder/ckfinder.js"></script>
         <script type="text/javascript" src="'.base_url().'temp/admin/js/ck_type.js"></script>
         ';
         if($this->uri->segment(3)=='network'){
           echo '
           <script type="text/javascript" src="'.base_url().'temp/admin/js/network_edit.js"></script>
           ';
         }
         ?>
      <script type="text/javascript" src="<?php echo base_url();?>temp/manager/js/custom.js?v=1">//chua chuyen sang</script>   
   </body>
</html>