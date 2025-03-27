<?php
$version = $this->uri->segment(1); // Lấy phiên bản từ URL
$profile_link = base_url("$version/profile");
$logout_link = base_url("$version/logout");

// Xác định sidebar phù hợp
$sidebar = ($version == 'v2' && $this->session->userdata('userid')) ? 'sidebar.php' : (($version == 'v3' && $this->session->userdata('advid')) ? 'advsidebar.php' : '');
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <title><?php echo $this->pub_config['sitename']; ?></title>
   <link rel="shortcut icon" href="<?php echo base_url(); ?>/upload/favicon.png" type="image/x-icon">
   <!-- Bootstrap core CSS -->
   <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>/temp/default/css/style.css" rel="stylesheet">
   <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js"></script>
</head>

<body>
   <div class="mask_mbnav" id="anhienmenu"></div>
   <header class="mb-3 border-bottom navbar-dark fixed-top topmenu">
      <div class="container-fluid d-flex align-items-center justify-content-between">
         <button type="button" class="button_mb_nav-d d-none" data-bs-toggle="collapse" data-bs-target="#anhienmenu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <line x1="3" y1="12" x2="21" y2="12"></line>
               <line x1="3" y1="6" x2="21" y2="6"></line>
               <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
         </button>
         <a href="<?php echo base_url($version); ?>" class="d-flex align-items-center text-dark text-decoration-none col-6 logo_img_wrap">
            <img src=" <?php echo base_url() ?>/upload/files/logo.png" alt="Logo" class="logo">
         </a>
         <div class="nav_u_profil me-4 pe-1">
            <div class="dropdown d-lg-block m-auto col-1 mx-3 d-flex d-row">
               <button class="btn btn-sm btn-primary dropdown-toggle fs-6" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo "{$this->member->email} ({$this->member->id})"; ?>
               </button>
               <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser1">
                  <li><a class="dropdown-item" href="<?php echo $profile_link; ?>">Profile</a></li>
                  <li><a class="dropdown-item" href="<?php echo $logout_link; ?>">Sign out</a></li>
               </ul>
            </div>
         </div>
      </div>
   </header>

   <main>
      <!-- Sidebar -->
      <?php if ($sidebar) include($sidebar); ?>
      <!-- End Sidebar -->

      <div class="container-fluid overflow-auto mx-2 mt-5">
         <!-- vdashboard -->
         <?php if (!empty($content)) echo $content; ?>
         <!-- end vdashboard -->
      </div>
   </main>

   <script src="<?php echo base_url(); ?>temp/default/js/bootstrap.min.js"></script>
   <script src="<?php echo base_url(); ?>temp/default/js/bootstrap.bundle.min.js"></script>
</body>

</html>