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
   <body>
		<section class="h-100">
			<div class="container h-100">
				<div class="row justify-content-sm-center h-100">
					<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
						<div class="text-center my-5">
							<img src="<?php echo $this->pub_config['logo'];?>" alt="logo" width="100">
						</div>
						<div class="card shadow-lg">
							<div class="card-body p-5">
								<h1 class="fs-4 card-title fw-bold mb-4">Aadvertiser Register</h1>
								<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
									<div class="mb-3">
										<label class="mb-2 text-muted">Username</label>
										<input id="name" type="text" class="form-control" name="username" value="" required autofocus>
										<div class="invalid-feedback">
										Username is required	
										</div>
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted" for="email">E-Mail Address</label>
										<input id="email" type="email" class="form-control" name="email" value="" required>
										<div class="invalid-feedback">
											Email is invalid
										</div>
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted" for="password">Password</label>
										<input id="password" type="password" class="form-control" name="password" required>
										<div class="invalid-feedback">
											Password is required
										</div>
									</div>
									<div class="mb-3">
										<label class="mb-2 text-muted" for="confirm_pass">Repeat Password</label>
										<input id="confirm_pass" type="password" class="form-control" name="confirm_pass" required>										
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted">First Name</label>
										<input type="text" class="form-control" name="mailling[firstname]" value="<?php if(!empty($this->mailling['firstname'])) echo $this->mailling['firstname']; ?>" required autofocus>										
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted">Last Name</label>
										<input type="text" class="form-control" name="mailling[lastname]" value="<?php if(!empty($this->mailling['lastname'])) echo $this->mailling['lastname']; ?>" required autofocus>										
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted">Address</label>
										<input type="text" class="form-control" name="mailling[ad]" required autofocus>
										<div class="invalid-feedback">
										Address is required	
										</div>
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted">Skype ID/Telegram</label>
										<input type="text" class="form-control" name="mailling[im_service]" value="" required autofocus>										
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted">Website</label>
										<input type="text" class="form-control" name="mailling[website]" value="<?php if(!empty($this->mailling['website'])) echo $this->mailling['website']; ?>" required autofocus>										
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted">Please choose your offer category</label>
										<div class="row">
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Email"  id="3hb7d8ttm7s"><label  for="3hb7d8ttm7s"><span >Email</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Display Ads / Banner" id="2cdavgdda5s"><label  for="2cdavgdda5s"><span >Display Ads / Banner</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Push / Pop" id="6utpnjadgav"><label  for="6utpnjadgav"><span >Push / Pop</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Google AdWords / BingAds" id="372aiuurbkgg"><label  for="372aiuurbkgg"><span >Google AdWords / BingAds</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Social Media" id="32so1b6sjt8g"><label  for="32so1b6sjt8g"><span >Social Media</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="SEO, SEM, SMO" id="3ieemgb049m"><label  for="3ieemgb049m"><span >SEO, SEM, SMO</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Personal Blog / website" id="8h66fjlbtt6"><label  for="8h66fjlbtt6"><span >Personal Blog / website</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Mobile traffic" id="8kedd012c3a"><label  for="8kedd012c3a"><span >Mobile traffic</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Incent" id="28mnqg6q639g"><label  for="28mnqg6q639g"><span >Incent</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Media buying" id="6hvtd09624p"><label  for="6hvtd09624p"><span >Media buying</span></label></div>
											<div class="col-auto"><input type="checkbox" name="aff_type[]" value="Other" id="4257d4svurr"><label  for="4257d4svurr"><span >Other</span></label></div>
										</div>									
									</div>

									<div class="mb-3">
										<label class="mb-2 text-muted">How did you find us?*</label>
										<textarea class="form-control" name="mailling[hear_about]" rows="3"></textarea>										
									</div>

									<!--p class="form-text text-muted mb-3">
										By registering you agree with our terms and condition.
									</p-->
									<div class="mb-3 form-check">
										<input type="checkbox" class="form-check-input"  name="mailling[terms]" id="terms">
										<label class="form-check-label" for="terms">I agree with <a class="sc-jWBwVP bBsnzv" target="_blank" href="<?php echo base_url('v2/terms');?>">Terms And Conditions</a></label>
									</div>

									<div class="mb-3 form-check">
										<input type="checkbox" class="form-check-input"  name="mailling[terms2]" id="terms2">
										<label class="form-check-label" for="terms2">
										I hereby consent and allow the use of my and/or my companys information, including sharing with a third party, to assess, detect, prevent or otherwise enable detection and prevention of malicious, invalid or unlawful activity and/or general fraud prevention.
										</label>
									</div>
									<div class="align-items-center d-flex">
										<button type="submit" class="btn btn-primary ms-auto btn_signup">
											Register	
										</button>
									</div>
								</form>
							</div>
							<div class="card-footer py-3 border-0">
								<div class="text-center">
									Already have an account? <a href="<?php echo base_url('v2/sign/in');?>" class="text-dark">Login</a>
								</div>
							</div>
						</div>
						<div class="text-center mt-5 text-muted">
							Copyright &copy; 2021 &mdash;  Wedebeek team
						</div>
					</div>
				</div>
			</div>
		</section>

      <!--thoong bao -->
      <div class="position-fixed top-0 end-0 p-5 hide">
         <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
            <div class="toast-body">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
               </svg>
               <span class="toastContent">
               Successfully edited profile
               </span>   
            </div>
         </div>
      </div>
      <!--thong bao loi-->
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
         $(document).ready(function(){               
            $('.btn_signup').on('click',function(e){
               e.preventDefault();
               var form = $(this).closest('form');         
               ajurl = "<?php echo base_url('advertiser/signup');?>";
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
         		$('.toastContent').html(obj.data);
         		var myAlert =document.getElementById('thongBao');//select id of toast
         		var bsAlert = new bootstrap.Toast(myAlert,{
         				animation:true,
         				delay:10000,
         				autohide:true
         				});//inizialize it
         		bsAlert.show();//show it  
         		setTimeout(() => {
                           	window.location.href = "<?php echo base_url('v2');?>";
                        	}, 15000);
            }else{
         		$('.toastContent').html(obj.data);
         		var myAlert =document.getElementById('thongBao2');//select id of toast
         		var bsAlert = new bootstrap.Toast(myAlert,option);//inizialize it
         		bsAlert.show();//show it  
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