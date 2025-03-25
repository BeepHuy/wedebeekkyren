<?php 

   if($newoffer){
       show_slide($newoffer,'New products',$marrpaymterm,$marroffertype,$mCountryKeycode);
   }
   if($topoffer){
       show_slide($topoffer,'Top sales products',$marrpaymterm,$marroffertype,$mCountryKeycode);
   }
   if($mcat_off){
        foreach($mcat_off as $mcat_off){
            show_slide($mcat_off['offer'],$mcat_off['cat'],$marrpaymterm,$marroffertype,$mCountryKeycode);
        }
       
   }
   
   
   
   function show_slide($offer,$title='',$marrpaymterm,$marroffertype,$mCountryKeycode){
    
       if(!empty($offer)){
            $i=0;
           echo '
           <div class="lolomoRow lolomoRow_title_card carosel_custom" data-list-context="genre">
               <h2 class="rowHeader">
                   <a class="rowTitle" href="'.base_url('v2').'">
                       <div class="row-header-title">'.$title.'</div>
                       <div class="aro-row-header more-visible">
                           <div class="see-all-link">Explore All</div>
                           <div class="aro-row-chevron icon-akiraCaretRight"></div>
                       </div>
                   </a>
               </h2>
               <div class="rowContainer rowContainer_title_card" id="row-1">
                   <div class="ptrack-container">
                       <div class="rowContent slider-hover-trigger-layer">
                           <div class="slider">
                           <span class="handle handlePrev active" tabindex="0" role="button" aria-label="See previous titles"><b class="indicator-icon icon-leftCaret"></b></span>                       
                           <div class="sliderMask showPeek">
                               <div class="sliderContent row-with-x-columns">';
           foreach($offer as $offer){
               $i++;    
               //xử lý country
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
                            <span class="boffer_point"><span>'.$point.'</span></span>&nbsp;-&nbsp;
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
                //end xử lý country
               

               echo '
               <div class="slider-item slider-item-'.$i.'">
                   <div class="title-card-container">
                    <div id="title-card-1-1" class="title-card">
                        <div class="ptrack-content">
                            <a href="'.base_url('v2').'" role="link" aria-label="Stranger Things" tabindex="0" aria-hidden="false" class="slider-refocus">
                                <div class="boxart-size-16x9 boxart-container boxart-rounded">
                                <img class="boxart-image boxart-image-in-padded-container" src="'.$offer->img.'" alt="">
                                <div class="fallback-text-container d-flex flex-column" aria-hidden="true">
                                    <img class="fallback-text-container-img" src="'.$offer->img.'" alt="">
                                    <div class="fallback-descript flex-shrink-1 text-white px-2">
                                        <p class="fallback-descript-title mt-2">'.$offer->title.'</p>

                                        <div class="tag pb-1">
                                               
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                            </svg>
                                            <span class="tag-text">'.$marroffertype[$offer->type].'</span> 
                                            &nbsp;
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                            </svg>
                                            <span class="tag-text">'.$marrpaymterm[$offer->paymterm].'</span>     
                                            &nbsp;-
                                            <span class="tag-text">CR</span>  
                                            <span class="tag-text">'.round($offer->cr,2).'%</span>  
                                            &nbsp;-
                                            <span class="tag-text">EPC</span>  
                                            <span class="tag-text">$'.round($offer->epc,2).'</span> 

                                        </div>
                                        <div class="box-offers-point">
                                            '.$point_geos_s.'
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
               ';
   
           }   
           
           echo '    
   
                                   </div>
                               </div>
                               <span class="handle handleNext active" tabindex="0" role="button" aria-label="See more titles"><b class="indicator-icon icon-rightCaret"></b></span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               ';    
       }
   }
   ?>
