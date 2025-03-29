<link href="<?php echo base_url().'temp/default/css/nhap.css';?>" rel="stylesheet">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<style>
   .filepond--credits {
      display: none !important;
   }
   .select2-container {
      width: 100% !important; 
   }

   .select2-container .select2-selection--multiple {
      border: none !important;      
      background:#ececee !important; 
   }
</style>

<?php 
   $acc = unserialize($userData->mailling);   
?> 

 <!-- offer content-->
   <div class="mt-5 mb-4">
      <div class="sc-dlyikq hrvHfq ">
         <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV" id="name_title">Profile</span>
         <div class="_1haMCIeKQlOTIl_pWtBGbw _1ye-KTmlb5GAdCMzA76WiG">
            <div class="css-15tqd4u hfK7mk6VgJGa8JX5PvVeJ hide_mobile">
               <div class="_3eOZ58qg6Kp88DgJr1zNp_">
                  <div class="tab_header tab_header_active" id="profile">
                     <a class="tab_link" href="<?php echo base_url();?>v3/profile/profile">Profile</a>
                  </div>
                  <div class="tab_header" id="changepass">
                     <a class="tab_link" href="<?php echo base_url();?>v3/profile/changepass">Change password</a>
                  </div>
                  <div class="tab_header" id="api-key">
                     <a class="tab_link" href="<?php echo base_url();?>v3/profile/api-key">Api-Key</a>
                  </div>
                  <div class="tab_header" id="postbacks">
                  <a class="tab_link" href="<?php echo base_url();?>v3/profile/postbacks">Global postbacks</a>
                  </div>
                  <div class="tab_header" id="postback_log">
                     <a class="tab_link" href="<?php echo base_url();?>v3/profile/postbacks_log">Postback Log</a>
                  </div>
                  <div class="tab_header" id="payment">
                  <a class="tab_link" href="<?php echo base_url();?>v3/profile/payment">Payment system</a>
                  </div>
               </div>
            </div>

            <!---content tab-->
            <div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent profile">
            
               <!-- Referall -->
               <form class="sc-jQMNup hiJcSc w-100" id="formProfile" enctype="multipart/form-data">
                  <div class="row justify-content-center align-items-flex">
                     <div class="col-md-6 text-center">
                        <div class="sc-ccLTTT cjuVOD">
                           <p class="sc-bJHhxl gXRQqD text-start">Referrals *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                              <input type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo base_url('v3/sign/up/'.$userData->id);?>" disabled>
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                              </svg>
                           </div>
                        </div>
                        <!-- Email -->
                        <div class="sc-ccLTTT cjuVOD">
                           <p class="sc-bJHhxl gXRQqD text-start">Email *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                              <input name="email"  placeholder="Please enter Email" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $userData->email;?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                 <polyline points="22,6 12,13 2,6"></polyline>
                              </svg>
                           </div>
                        </div>

                        <!-- Skype ID/Telegram -->
                        <div class="sc-ccLTTT cjuVOD">
                           <p class="sc-bJHhxl gXRQqD text-start">Skype ID/Telegram *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                              <input name="im_service" maxlength="255" placeholder="Please enter Skype ID/Telegram" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php if($acc['im_service']=='skype') echo $acc['im_info'];else echo $acc['im_service'];?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                              </svg>
                           </div>
                        </div>

                        <!-- First Name -->
                        <div class="sc-ccLTTT cjuVOD">
                           <p class="sc-bJHhxl gXRQqD text-start">First Name *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                              <input name="firstname" maxlength="255" placeholder="Please enter First Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['firstname'];?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                              </svg>
                           </div>
                        </div>

                        <!-- Last Name -->
                        <div class="sc-ccLTTT cjuVOD">
                           <p class="sc-bJHhxl gXRQqD text-start">Last Name *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                              <input name="lastname" maxlength="255" placeholder="Please enter Last Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['lastname'];?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                              </svg>
                           </div>
                        </div>
                        <!-- Сompany name-->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">Сompany name</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <input name="company" placeholder="Please enter Сompany name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo isset($acc['company']) ? $acc['company'] : ''; ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v3"></path>
                                 <circle cx="12" cy="7" r="4"></circle>
                              </svg>
                           </div>
                        </div>
                        <!--Zip Code -->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">Zip Code *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <input name="zip" placeholder="Please enter Zip Code" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo isset($acc['zip']) ? $acc['zip'] : '' ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                 <polyline points="22,6 12,13 2,6"></polyline>
                              </svg>
                           </div>
                        </div>
                        <!--Payout-->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">Payout *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <input name="payout" placeholder="Please enter Payout" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $userData->payout;?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                 <polyline points="22,6 12,13 2,6"></polyline>
                              </svg>
                           </div>
                        </div>
                        <!-- Tel. -->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">Tel. *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <input name="phone" placeholder="Please enter Tel" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $userData->phone;?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                              </svg>
                           </div>
                        </div>
                        <!-- Images -->
                        <div class="sc-ccLTTT cjuVOD">
                              <div style="margin-bottom: 15px;">
                                 <p class="sc-bJHhxl gXRQqD text-start">Company Registration Certificate</p>
                                 <input name="reg_cert[]" type="file" id="fileInput" multiple />
                                 <?php if (!empty($userData->reg_cert) && is_array($userData->reg_cert) && count(array_filter($userData->reg_cert, function($value) {
                                    return $value !== null && $value !== '';
                                 })) > 0) : ?><!-- Kiểm tra nếu có file -->
                                    <label class="sc-bJHhxl gXRQqD text-start">Select photo to delete</label>
                                    <div style="display: flex; flex-wrap: nowrap; gap: 15px; margin-top: 10px;" id="preview-container">
                                       <?php foreach ($userData->reg_cert as $value): ?>
                                          <div style="width: 100px; position: relative; border:none; padding: 5px; box-sizing: border-box;">
                                                <?php if (strtolower(pathinfo($value, PATHINFO_EXTENSION)) === 'pdf'): ?>
                                                   <!-- Hiển thị PDF -->
                                                   <embed src="<?php echo base_url('upload/adv/' . $value); ?>" type="application/pdf" style="width: 100%; height: 75px;">
                                                <?php else: ?>
                                                   <!-- Hiển thị ảnh -->
                                                   <img src="<?php echo base_url('upload/adv/' . $value); ?>" alt="Ảnh" style="width: 100%; height: 75px; object-fit: cover; display: block;">
                                                <?php endif; ?>

                                                <input type="checkbox" name="imageToDelete[]" value="<?php echo $value; ?>" id="delete_<?php echo $value; ?>" style="position: absolute; top: 5px; right: 5px; width: 15px; height: 15px; opacity: 0;">
                                                <label class="delete-item"  for="delete_<?php echo $value; ?>" style="position: absolute; top: 5px; right: 5px; width: 20px; height: 20px; background: black; color: white; text-align: center; line-height: 20px; border-radius: 50%; cursor: pointer;">x</label>
                                          </div>
                                       <?php endforeach; ?>
                                    </div>  
                                 <?php endif; ?>
                           </div>
                           <div id="popup" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none; z-index: 9999; background: white; border: 1px solid #ccc; box-shadow: 0 0 15px rgba(0,0,0,0.6);">
                              <embed id="popup-content" src="" type="application/pdf" style="width: 95vw; height: 95vh; display: none;">
                              <img id="popup-image" src="" alt="Popup Image" style="max-width: 95vw; max-height: 95vh; object-fit: contain; display: none;">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 text-center">
                        <!-- Street -->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">Street *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <input name="street" placeholder="Please enter Street" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo isset($acc['street']) ? $acc['street'] : '' ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                 <polyline points="9 22 9 12 15 12 15 22"></polyline>
                              </svg>
                           </div>
                        </div>
                        <!-- City -->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">City *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <input name="city" placeholder="Please enter City" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo isset($acc['city']) ? $acc['city'] : '' ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                 <polyline points="9 22 9 12 15 12 15 22"></polyline>
                              </svg>
                           </div>
                        </div>
                        <!-- Country -->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">Country *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <select name="country" id="country_id" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c">
                                    <option value="">Select Country</option>
                                    <?php foreach ($all_countries as $country): ?>
                                       <option value="<?php echo htmlspecialchars($country->country); ?>" 
                                          id="<?php echo htmlspecialchars($country->keycode); ?>"
                                          <?php echo ($selected_country == $country->country) ? 'selected' : ''; ?>>
                                          <?php echo htmlspecialchars($country->country); ?>
                                       </option>
                                    <?php endforeach; ?>
                              </select>
                           </div>
                        </div>

                        <!-- State / Region -->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">State / Region *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <select name="state" id="st_reg" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c">
                                    <option value="">Select State</option>
                                    <?php if (!empty($selected_state)): ?>
                                       <option value="<?php echo htmlspecialchars($selected_state); ?>" selected>
                                          <?php echo htmlspecialchars($selected_state); ?>
                                       </option>
                                    <?php endif; ?>
                              </select>
                           </div>
                        </div>
                        <!--Offer Name -->
                        <div>
                           <p class="sc-bJHhxl gXRQqD text-start">Offer Name</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <input name="offername" placeholder="Please enter Offer Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo isset($acc['offername']) ? $acc['offername'] : '' ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                 <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                              </svg>
                           </div>
                           <p style='font-size: 12px;font-style: italic;'>Please list at least 1 Offer Name you want to use as an advertiser with Wedebeek’’.</p>
                        </div>
                        <!-- Traffic Source -->
                        <div class="sc-bJHhxl gXRQqD">
                           <p class="sc-bJHhxl gXRQqD text-start"><span>Traffic Source *</span></p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <select name="aff_type[]" id="aff_type_id" class="select2-custom" multiple style="width:100%">
                                    <?php foreach ($all_traftype as $traftypeIA): ?>
                                       <?php 
                                       // Kiểm tra xem traffic type này có được chọn không
                                       $selected = in_array($traftypeIA->name, $selected_traffic_sources) ? 'selected' : '';
                                       ?>
                                       <option value="<?php echo $traftypeIA->name; ?>" <?php echo $selected; ?>>
                                          <?php echo $traftypeIA->name; ?>
                                       </option>
                                    <?php endforeach; ?>
                              </select>
                           </div>
                        </div>
                        <!-- categories -->
                        <div class="sc-bJHhxl gXRQqD">
                           <p class="sc-bJHhxl gXRQqD text-start">Offer Categories *</p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <select name="offercat[]" id="offercat_id" class="select2-custom" multiple style="width:100%;">
                                    <?php foreach ($all_categories as $category): ?>
                                       <?php 
                                       // Kiểm tra xem category này có được chọn không
                                       $selected = in_array($category->offercat, $selected_categories) ? 'selected' : '';
                                       ?>
                                       <option value="<?php echo $category->offercat; ?>" <?php echo $selected; ?>>
                                          <?php echo $category->offercat; ?>
                                       </option>
                                    <?php endforeach; ?>
                              </select>
                           </div>
                        </div>

                        <!-- Website -->
                        <div class="sc-ccLTTT cjuVOD">
                           <p class="sc-bJHhxl gXRQqD text-start"><span>Website</span><span class="sc-hlILIN kDoghg">*</span></p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <textarea style="resize: none; overflow-y: scroll; width: 100%; height: 60px;" name="website" placeholder="Please enter URl Website" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"><?php echo isset($acc['website']) ? $acc['website'] : ''; ?></textarea>
                           </div>
                        </div>
                        <!--Briefly Describe Your Business Activities  -->
                        <div class="sc-ccLTTT cjuVOD">
                           <p class="sc-bJHhxl gXRQqD text-start"><span>Briefly Describe Your Business Activities</span><span class="sc-hlILIN kDoghg">*</span></p>
                           <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                              <textarea style="resize: none; overflow-y: scroll; width: 100%; height: 60px;" name="biz_desc" placeholder="Please enter Briefly Describe Your Business Activities" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"><?php echo isset($userData->biz_desc) ? $userData->biz_desc : ''; ?></textarea>
                           </div>
                        </div>
                     </div>
                  </div>

                  <input type="hidden" name="action" value="update_info">
                  <div class="sc-TuwoP gOhHft">
                     <button class="data_save K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                        <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                        <span class="_1pFgCebzxXEI3gItBe_863">
                           <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                           </svg>
                        </span>
                        <span class="_3axrJUuPR6Tfk-J1aQF4dm">Save</span>
                     </button>
                  </div>

               </form>
            </div>
         </div>
      
         <?php
         
         include('changepass.php');
         include('api-key.php');
         include('postback.php');
         include('postback_log.php');
         include('payment.php'); 

         ?>

         <!--content tab end-->

      </div>
   </div>

   </div>
   <!-- endoffer content-->

   <!--thoong bao -->
