<div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent payment">
   <div class="sc-doWzTn dLRsqg">      
            <?php
            echo $this->session->userdata('thongbao');
            $this->session->unset_userdata('thongbao');
            if(!empty($this->member_info['payment_method'])){
               if($this->member_info['payment_method']=='paypal'){
                  echo '
                           <div class="sc-dBaXSw dRFICO">        
                              <form class="sc-fHSTwm kFqhpQ" method="post" action="'.base_url('v2/profile/payment').'">
                              <input type="hidden" name="action" value="1"/>
                              <input type="hidden" name="payment_method" value="paypal"/>
                                 <div class="sc-hdPSEv fjGKvx">
                                    <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                       <span class="_2emChIs6yt79MK9bxuriDh">Payment system</span>
                                       <input disabled="" placeholder="Payment system" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-pr7nsj" value="Paypal">
                                    </div>
                                    <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                       <span class="_2emChIs6yt79MK9bxuriDh">Currency</span>
                                       <input placeholder="Currency" disabled="" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-pr7nsj" value="USD">
                                    </div>
                                    <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                       <span class="_2emChIs6yt79MK9bxuriDh">PayPal email</span>
                                       <input name="payment_paypal_email" placeholder="PayPal email" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="'.@$this->member_info['payment_paypal_email'].'">
                                    </div>
                                 </div>
                                 <div class="sc-gleUXh iCdcLw">
                              <button type="submit" class="data_save K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                                 <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                 <span class="_1pFgCebzxXEI3gItBe_863">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                       <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                 </span>
                                 <span class="_3axrJUuPR6Tfk-J1aQF4dm">Save</span>
                              </button>
                              <button type="button" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                                 <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                 <span class="_1pFgCebzxXEI3gItBe_863">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                       <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                 </span>
                                 <span class="_3axrJUuPR6Tfk-J1aQF4dm">Mark payment system as main</span>
                              </button>
                           </div>
                           <div class="sc-cmIlrE friTVO">
                              <button type="button" class="_1LJBCl0B6Vr36tDEKevj-b css-13zo4jz">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                 </svg>
                              </button>
                           </div>
                        </form> 
                     </div>
                  ';
               }
               if($this->member_info['payment_method']=='payoneer'){
                  echo '
                           <div class="sc-dBaXSw dRFICO">        
                              <form class="sc-fHSTwm kFqhpQ" method="post" action="'.base_url('v2/profile/payment').'">
                              <input type="hidden" name="action" value="1"/>
                              <input type="hidden" name="payment_method" value="payoneer"/>
                                 <div class="sc-hdPSEv fjGKvx">
                                    <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                       <span class="_2emChIs6yt79MK9bxuriDh">Payment system</span>
                                       <input disabled="" placeholder="Payment system" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-pr7nsj" value="payoneer">
                                    </div>
                                    <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                       <span class="_2emChIs6yt79MK9bxuriDh">Currency</span>
                                       <input placeholder="Currency" disabled="" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-pr7nsj" value="USD">
                                    </div>
                                    <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                       <span class="_2emChIs6yt79MK9bxuriDh">payoneer Id</span>
                                       <input name="payment_payoneer_email" placeholder="payoneer email" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="'.@$this->member_info['payment_payoneer_email'].'">
                                    </div>
                                 </div>
                                 <div class="sc-gleUXh iCdcLw">
                              <button type="submit" class="data_save K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                                 <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                 <span class="_1pFgCebzxXEI3gItBe_863">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                       <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                 </span>
                                 <span class="_3axrJUuPR6Tfk-J1aQF4dm">Save</span>
                              </button>
                              <button type="button" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                                 <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                 <span class="_1pFgCebzxXEI3gItBe_863">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                       <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                 </span>
                                 <span class="_3axrJUuPR6Tfk-J1aQF4dm">Mark payment system as main</span>
                              </button>
                           </div>
                           <div class="sc-cmIlrE friTVO">
                              <button type="button" class="_1LJBCl0B6Vr36tDEKevj-b css-13zo4jz">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                 </svg>
                              </button>
                           </div>
                        </form> 
                     </div>
                  ';
               }
               if($this->member_info['payment_method']=='wire'){
                  echo '
                     <div class="sc-dBaXSw dRFICO">        
                        <form class="sc-fHSTwm kFqhpQ"  method="post" action="'.base_url('v2/profile/payment').'">
                        <input type="hidden" name="action" value="1"/>
                        <input type="hidden" name="payment_method" value="wire"/>
                           <div class="sc-hdPSEv fjGKvx">
                              <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                 <span class="_2emChIs6yt79MK9bxuriDh">Payment system</span>
                                 <input disabled="" placeholder="Payment system" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-pr7nsj" value="Bank Wire">
                              </div>
                              <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                 <span class="_2emChIs6yt79MK9bxuriDh">Currency</span>
                                 <input placeholder="Currency" disabled="" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-pr7nsj" value="USD">
                              </div>

                              <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                 <span class="_2emChIs6yt79MK9bxuriDh">Bank Name</span>
                                 <input name="payment_wire_bankname" placeholder="Bank Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="'.@$this->member_info['payment_wire_bankname'].'">
                              </div>
                              <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                 <span class="_2emChIs6yt79MK9bxuriDh">Bank Address</span>
                                 <input name="payment_wire_bankaddress" placeholder="Bank Address" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="'.@$this->member_info['payment_wire_bankaddress'].'">
                              </div>
                              <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                 <span class="_2emChIs6yt79MK9bxuriDh">Account Number</span>
                                 <input name="payment_wire_accountnum" placeholder="Account Number" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="'.@$this->member_info['payment_wire_accountnum'].'">
                              </div>
                              <div class="_3WCfA5WYRlXEJAXoSGLCJM css-14okyx3">
                                 <span class="_2emChIs6yt79MK9bxuriDh">Swiftcode</span>
                                 <input name="payment_wire_purpose" placeholder="Swiftcode" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="'.@$this->member_info['payment_wire_purpose'].'">
                              </div>
                              
                           </div>
                           <div class="sc-gleUXh iCdcLw">
                        <button type="submit" class="data_save K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                           <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                           <span class="_1pFgCebzxXEI3gItBe_863">
                              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                 <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                              </svg>
                           </span>
                           <span class="_3axrJUuPR6Tfk-J1aQF4dm">Save</span>
                        </button>
                        <button type="button" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                           <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                           <span class="_1pFgCebzxXEI3gItBe_863">
                              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                 <polyline points="20 6 9 17 4 12"></polyline>
                              </svg>
                           </span>
                           <span class="_3axrJUuPR6Tfk-J1aQF4dm">Mark payment system as main</span>
                        </button>
                     </div>
                     <div class="sc-cmIlrE friTVO">
                        <button type="button" class="data_save _1LJBCl0B6Vr36tDEKevj-b css-13zo4jz ">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                              <polyline points="3 6 5 6 21 6"></polyline>
                              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                           </svg>
                        </button>
                     </div>
                  </form> 
               </div>
                  ';
                  
               }
            }
            ?>

            


      <div class="sc-bNQFlB leWwoU">
         <button type="button" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_"  data-bs-toggle="modal" data-bs-target="#paymentModal">
            <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
            <span class="_1pFgCebzxXEI3gItBe_863">
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
               </svg>
            </span>
            <span class="_3axrJUuPR6Tfk-J1aQF4dm">Add Payment System</span>
         </button>
      </div>
   </div>
