<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <title><?php echo $this->pub_config['sitename'];?></title>
      <link rel="shortcut icon" href="<?php echo base_url();?>/upload/favicon.png" type="image/x-icon">
      <!-- Bootstrap core CSS -->
      <link href="<?php echo base_url();?>temp/default/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="<?php echo base_url();?>/temp/default/css/style.css" rel="stylesheet">
      <script src="<?php echo base_url();?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript"></script>
      <meta name='ir-site-verification-token' value='- 296595'>
   </head>
   <body>
   <div class="mask_mbnav" id="anhienmenu"></div>
   <header class="mb-3 border-bottom navbar-dark fixed-top topmenu">
         <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
               <button type="button" class="button_mb_nav-d d-none"  data-bs-toggle="collapse" data-bs-target="#anhienmenu">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                     <line x1="3" y1="12" x2="21" y2="12"></line>
                     <line x1="3" y1="6" x2="21" y2="6"></line>
                     <line x1="3" y1="18" x2="21" y2="18"></line>
                  </svg>
               </button>
               <a href="<?php echo base_url('v2');?>" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none col-6 logo_img_wrap">
               <img src="<?php echo $this->pub_config['logo'];?>" alt="Logo" class="logo">
               </a>
               <div class="nav_u_profil me-4 pe-1">
                  <div class="dropdown d-lg-block m-auto col-1 mx-3 d-flex d-row">
                      
                     <button class="btn btn-sm btn-primary d-block dropdown-toggle fs-6" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                       <?php echo $this->member->email .' ('.$this->member->id.')';?>
                     </button>
                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser1" style="right:0px !important">
                        <li><a class="dropdown-item" href="<?php echo base_url('v2/profile/profile');?>">Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('v2/logout');?>">Sign out</a></li>
                     </ul>

             
  
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!--nav class="navbar navbar-expand-md navbar-dark fixed-top topmenu">
         <div class="container-fluid">
            <img src="http://wedebeek.com/upload/files/logo.png" alt="Logo" class="logo">
         </div>
         
         </!--nav-->
      <main>
         <!-- sidebar-->
         <?php 
         if($this->session->userdata('userid')){
            include('sidebar.php');
         }
         ?>
         <!-- end sidebar-->
         <div class="container-fluid  overflow-auto mx-2 mt-5">
            <!-- vdashboard--->
            <?php 
               if(!empty($content))echo $content;
               ?>
            <!--end vdashboard--->
         </div>
      </main>
      <script src="<?php echo base_url();?>temp/default/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url();?>temp/default/js/bootstrap.bundle.min.js"></script>
      
      
   </body>
</html>