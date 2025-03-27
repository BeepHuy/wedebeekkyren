<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Advertiser</title>
    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/temp/default/css/login.css" rel="stylesheet">
    <link href="<?php echo base_url('/temp/pulisher/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('/temp/pulisher/css/error.css'); ?>" rel="stylesheet">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        .ajax-error {
            color: white !important;
            background-color: darkred;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            display: none;
        }

        .alert-success {
            color: white !important;
            background-color: green;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
       /* Tùy chỉnh giao diện của Select2 */
        .select2-container--default .select2-selection--multiple {
            border-radius: 20px;
            border: 2px solid var(--border-color);
            padding: 5px;
        }

    </style>

</head>

<body>
    <div class="loader"><i class="dot"></i> <i class="dot"></i> <i class="dot"></i></div>

    <!-- Header -->
    <header class="sc-bdVaJa hTXyZr">
        <div class="sc-bxivhb cpOYPG"></div>
        <div class="ECBVuC1-2xlutADBhrw- ON7Z_5ZehzihyO3o4vqbE" data-test-id="menu-English">
            <div class="_37NUkzmoyY2UEU1AerMvXX">
                <span class="_2cCWo1Fd19nOeZ9SafKr1H">English</span>
            </div>
        </div>
    </header>
    <!-- End Header -->

    <!-- Form Container -->
    <main class="sc-fAjcbJ kFfNqn">
        <div class='form-container'>
            <div class="brand">
                <img src=" <?php echo base_url() ?>/upload/files/website_logo_transparent_background.png"
                    class="logo1" style="width:450px; height:auto; cursor: grab;"
                    onclick="window.location.href='<?php echo base_url(''); ?>';">
                <span>Wedebeek Technology Limited</span>
            </div>

            <!-- Div này sẽ hiện lỗi từ AJAX -->
            <div class="alert alert-success error-container ajax-error" style="display:none; color:red;"></div>

            <div>
                <div class="form-row">
                    <h2 class='signup'>SIGN UP</h2>
                    <h2 class='title'>AS ADVERTISER</h2>
                </div>
                <!-- Thêm id="registerForm" để AJAX submit -->
                <form id="registerForm" action="<?php echo site_url('v3/sign/up'); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-row">
                        <label for="firstname">First Name *</label>
                        <input type="text" name="mailling[firstname]" id="firstname">
                    </div>

                    <div class="form-row">
                        <label for="lastname">Last Name *</label>
                        <input type="text" name="mailling[lastname]" id="lastname">
                    </div>
                    <div class="form-row">
                        <label for="phone">Phone. *</label>
                        <input type="number" name="phone" id="phone">
                    </div>
                    <div class="form-row">
                        <label for="email">Email *</label>
                        <input type="text" name="email" id='email'>
                    </div>

                    <div class="form-row">
                        <label for="pass">Password *</label>
                        <input type="password" name="password" id='password'>
                    </div>

                    <div class="form-row">
                        <label for="confirm_pass">Repeat Password *</label>
                        <input type="password" name="confirm_pass" id='confirm_pass'>
                    </div>

                    <div class="form-row">
                        <label for="contact">Skype ID/ Telegram *</label>
                        <input type="text" name="mailling[im_service]" id='contact'>
                    </div>

                    <div class="form-row">
                        <label for="company">Company Name</label>
                        <input type="text" name="mailling[company]" id="company">
                    </div>

                    <div class="form-row">
                        <label for="street">Street *</label>
                        <input type="text" name="mailling[street]" id="street">
                    </div>

                    <div class="form-row">
                        <label for="city">City *</label>
                        <input type="text" name="mailling[city]" id="city">
                    </div>
                    <div class="form-row">
                        <label for="reg_cert">Company Registration Certificate *</label>
                        <input type="file" name="reg_cert[]" id="reg_cert" multiple style="padding: 2px 10px;">
                    </div>


                    <div class="form-row">
                        <label for="country_id">Country *</label>
                        <select name="mailling[country]" id="country_id" style="text-align: left;">
                            <option value="">Please select country</option>
                            <?php foreach ($country as $value) { ?>
                                <option value="<?php echo $value->country ?>" id="<?php echo $value->keycode ?>"><?php echo $value->country ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="st_reg">State/Region *</label>
                        <select name="mailling[state]" id="st_reg" style="text-align: left;"></select>
                    </div>
                    <div class="form-row">
                        <label for="zip">Zip Code *</label>
                        <input type="text" name="mailling[zip]" id="zip">
                    </div>

                    <div class="form-row">
                        <label for="payout">Payout *</label>
                        <input type="text" name="payout" id="payout">
                    </div>
                    <div class="form-row">
                        <label for="website">URL Website *</label>
                        <input type="text" name="mailling[website]" id="website">
                    </div>
                    <div class="form-row">
                        <label for="offername">Offer Name *</label>
                        <input type="text" name="mailling[offername]" id="offername">
                    </div>
                    <p style="margin:0 0 15px 185px;font-size: 12px; max-width:340px;font-style: italic;">
                        Please list at least 1 Offer Name you want to use as an advertiser with Wedebeek’’
                    </p>

                    <div class="form-row">
                        <label for="biz_desc">Briefly Describe Your Business Activities *</label>
                        <textarea name="biz_desc" class="textarea" id="biz_desc" style="height: 70px;"></textarea>
                    </div>
                    <div class="form-row">
                        <label for="offercat_id">Offer Categories *</label>
                        <select name="mailling[offercat]" id="offercat_id" class="select2-custom" multiple>
                            <?php foreach ($offercat as $value) { ?>
                                <option value="<?php echo $value->id ?>" id="">
                                    <?php echo $value->offercat ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                
                    <!-- <div class="form-row">
                        <label for="category_id">Category *</label>
                        <select name="mailling[category]" id="category_id" class="select2-custom" multiple>
                            <?php foreach ($offercat as $value) { ?>
                                <option value="<?php echo $value->offercat ?>" id="">
                                    <?php echo $value->offercat ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div> -->
                    <div class="form-row">
                        <label for="traftype">Allow Traffic Source *</label>
                        <select name="aff_type[]" id="traftype" class="select2-custom" multiple>
                            <?php foreach ($traftype as $value) { ?>
                                <option value="<?php echo $value->name ?>" id="">
                                    <?php echo $value->name ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="mailling[terms]" value="1" id="agree1">
                            <label for="agree1">
                                <span>
                                    <span>I agree with
                                        <a target="_blank" href="<?php echo base_url('/v3/news/3'); ?>">Terms And Conditions</a>
                                    </span>
                                </span>
                            </label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" name="agree2" id="agree2">
                            <label for="agree2">
                                <span class="">I hereby consent and allow the use of my and/or my companys information, including sharing with a third party, to assess, detect, prevent or otherwise enable detection and prevention of malicious, invalid or unlawful activity and/or general fraud prevention.</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit">Sign Up</button>
                        <span class='haveaccount'>Already have account?
                            <a href="<?php echo base_url('v3/sign/in'); ?>">Sign in</a>
                        </span>
                    </div>


                </form>

            </div>

        </div>
    </main>
    <!-- End Form Container -->

    <!-- Footer -->
    <footer class="sc-ifAKCX hbyzzN">
        <span>Powered by&nbsp;<a target="_blank" rel="noreferrer" href="https://wedebeek.com/">Wedebeek team</a>&nbsp;2021</span>
        <div class="sc-bZQynM dAZhcd">
            <a href="https://www.linkedin.com/in/biphan-wedebeek/" rel="noreferrer" target="_blank">Our LinkedIn </a>
            <a href="https://www.facebook.com/teamwedebeek" rel="noreferrer" target="_blank">Our Facebook</a>
        </div>
    </footer>
    <!-- End Footer -->

    <script>
        $(document).ready(function() {
            $('#offercat_id').select2({
                placeholder: "Please select your offer categories",
                allowClear: true,
                closeOnSelect: false 
            });

            $('#traftype').select2({
                placeholder: "Please select your offer traffic sources",
                allowClear: true,
                closeOnSelect: false 
            });
            //Trả về danh sách state khi chọn country
            $('#country_id').change(function() {
                var ckey = $('#country_id option:selected').attr('id');
                var country_name = $('#country_id option:selected').text();
                $.ajax({
                    url: 'https://api.countrystatecity.in/v1/countries/' + ckey + '/states',
                    type: 'GET',
                    headers: {
                        'X-CSCAPI-KEY': 'cGhRTmJ4am5YeUxSWVczbkIzZTNNQm14MWxsalg5dEw2MUxFeU5SSg=='
                    },
                    success: function(response) {
                        var htmlContent = '';
                        if (response.length > 0) {
                            response.forEach(function(value) {
                                htmlContent += "<option value='" + value.name + "'>" + value.name + "</option>";
                            });
                        } else {
                            htmlContent = "<option value='" + country_name + "'>" + country_name + "</option>";
                        }

                        $('#st_reg').html(htmlContent);
                    },
                    error: function(xhr, status, error) {
                        $('#st_reg').html("<option value='" + country_name + "'>" + country_name + "</option>");
                    }
                });
            });

            // ----- AJAX submit form -----
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var ajurl = "<?php echo site_url('v3/sign/up'); ?>";
                // FormData để gửi cả file và input
                var formData = new FormData(form[0]);
                $.ajax({
                    type: "POST",
                    url: ajurl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var obj = {};
                        try {
                            obj = JSON.parse(data);
                        } catch (e) {
                            // Nếu có lỗi parse JSON
                            alert('server error, max image size is 2M');
                            return;
                        }
                        if (obj.error == 0) {
                            // ----- Trường hợp đăng ký thành công -----
                            $('.ajax-error')
                                /* console.log($obj.data); */
                                // Xóa class thể hiện lỗi
                                .removeClass('error-container')
                                // Thêm class để hiển thị thông báo thành công
                                .addClass('alert alert-success')
                                //noi dung thong bao
                                .html(obj.data)
                                // Hiển thị phần tử
                                .show();

                            // Sau 3 giây thì chuyển sang trang đăng nhập
                            setTimeout(function() {
                                window.location.href = "<?php echo site_url('v3/sign/in'); ?>";
                            }, 2000);

                        } else {
                            // ----- Trường hợp có lỗi trả về -----
                            $('.ajax-error')
                                .removeClass('alert alert-success')
                                .addClass('error-container')
                                .html(obj.data)
                                .show();

                            // Tùy ý: cho lỗi tự ẩn sau 5 giây 
                            setTimeout(function() {
                                $('.ajax-error').fadeOut('slow');
                            }, 5000);
                        }
                    },
                    error: function() {
                        alert('Network Error!');
                    }
                });
            });

            // Ẩn .ajax-error ngay khi user bắt đầu nhập
            $('input, textarea, select').on('input change', function() {
                $('.ajax-error').fadeOut('fast');
            });

        });
    </script>


</body>

</html>