<div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent postbacks">
   <div class="sc-fKGOjr eFewfh">
      <?php
      if(!empty($postBack)){
         foreach($postBack as $postBack){
            echo '
            <form class="sc-hzDEsm huqNsh">
               <div class="sc-jeCdPy hcaxXo">
                  <div class="_3WCfA5WYRlXEJAXoSGLCJM css-pp1feo">
                     <input type="hidden" name="pbid" value="'.$postBack->id.'">
                     <input type="hidden" name="action" value="deletePostBack">
                     <input name="url" data-id="" placeholder="URL" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="'.$postBack->postback.'">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                     </svg>
                  </div>
                  
                  <div class="_2pOF-T29kOhb_V7rdJc7lm css-s9dgfu">
                     <div class="_19C74tkRgpO1m06ZW7AnB1 css-d3aal9">
                        <div class="_2OwLpj9TZ-8y_zCUI9GiK5">
                           <div class="_3XLJyNAzVNxxfc02Pjj2fW">
                              <span class="_3aNWr-_oGR2IfWm2Dgv-87">Approved</span>
                              <div class="_2MwchzF2ZswCEBEcL8RjRk"></div>
                           </div>
                        </div>
                        <div class="hwGe6ChZS1mygU7IkVQkN ueyjmSYC7EYpmNEMn2w2M">
                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_6FF2NYn2DKbXwyhEkUyVK">
                              <polyline points="6 9 12 15 18 9"></polyline>
                           </svg>
                        </div>
                     </div>
                  </div>
                  <button disabled="" type="submit" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                     <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                     <span class="_1pFgCebzxXEI3gItBe_863">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                           <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                     </span>
                     <span class="_3axrJUuPR6Tfk-J1aQF4dm">Save</span>
                  </button>
               </div>
               <button type="button" class="_1LJBCl0B6Vr36tDEKevj-b  btn_del_postBack">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                     <polyline points="3 6 5 6 21 6"></polyline>
                     <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                  <span class="">Remove</span>
               </button>
            </form>
            
            ';
         }
      }
      ?>
      
      <div class="sc-jvEmr kJNEUr">
         <button type="button" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_" data-bs-toggle="modal" data-bs-target="#pbModal">
            <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
            <span class="_1pFgCebzxXEI3gItBe_863">
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
               </svg>
            </span>
            <span class="_3axrJUuPR6Tfk-J1aQF4dm">Add Postback</span>
         </button>
      </div>
      <hr/>
      <div class="row mt-4">
         
         <div class="col-6">
         <h5 style="display:block;margin:0 auto;" class="mb-4">Test Postback</h5>
           
            <div class="row mb-3">
                  <label for="pburl" class="col-sm-2 col-form-label-sm">Offers Test</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control form-control-sm" id="pburl" value="<?php echo base_url(); ?>click/testpb?pid=<?php echo $this->member->id ?>&offer_id=7745">
                  </div>
               </div>
               
               <div class="alert alert-success" role="alert">
                  Please add this link to your website in the offer section.  Then just run the link in your offer output to complete the conversion test
               </div>
              
           
         </div>
         <div class="col-6" id="postback_status">


         </div>

      </div>

       <!-- <div class="sc-fZwumE pqimY mt-3">
         <div class="sc-fQejPQ gOmke" data-bs-toggle="collapse" data-bs-target="#Postback_information">
            Postback information
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
               <line x1="12" y1="19" x2="12" y2="5"></line>
               <polyline points="5 12 12 5 19 12"></polyline>
            </svg>
         </div>
         <div id="Postback_information" class="collapse">
            <p class="sc-clNaTc iSOTr">Parameter "PostBack URL" will be useful if its necessary for you to get information about complete conversion automatically. For example in case if you keep records of conversions in external system of statistic or tracking ones at traffic sources.</p>
            <p class="sc-clNaTc iSOTr">Postback-request will be send to specified URL using method GET.</p>
            <p class="sc-clNaTc iSOTr">Postbacks will be sent from the given IPs:</p>
            <pre class="sc-etwtAo jIycMb"><span>213.227.156.167<span>, </span></span><span>213.227.156.169<span>, </span></span><span>213.227.134.71<span>, </span></span><span>213.227.134.212<span>, </span></span><span>212.32.250.3<span>, </span></span><span>212.32.250.2<span>, </span></span><span>213.227.134.73<span>, </span></span><span>213.227.132.163<span>, </span></span><span>212.32.252.83</span></pre>
            <p class="sc-clNaTc iSOTr">You can use macros specified below to transmit request parameters.</p>
            <p class="sc-clNaTc iSOTr">Example Postback-link for transmitting of amount of received funds and subaccount:</p>
            <pre class="sc-etwtAo jIycMb">http://example.com/mystat.php?myprofit={sum}&amp;mySubID={sub1}</pre>
            <p class="sc-clNaTc iSOTr">In moment of transition macros {sum} and {subid} will be replaced to according values.</p>
            <div class="sc-jXQZqI JxdHt"></div>
            <div class="sc-iGPElx jhcKlU">
               <ul>
                  <li class="sc-eInJlc kgLgJH"><span class="sc-hgHYgh sc-gtfDJT fbsUHh">Parameter</span><span class="sc-fOICqy eXmHYv">Description</span></li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{uagent}</span>UserAgent of user browser</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{ip}</span>User IP-address</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub1}</span>Subaccount 1</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub2}</span>Subaccount 2</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub3}</span>Subaccount 3</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub4}</span>Subaccount 4</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub5}</span>Subaccount 5</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub6}</span>Subaccount 6</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub7}</span>Subaccount 7</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sub8}</span>Subaccount 8</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{ref_id}</span>Used to send clickid value via a postback</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{os_id}</span>Additional parameter for tracking URL</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{ext1}</span>Additional parameter for tracking URL</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{ext2}</span>Additional parameter for tracking URL</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{ext3}</span>Additional parameter for tracking URL</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{transactionid}</span>Conversion identificator of advertiser</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{date}</span>Date and time of conversion committing in format Y-m-d H:i:s</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{click_date}</span>Date and time of click committing in format Y-m-d H:i:s</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{offerid}</span>Offer identificator in the System</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{offer_name}</span>Offer title in the System</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{status}</span>Conversion status, available values:</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{sum}</span>Conversion payout</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{payout}</span>Conversion payout</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{city}</span>City</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{geo}</span>Country</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{goal}</span>Goal</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{currency}</span>Currency</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{comment}</span>Comment</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{time}</span>Time of conversion committing in format H:i:s</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{date_only}</span>Date of conversion committing in format Y-m-d</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{rand}</span>Randomly generated number</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{referrer}</span>Click referrer</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field_1}</span>Custom field 1</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field_2}</span>Custom field 2</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field_3}</span>Custom field 3</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field_4}</span>Custom field 4</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field_5}</span>Custom field 5</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field_6}</span>Custom field 6</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field_7}</span>Custom field 7</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field1}</span>Custom field 1</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field2}</span>Custom field 2</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field3}</span>Custom field 3</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field4}</span>Custom field 4</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field5}</span>Custom field 5</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field6}</span>Custom field 6</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{custom_field7}</span>Custom field 7</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{os}</span>OS Family</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{timestamp}</span>unix timestamp of conversion creation</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{fbclid}</span>Facebook click ID</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{order_sum}</span>Used to send conversion's price</li>
                  <li class="sc-kasBVs eDNLfK"><span class="sc-hgHYgh bslKcw">{order_currency}</span>Used to send conversion's currency</li>
               </ul>
            </div>
         </div>
        </div> -->
   </div>
