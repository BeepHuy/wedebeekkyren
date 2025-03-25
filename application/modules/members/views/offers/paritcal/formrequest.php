<div class="mt-3">
<div class="container my-4">
<div class="card shadow-sm p-3">
   <form id="myForm" class="form-rq" method="POST" action="<?php echo ($status == 'Deny') ? base_url('v2/offers/requpdate/'.$rq->id) : base_url('v2/offers/request/'.$offer->id); ?>">
      
            <!-- Thông báo không chỉnh sửa -->
            <div class="mb-3">
               <input style="font-size:14px" type="text" class="form-control text-center" placeholder="To promote this campaign, you need to provide traffic details below!" disabled />
            </div>

            <!-- Traffic Type -->
            <div class="mb-3">
               <label for="mySelect" class="form-label fw-bold">Traffic Type 
                  <span class="text-danger" id="crequestError"></span>
               </label>

               <select style="font-size:13.5px" id="mySelect" name="crequest[]" multiple class="form-select" data-placeholder="Select Traffic Type">
                  <?php foreach ($traftype as $type): ?>
                     <option style="font-size:13.5px" value="<?php echo $type->name; ?>"><?php echo $type->name; ?></option>
                  <?php endforeach; ?>
               </select>
            </div>

            <!-- Traffic URL -->
            <div class="mb-3" id="trafficUrlContainer">
               <label for="trafficUrl" class="form-label fw-bold">Traffic URL 
                  <span class="text-danger" id="trafficurlError"></span>
               </label>
               <input type="text" class="form-control" name="trafficurl" id="trafficUrl" style="font-size:13.5px" placeholder="Please fill in the exact Website URL where you place the tracking to receive traffic!" />
            </div>
            <div id="dynamicTrafficFields" style="display:none">
                                            
            </div>

            <!-- Card chứa Subject và Message (chỉ hiển thị khi chọn Email Traffic) -->
            <div class="card shadow-sm p-3 mt-4" id="emailContentCard" style="display:none;margin-top:10px">
               <!-- Subject -->
               <label for="emailtraffic" class="form-label fw-bold">Email Traffic</label>
               <hr>
               <div class="mb-3">
                  <input style="font-size:14px" type="text" class="form-control text-center" placeholder="Please provide the creative you use to send to potential customers!" disabled />
               </div>
               <div class="mb-3">
                  <label for="subject" class="form-label">Subject 
                     <span class="text-danger" id="subjectError"></span>
                  </label>
                  <input style="font-size:13.5px" type="text" class="form-control" name="subject" id="subject" placeholder="Enter your Subject" />
               </div>

              <!-- Message -->
              <div class="mb-3">
                  <label for="message" class="form-label">Creative Content <span class="text-danger" id="soanthaoError"></span> </label>
                  <textarea id="soanthao" name="message" class="form-control" rows="4" placeholder="Enter your message..."></textarea>
                  <p id="charCount">0 / 50.000 characters</p>
               </div>
            </div>
         </div>
      </div>
      <div class="d-flex justify-content-between align-items-center mt-2">
         <div class="denytext" style="padding-right: 30px;">
            <?php
               if($status == 'Deny'){
                  $this->load->view('offers/paritcal/status.php', ['rq' => $rq]);
               }
            ?>
         </div>
         <div>
            <button type="submit" class="btn_prv_link btn_prv_link_2">
               <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
               <span class="btn_prv_link_2_child_span">
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                     <line x1="12" y1="5" x2="12" y2="19"></line>
                     <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
               </span>
               <span class="btn_prv_link_2_child2"><?php echo ($status == 'Deny') ? 'Reapply' : 'Apply'; ?></span>
            </button>
         </div>
      </div>
   </form>
</div>