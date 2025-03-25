<!-- postback infomation-offer-->
<div class="row cpv_postback_info mt-3 pt-3">
                     <div class="fomziX">
                        <p class="cpv_postback_info_title">Your Postbacks</p>
                        <div class="d-flex justify-content-end">
                           <a class="" href="/v2/profile/postbacks">
                              <a href="<?php echo base_url('v2/profile/postbacks');?>" type="button" class="btn_pb_info d-inline-flex justify-content-center align-items-center me-1">
                                 <span class="pb_info_icon_wr">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                       <circle cx="12" cy="12" r="10"></circle>
                                       <line x1="2" y1="12" x2="22" y2="12"></line>
                                       <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                    </svg>
                                 </span>
                                 <span class="btn_pb_info_lb">Global postbacks</span>
                              </a>
                           </a>
                           <a href="<?php echo base_url('v2/profile/postbacks');?>" type="button" class="btn_pb_info  d-inline-flex justify-content-center align-items-center">
                              <span class="pb_info_icon_wr">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                 </svg>
                              </span>
                              <span class="btn_pb_info_lb">Add Postback</span>
                           </a>
                        </div>
                        <div class="box-pb-infomation">
                           <div class="box-pb-inf_title" data-bs-toggle="collapse" data-bs-target="#collap_infopb" >
                              Postback information
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                 <line x1="12" y1="19" x2="12" y2="5"></line>
                                 <polyline points="5 12 12 5 19 12"></polyline>
                              </svg>
                           </div>
                           <div class="opostback_infomation collapse" id="collap_infopb">
                              <p>Parameter "PostBack URL" will be useful if its necessary for you to get information about complete conversion automatically. For example in case if you keep records of conversions in external system of statistic or tracking ones at traffic sources.</p>
                              <p>Postback-request will be send to specified URL using method GET.</p>
                              <p>Postbacks will be sent from the given IPs:</p>
                              <pre class="qtdd"><span>213.227.156.167<span>, </span></span><span>213.227.156.169<span>, </span></span><span>213.227.134.71<span>, </span></span><span>213.227.134.212<span>, </span></span><span>212.32.250.3<span>, </span></span><span>212.32.250.2<span>, </span></span><span>213.227.134.73<span>, </span></span><span>213.227.132.163<span>, </span></span><span>212.32.252.83</span></pre>
                              <p>You can use macros specified below to transmit request parameters.</p>
                              <p>Example Postback-link for transmitting of amount of received funds and subaccount:</p>
                              <pre class="qtdd">http://example.com/mystat.php?myprofit={sum}&amp;mySubID={sub1}</pre>
                              <p>In moment of transition macros {sum} and {subid} will be replaced to according values.</p>
                              <hr/>
                              <div class="sc-iGPElx jhcKlU">
                                 <table class="table table-striped table-hover">
                                    <thead>
                                       <tr>
                                          <th style="border-bottom:1px solid #dadada">Parameter</th>
                                          <th style="border-bottom:1px solid #dadada">Description</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr><td>{uagent}</td><td>UserAgent of user browser</td></tr>
                                       <tr><td>{ip}</td><td>User IP-address</td></tr>
                                       <tr><td>{sub1}</td><td>Subaccount 1</td></tr>
                                       <tr><td>{sub2}</td><td>Subaccount 2</td></tr>
                                       <tr><td>{sub3}</td><td>Subaccount 3</td></tr>
                                       <tr><td>{sub4}</td><td>Subaccount 4</td></tr>
                                       <tr><td>{sub5}</td><td>Subaccount 5</td></tr>
                                       <tr><td>{sub6}</td><td>Subaccount 6</td></tr>
                                       <tr><td>{sub7}</td><td>Subaccount 7</td></tr>
                                       <tr><td>{sub8}</td><td>Subaccount 8</td></tr>
                                       <tr><td>{ref_id}</td><td>Used to send clickid value via a postback</td></tr>
                                       <tr><td>{os_id}</td><td>Additional parameter for tracking URL</td></tr>
                                       <tr><td>{ext1}</td><td>Additional parameter for tracking URL</td></tr>
                                       <tr><td>{ext2}</td><td>Additional parameter for tracking URL</td></tr>
                                       <tr><td>{ext3}</td><td>Additional parameter for tracking URL</td></tr>
                                       <tr><td>{transactionid}</td><td>Conversion identificator of advertiser</td></tr>
                                       <tr><td>{date}</td><td>Date and time of conversion committing in format Y-m-d H:i:s</td></tr>
                                       <tr><td>{click_date}</td><td>Date and time of click committing in format Y-m-d H:i:s</td></tr>
                                       <tr><td>{offerid}</td><td>Offer identificator in the System</td></tr>
                                       <tr><td>{offer_name}</td><td>Offer title in the System</td></tr>
                                       <tr><td>{status}</td><td>Conversion status, available values:</td></tr>
                                       <tr><td>{sum}</td><td>Conversion payout</td></tr>
                                       <tr><td>{payout}</td><td>Conversion payout</td></tr>
                                       <tr><td>{city}</td><td>City</td></tr>
                                       <tr><td>{geo}</td><td>Country</td></tr>
                                       <tr><td>{goal}</td><td>Goal</td></tr>
                                       <tr><td>{currency}</td><td>Currency</td></tr>
                                       <tr><td>{comment}</td><td>Comment</td></tr>
                                       <tr><td>{time}</td><td>Time of conversion committing in format H:i:s</td></tr>
                                       <tr><td>{date_only}</td><td>Date of conversion committing in format Y-m-d</td></tr>
                                       <tr><td>{rand}</td><td>Randomly generated number</td></tr>
                                       <tr><td>{referrer}</td><td>Click referrer</td></tr>
                                       <tr><td>{custom_field_1}</td><td>Custom field 1</td></tr>
                                       <tr><td>{custom_field_2}</td><td>Custom field 2</td></tr>
                                       <tr><td>{custom_field_3}</td><td>Custom field 3</td></tr>
                                       <tr><td>{custom_field_4}</td><td>Custom field 4</td></tr>
                                       <tr><td>{custom_field_5}</td><td>Custom field 5</td></tr>
                                       <tr><td>{custom_field_6}</td><td>Custom field 6</td></tr>
                                       <tr><td>{custom_field_7}</td><td>Custom field 7</td></tr>
                                       <tr><td>{custom_field1}</td><td>Custom field 1</td></tr>
                                       <tr><td>{custom_field2}</td><td>Custom field 2</td></tr>
                                       <tr><td>{custom_field3}</td><td>Custom field 3</td></tr>
                                       <tr><td>{custom_field4}</td><td>Custom field 4</td></tr>
                                       <tr><td>{custom_field5}</td><td>Custom field 5</td></tr>
                                       <tr><td>{custom_field6}</td><td>Custom field 6</td></tr>
                                       <tr><td>{custom_field7}</td><td>Custom field 7</td></tr>
                                       <tr><td>{os}</td><td>OS Family</td></tr>
                                       <tr><td>{timestamp}</td><td>unix timestamp of conversion creation</td></tr>
                                       <tr><td>{fbclid}</td><td>Facebook click ID</td></tr>
                                       <tr><td>{order_sum}</td><td>Used to send conversion's price</td></tr>
                                       <tr><td>{order_currency}</td><td>Used to send conversion's currency</td></tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mt-3">
                        <p class="cpv_postback_info_title">Your Javascript Pixels</p>
                        <div class="d-flex justify-content-end">                        
                           <a href="<?php echo base_url('v2/profile/postbacks');?>" type="button" class="btn_pb_info d-inline-flex justify-content-center align-items-center me-1">
                              <span class="pb_info_icon_wr">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                 </svg>
                              </span>
                              <span class="btn_pb_info_lb">Add Pixel</span>
                           </a>
                        </div>
                     </div>
                  </div>
                  <!-- END postback infomation-offer-->