</div>



<!-- Modal -->
<div class="modal fade" id="pbModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg: Làm cho modal lớn hơn -->
      <div class="modal-content">

       <form>
         <div class="modal-header">
         <h5 class="modal-title" id="pbModalLabel" style="color: #3d76b9;">Add</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            
         <div class="input-group mb-3"> <!-- Thêm mb-3 để tạo khoảng cách giữa các phần tử -->
               <span class="input-group-text" id="addon-wrapping">URL</span>
               <input name="url" type="text" class="form-control form-control-lg" placeholder="PostBack Url" aria-label="Url" aria-describedby="addon-wrapping"> <!-- form-control-lg: Tăng kích thước input -->  
               <input type="hidden"  name="action" value="addPostback">           
            </div>  
            <div style="border: 1px solid #dddddd; border-radius: 5px; padding: 15px; margin-bottom: 20px; background-color: #fafafa;">
                  <!-- Chọn Tất Cả -->
                  <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                     <span style="font-weight: bold;">Status : </span>
                  </label>
                  <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                     <span style="font-weight: bold; ">Postback Information: Postback-request will be send to specified URL using method GET.</span>
                  </label>
                  <hr style="margin: 10px 0;">
                  <!-- Các Tùy Chọn -->
                  <div style="display: flex; flex-wrap: wrap;">
                     <div style="width: 50%; padding-right: 10px;">
                        <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">

                           <span style="font-weight: bold; color: #333333;">{sub1}</span>
                           <span style="margin-left: 5px; color: #555555; font-style: italic;">(Used to send Clickid value via a postback)</span>
                        </label>
                        <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">

                           <span style="font-weight: bold; color: #333333;">{sub2}</span>
                           <span style="margin-left: 5px; color: #555555; font-style: italic;">(Used to send Affiliate ID value via a postback)</span>
                        </label>
                        <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">

                           <span style="font-weight: bold; color: #333333;">{sub3}</span>
                           <span style="margin-left: 5px; color: #555555; font-style: italic;">(Used to send Sub – Affiliate ID value via a postback)</span>
                        </label>
                     </div>
                     <div style="width: 50%; padding-left: 10px;">
                        <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">

                           <span style="font-weight: bold; color: #333333;">{sub4}</span>
                           <span style="margin-left: 5px; color: #555555; font-style: italic;">(Used to send Any value via a postback)</span>
                        </label>
                        <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">

                           <span style="font-weight: bold; color: #333333;">{payout}</span>
                           <span style="margin-left: 5px; color: #555555; font-style: italic;">(Used to get Payout per conversion)</span>
                        </label>
                        <label style="display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">

                           <span style="font-weight: bold; color: #333333;">{saleAmount}</span>
                           <span style="margin-left: 5px; color: #555555; font-style: italic;">(Used to get Amount for per sale.)</span>
                        </label>
                     </div>
                  </div>
         </div>
         </div>
         <div class="modal-footer">
               <button type="button" class="btn btn-lg data_save2" style="background-color: #3d76b9; color: white;">Save</button>
         </div>
         </form>


    </div>
  </div>
</div>