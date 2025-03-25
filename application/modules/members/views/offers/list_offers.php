<script>
   $(document).ready(function(){
      $('.order_wrap_list_items').on('click',function(){
         var urla= '<?php echo base_url('v2/smartlinks/ajorder');?>';
         $dt = $(this).attr('data-sort');         
         $.ajax({
         type:"POST",
         url:urla,
         data:{data:$dt},
         success:function(){location.reload();}            
      });
      })
     
   })  
</script>
<div class="card mt-5">
   <div class="card-body" >
      <!--chart-->
      <span class="card-offers-stitle">Offers</span>
      <form id="form_loc">
         <div class="card-offers-sboxs mb-3">
            <input name="oName" type="text" value="<?php echo $this->session->userdata('oName');?>" placeholder="Search" class="card-offers-sinput">
            <span class="nut">/</span>
         </div>
         <div class="row">
            <div class="col-lg-2 col-sm-6 pe-1 mb-2">
               <select name="oCat" data-placeholder="Categories..." class="chosen-select filteroff d-none" multiple tabindex="4">
                  <option value=""></option>
                  <?php
                     $arrcategory = $this->session->userdata('oCat');
                     $mOfferCat = array();
                     if($category){
                        foreach($category as $category){
                           if(!empty($arrcategory) && in_array($category->id,$arrcategory)){
                              $sl = 'selected';
                           }else{
                              $sl = '';
                           }
                           $mOfferCat[$category->id] = $category->offercat;
                           echo '<option value="'.$category->id.'" '.$sl.'>'.$category->offercat.'</option>';
                        }
                     }
                     ?>
               </select>
            </div>
            <div class="col-lg-2 col-sm-6  pe-1 mb-2">
               <select name="oCountry" data-placeholder="Countries..." class="chosen-select2 filteroff d-none" multiple tabindex="4">
                  <option value=""></option>
                  <?php
                     $arrCountry = $this->session->userdata('oCountry');
                     $mCountryKeycode = array();
                     if($country){
                        foreach($country as $country){
                           
                           if(!empty($arrCountry) && in_array($country->id,$arrCountry)){
                              $sl = 'selected';
                           }else{
                              $sl = '';
                           }
                           $mCountryKeycode[$country->id] = strtolower($country->keycode);
                           echo '<option value="'.$country->id.'" '.$sl.'>'.$country->country.'</option>';
                        }
                     }
                     ?>
               </select>
            </div>

            <div class="col-lg-2 col-sm-6  pe-1 mb-2">
               <select name="opaymterm" data-placeholder="Payment Term..." class="chosen-select3 filteroff d-none" multiple tabindex="4">
                  <option value=""></option>
                  <?php
                     $arrpaymterm = $this->session->userdata('opaymterm');
                     $marrpaymterm = array();
                     $termcat='';
                     if($paymterm){
                        foreach($paymterm as $paymterm){
                           $marrpaymterm[$paymterm->id] = $paymterm->payment_term;
                           if(!empty($arrpaymterm) && in_array($paymterm->id,$arrpaymterm)){
                              $sl = 'selected';                             
                             
                           }else{
                              $sl = '';
                           }
                           
                           echo '<option value="'.$paymterm->id.'" '.$sl.'>'.$paymterm->payment_term.'</option>';
                        }
                     }
                     ?>
               </select>
            </div>

            <!-- menu smlink-->            
            <div class="smlinks">            
               <a href="<?php echo base_url('v2/smartlinks')?>" class="nav-link link-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-coin" viewBox="0 0 18 18">
                  <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                  </svg>
                  <span class="text_slidebar_h">Smartlinks</span>
                  
               </a>                  
            </div>
            <div class="smlinks">            
               <a href="<?php echo base_url('v2/smartoffers')?>" class="nav-link link-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cash" viewBox="0 0 18 18">
                     <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                     <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                  </svg>
                  <span class="text_slidebar_h">SmartOffers</span>                        
               </a>                  
            </div>


         </div>
      </form>
      <link rel="stylesheet" href="<?php echo base_url();?>/temp/default/css/select2.css" />
      <script src="<?php echo base_url();?>/temp/default/js/multiple/select2.min.js"></script>  
      <script>                      
         $(document).ready(function(){
            $('.card-offers-sinput').focusin(function() {
               $('.nut').text('Enter');
               $('.nut').addClass('focus-input-span');
               $('.card-offers-sboxs').addClass('focus-input');                          
               
            })
            $('.card-offers-sinput').focusout(function() {
               $('.nut').text('/');
               $('.nut').removeClass('focus-input-span');
               $('.card-offers-sboxs').removeClass('focus-input');
            });
            
            //tắt menu orderby
            $('body').click(function(){
               $('#menu_sapxep').removeClass('show');
               
            })
         
            $('.chosen-select').select2({
               theme: "classic",
               width:'100%'
            });
            $('.chosen-select2').select2({
               theme: "classic",
               width:'100%'
            });
            $('.chosen-select3').select2({
               theme: "classic",
               width:'100%'
            });
            //lựa chọn country hoặc category
            $('.filteroff').change(function(){
               var data= $(this).val();
               var name = $(this).attr('name');
               ajaxFilterO(data,name);
            })
            //nhạp textg xong
            $('.card-offers-sinput').blur(function(){
               var data= $(this).val();
               var name = $(this).attr('name');
               ajaxFilterO(data,name);
            });
         
         })
         function ajaxFilterO(data,name){
               
               var ajurl = "<?php echo base_url('/v2/offers/ajax_serach_offer');?>";
               var loading = '<div class="d-flex justify-content-center mt-2"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div></div>';
               $('#list_offers').html(loading);
               //load ajax sau khi load xong thì f5
               $.ajax({
                  type:"POST",
                  url:ajurl,
                  data:{gt:data,name:name},
                  success:function(){location.reload();}
                        
               }); 
               //$('#form_loc').submit();
         }
         
      </script>
      <!--- ------>
      <div class="border-top mt-3 pt-3 d-flex align-items-center justify-content-between">
         <div class="d-flex flex-column">
            <span class="card-offers-sresult">Result</span>
            <span><?php if(!empty($totals))echo $totals;else echo 0;?>&nbsp;Offers</span>
         </div>
         <div style="position:relative" class="menu_sort">
            <span class="card-offers-sresult">Sorting</span>
            <div class="d-flex" data-bs-toggle="collapse" data-bs-target="#menu_sapxep">
            <span class="d-flex align-items-center cus_pointer">
                  <?php
                  $s= $this->session->userdata('sort_offer');
                   if($s){
                     $ar = explode('-',$s);
                     echo '
                        <img src="'.base_url('temp/default/images/'.$ar[1].'.svg').'" class="order_img me-1">
                        By '.strtoupper($ar[0]).'
                     ';

                   }else{
                     echo '
                        <img src="'.base_url('temp/default/images/desc.svg').'" class="order_img me-1">
                        By ID
                     ';
                   }
                  ?>
                 
               </span>
            </div>
            <div class="order_wrap collapse" id="menu_sapxep">
               <div class="d-flex flex-column order_wrap_list">
                  <div class="order_wrap_list_items" data-sort="id-desc"><img src="<?php echo base_url();?>/temp/default/images/desc.svg" class="order_img me-1"><span>By ID</span></div>
                  <div class="order_wrap_list_items" data-sort="id-asc"><img src="<?php echo base_url();?>/temp/default/images/asc.svg" class="order_img me-1"><span>By ID</span></div>
                  <div class="order_wrap_list_items" data-sort="title-desc"><img src="<?php echo base_url();?>/temp/default/images/desc.svg" class="order_img me-1"><span>By Title</span></div>
                  <div class="order_wrap_list_items" data-sort="title-asc"><img src="<?php echo base_url();?>/temp/default/images/asc.svg" class="order_img me-1"><span>By Title</span></div>
                  <div class="order_wrap_list_items" data-sort="cr-desc"><img src="<?php echo base_url();?>/temp/default/images/desc.svg" class="order_img me-1"><span>By CR</span></div>
                  <div class="order_wrap_list_items" data-sort="cr-asc"><img src="<?php echo base_url();?>/temp/default/images/asc.svg" class="order_img me-1"><span>By CR</span></div>
                  <div class="order_wrap_list_items" data-sort="epc-desc"><img src="<?php echo base_url();?>/temp/default/images/desc.svg" class="order_img me-1"><span>By EPC</span></div>
                  <div class="order_wrap_list_items" data-sort="epc-asc"><img src="<?php echo base_url();?>/temp/default/images/asc.svg" class="order_img me-1"><span>By EPC</span></div>
               </div>
            </div>
         </div>
      </div>
      <!--End chart-->
   </div>