<div class="position-fixed bottom-0 end-0 p-5 hide">
   <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">

      <div class="toast-body">
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
$(document).ready(function() {
    // Lưu trữ state ban đầu từ database
    var originalState = '<?php echo isset($selected_state) ? addslashes($selected_state) : ""; ?>';
    var originalCountry = '<?php echo isset($selected_country) ? addslashes($selected_country) : ""; ?>';
    
    // Hàm reset state dropdown
    function resetStateDropdown() {
        var stateSelect = $('#st_reg');
        stateSelect.html('<option value="">Select State</option>');
    }
    
    // Hàm load states cho country được chọn
    function loadStatesForCountry(countryCode, countryName) {
        var stateSelect = $('#st_reg');
        
        // Hiển thị trạng thái loading
        stateSelect.html('<option value="">Loading states...</option>');
        
        $.ajax({
            url: 'https://api.countrystatecity.in/v1/countries/' + countryCode + '/states',
            type: 'GET',
            headers: {
                'X-CSCAPI-KEY': 'cGhRTmJ4am5YeUxSWVczbkIzZTNNQm14MWxsalg5dEw2MUxFeU5SSg=='
            },
            success: function(response) {
                resetStateDropdown();
                
                if (response && response.length > 0) {
                    // Thêm tất cả states từ API
                    response.forEach(function(state) {
                        stateSelect.append(
                            $('<option></option>')
                                .val(state.name)
                                .text(state.name)
                        );
                    });
                    
                    // Nếu country mới khác country ban đầu, bỏ chọn state cũ
                    if ($('#country_id').val() !== originalCountry) {
                        stateSelect.val('');
                    }
                    // Nếu cùng country, giữ lại state ban đầu nếu có
                    else if (originalState) {
                        stateSelect.val(originalState);
                    }
                } else {
                    // Fallback nếu không có states
                    stateSelect.append(
                        $('<option></option>')
                            .val(countryName)
                            .text(countryName)
                    );
                }
            },
            error: function(xhr, status, error) {
                resetStateDropdown();
                console.error('Error loading states:', error);
                
                // Thêm option lỗi + country name như fallback
                stateSelect.append(
                    $('<option></option>')
                        .val('')
                        .text('Error loading states')
                ).append(
                    $('<option></option>')
                        .val(countryName)
                        .text(countryName)
                );
            }
        });
    }
    
      // Xử lý khi thay đổi country
      $('#country_id').change(function() {
         var countryCode = $(this).find('option:selected').attr('id');
         var countryName = $(this).val();
         
         if (!countryCode) {
               resetStateDropdown();
               return;
         }
         
         loadStatesForCountry(countryCode, countryName);
      });
      
      // Tự động load states nếu đã có country được chọn
      if ($('#country_id').val()) {
         $('#country_id').trigger('change');
      }
   });
