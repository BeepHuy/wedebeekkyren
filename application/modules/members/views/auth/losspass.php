<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<title>Authorization</title>
	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url();?>temp/default/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="<?php echo base_url();?>/temp/default/css/login.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<!-- Animate CSS for animations -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
	<!-- WOW JS for scroll animations -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script src="<?php echo base_url();?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript"></script>
	<link rel="stylesheet"  href="<?php echo base_url('temp/default/home_site');?>/css/style.css"/>
	<link rel="stylesheet"  href="<?php echo base_url('temp/default/home_site');?>/css/lightslider.css"/>
	<link rel="stylesheet"  href="<?php echo base_url('temp/default/pages');?>/css/style.css"/>   
	<style>
		:root {
			--primary-color: rgb(29, 64, 92);
			--secondary-color: rgb(45, 125, 179);
		}

		body {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
			background: linear-gradient(135deg, #f5f7fa 0%, #e4ecf7 100%);
			padding-top: 80px; /* Added for fixed header */
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}

		.dot {
			display: inline-block;
			width: 14px;
			height: 14px;
			margin: 0 8px;
			border-radius: 50%;
			background-color: var(--primary-color);
			animation: dot-pulse 1.4s infinite ease-in-out;
		}

		.dot:nth-child(1) { animation-delay: -0.32s; }
		.dot:nth-child(2) { animation-delay: -0.16s; }

		@keyframes dot-pulse {
			0%, 80%, 100% { transform: scale(0); }
			40% { transform: scale(1); }
		}

		/* Main content styling */
		.kFfNqn {
			padding: 30px 20px;
			flex: 1;
		}

		.cIUDWQ {
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.eVigII {
			background-color: white;
			border-radius: 24px;
			box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
			padding: 40px;
			position: relative;
			overflow: hidden;
			border: none;
			animation: fadeIn 0.5s ease-out;
			max-width: 450px !important;
			width: 100% !important;
		}

		.eVigII::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			height: 6px;
			background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
			border-radius: 3px;
		}

		.iApbYG {
			width: 180px !important;
			margin-bottom: 15px !important;
			border-radius: 10px;
		}

		.cnxHgy {
			color: var(--primary-color);
			font-weight: 500;
			margin-bottom: 30px !important;
			letter-spacing: 0.3px;
			font-size: 16px;
			text-transform: none;
		}

		.ioyCcs {
			width: 100%;
		}

		.kFPdwr {
			width: 100%;
		}

		.xzcRZ {
			margin-bottom: 25px;
		}

		.resetpass {
			font-weight: 400;
			margin-bottom: 15px !important;
			color: #555 !important;
			font-size: 14px !important;
			font-family: inherit;
		}

		.jxLAT {
			height: 56px;
			border-radius: 18px !important;
			border: 1.5px solid #e0e6ed !important;
			transition: all 0.3s;
			width: 100%;
			padding: 10px 20px !important;
			font-size: 14px !important;
			box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03) !important;
			font-family: inherit;
		}

		.jxLAT:focus {
			border-color: var(--secondary-color) !important;
			box-shadow: 0 0 0 4px rgba(45, 125, 179, 0.15) !important;
			outline: none;
		}

		.jaHTXm {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-top: 35px !important;
			gap: 20px !important;
		}

		.btn_signin {
			background-color: var(--primary-color) !important;
			border: none !important;
			padding: 16px 30px !important;
			border-radius: 30px !important;
			font-weight: 500;
			letter-spacing: 0.5px;
			box-shadow: 0 8px 20px rgba(29, 64, 92, 0.25) !important;
			transition: all 0.3s !important;
			color: white !important;
			width: auto !important;
			min-width: 160px !important;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 14px !important;
			font-family: inherit;
		}

		.btn_signin:hover {
			background-color: var(--secondary-color) !important;
			transform: translateY(-3px);
			box-shadow: 0 12px 25px rgba(29, 64, 92, 0.35) !important;
		}

		.btn_signin:active {
			transform: translateY(0);
		}

		._3kiCWIsiMrRqCXneU8Asq6 {
			position: relative;
		}

		._3axrJUuPR6Tfk-J1aQF4dm {
			display: flex;
			align-items: center;
			font-size: 14px !important;
			white-space: nowrap;
		}

		._3axrJUuPR6Tfk-J1aQF4dm::before {
			content: '\f0c1';
			font-family: 'Font Awesome 6 Free';
			font-weight: 900;
			margin-right: 10px;
			font-size: 14px;
		}

		.gPtJgO {
			color: var(--primary-color);
			text-decoration: none;
			font-weight: 500;
			transition: all 0.3s;
			display: flex;
			align-items: center;
			font-size: 14px !important;
			padding: 10px 15px;
			border-radius: 30px;
			white-space: nowrap;
		}

		.gPtJgO:hover {
			color: var(--secondary-color);
			background-color: rgba(29, 64, 92, 0.05);
		}

		.gPtJgO::before {
			content: '\f060';
			font-family: 'Font Awesome 6 Free';
			font-weight: 900;
			margin-right: 8px;
		}

		/* Google Maps container */
		.wrap {
			margin-top: 40px;
			margin-bottom: 40px;
			border-radius: 16px;
			overflow: hidden;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
		}

		/* Custom slide in animation */
		@keyframes slideInRightMD {
			from {
				transform: translate3d(5%, 0, 0);
				opacity: 0;
			}
			to {
				transform: translate3d(0, 0, 0);
				opacity: 1;
			}
		}

		.slideInRightMD {
			animation-name: slideInRightMD;
			animation-duration: 1s;
		}

		/* Footer styling */
		.hbyzzN {
			padding: 25px;
			color: #666;
			text-align: center;
			margin-top: auto;
			font-size: 14px;
		}

		.fPkDMs, .hbyzzN a {
			color: var(--primary-color);
			text-decoration: none;
			transition: color 0.3s;
			padding: 5px;
			border-radius: 15px;
		}

		.fPkDMs:hover, .hbyzzN a:hover {
			color: var(--secondary-color);
			background-color: rgba(29, 64, 92, 0.05);
		}

		.dAZhcd {
			margin-top: 15px;
		}

		.dAZhcd a {
			margin: 0 10px;
			display: inline-flex;
			align-items: center;
			padding: 8px 15px;
			border-radius: 20px;
			transition: all 0.3s;
		}

		.dAZhcd a:hover {
			background-color: rgba(29, 64, 92, 0.08);
			transform: translateY(-2px);
		}

		.dAZhcd a:first-child::before {
			content: '\f0e1';
			font-family: 'Font Awesome 6 Brands';
			margin-right: 8px;
		}

		.dAZhcd a:last-child::before {
			content: '\f09a';
			font-family: 'Font Awesome 6 Brands';
			margin-right: 8px;
		}

		/* Toast styling */
		#thongBao, #thongBao2 {
			border-radius: 20px;
			box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
			min-width: 300px;
			overflow: hidden;
		}
		.position-fixed.top-0.end-0.p-5 {
			top: 90px !important; /* Điều chỉnh để nằm dưới navbar */
		}
		#thongBao .toast-body {
			background-color: #d4edda;
			color: #155724;
			padding: 15px 20px;
			border-radius: 20px;
			display: flex;
			align-items: center;
		}

		#thongBao2 .toast-body {
			padding: 15px 20px;
			border-radius: 20px;
			display: flex;
			align-items: center;
		}

		.toastContent {
			display: inline-block;
			margin-left: 10px;
			font-size: 15px;
		}

		/* Responsive adjustments */
		@media (max-width: 576px) {
			.eVigII {
				padding: 30px 20px;
				max-width: 100% !important;
			}
			
			.jaHTXm {
				flex-direction: column;
				gap: 15px !important;
			}
			
			.btn_signin, .gPtJgO {
				width: 100% !important;
				justify-content: center;
				min-width: 0 !important;
			}
		}

		/* Animation */
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(10px); }
			to { opacity: 1; transform: translateY(0); }
		}

		/* Header background custom */
		.bg-custom {
			background-color: white !important;
			box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1) !important;
		}

		.btn-login-menu:hover {
			background-color: rgba(29, 64, 92, 0.08);
		}

		.btn-signup-menu:hover {
			background-color: var(--secondary-color) !important;
		}
        
        /* Hiện thị toast messages */
        .position-fixed.hide {
            display: block !important;
        }
	</style>
