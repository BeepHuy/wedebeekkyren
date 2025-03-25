<div class="row  mt-5">
   <div class="sc-dlyikq hrvHfq">
      <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV">Payments</span>
      <!--div class="sc-hORach fbiYMC">
         <input name="white" type="text" placeholder="Search" class="sc-bMVAic cRFcPy" value=""><span class="sc-bAeIUo eWBLfl">/</span>
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sc-GMQeP kavdHi">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
         </svg>
         </div-->
      <div class="card">
         <div class="card-header">
            <b>Current Payout Amount</b>
         </div>
         <div class="card-body">
            <p class="card-text">You currently have <b>$<?php 
               echo floatval($this->member->available);
               if(floatval($this->pub_config['minpay'])>floatval($this->member->available)){
                   $dis=' disabled ';
               }else{
                   $dis='';
               }
               
               ?></b> ready to be paid out. A minimum balance of <b>$<?php echo floatval($this->pub_config['minpay']);?></b> is required to request a payout.</p>
             
            <div class="col-auto">
                <button type="submit" data-status="new_payment" class="btn btn-primary mb-3 btn-sm ttt" <?php echo $dis?> >Request Payment</button>
            </div>
            
         </div>
      </div>
      <div class="card mt-2">
         <div class="card-header">
            <b>Payout History</b>
         </div>
         <div class="card-body">
            <div class="sc-eitiEO uHLlo">
               <?php
                  if($this->session->userdata('err_po')){
                      echo '<span class="text-danger tt">'.$this->session->userdata('err_po').'</span>';
                      $this->session->unset_userdata('err_po');
                  }
                  if($this->session->userdata('succ_po')){
                      echo '<span class="text-success tt">'.$this->session->userdata('succ_po').'</span>';
                      $this->session->unset_userdata('succ_po');
                  }
                  if($payment){
                      foreach($payment as $payment){
                        if($payment->method=='Bank Wire'){
                            $ar = unserialize($payment->note);
                                $note.= "<b>Name on Account".': </b>'.$ar['wire_name_on_card'].'<br/>';
                                $note.= "<b>Address on Account".': </b>'.$ar['wire_address'].'<br/>';
                                $note.= "<b>City on Account".': </b>'.$ar['wire_city'].'<br/>';
                                $note.= "<b>State on Account".': </b>'.$ar['wire_state'].'<br/>';
                                $note.= "<b>Zip on Account".': </b>'.$ar['wire_zip'].'<br/>';
                                $note.= "<b>Bank Name".': </b>'.$ar['wire_bankname'].'<br/>';
                                $note.= "<b>Bank Address".': </b>'.$ar['wire_bankaddress'].'<br/>';
                                $note.= "<b>Bank Country".': </b>'.$ar['wire_country'].'<br/>';
                                $note.= "<b>Account Number".': </b>'.$ar['wire_accountnum'].'<br/>';
                                $note.= "<b>Swiftcode".': </b>'.$ar['wire_purpose'].'<br/>';
                        }else{
                            $note =$payment->note;
                        }

                          echo '
                          <a class="sc-gGCbJM bfwcis" href="#" data-status="'.$payment->status.'" data-id="'.$payment->id.'">
                              <span class="sc-lcpuFF sc-bqjOQT text-success edit_pp">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                  </svg>
                              </span>
                              <span class="sc-lcpuFF sc-bqjOQT fYJXyK">'.$payment->date.'</span>
                              <span class="sc-lcpuFF sc-jkCMRl iYdzkK method">'.$payment->method.'</span>
                              <span class="sc-lcpuFF sc-jkCMRl iYdzkK note">'.$note.'</span>
                              <span class="sc-lcpuFF sc-crNyjn hERdbK">'.$payment->amount.'<span>USD</span></span>
                              <div type="2" class="sc-nrwXf dhYqaO '.$payment->status.'">'.$payment->status.'</div>
                          </a>
                          ';
                      }
                  }
                  ?>         
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="paymentModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <form class="formpayment" method="post" action="<?php echo base_url('v2/request_payouts');?>">
            <input type="hidden" name="pid" id="pid" value="0">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <style>
               .formpayment label{
               text-align: right
               }
            </style>
         
            <div class="modal-body">
                <div class="row mb-2" id="amount">
                  <label class="col-sm-4 col-form-label  col-form-label-sm">Amount</label>
                  <div class="col-sm-8">                     
                  <input type="text" name="amount" class="form-control form-control-sm" id="amount" placeholder="$">
                  </div>
               </div>
               <div class="row mb-2">
                  <label for="payment_method" class="col-sm-4 col-form-label  col-form-label-sm">Payment Method</label>
                  <div class="col-sm-8">
                     <select name="payment_method" class="form-select form-select-sm" id="payment_method">
                        <option  value="pmchose">Payment Method</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Payoneer">Payoneer</option>
                        <option value="Crypto">Crypto</option>
                        <option value="Bank Wire">Bank Wire</option>
                     </select>
                  </div>
               </div>
               <!--payoone-->
               <div class="row mb-2 formpay" id="Payoneer">
                  <label class="col-sm-4 col-form-label  col-form-label-sm">Payoneer Id</label>
                  <div class="col-sm-8">                     
                     <input type="text" name="payment_payoneer_email" id="input_Payoneer" class="form-control form-control-sm" value="<?php echo $this->member_info['payment_payoneer_email'];?>">
                  </div>
               </div>
               <!-- paypal-->
               <div class="row mb-2 formpay" id="PayPal">
                  <label class="col-sm-4 col-form-label  col-form-label-sm">Paypal Email</label>
                  <div class="col-sm-8">                     
                     <input type="text" name="payment_paypal_email" id="input_PayPal" class="form-control form-control-sm" value="<?php echo $this->member_info['payment_paypal_email'];?>">
                  </div>
               </div>
                <!-- crypto-->
                <div class="row mb-2 formpay" id="Crypto">
                  <label class="col-sm-4 col-form-label  col-form-label-sm">Detail Payment</label>
                  <div class="col-sm-8">                     
                     <textarea type="text" name="payment_Crypto" id="input_Crypto" class="form-control form-control-sm"></textarea>
                  </div>
               </div>
               <!--wire-->
               <div  id="BankWire" class="formpay">
                    <div class="row mb-2 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Name on Account</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_name_on_card]" type="text" class="form-control form-control-sm"  value="<?php echo @$this->member_info['firstname'].$this->member_info['lastname'];?>">
                        </div>
                    </div>
                    <div class="row mb-2 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Address on Account</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_address]" type="text" class="form-control form-control-sm"  value="<?php echo @$this->member_info['ad'];?>">
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm" >City on Account</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_city]" type="text" class="form-control form-control-sm"  value="<?php echo @$this->member_info['city'];?>">
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">State on Account</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_state]" type="text" class="form-control form-control-sm"  value="<?php echo @$this->member_info['state'];?>">
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Zip on Account</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_zip]" type="text" class="form-control form-control-sm"  value="<?php echo @$this->member_info['zip'];?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Bank Name</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_bankname]" type="text" class="form-control form-control-sm" >
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Bank Address</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_bankaddress]" value="<?php echo @$this->member_info['payment_BankWire[wire_bankaddress'];?>" type="text" class="form-control form-control-sm" >
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Bank Country</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" name="BankWire[wire_country]"  value="<?php echo @$this->member_info['payment_BankWire[wire_country'];?>">
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Account Number</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_accountnum]"  value="<?php echo @$this->member_info['payment_BankWire[wire_accountnum'];?>" type="text" class="form-control form-control-sm" >
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label class="col-sm-4 col-form-label  col-form-label-sm">Swiftcode</label>
                        <div class="col-sm-8">
                            <input name="BankWire[wire_purpose]" value="<?php echo @$this->member_info['payment_BankWire[wire_purpose'];?>" type="text" class="form-control form-control-sm" >
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary btn-sm" id="savebutton" disabled>Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- end modal payment2-->
<script>
   $(document).ready(function(){
      
       $('.ttt').click(function(e){
           var st = $(this).attr('data-status');
           if((st!="new_payment") && (st!="Pending") ){
               alert('This Payment is '+st +' !');
           }else{
               //xuwr lsy ok
               var pid = $(this).attr('data-id');
               var note = $(this).find('.note').text();
               var method = $(this).find('.method').text();
               //xuwr lsy ok
                if(pid){
                    $('#amount').hide();

                    $('#payment_method').val(method).change();
                    $('#pid').val(pid);
                    $('#input_'+method).val(note);                    

                }else{
                    $('#pid').val(0);
                    $('#amount').show();
                    $('#payment_method').val('pmchose').change();
                }
                $('#paymentModal').modal('show');
               
           }
         
           e.preventDefault();
           
       });
                       
        //form payment**************************************
       $('.formpay').hide();           
    
        $('#payment_method').on('change', function (e) {
            payoption = $(this).val();            
            if(payoption) {
                if(payoption=="Bank Wire") payoption="BankWire";
                $('.formpay').hide();
                $('#'+payoption).show();
                if(payoption=="pmchose"){
                    $("#savebutton").prop("disabled", true);
                }else{
                    $("#savebutton").removeAttr('disabled');
                }
                
            }  
        });
       //end form payment ****************************************************
   });