</script>

<script>
   $(document).ready(function(){
      $('#aff_type_id').select2({
         placeholder: "Please select your Traffic Source",
         allowClear: true,
         closeOnSelect: false 
      });
      $('#offercat_id').select2({
         placeholder: "Please select your offer categories",
         allowClear: true,
         closeOnSelect: false 
      });
      //xử ly tab
      // Ẩn tất cả nội dung và xóa active
      $('.tabcontent').hide();
      $('.tab_header').removeClass('tab_header_active');

      // Lấy tab hiện tại từ URL
      var segments = $(location).attr('href').split('/');
      var currentTab = segments[segments.length - 1] || "profile";

      $('.' + currentTab).show();
      $('#' + currentTab).addClass('tab_header_active');

      // Sự kiện click vào tab
      $('.tab_header').on('click', function (e) {
       
         e.preventDefault();
         var tabID = $(this).attr('id');
         /* alert(tabID) */

         $('.tabcontent').hide();
         $('.tab_header').removeClass('tab_header_active');

         $('.' + tabID).show();
         $('#' + tabID).addClass('tab_header_active');
      });
      
      //xuwr ly del posstrbck
      $('.btn_del_postBack').on('click',function(e){
         e.preventDefault();
         var form = $(this).closest('form');
         ajurl = "<?php echo base_url('v3/profile/postbacks');?>";
         $.ajax({
               type:"POST",
               url:ajurl,
               data:form.serialize(),
               success:ajaxSuccPb,
               error:ajaxErr
            });
      });

      
      //addd posstback 
      $('.data_save2').on('click',function(e){
         e.preventDefault();
         var form = $(this).closest('form');
         ajurl = "<?php echo base_url('v3/profile/postbacks');?>";
         $.ajax({
               type:"POST",
               url:ajurl,
               data:form.serialize(),
               success:ajaxSuccPb,//refhesh
               error:ajaxErr
            });
      });

      // Save 
      $('.data_save').on('click',function(e){
         e.preventDefault();

         var form = $(this).closest('form')[0];
         var formData = new FormData(form); 

         ajurl = "<?php echo base_url('v3/profile');?>";
         $.ajax({
               type:"POST",
               url:ajurl,
               data:formData,
               processData: false,  // Không xử lý dữ liệu (vì dùng FormData)
               contentType: false,  //
               success:ajaxSuccess,
               error:ajaxErr
            });
      });

      FilePond.registerPlugin(FilePondPluginImagePreview);

      // Kích hoạt FilePond trên input
     // Optional: Cấu hình thêm
     $('#fileInput').filepond({
         name: 'reg_cert[]',           // Gắn lại name đúng như form
         allowMultiple: true,          // Cho phép chọn nhiều file
         allowImagePreview: true,      // Bật tính năng preview ảnh
         imagePreviewHeight: 100,      // Chiều cao preview
         allowRemove: true,            // Cho phép xóa file
         storeAsFile: true             // Đảm bảo gửi file qua input gốc
      });

         //reset apikey
      $('#resetApikey').on('click',function(e){
         e.preventDefault();
         var form = $(this).closest('form');
         ajurl = "<?php echo base_url('v3/profile/resetApi');?>";
         $.ajax({
            type:"POST",
            url:ajurl,
            data:'resetApikey',
            success:function(apikey){
               $('#Api-Key').val(apikey);
            },
            error:ajaxErr
         });
      });

      $(document).on('click', '.delete-item', function () {
         $(this).closest('div').hide(); // Xóa phần tử cha chứa file
      });


   })

   //ajax thanfh coong
   function ajaxSuccPb(data){
      if(data==1){
         window.location.replace("<?php echo base_url('v3/profile/postbacks');?>");
      }else{
         alert('Error!');
      }
   }

   function ajaxSuccess(data){
      $('#toastContent').html(data);
      var myAlert =document.getElementById('thongBao');//select id of toast
      var bsAlert = new bootstrap.Toast(myAlert,option);//inizialize it
      bsAlert.show();//show it
      console.log(data);
      if (data.includes('<strong>SUCCESS: </strong> Successfully edited profile.')) {
          // Reload trang sau khi hiển thị thông báo
         setTimeout(() => {
            window.location.reload();
         }, 1000);
    }

      
   }

   function ajaxErr(){
      alert('Update Error!');
   }

   var option = {
      animation:true,
      delay:5000,
      autohide:true
   };

   ////Popup
   $(document).on('mouseenter', '#preview-container img, #preview-container embed', function (e) {
      const file = $(this).attr('src'); // Lấy link file
      const ext = file.split('.').pop().toLowerCase(); // Lấy phần mở rộng

      // Reset hiển thị popup
      $('#popup img, #popup embed').hide();

      if (ext === 'pdf') {
         $('#popup embed').attr('src', file).css({
               width: '95vw',
               height: '95vh', 
               display: 'block'
         });
         // Thêm pointer-events cho phép scroll PDF
         $('#popup').css('pointer-events', 'all');
      } else {
         $('#popup img').attr('src', file).css({
               maxWidth: '95vw',
               maxHeight: '95vh',
               display: 'block'
         });
         // Disable pointer-events cho ảnh
         $('#popup').css('pointer-events', 'none');
      }

      // Hiển thị popup ở giữa màn hình
      $('#popup').css({
         display: 'block',
         top: '50%',
         left: '50%',
         transform: 'translate(-50%, -50%)'
      });
   });

   $(document).on('mousemove', function(e) {
      var popup = $('#popup');
      var previewContainer = $('#preview-container');
      
      if (!popup.is(e.target) && popup.has(e.target).length === 0 && 
         !previewContainer.is(e.target) && previewContainer.has(e.target).length === 0) {
         popup.hide();
      }
   });
</script>