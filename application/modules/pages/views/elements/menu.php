<link rel="stylesheet"  href="<?php echo base_url('temp/default/home_site'); ?>/css/menuhead.css" />
<script src="<?php echo base_url('temp/default/home_site'); ?>/js/menuhead.js"></script>

<!-- Fixed navbar -->
<nav class="navbar navbar-expand-lg fixed-top bg-custom" id="navbar" aria-label="Tenth navbar example">
    <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse my-2" id="navbarsExample08">
        <ul class="navbar-nav justify-content-end w-100" >
            <li class="nav-item mx-3">
                <a class="nav-link active" aria-current="page" href="<?php echo base_url();?>">HOME</a>
            </li>
            <li class="nav-item  mx-3">
                <a class="nav-link" aria-current="page" href="<?php echo base_url('aboutus');?>">ABOUT US</a>
            </li>
            <li class="nav-item  mx-3">
                <a class="nav-link" aria-current="page" href="<?php echo base_url('advertiser');?>">ADVERTISER</a>
            </li>
            <li class="nav-item  mx-3">
                <a class="nav-link" aria-current="page" href="<?php echo base_url('publisher');?>">PUBLISHER</a>
            </li>
        </ul>
        <div class="w20 text-center d-none d-lg-block">
            <a class="navbar-brand d-none d-lg-block px-lg-6 w20"  href="<?php echo base_url();?>">                    
            <img id="logo" src="https://wedebeek.com/upload/files/logo.png"/>
            </a>
            <div class="mt-2" id="text-brand-lg">Wedebeek</div>
        </div>
        <ul class="navbar-nav justify-content-start w-100">
            <li class="nav-item  mx-3">
                <a class="nav-link" href="<?php echo base_url('products');?>">PRODUCTS </a>
            </li>
            <li class="nav-item  mx-3">
                <a href="<?php echo base_url('contact');?>" class="nav-link ">CONTACT</a>
            </li>
            <li class="nav-item  mx-3 menu-login">
                <a class="nav-link btn-login-menu" href="#" id="loginDropdown" role="button" onclick="toggleMenu(event, 'loginMenu')">LOGIN</a>
                <div id="loginMenu" class="dropdown-menu-custom" style="display: none;">
                    <a class="dropdown-item" href="<?php echo base_url('v2/sign/in'); ?>">PUBLISHER</a>
                    <a class="dropdown-item" href="<?php echo base_url('v3/sign/in'); ?>">ADVERTISER</a>
                </div>
            </li>

            <li class="nav-item mx-3 menu-signup">
                <a class="nav-link btn-signup-menu" href="#" id="signupDropdown" role="button" onclick="toggleMenu(event, 'signupMenu')">SIGN UP</a>
                <div id="signupMenu" class="dropdown-menu-custom" style="display: none;">
                    <a class="dropdown-item" href="<?php echo base_url('v2/sign/up'); ?>">PUBLISHER</a>
                    <a class="dropdown-item" href="<?php echo base_url('v3/sign/up'); ?>">ADVERTISER</a>
                </div>
            </li>
        </ul>
    </div>
    </div>
</nav>