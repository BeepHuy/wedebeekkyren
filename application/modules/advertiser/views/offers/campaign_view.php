<!-- offer content-->
<div class="mt-5 mb-2">
   <span class="offer-view-title"><?php echo $offer->title;?></span>
</div>
<div class="card mb-4">
   <div class="card-body" >
      <div class="row campaign-views">
         <div class="col-lg-7 ps-md-3 pe-md-4 vcampaign_left">
            <div class="vcampaign_left_h d-flex flex-column">
               <div class="d-flex justify-content-between">
                  <div class="vcampaign_left_hl">
                     <p class="vcampaign_left_information">Offer information</p>
                     <div class="ljzHPa">
                        <p><strong>Description: </strong> <?php echo $offer->description;?></p>
                        <p><strong>Conversion Flow:</strong>&nbsp; <?php echo $offer->convert_on;?></p>
                        <p><strong>Allowed Traffic Sources:</strong>&nbsp; <?php echo $offer->traffic_source;?></p>
                        <p><strong>Restricted Traffic Sources:</strong> <strong>&nbsp;</strong>&nbsp;<?php echo $offer->restriced_traffics;?></p>
                     </div>
                  </div>
                  <div class="sc-ktHwxA sc-cTjmhe ebomDJ">
                     <img src="<?php echo $offer->img;?>" alt="<?php echo $offer->title;?>" width=100%>
                  </div>
               </div>
            </div>
            <div class="vcampaign_left_h d-flex flex-column">
               <div class="row mt-3">
                  <div class="col-6">
                     <span><strong>Offer preview:</strong></span><br>
                     <?php
                        $link=explode(',',$offer->preview);
                        $duoi = 0;
                        if($link){
                           foreach($link as $link){
                              if($duoi == 0){$duoi = '';}
                              echo '<a href="'.$link.'" type="button" class="btn btn-success btn-sm  me-2 mt-2">Offer preview '.$duoi.'</a>';
                              $duoi++;
                           }
                        }
                        ?>
                  </div>
                  <div class="col-6">
                     <span><strong>LandingPage:</strong></span><br>
                     <?php
                        $link=explode(',',$offer->landingpage);
                        $duoi = 0;
                        if($link){
                           foreach($link as $link){
                              if($duoi == 0){$duoi = '';}
                              echo '<a href="'.$link.'" type="button" class="btn btn-outline-primary btn-sm  me-2 mt-2">Landing Page '.$duoi.'</a>';
                              $duoi++;
                           }
                        }
                        ?>                        
                  </div>
               </div>
            </div>
            <?php
               $t=0;              
                  if($offer->request){
                     if($status=='Pending'){
                        //ddax request
                        echo '
                           <div class="mt-4">
                              <p class="text-primary">
                                 Pending !<br/>
                                 <b>Ticket already exists. You can know status at Support page</b>
                              </p>
                           </div>                                 
                        ';
                     }elseif($status=='Approved'){
                         //ddax approved hoacwj k can reqeust
                         goto apploved;                       
                        
                     }else{
                        echo '
                           <div class="mt-3">
                              <form class="form-rq" method="POST" action="'.base_url('v2/offers/request/'.$offer->id).'">
                                 <textarea name="request" placeholder="To receive approval at the nearest time, please provide a full traffic description to your manager. "></textarea>
                                 <div class="d-flex justify-content-between align-items-end mt-2">
                                    <div></div>
                                    <div class="d-flex align-items-center">
                                       <span class="rqqqq">No less than 5 characters are required</span>
                                       <button type="submit" class="btn_prv_link btn_prv_link_2">
                                          <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                          <span class="btn_prv_link_2_child_span">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                             </svg>
                                          </span>
                                          <span class="btn_prv_link_2_child2">Apply</span>
                                       </button>
                                    </div>
                                 </div>
                              </form>
                           </div>                                 
                           ';
                     }
                  }else{
                    //không có reqeust
                    apploved:
                    $t =1;
                    include('approved1.php');
                     
                  }
               ?>
         </div>
         <?php
            //xuwr lys device
               $dv= $this->db->where('id',$offer->device)->get('device')->row();
               if($dv) $dv= $dv->device;else $dv = '';
            //xử lý country
               $point_geos = unserialize($offer->point_geos);
               $percent_geos = unserialize($offer->percent_geos);
               $moCountry_tag = '';
               $mIdCat=explode('o',substr($offer->country,1,-1));                     
               if($mIdCat){
                  $oCountry = $this->db->where_in('id',$mIdCat)->get('country')->result();
                  $moCountry = array();
                  if($oCountry){
                     foreach($oCountry as $oCountry){
                        $moCountry[$oCountry->id] = $oCountry->keycode;
                     }
                  }
                  foreach($mIdCat as $mIdCat){
                     if($mIdCat=='all'){
                        $moCountry_tag .= '
                        <div data-test-id="affise-ui-geography-row" class="sc-eXNvrr gDsdmm">
                           <div data-test-id="affise-ui-geography-row-country" class="sc-cpmKsF jRKgwY">
                              <div class="d-flex flag_detail_of">
                                 <div class="d-flex align-items-center">
                                    <span class="sc-gVyKpa bbnMFd">All GEO</span>
                                 </div>                        
                              </div>
                           </div>
                           <div data-test-id="affise-ui-geography-row-revenue" class="sc-cpmKsF sc-jrIrqw iWDZfO"><span>'.$point_geos['all'].'</span>USD</div>
                           <div data-test-id="affise-ui-geography-row-device" class="sc-cpmKsF jRKgwY"><span>All Devices</span></div>
                           <div data-test-id="affise-ui-geography-row-os" class="sc-cpmKsF jRKgwY"><span>All OS</span></div>
                        </div>
                        ';
                        break;
                     }else{
                        if(!empty($point_geos[$moCountry[$mIdCat]])){
                           $point= '$ '.$point_geos[$moCountry[$mIdCat]];

                        }else{
                           //check %
                           if(!empty($percent_geos[$moCountry[$mIdCat]])){
                              $point = $percent_geos[$moCountry[$mIdCat]].'% Revshare';
                           }else{
                              $point= '$0';
                           }
                           
                        }
                        $moCountry_tag .= '
                        <div data-test-id="affise-ui-geography-row" class="sc-eXNvrr gDsdmm">
                           <div data-test-id="affise-ui-geography-row-country" class="sc-cpmKsF jRKgwY">
                              <div class="d-flex flag_detail_of">
                                 <div class="d-flex align-items-center">
                                    <img class="icon-flag-cpview" src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/'.strtolower($moCountry[$mIdCat]).'.svg">
                                    <span class="sc-gVyKpa bbnMFd">'.$moCountry[$mIdCat].'</span>
                                 </div>                        
                              </div>
                           </div>
                           <div data-test-id="affise-ui-geography-row-revenue" class="sc-cpmKsF sc-jrIrqw iWDZfO"><span>'.$point.'</span></div>
                           <div data-test-id="affise-ui-geography-row-device" class="sc-cpmKsF jRKgwY"><span>All Devices</span></div>
                           <div data-test-id="affise-ui-geography-row-os" class="sc-cpmKsF jRKgwY"><span>All OS</span></div>
                        </div>
                        ';
            
                     }
                     
                  }
               }
            ?>
         <div class="col-lg-5 EnqEY">
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-hUfwpO jhJgNj">Conversions</p>
               <?php echo $moCountry_tag;?>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-iNhVCk gmVVGK">Conversion rates</p>
               <div class="sc-drMfKT bOjCqL">
                  <div class="" style="width:160px">
                  <span><?php echo round($offer->cr,2);?></span>
               </div>
                  <span>%</span>
                
               </div>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-iNhVCk gmVVGK">EPC</p>
               <div class="sc-drMfKT bOjCqL">
                  <div class="" style="width:160px">
                  <span><?php echo round($offer->epc,2);?></span>
               </div>
                  <span>$</span>
                
               </div>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-iNhVCk gmVVGK">Limits</p>
               <div class="sc-ugnQR hWFfaR">
                  <div class="sc-eIHaNI eVOlRG">Day</div>
                  <div class="sc-eIHaNI sc-eTpRJs cQUeis">Conversions</div>
                  <div class="sc-eIHaNI eVOlRG"><?php echo $offer->capped;?></div>
                  <div class="sc-eIHaNI sc-dxZgTM cShRxf">All Goals</div>
                  <div class="sc-eIHaNI eVOlRG"></div>
               </div>
            </div>
          

         </div>
      </div>
      <?php
         if($t){
            include('approved2.php');
         }
         ?>
   </div>
   <!--end card-body-->
</div>
<!-- endoffer content-->