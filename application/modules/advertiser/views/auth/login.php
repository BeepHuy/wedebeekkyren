<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<title>Authorization</title>
   <!-- Bootstrap core CSS -->
      <link href="<?php echo base_url();?>temp/default/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
     
	<link href="<?php echo base_url();?>/temp/default/css/login.css" rel="stylesheet">
	<script src="<?php echo base_url();?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript"></script>
<body wfd-invisible="true">
	<div class="loader" wfd-invisible="true"><i class="dot"></i> <i class="dot"></i> <i class="dot"></i></div>
	<div id="root">
		<div class="_15fu8tliQjoFX_txAhIwyW _2JZmjKGweSe3VKt76UWHXO css-1ed4bhs">
			<div class="_1q1YDBKhjzRspY4va-DRI4"></div>
		</div>
		<div class="sc-eqIVtm jFlzmB">
			<header class="sc-bdVaJa hTXyZr">
				<div class="sc-bxivhb cpOYPG"></div>
				<div class="ECBVuC1-2xlutADBhrw- ON7Z_5ZehzihyO3o4vqbE" data-test-id="menu-English">
					<div class="_37NUkzmoyY2UEU1AerMvXX">
						<span class="_2cCWo1Fd19nOeZ9SafKr1H">English</span>
						
					</div>
				</div>
			</header>
         <Script>
            $(document).ready(function(){
               
               $( ".click_btn_login" ).each(function() {
                  var t =$(this).siblings('.span_ip');                  
                  if ($(this).val()) {
                     $(t).removeClass('jBAAej');
                     $(t).addClass('fLnJSC');
                  }else{
                     $(t).removeClass('fLnJSC');
                     $(t).addClass('jBAAej');
                  }
               });
               $('.click_btn_login').on('click',function(){
                  var t =$(this).siblings('.span_ip');                  
                  $(t).removeClass('jBAAej');
                  $(t).addClass('fLnJSC');
               })
               $(".click_btn_login").focusout(function(){
                  var t =$(this).siblings('.span_ip');
                  if ($(this).val()) {
                     $(t).removeClass('jBAAej');
                     $(t).addClass('fLnJSC');
                  }else{
                     $(t).removeClass('fLnJSC');
                     $(t).addClass('jBAAej');
                  }
               });
            })
         </script>
			<main class="sc-fAjcbJ kFfNqn">
				<div class="sc-Rmtcm cIUDWQ">
					<div class="sc-bRBYWo eVigII">
						<img src="<?php echo $this->pub_config['logo'];?>" class="sc-VigVT iApbYG">
                  <span class="sc-jhAzac cnxHgy">Authorization</span>
						<div class="sc-hzDkRC ioyCcs">
							<form class="sc-kpOJdX kFPdwr" method="post" action="">
								<div data-test-id="login-signin-email-input" class="xzcRZ">
									<div class="sc-kAzzGY jIpyka" height="52px">
                              <input type="hidden" name="login" value="login">
										<input name="email" type="email" class="jxLAT click_btn_login" value="<?php if(set_value('email'))echo set_value('email');?>" id="ip_email">
										<span class="jBAAej span_ip" height="36px">Email</span>
									</div>
								</div>
								<div data-test-id="login-signin-password-input" class="xzcRZ">
									<div class="sc-kAzzGY jIpyka" height="52px">
										<input type="password" name="pwd" class="jxLAT click_btn_login" value="<?php if(set_value('pwd'))echo set_value('pwd');?>" id="ip_pass">
                              <span class="jBAAej span_ip" height="36px">Password</span>
										
									</div>
								</div>
								<div data-test-id="login-signin-remember-toogle" class="sc-eNQAEJ jpWIxZ">
									<div class="_24Sdpdb7tKbUjJcti0bPnh _35iQwZ_AuaFmdI_kBnReo_">
                              <input class="" type="checkbox" name="7h429qn81qj" id="7h429qn81qj" value="false">
                              <label class="_19KU9ICo0Eb0R2seYqKsCW" for="7h429qn81qj">
                                 <span class="_19KU9ICo0Eb0R2seYqKsCW">Remember Me</span>
                              </label>
                           </div>
								</div>
								<div class="sc-dxgOiQ jaHTXm">
									<button data-test-id="login-signin-signin-button" type="submit" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_ btn_signin">
										<div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
										<span class="_1pFgCebzxXEI3gItBe_863">
											<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
												<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
												<polyline points="10 17 15 12 10 7"></polyline>
												<line x1="15" y1="12" x2="3" y2="12"></line>
											</svg>
										</span>
										<span class="_3axrJUuPR6Tfk-J1aQF4dm">Sign In</span>
									</button>
									<a class="sc-jKJlTe gPtJgO" href="<?php echo base_url('advertiser/signup');?>">Create Account</a>
								</div>
								<div class="sc-hMqMXs iQKfMG">
									<a class="sc-jKJlTe gPtJgO" href="<?php echo base_url('advertiser/signpassword/reset');?>">Password Recovering</a>
									<div class="sc-kEYyzF chXnfj"><a class="sc-jKJlTe gPtJgO" target="_blank" href="<?php echo base_url('v2/terms');?>">Terms And Conditions</a><a class="sc-jKJlTe gPtJgO" target="_blank" href="<?php echo base_url('v2/privacy');?>">Privacy Policy</a></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</main>
			<footer class="sc-ifAKCX hbyzzN">
				<span>Powered by&nbsp;<a target="_blank" rel="noreferrer" href="https://wedebeek.com/" class="sc-EHOje fPkDMs">Wedebeek team</a>&nbsp;2021</span>
				<div class="sc-bZQynM dAZhcd"><a href="https://www.linkedin.com/in/biphan-wedebeek/" rel="noreferrer" target="_blank">Our LinkedIn </a>
            <a href="https://www.facebook.com/teamwedebeek" rel="noreferrer" target="_blank">Our Facebook</a></div>
			</footer>
		</div>
	</div>
	 <!--thoong bao -->
    <div class="position-fixed top-0 end-0 p-5 hide">
            <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">

               <div class="toast-body d-flex">   
                  
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                     <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </svg>                 
                  
                  <span id="toastContent">
                     Successfully edited profile
                  </span>   
               </div>
            </div>
         </div>
         <script>
            $(document).ready(function(){               
               $('.btn_signin').on('click',function(e){
                  e.preventDefault();
                  var form = $(this).closest('form');         
                  ajurl = "<?php echo base_url('advertiser/signin');?>";
                  $.ajax({
                        type:"POST",
                        url:ajurl,
                        data:form.serialize(),
                        success:ajaxSuccess,
                        error:ajaxErr                     
                  });
               })

            });

            function ajaxErr(){
               alert('Network Error!');
            }
            function ajaxSuccess(data){
               const obj = JSON.parse(data);
               if(obj.error==0){
                  setTimeout(() => {
                     window.location.href = "<?php echo base_url('advertiser');?>";
                  }, 3000);
               }               
               $('#toastContent').html(obj.data);
               var myAlert =document.getElementById('thongBao');//select id of toast
               var bsAlert = new bootstrap.Toast(myAlert,option);//inizialize it
               bsAlert.show();//show it   
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