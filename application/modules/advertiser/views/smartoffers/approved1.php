<div class="row track_link_info">
                           <div class="track_link">
                              <div class="track_link_label d-flex justify-content-between mt-3">
                                 <p class="vcampaign_left_information">Tracking link</p>
                                 <a target="_blank" style="color:rgb(131, 131, 131)" href="https://affise.zendesk.com/hc/en-us/sections/201683795">Trackers integration</a>
                              </div>
                              <div class="input-group mb-3">
                                 <span class="input-group-text coppy_dt">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=""><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                 </span>
                                 <input type="text" id="tracklink" class="form-control" value="<?php echo base_url('smartoffer?pid='.$this->member->id.'&smid='.$offer->id);?>" disabled>
                                 <input id="base_tracklink"  type="hidden" class="form-control" value="<?php echo base_url('smartoffer?pid='.$this->member->id.'&smid='.$offer->id);?>" disabled>
                                 <span class="input-group-text"> SSL </span>
                               </div>
                           </div>
                           
                           <div class="mb-1 col-md-4 col-sm-6 track_subid">
                              <label class="form-label">Sub 1</label>
                              <input type="text" class="form-control sub1 sub_input"/>
                            </div>
                            <div class="mb-1 col-md-4 col-sm-6 track_subid">
                              <label class="form-label">Sub 2</label>
                              <input type="text" class="form-control sub2 sub_input"/>
                            </div>
                            <div class="mb-1 col-md-4 col-sm-6 track_subid">
                              <label class="form-label sub3">Sub 3</label>
                              <input type="text" class="form-control sub3 sub_input"/>
                            </div>
                            <div class="mb-1 col-md-4 col-sm-6 track_subid">
                              <label class="form-label">Sub 4</label>
                              <input type="text" class="form-control sub4 sub_input"/>
                            </div>
                            <div class="mb-1 col-md-4 col-sm-6 track_subid">
                              <label class="form-label">Sub 5</label>
                              <input type="text" class="form-control sub5 sub_input"/>
                            </div>
                            <div class="mb-1 col-md-4 col-sm-6 track_subid">
                              <label class="form-label">Sub 6</label>
                              <input type="text" class="form-control sub6 sub_input"/>
                            </div>
                        
                        </div>
                         <!--thoong bao -->
         <div class="position-fixed bottom-0 end-0 p-5 hide" style="z-index: 10;">
            <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">

               <div class="toast-body">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                     <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </svg>
                  <span id="toastContent">
                     Copy to clipboard
                  </span>   
               </div>
            </div>
         </div>
                        
                        <script>
                        $(document).ready(function(){
                            var base_tracklink = $('#base_tracklink').val();
                            $('.coppy_dt').on('click',function(){
                                coppy_track();
                            })
                            //$('.sub_input').on('change',function(){
                           //$('.sub_input').focus(function(){
                           $( ".sub_input" ).keyup(function( event ) {
                                var duoi =base_tracklink;
                                $(".sub_input" ).each(function( index ) {
                                    if($( this ).val())
                                    duoi +="&sub"+(index+1)+"="+$( this ).val();
                                    //alert( index + ": " + $( this ).val() );
                                });
                                $('#tracklink').val(duoi);
                                
                                
                            })
                            function coppy_track(){
                                var data = $('#tracklink').val();    
                                var myAlert =document.getElementById('thongBao');//select id of toast
                                var bsAlert = new bootstrap.Toast(myAlert,{animation:true,delay:2000,autohide:true});//inizialize it
                                                          
                                  /* Select the text field */
                                 var $temp = $("<input>");
                                 $("body").append($temp);
                                 $temp.val(data).select();
                                 document.execCommand("copy");
                                 $temp.remove();                              
                                  /* Alert the copied text */
                                  //alert("Copied the text: " + copyText.value);
                                  bsAlert.show();//show it  
                            }
                           
                            
                        });
                           
                       
                        </script>
                        <style>
                          .input-group-text{
                            background:#fff
                          }
                          .coppy_dt{cursor:pointer}
                          </style>