</head>
<body>
<!-- Navbar - Giữ nguyên HTML gốc của header -->
<nav style='font-size:16px' class="navbar navbar-expand-lg fixed-top bg-custom" id="navbar" aria-label="Tenth navbar example">
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
            <a class="navbar-brand d-none d-lg-block px-lg-6 w20"  href="./index.html">                    
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
                <a class="nav-link btn-login-menu" href="<?php echo base_url('v2/sign/in');?>">LOGIN</a>
            </li>
            <li class="nav-item  mx-3 menu-signup">
                <a class="nav-link btn-signup-menu" href="<?php echo base_url('v2/sign/up');?>">SIGN UP</a>
            </li>
        </ul>
    </div>
    </div>
</nav>

<div id="root">
    <!-- Main Content -->
    <main class="sc-fAjcbJ kFfNqn">
        <div class="sc-Rmtcm cIUDWQ">
            <div class="sc-bRBYWo eVigII" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 450px;">
                <!-- Logo và title -->
                <img src="<?php echo $this->pub_config['logo'];?>" class="sc-VigVT iApbYG" style="width: 300px; margin: 0 0 10px 0;">
                <span class="sc-jhAzac cnxHgy" style="text-align: center; margin: 0 0 30px 0;">Wedebeek Technology Limited</span>
                <!-- Form container -->
                <div class="sc-hzDkRC ioyCcs" style="width: 100%; max-width: 400px;">
                    <form class="sc-kpOJdX kFPdwr" style="width: 100%;">
                        <div class="sc-ckVGcZ xzcRZ" style="width: 100%; margin-bottom: 20px;">
                            <div class="sc-kAzzGY" height="52px" style="position: relative; width: 100%;">
                                <span class="sc-kgoBCf resetpass" style="display: block; text-align: left; margin-bottom: 10px;font-family:inherit;font-size:14px;color:#555555">Enter email to get link for password recovering</span>
                                <input type="email" name="email" class="sc-chPdSV jxLAT click_btn_login" style="width: 100%; height:auto; padding-left: 10px; margin: 0 auto; display: block;" value="<?php echo set_value('email'); ?>">
                            </div>
                        </div>
                        <!-- Button container -->
                        <div class="sc-dxgOiQ jaHTXm" style="margin: 30px 0 0 0; display: flex; align-items: center; gap: 20px; width: 100%;">
                            <button type="submit" class="K3TX2EnGEDIGIEiEIo_0X *3-Xcfgk4YnBeM0kgvmZfs* btn_signin" style="margin:0; text-align: center; border-radius:30px; color: white; background-color: #004b6b; padding:16px 30px; font-size:14px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); min-width: 160px;">
                                <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                <span class="_3axrJUuPR6Tfk-J1aQF4dm">Get link</span>
                            </button>
                            <a class="sc-jKJlTe gPtJgO" href="<?php echo base_url('v2/sign/in');?>" style="text-align: center; font-size: 14px;">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Google Maps Section -->
    <div class="container">
        <div class="wrap wow slideInRightMD" style="visibility: visible; animation-name: slideInRightMD;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.3302601537607!2d108.23847917604982!3d16.048342884628177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142176300d6fd1d%3A0x54b974a650dea81f!2zMTc0IENow6J1IFRo4buLIFbEqW5oIFThur8sIELhuq9jIE3hu7kgUGjDuiwgTmfFqSBIw6BuaCBTxqFuLCDEkMOgIE7hurVuZyA1NTAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1692034365995!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- Footer -->
    <footer class="sc-ifAKCX hbyzzN">
        <span>Powered by&nbsp;<a target="_blank" rel="noreferrer" href="https://wedebeek.com/" class="sc-EHOje fPkDMs">Wedebeek team</a>&nbsp;2021-<?php echo date('Y'); ?></span>
        <div class="sc-bZQynM dAZhcd"><a href="https://www.linkedin.com/in/biphan-wedebeek/" rel="noreferrer" target="_blank">Our LinkedIn </a>
        <a href="https://www.facebook.com/teamwedebeek" rel="noreferrer" target="_blank">Our Facebook</a></div>
    </footer>