</div>
<div class="row" id="list_offers">
   <?php
      if(!empty($offer)){
         foreach($offer as $offer){
            // $marrpaymterm//xưrlythông tin payment term
            
               $termcat = '
                        <a href="#" class="d-flex align-items-center me-3 tag-link">
                           <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                              <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                              <line x1="7" y1="7" x2="7.01" y2="7"></line>
                           </svg>
                           <span class="tag-text">'.$marrpaymterm[$offer->paymterm].'</span>
                        </a>';
           
            //xử lý cuntry
            $Icon = '';
            $point_geos_s = '';
            $mIdCountry=explode('o',substr($offer->country,1,-1));
            $point_geos = unserialize($offer->point_geos);
            $percent_geos = unserialize($offer->percent_geos);
            $mCountryKeycode['all'] ='';
            if($mIdCountry){
               $dem = 0;
               $cll = '';
               $soluong = count($mIdCountry);
               foreach($mIdCountry as $mIdCountry){
                  $geo_code = strtoupper($mCountryKeycode[$mIdCountry]);
                  if(!empty($point_geos[$geo_code])){
                     $point = '$'.$point_geos[$geo_code];
                  }else{
                     //lấy %
                     if(!empty($percent_geos[$geo_code])){
                        $point = $percent_geos[$geo_code].'% Revshare';
                     }else{
                        $point = '$0';
                     }
                  } 
                  
                  if($mIdCountry=='all'){
                     $Icon = 'All Countries ';
                     if(!empty($point_geos['all'])) $point = '$'.$point_geos['all'];
                     if(!empty($percent_geos['all'])) $point = $percent_geos['all'].'% Revshare';
                  }else{                  
                     $Icon = '<img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/'.$mCountryKeycode[$mIdCountry].'.svg">';
                  }
                  
                  $dem++;
                  if($dem==$soluong){
                     $cll = 'enditem';
                  }
                  if($dem<4){//chỉ lấy 3 cái
                     $point_geos_s .='                     
                        <div class="flag_icon_country '.$cll.'">
                           <span class="boffer_point"><span>'.$point.'</span></span>&nbsp;—&nbsp;
                           '.$Icon.'
                        </div>
                     
                     ';
                  }
                  

               }
            }
            if($dem>=4){
               $soluong = $soluong-3;
               $point_geos_s .= "&nbsp;&nbsp;+ $soluong More";
            }
            
            //;xử lý category
            $cat_tag = '';
            $mIdCat=explode('o',substr($offer->offercat,1,-1));                     
            if($mIdCat){
               foreach($mIdCat as $mIdCat){
                  $cat_tag .= '
                           <a href="#" class="d-flex align-items-center me-3 tag-link">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                                 <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                 <line x1="7" y1="7" x2="7.01" y2="7"></line>
                              </svg>
                              <span class="tag-text">'.$mOfferCat[$mIdCat].'</span>
                           </a>';
               }
            }
            //kieemr tra reqeusst
            if($offer->request&&$offer->status!='Approved'){
               if($offer->status=='Pending'){
                  $link = '<a href="'.base_url('/v2/offer/'.$offer->id).'" type="button" class="btn btn-warning btn-sm">Pending</a> ';
               }else{                  
                  $link = '<a href="'.base_url('/v2/offer/'.$offer->id).'" type="button" class="btn btn-primary btn-sm">Request Access</a> ';
               }
               
            }else{               
               $link = '<a href="'.base_url('/v2/offer/'.$offer->id).'" type="button" class="btn btn-success btn-sm">Get Link</a>';
            }
            //check xem smartoffer với smartlink
            if($offer->smtype==2){
               $badge = '<span class="badge bg-success"> Smart Offer </span>';
            }elseif($offer->smtype==3){
               $badge = '<span class="badge bg-info"> Smart Link </span>';
            }else{
               $badge = '';
            }
            
            echo 
            ' <div class="col-12 mt-3">
            <div name="white" class="p-3 shadow bg-body border rounded d-flex box-offers-items">
               <div class="box-offers-images d-lg-flex flex-column align-items-center justify-content-center flex-shrink-0 me-3">
                  <img class="box-offers-img" src="'.$offer->img.'" alt="">
               </div>
               <div class="box-offers-container">
                  <div class="box-offers-detail">
                     <div class="box-offers-ticons">
                        <span class="box-offers-id">#&nbsp;'.$badge.'&nbsp;'.$offer->id.'&nbsp;<span>—</span></span>
                        <div class="d-flex align-items-center">
                          <!-- tag--->
                           '.$cat_tag.' 
                           <span>— &nbsp;</span>
                           '.$termcat.'
                         <!--end tag-->  
                        </div>
                     </div>
                     <a class="box-offers-links" href="'.base_url('/v2/offer/'.$offer->id).'">
                     '.$offer->title.'
                     </a>
                     <div class="box-offers-point mt-2 pt-2 d-flex">
                        '.$point_geos_s.' 
                     </div>


                  </div>
                  <div class="sc-TFwJa eSDKjj d-flex flex-column">
                     '.$link.'       
                     <p class="mt-2">
                     CR: '.round($offer->cr,2).'% - EPC: $'.round($offer->epc,2).'
                     </p>                      
                  </div>
               </div>
            </div>
         </div>';
         }
      }else{
         echo '
         <div class="col-12 my-5">
            <div class="d-flex justify-content-center"><h6>There are no offers</h6></div>
         </div>
         ';
      }
      ?>
   <!-- pagination-->
   <div class="col-md-6 my-2">
      <ul class=" pagination">                       
         <?php echo $this->pagination->create_links();?>     
      </ul>
   </div>
   <!-- end pagination-->
</div>
<style>
   .flag_icon_country{
      border-right:1px solid #cacaca;
      padding: 0 5px;
   }
   .enditem{
      border-right:0px !important;
   }
   .select2-selection--multiple:before {
   content: "";
   position: absolute;
   right: 7px;
   top: 42%;
   border-top: 5px solid #888;
   border-left: 4px solid transparent;
   border-right: 4px solid transparent;
   }
   .smlinks{
      border: 1px solid #cacaca;
      width:150px;
      height:32px;
      line-height:32px;
      margin: 0 5px
      
   }
   .smlinks:hover{
      border-color:#56bf85;      
   }
   .smlinks a{
      padding:0 !important
   }
  
</style>