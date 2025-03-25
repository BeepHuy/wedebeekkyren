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
					         $(t).removeClass('jBAAej span_ip');
					         $(t).addClass('fLnJSC');
					      }else{
					         $(t).removeClass('fLnJSC');
					         $(t).addClass('jBAAej span_ip');
					      }
					   });
                       //thuwr span click
					   $('.span_ip').on('click',function(){
					      var t =$(this).siblings('.click_btn_login');                  
					      $(this).removeClass('jBAAej span_ip');
					      $(this).addClass('fLnJSC');
                          $(t).focus();
					   })

                       $('.click_btn_login').on('click',function(){
					      var t =$(this).siblings('.span_ip');                  
					      $(t).removeClass('jBAAej span_ip');
					      $(t).addClass('fLnJSC');
					   })
					   $(".click_btn_login").focusout(function(){ 
                           
                        var t =$(this).siblings('span');
                          console.log(t);
					      if($(this).val()) {
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
                        <span class="sc-jhAzac cnxHgy">Password Recovering</span>
						<div class="sc-hzDkRC ioyCcs">
                            <form class="sc-kpOJdX kFPdwr">
                                <div class="sc-ckVGcZ xzcRZ">
                                    <div class="sc-kAzzGY jIpyka" height="52px">
                                        <input type="email" name="email" class="sc-chPdSV jxLAT click_btn_login" value="<?php echo set_value('email'); ?>">
                                        <span class="sc-kgoBCf jBAAej  span_ip" height="36px">Enter email to get link for password recovering</span></div>
                                </div>
                                <div class="sc-dxgOiQ jaHTXm">
                                    <button type="submit" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_ btn_signin">
                                        <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                        <span class="_1pFgCebzxXEI3gItBe_863">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                        </svg>
                                        </span>
                                        <span class="_3axrJUuPR6Tfk-J1aQF4dm">Get link</span>
                                    </button>
                                    <a class="sc-jKJlTe gPtJgO" href="<?php echo base_url('advertiser/signin');?>">Sign In</a>
                                </div>
                            </form>
                        </div>
					</div>
				</div>
			</main>
			<footer class="sc-ifAKCX hbyzzN">
				<span>Powered by&nbsp;<a target="_blank" rel="noreferrer" href="http://affise.com" class="sc-EHOje fPkDMs">Affise.com</a>&nbsp;2021</span>
				<div class="sc-bZQynM dAZhcd"><a href="#" rel="noreferrer" target="_blank">Our LinkedIn </a>
            <a href="#" rel="noreferrer" target="_blank">Our Facebook</a></div>
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
               $('.btn_signin').on('click',function(e){
                  e.preventDefault();
                  var form = $(this).closest('form');         
                  ajurl = "<?php echo base_url('advertiser/signpassword/reset');?>";
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