</div>

<!-- Toast notifications -->
<div class="position-fixed top-0 end-0 p-5 hide">
    <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
        <div class="toast-body d-flex">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <span class="toastContent">
               Successfully edited profile
            </span>
        </div>
    </div>
</div>

<!-- Error toast -->
<div class="position-fixed top-0 end-0 p-5 hide">
    <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao2">
        <div class="toast-body bg-danger text-white">
            <span class="toastContent ">
               Successfully edited profile
            </span>
        </div>
    </div>
</div>

<script>
// Initialize WOW.js for scroll animations
new WOW().init();

$(document).ready(function(){
    
	$('.btn_signin').on('click',function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        ajurl = "<?php echo base_url('v2/sign/password/reset');?>";
        
        
        $.ajax({
            type:"POST",
            url:ajurl,
            data:form.serialize(),
            success:ajaxSuccess,
            error:ajaxErr,
            complete: function() {
            }
        });
    });
});

function ajaxErr(){
    console.error('AJAX Error: Network Error!');
    alert('Network Error!');
}

function ajaxSuccess(data){
    try {
        // Log the raw response
        console.log('AJAX Response:', data);
        
        const obj = JSON.parse(data);
        console.log('Parsed Response:', obj);
        
        if(obj.error==0){
            console.log('Success message:', obj.data);
            
            // Remove 'hide' class from container
            $('#thongBao').closest('.position-fixed').removeClass('hide');
            
            // Update toast content
            $('.toastContent').html(obj.data);
            
            var myAlert = document.getElementById('thongBao');
            // Check if Bootstrap is loaded correctly
            if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                console.log('Showing success toast');
                var bsAlert = new bootstrap.Toast(myAlert, {
                    animation: true,
                    delay: 10000,
                    autohide: true
                });
                bsAlert.show();
            } else {
                // Fallback if Bootstrap Toast is not available
                console.error('Bootstrap Toast not available, using alert');
                alert(obj.data);
            }
            
            setTimeout(() => {
                window.location.href = "<?php echo base_url('v2');?>";
            }, 5000);
        } else {
            console.log('Error message:', obj.data);
            
            // Remove 'hide' class from container
            $('#thongBao2').closest('.position-fixed').removeClass('hide');
            
            // Update toast content
            $('.toastContent').html(obj.data);
            
            var myAlert = document.getElementById('thongBao2');
            // Check if Bootstrap is loaded correctly
            if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                console.log('Showing error toast');
                var bsAlert = new bootstrap.Toast(myAlert, option);
                bsAlert.show();
            } else {
                // Fallback if Bootstrap Toast is not available
                console.error('Bootstrap Toast not available, using alert');
                alert(obj.data);
            }
        }
    } catch (error) {
        console.error('Error parsing AJAX response:', error);
        console.error('Raw response:', data);
        alert('Error processing response: ' + error.message);
    }
}

var option = {
    animation:true,
    delay:5000,
    autohide:true
};
</script>
<script src="<?php echo base_url();?>temp/default/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>temp/default/js/bootstrap.bundle.min.js"></script>
</body>
</html>