</div>
<div class="clearfix mb-2"></div>
<!-- Modal -->
<div class="modal fade" id="paymentModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

      <form class="formpayment" method="post" action="<?php echo base_url('v2/profile/post_payment');?>">
      <input type="hidden" name="action" value=1/>
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <style>
         .formpayment label{
            text-align: right
         }
         </style>
         <script>
            $(document).ready(function(){
               $('#payment_method').val('<?php echo $this->member_info['payment_method'];?>');
               $('#payment_method').trigger("liszt:updated");                  
                  var payoption = '<?php echo $this->member_info['payment_method'];?>';                   
                  if(payoption == 'paypal') {
                     $('#paypal').show();
                     $('.wire').hide();
                     $('#payoneer').hide();
                  }
                  
                  if(payoption == 'wire') {
                     $('.wire').show();
                     $('#paypal').hide();
                     $('#payoneer').hide();
                  }
                  if(payoption == 'payoneer') {
                     $('.wire').hide();
                     $('#paypal').hide();
                     $('#payoneer').show();
                  }

               $('#payment_method').on('change', function (e) {
                  payoption = $(this).val(); 
                  
                  if(payoption == 'paypal') {
                     $('#paypal').show();
                     $('.wire').hide();
                     $('#payoneer').hide();
                  }
                  if(payoption == 'wire') {
                     $('.wire').show();
                     $('#paypal').hide();
                     $('#payoneer').hide();
                  }
                  if(payoption == 'payoneer') {
                     $('.wire').hide();
                     $('#paypal').hide();
                     $('#payoneer').show();
                  }
               });
            });
            
         </script>
         <div class="modal-body">
            
               <div class="row mb-2">
                  <label for="payment_method" class="col-sm-4 col-form-label  col-form-label-sm">Payment Method</label>
                  <div class="col-sm-8">
                     <select name="payment_method" class="form-select form-select-sm" id="payment_method">
                        <option selected>Choose...</option>
                        <option value="wire">Bank Wire</option>
                        <option value="paypal">PayPal</option>
                        <option value="payoneer">Payoneer Id</option>
                     </select>
                  </div>
               </div>
               <!--payoone-->
               
               <div class="row mb-2" id="payoneer">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Payoneer Id</label>
                  <div class="col-sm-8">                     
                     <input id="inputname" type="text" name="payment_payoneer_email" class="form-control form-control-sm" value="<?php echo $this->member_info['payment_payoneer_email'];?>">
                  </div>
               </div>

               <!-- paypal-->
               <div class="row mb-2" id="paypal">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Paypal Email</label>
                  <div class="col-sm-8">                     
                     <input id="inputname" type="text" name="payment_paypal_email" class="form-control form-control-sm" value="<?php echo $this->member_info['payment_paypal_email'];?>">
                  </div>
               </div>

               <!--wire-->

               <div class="row wire mb-2">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Name on Account</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="inputname"  value="<?php echo @$this->member_info['firstname'].$this->member_info['lastname'];?>">
                  </div>
               </div>

               <div class="row wire mb-2">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Address on Account</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="inputname"  value="<?php echo @$this->member_info['ad'];?>">
                  </div>
               </div>
               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm" >City on Account</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="inputname"  value="<?php echo @$this->member_info['city'];?>">
                  </div>
               </div>
               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">State on Account</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="inputname"  value="<?php echo @$this->member_info['state'];?>">
                  </div>
               </div>

               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Zip on Account</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="inputname"  value="<?php echo @$this->member_info['zip'];?>">
                  </div>
               </div>
               <hr/>

               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Bank Name</label>
                  <div class="col-sm-8">
                     <input name="payment_wire_bankname" name="payment_wire_bankname" type="text" class="form-control form-control-sm" id="inputname">
                  </div>
               </div>
               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Bank Address</label>
                  <div class="col-sm-8">
                     <input name="payment_wire_bankaddress" value="<?php echo @$this->member_info['payment_wire_bankaddress'];?>" type="text" class="form-control form-control-sm" id="inputname">
                  </div>
               </div>
               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Bank Country</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="inputname" name="payment_wire_country"  value="<?php echo @$this->member_info['payment_wire_country'];?>">
                  </div>
               </div>
               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Account Number</label>
                  <div class="col-sm-8">
                     <input name="payment_wire_accountnum"  value="<?php echo @$this->member_info['payment_wire_accountnum'];?>" type="text" class="form-control form-control-sm" id="inputname">
                  </div>
               </div>
               <div class="row wire mb-3">
                  <label for="inputname" class="col-sm-4 col-form-label  col-form-label-sm">Swiftcode</label>
                  <div class="col-sm-8">
                     <input name="payment_wire_purpose" value="<?php echo @$this->member_info['payment_wire_purpose'];?>" type="text" class="form-control form-control-sm" id="inputname">
                  </div>
               </div>
            
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
         </div>
      </form>

      </div>
   </div>
</div>