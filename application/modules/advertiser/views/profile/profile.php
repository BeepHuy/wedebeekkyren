<link href="<?php echo base_url();?>/temp/default/css/nhap.css" rel="stylesheet">
<?php $acc = unserialize($userData->mailling);  ?>

 <!-- offer content-->
 <div class="mt-5 mb-4">

                     <div class="sc-dlyikq hrvHfq ">
                        <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV" id="name_title">Profile</span>
                        <div class="_1haMCIeKQlOTIl_pWtBGbw _1ye-KTmlb5GAdCMzA76WiG">

                        <div class="css-15tqd4u hfK7mk6VgJGa8JX5PvVeJ hide_mobile">
                        <div class="_3eOZ58qg6Kp88DgJr1zNp_">
                           <div class="tab_header tab_header_active" id="profile">
                              <a class="tab_link" href="<?php echo base_url();?>v2/profile/profile">Profile</a>
                           </div>
                           <div class="tab_header" id="changepass">
                              <a class="tab_link" href="<?php echo base_url();?>/v2/profile/changepass">Change password</a>
                           </div>
                           <div class="tab_header" id="api-key">
                              <a class="tab_link" href="<?php echo base_url();?>v2/profile/api-key">Api-Key</a>
                           </div>
                           <div class="tab_header" id="postbacks">
                           <a class="tab_link" href="<?php echo base_url();?>v2/profile/postbacks">Global postbacks</a>
                           </div>
                           <div class="tab_header" id="postback_log">
                              <a class="tab_link" href="<?php echo base_url();?>v2/profile/postbacks_log">Postback Log</a>
                           </div>
                           <div class="tab_header" id="payment">
                           <a class="tab_link" href="<?php echo base_url();?>v2/profile/payment">Payment system</a>
                           </div>





                        </div>
                     </div>

                      <!---content tab-->
                      <div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent profile">
                         <form class="sc-jQMNup hiJcSc" id="formProfile">
                          <div class="sc-ccLTTT cjuVOD">
                               <p class="sc-bJHhxl gXRQqD">Referrals</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                                  <input type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo base_url('advertiser/signup/'.$userData->id);?>" disabled>
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                  </svg>
                               </div>
                           </div>
                           <div class="sc-ccLTTT cjuVOD">
                               <p class="sc-bJHhxl gXRQqD">Email</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                                  <input name="email"  placeholder="Email" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $userData->email;?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                     <polyline points="22,6 12,13 2,6"></polyline>
                                  </svg>
                               </div>
                            </div>
                            <div class="sc-ccLTTT cjuVOD">
                               <p class="sc-hARARD cKOZpE">Skype ID/Telegram</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                                  <input name="im_service" maxlength="255" placeholder="Skype ID/Telegram" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php if($acc['im_service']=='skype') echo $acc['im_info'];else echo $acc['im_service'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                  </svg>
                               </div>
                            </div>

                            <div class="sc-ccLTTT cjuVOD">
                               <p class="sc-hARARD cKOZpE">Avartar</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                                  <input name="avartar" maxlength="255" placeholder="First Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php if(!empty($acc['avartar']))echo $acc['avartar'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                  </svg>
                               </div>
                            </div>
                            <div class="sc-ccLTTT cjuVOD">
                               <p class="sc-hARARD cKOZpE">First Name</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                                  <input name="firstname" maxlength="255" placeholder="First Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['firstname'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                  </svg>
                               </div>
                            </div>
                            <div class="sc-ccLTTT cjuVOD">
                               <p class="sc-hARARD cKOZpE">Last Name</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                                  <input name="lastname" maxlength="255" placeholder="Last Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['lastname'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                  </svg>
                               </div>
                            </div>



                            <!--div class="sc-ccLTTT cjuVOD">
                               <p class="sc-hARARD cKOZpE"><span>Please choose your traffic type:</span><span class="sc-hlILIN kDoghg">*</span></p>
                               <div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="5te895egc6c" id="5te895egc6c" checked=""><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="5te895egc6c"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Email</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="3qib9hbqnfjg" id="3qib9hbqnfjg" checked=""><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="3qib9hbqnfjg"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Display Ads / Banner</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="5flm1g2aiee" id="5flm1g2aiee" checked=""><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="5flm1g2aiee"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Push / Pop</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="836u7ilhdjq" id="836u7ilhdjq" checked=""><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="836u7ilhdjq"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Google AdWords / BingAds</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="69nhndqa7n1" id="69nhndqa7n1" checked=""><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="69nhndqa7n1"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Social Media</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="1rcn2ntem6h" id="1rcn2ntem6h" checked=""><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="1rcn2ntem6h"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">SEO, SEM, SMO</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="73qkrmhhrah" id="73qkrmhhrah"><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="73qkrmhhrah"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Personal Blog / website</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="68c1gaj56uu" id="68c1gaj56uu" checked=""><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="68c1gaj56uu"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Mobile traffic</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="5mvk6lb44sd" id="5mvk6lb44sd"><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="5mvk6lb44sd"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Incent</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="7t0n6201msc" id="7t0n6201msc"><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="7t0n6201msc"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Media buying</span></label></div>
                                  <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi"><input class="" type="checkbox" name="92c7fp622ni" id="92c7fp622ni"><label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00" for="92c7fp622ni"><span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">Other</span></label></div>
                               </div>
                            </!--div-->
                            <div>
                               <p class="sc-bJHhxl gXRQqD">Сompany name</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="company" placeholder="Сompany name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['company'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                     <circle cx="12" cy="7" r="4"></circle>
                                  </svg>
                               </div>
                            </div>

                            <div>
                               <p class="sc-bJHhxl gXRQqD">Address 1</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="ad" placeholder="Address 1" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['ad'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                     <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                  </svg>
                               </div>
                            </div>
                            <div>
                               <p class="sc-bJHhxl gXRQqD">Address 2</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="ad2" placeholder="Address 2" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['ad2'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                     <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                  </svg>
                               </div>
                            </div>
                            <div>
                               <p class="sc-bJHhxl gXRQqD">City</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="city" placeholder="City" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['city'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                     <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                  </svg>
                               </div>
                            </div>
                            <div>
                               <p class="sc-bJHhxl gXRQqD">Country</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="country" placeholder="Country" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['country'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <circle cx="12" cy="12" r="10"></circle>
                                     <line x1="2" y1="12" x2="22" y2="12"></line>
                                     <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                  </svg>
                               </div>
                            </div>

                            <div>
                               <p class="sc-bJHhxl gXRQqD">State / Region</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="state" placeholder="*State / Region" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['state'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <circle cx="12" cy="12" r="10"></circle>
                                     <line x1="2" y1="12" x2="22" y2="12"></line>
                                     <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                  </svg>
                               </div>
                            </div>
                            <div>
                               <p class="sc-bJHhxl gXRQqD">Zip Code</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="zip" placeholder="Zip Code" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $acc['zip'];?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                     <polyline points="22,6 12,13 2,6"></polyline>
                                  </svg>
                               </div>
                            </div>
                            <div>
                               <p class="sc-bJHhxl gXRQqD">Tel.</p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <input name="phone" placeholder="Tel." type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $userData->phone;?>">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                     <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                  </svg>
                               </div>
                            </div>
                            <div class="sc-ccLTTT cjuVOD">
                               <p class="sc-hARARD cKOZpE"><span>How did you find us?</span><span class="sc-hlILIN kDoghg">*</span></p>
                               <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                                  <textarea name="hear_about" placeholder="How did you find us?" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"><?php echo $acc['hear_about'];?></textarea>

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
   $(document).ready(function(){
      //xử ly tab
      $('.tabcontent').hide();
      $('.tab_header').removeClass('tab_header_active');

      var segments = $(location).attr('href').split("/").splice(0, 7).join("/").split( '/' );
      var curentTab=segments[5];
      $('.'+curentTab).show();
      $('#'+curentTab).addClass('tab_header_active');

      $('.tab_header').on('click',function(e){
         curentTab = $(this).attr('id');
         $('.tabcontent').hide();//an het cac tab
         $('.tab_header').removeClass('tab_header_active');
         $('.'+curentTab).show();//clss do nos la tab content
         $('#'+curentTab).addClass('tab_header_active');//id do chinsh tab header
         e.preventDefault();
      })
      //xuwr ly del posstrbck
      $('.btn_del_postBack').on('click',function(e){
         e.preventDefault();
         var form = $(this).closest('form');
         ajurl = "<?php echo base_url('v2/profile/postbacks');?>";
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
         ajurl = "<?php echo base_url('v2/profile/postbacks');?>";
         $.ajax({
               type:"POST",
               url:ajurl,
               data:form.serialize(),
               success:ajaxSuccPb,//refhesh
               error:ajaxErr
            });

      });
      // save 
      $('.data_save').on('click',function(e){
         e.preventDefault();
         var form = $(this).closest('form');
         ajurl = "<?php echo base_url('v2/profile/profile');?>";
         $.ajax({
               type:"POST",
               url:ajurl,
               data:form.serialize(),
               success:ajaxSuccess,
               error:ajaxErr
            });

      });
      //reset apikey
      $('#resetApikey').on('click',function(e){
         e.preventDefault();
         var form = $(this).closest('form');
         ajurl = "<?php echo base_url('v2/profile/resetApi');?>";
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

   })
   //ajax thanfh coong
   function ajaxSuccPb(data){
      if(data==1){
         window.location.replace("<?php echo base_url('v2/profile/postbacks');?>");
      }else{
         alert('Error!');
      }
   }
   function ajaxSuccess(data){
      $('#toastContent').html(data);
      var myAlert =document.getElementById('thongBao');//select id of toast
      var bsAlert = new bootstrap.Toast(myAlert,option);//inizialize it
      bsAlert.show();//show it
   }
   function ajaxErr(){
      alert('Update Error!');
   }
   var option = {
      animation:true,
      delay:5000,
      autohide:true
   };

//hamf guiwr ajax post

</script>