</script>
<style>
   .tt{margin-bottom:20px;font-weight:bold;display:block}
   .Reverse{
   background-color:#c5577d !important; 
   }
   .Pending{
   background-color:#ad7e30 !important; 
   }
   .edit_pp{width:30px}
   /*! CSS Used from: Embedded */
   *{box-sizing:border-box;}
   div,span,a{margin:0px;padding:0px;border:0px;font-size:100%;vertical-align:baseline;}
   .fbiYMC{display:flex;-webkit-box-align:center;align-items:center;width:230px;max-width:450px;position:relative;transition:width 0.1s ease 0s;}
   @media (max-width: 425px){
   .fbiYMC{width:100%;}
   }
   .cRFcPy{outline:0px;border:0px;height:33px;font-size:0.9em;padding:0px 35px 0px 10px;background-color:rgb(236, 236, 238);display:flex;-webkit-box-align:center;align-items:center;width:100%;border-radius:2px;color:rgb(62, 62, 73);}
   .cRFcPy::-webkit-input-placeholder{color:rgb(153, 153, 153);}
   .cRFcPy:focus{padding:0px 60px 0px 10px;}
   .cRFcPy:focus::-webkit-input-placeholder{color:transparent;}
   .eWBLfl{color:rgb(166, 166, 166);position:absolute;right:10px;width:20px;height:20px;display:flex;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;border:1px solid rgb(187, 187, 187);border-radius:2px;}
   @media (max-width: 425px){
   .eWBLfl{display:none;}
   }
   .kavdHi{position:absolute;right:8px;top:8px;color:rgb(62, 62, 73);display:none;}
   @media (max-width: 425px){
   .kavdHi{display:block;}
   }
   .bfwcis{display:flex;-webkit-box-pack:justify;justify-content:space-between;-webkit-box-align:center;align-items:center;margin-bottom:7px;padding:12px 15px;border-radius:3px;background-color:rgb(255, 255, 255);color:rgb(0, 0, 0);box-shadow:rgba(0, 0, 0, 0.17) 0px 2px 7px 0px;font-size:13px;text-decoration:none;transition:all 0.2s ease 0s;}
   .bfwcis:hover{transform:scale(0.99);}
   @media (max-width: 768px){
   .bfwcis{flex-direction:column;align-items:flex-start;}
   }
   .fYJXyK{width:25%;padding-right:10px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
   @media (max-width: 768px){
   .fYJXyK{width:100%;margin-bottom:10px;padding-right:0px;}
   }
   .iYdzkK{width:20%;}
   @media (max-width: 768px){
   .iYdzkK{width:100%;margin-bottom:10px;padding-right:0px;}
   }
   .hERdbK{width:15%;color:rgb(131, 131, 131);}
   @media (max-width: 768px){
   .hERdbK{width:100%;margin-bottom:10px;padding-right:0px;}
   }
   .hERdbK > span{padding-left:3px;}
   .fTkPgh{width:25%;padding-right:10px;}
   @media (max-width: 768px){
   .fTkPgh{width:100%;margin-bottom:10px;padding-right:0px;}
   }
   .dhYqaO{display:flex;-webkit-box-pack:center;justify-content:center;width:15%;padding:2px 7px;border-radius:3px;background-color:rgb(73, 142, 68);color:rgb(255, 255, 255);text-transform:uppercase;text-align:center;font-size:12px;}
   @media (max-width: 768px){
   .dhYqaO{width:auto;margin-bottom:0px;}
   }
   .uHLlo{margin-top:20px;}
   .hrvHfq{flex:1 1 0%;}
   /*! CSS Used from: Embedded */
   ._1ykwro3W9x7ktXduniR6Cp{background-color:inherit;display:inline-block;}
   ._2zZKiYIMOuyWJddFzI_uHV{font-size:1.6em;padding:5px 0 15px;}
   /*! CSS Used from: Embedded */
   .css-1didjui{text-transform:capitalize;font-size:18px;color:rgb(102, 102, 102);}
</style>