<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style> .select2-container--open {z-index: 9999 !important;}</style>

<!-- offer content-->
<div class="mt-5 mb-2">
   <span class="offer-view-title"><?php echo $offer->title;?></span>
</div>


<div class="card mb-4">
   <div class="card-body" >
      <div class="row campaign-views">
         <div class="col-lg-7 ps-md-3 pe-md-4 vcampaign_left">

            <!-- Offer imformationn -->
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
            <!-- ------------------- -->

            <!-- preview and landing -->
            <div class="vcampaign_left_h d-flex flex-column">
               <div class="row mt-3">
                  <!-- Link preview offer -->
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
                  <!-- ------------------ -->
                  <!-- Link landingpage -->
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
                  <!-- ---------------- -->
               </div>
            </div>
            <!-- ------------------- -->
            
            <!-- Show information by request status -->
            <?php
               $t=0;
               if(!$offer->request) {
                  // Không có request -> Approved
                  $t = 1;
                  include('approved1.php');
               } else {
                  // Có request -> kiểm tra status
                  switch($status) {
                     case 'Pending':
                           if (!empty($rq->crequest)) {
                              $this->load->view('/offers/paritcal/repviewinfo.php', ['rq' => $rq]);
                              
                           } 
                              $this->load->view('offers/paritcal/status.php', ['rq' => $rq]);
                           break;
                     case 'Approved':
                           if (!empty($rq->crequest)) {
                              include('approved1.php');
                              $this->load->view('/offers/paritcal/repviewinfo.php', ['rq' => $rq]);
                           } else {
                              $t = 1;
                              include('approved1.php');
                           }
                           $this->load->view('offers/paritcal/status.php', ['rq' => $rq]);
                           break;
                     case 'Deny':
                        if($offer->trafrequire == 1) {
                           $this->load->view('offers/paritcal/formrequest.php', [
                              'offer' => $offer,                
                              'traftype' => $traftype           
                           ]);
                        } else {
                           echo '<div class="mt-3 w-30 float-end">
                              <form class="form-rq" method="POST" action="'.base_url('v2/offers/requpdate/'.$rq->id).'">
                                 <textarea class="d-none" name="request" placeholder="To receive approval at the nearest time, please provide a full traffic description to your manager. "></textarea>
                                 <div class="d-flex justify-content-between align-items-end mt-2">
                                    <div></div>
                                    <div class="d-flex align-items-center">
                                       <button type="submit" class="btn_prv_link btn_prv_link_2">
                                          <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                          <span class="btn_prv_link_2_child_span">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                             </svg>
                                          </span>
                                          <span class="btn_prv_link_2_child2">Reapply</span>
                                       </button>
                                    </div>
                                 </div>
                              </form>
                           </div>    ';
                           $this->load->view('offers/paritcal/status.php', ['rq' => $rq]);
                        }
                        
                        break;
                     default:
                           // Chưa request
                           if($offer->trafrequire == 1) {
                              $this->load->view('offers/paritcal/formrequest.php', [
                                 'offer' => $offer,                
                                 'traftype' => $traftype           
                              ]);
                           } else {
                              echo '<div class="mt-3 ">
                                 <form class="form-rq" method="POST" action="'.base_url('v2/offers/request/'.$offer->id).'">
                                    <textarea class="d-none" name="request" placeholder="To receive approval at the nearest time, please provide a full traffic description to your manager. "></textarea>
                                    <div class="d-flex justify-content-between align-items-end mt-2">
                                       <div></div>
                                       <div class="d-flex align-items-center">
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
                              </div>    ';
                           }
                     }
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
      <?php if ($t) {include('approved2.php');}?>
   </div>
   <!--end card-body-->
</div>
<!-- Nút kích hoạt Modal -->
<?php
if($trafficurl || (!empty($rq->subject))){
   $this->load->view('offers/paritcal/traffic_display.php', ['rq' => $rq]);
}
?> 
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<!--ckeditor-->
<script type="text/javascript">
   // Định nghĩa biến base_url từ PHP
   var base_url = "<?= base_url(); ?>";
</script>

<script type="text/javascript" src="<?= base_url(); ?>ckeditor/new_ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>ckeditor/ckfinder/ckfinder.js"></script>

<!-- endoffer content-->
<script>
   $(document).ready(function() {
   $('#mySelect, #trafficTypeSelect').select2({
      placeholder: "Select Traffic Type",
      allowClear: true,
      width: '100%'
   });

   var trafficData = {}; // Đối tượng lưu trữ dữ liệu

   // Xử lý hiển thị/ẩn các khối dựa vào lựa chọn Traffic Type
   $("#mySelect").on("change", function() {
      var selected = $(this).val() || [];
      var hasNonEmailTraffic = false;

      // Ẩn cả hai container
      $("#emailContentCard").hide();
      $("#trafficUrlContainer").hide();
      $("#dynamicTrafficFields").empty();

      // Kiểm tra nếu không có gì được chọn
      if (selected.length === 0) {
            $("#trafficUrlContainer").show();
            return; 
      }

      $.each(selected, function(index, trafficType) {
            if (trafficType === "Email Traffic") {
               // Hiển thị div nhập email
               $("#emailContentCard").show();
            }
            
            if (!(trafficType === "Email Traffic")){
               hasNonEmailTraffic = true;
               var fieldHtml = `
               <div class="traffic-url-field mb-3">
                  <input style ="font-size:11px;margin-bottom:10px" type="text" class="form-control traffic-url-input" 
                        name="trafficurl[]" data-traffic-type="${trafficType}"
                        placeholder="Please fill in the exact Website URL of ${trafficType} where you place the tracking to receive traffic" 
                        value="${trafficData[trafficType] || ''}" />
               </div>
               `;
            
               // Thêm vào container
               $("#dynamicTrafficFields").append(fieldHtml);
            }
      });

      if (hasNonEmailTraffic) {
            var labelhtml = '<label class="form-label fw-bold">Traffic URL<span class="text-danger" id="trafficurlError"></span></label>';
            $("#dynamicTrafficFields").prepend(labelhtml);
            $("#dynamicTrafficFields").show(); 
      }
   });

   // Lưu dữ liệu khi người dùng nhập vào các ô input
   $(document).on('input touchend', '.traffic-url-input', function() {
      var trafficType = $(this).data('traffic-type');
      trafficData[trafficType] = $(this).val();
   });

   // Xóa dữ liệu khi Traffic Type bị xóa
   $("#mySelect").on("select2:unselect", function(e) {
      var removedTrafficType = e.params.data.id;
      delete trafficData[removedTrafficType];
   });

   // Hàm loại bỏ thẻ HTML
   function stripHtml(html) {
      let tmp = document.createElement("div");
      tmp.innerHTML = html;
      return tmp.textContent || tmp.innerText || "";
   }

   // Hàm chuẩn hóa văn bản (loại bỏ khoảng trắng thừa)
   function normalizeText(text) {
      return text.replace(/\s+/g, ' ').trim();
   }

   const charCountDisplay = $("#charCount");
   const maxLength = 50000;
   const imageCharCount = 50;

   function countCharacters() {
      try {
         let editor = CKEDITOR.instances['soanthao']; 
         if (!editor) return;
         
         let text = editor.getData(); // Lấy nội dung từ CKEditor
         if (text === undefined) return;

         let strippedText = stripHtml(text); // Loại bỏ các thẻ HTML
         let normalizedText = normalizeText(strippedText); // Chuẩn hóa văn bản

         let imgCount = (text.match(/<img\s+/g) || []).length; // Đếm số thẻ <img>
         let totalLength = normalizedText.length + imgCount * imageCharCount; // Tính tổng ký tự

         // Hiển thị số ký tự hiện tại
         if (totalLength > maxLength) {
            charCountDisplay.css("color", "red"); // Đổi màu đỏ khi vượt giới hạn
            charCountDisplay.text(`${totalLength} / ${maxLength} characters (exceeded ${totalLength - maxLength} characters!)`);
         } else {
            charCountDisplay.css("color", "black"); // Bình thường giữ màu đen
            charCountDisplay.text(`${totalLength} / ${maxLength} characters`);
         }
      } catch (e) {
         console.error("Error counting characters:", e);
      }
   }

   // Khởi tạo CKEditor với cấu hình đầy đủ
   function initCKEditor() {
      if (typeof CKEDITOR !== 'undefined' && document.getElementById('soanthao') && !CKEDITOR.instances['soanthao']) {
         var editor = CKEDITOR.replace('soanthao', {
            extraPlugins: 'pastefromword',
            pasteFilter: 'semantic-content',
            filebrowserUploadUrl: base_url + 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserBrowseUrl: base_url + 'ckeditor/ckfinder/ckfinder.html',
            filebrowserUploadMethod: 'form',
            removePlugins: 'save',
            allowedContent: true, // Quan trọng: cho phép tất cả nội dung
            disableNativeSpellChecker: false,
            height: 300,
            width: '100%',
            // Quan trọng: Cấu hình entities để hiển thị HTML đúng cách
            entities: false,
            entities_latin: false,
            entities_greek: false,
            entities_processNumerical: false,
            // Cấu hình xử lý HTML
            htmlEncodeOutput: false,
            forceSimpleAmpersand: true
         });

         // Thiết lập CKFinder cho CKEditor nếu có
         if (typeof CKFinder !== 'undefined') {
            CKFinder.setupCKEditor(editor, base_url + 'ckeditor/ckfinder/');
         }

         // Sự kiện khi CKEditor sẵn sàng
         editor.on('instanceReady', function() {
            console.log('CKEditor is ready');
            countCharacters();
            
            // Đăng ký các sự kiện
            this.on("paste", function() {
               setTimeout(countCharacters, 100);
            });
            
            this.on("change", countCharacters);
            this.on("key", countCharacters);
            
            this.on("key", function() {
               $("#soanthaoError").text('');
            });
         });
      }
   }

   // Khởi chạy CKEditor sau khi trang đã tải
   if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function() {
         setTimeout(initCKEditor, 500);
      });
   } else {
      setTimeout(initCKEditor, 500);
   }
   
   // Tăng cường xử lý form submit cho cả desktop và mobile
   $("#myForm, #myyForm").on("submit", function(e) {
      e.preventDefault(); // Ngăn form submit trước khi validate
      
      // Đảm bảo CKEditor đã được cập nhật đầy đủ
      try {
         if (CKEDITOR.instances['soanthao']) {
            CKEDITOR.instances['soanthao'].updateElement();
         }
      } catch (e) {
         console.error("Error updating CKEditor element:", e);
      }
      
      // Đếm ký tự trước khi validate
      countCharacters();
      
      let isValid = true;
      // Xóa thông báo lỗi cũ
      $("#crequestError").text('');
      $(".traffic-url-error").remove();

      // Validate Traffic Type
      const crequest = $("select[name='crequest[]']").val() || [];
      if (!crequest || crequest.length === 0) {
         $("#crequestError").text('Traffic Type is required.');
         isValid = false;
      }

      // Validate các trường URL động
      $("input[name='trafficurl[]']").each(function() {
         // Bỏ qua trường có id="traffic_EmailTraffic"
         if ($(this).attr('id') === 'traffic_EmailTraffic') {
            return; // Bỏ qua validation cho trường này
         }

         const trafficurl = $(this).val().trim();

         if (!trafficurl) {
            $(this).after('<div class="text-danger traffic-url-error mt-1">Traffic URL is required.</div>');
            isValid = false;
         } else {
            // Kiểm tra xem URL có chứa dấu phẩy hoặc nhiều URL
            if (trafficurl.includes(',') || trafficurl.indexOf('http', 10) !== -1) {
               $(this).after('<div class="text-danger traffic-url-error mt-1">Please enter only one URL per field.</div>');
               isValid = false;
            }
            // Kiểm tra xem URL có chứa nhiều protocol
            else if ((trafficurl.match(/:\/\//g) || []).length > 1) {
               $(this).after('<div class="text-danger traffic-url-error mt-1">Invalid URL format. URL contains multiple protocols.</div>');
               isValid = false;
            }
            // Kiểm tra URL có hợp lệ
            else {
               try {
                  new URL(trafficurl);
               } catch (e) {
                  $(this).after('<div class="text-danger traffic-url-error mt-1">Please enter a valid URL starting with http:// or https://</div>');
                  isValid = false;
               }
            }
         }
      });

      // Kiểm tra Email Traffic nếu đã chọn
      if (crequest && crequest.includes("Email Traffic")) {
         const subject = $("#subject").val().trim();
         if (!subject) {
            $("#subjectError").text('Subject is required.');
            isValid = false;
         }
         
         try {
            let editor = CKEDITOR.instances['soanthao'];
            if (editor) {
               let text = editor.getData();
               let strippedText = stripHtml(text);
               let normalizedText = normalizeText(strippedText);
               let imgCount = (text.match(/<img\s+/g) || []).length;
               let totalLength = normalizedText.length + imgCount * imageCharCount;
               
               if (totalLength < 50) { 
                  $("#soanthaoError").text(`Creative Content must be at least 50 characters long. Current: ${totalLength}`);
                  isValid = false;
               }
               
               if (totalLength > maxLength) {
                  $("#soanthaoError").text(`Content must not exceed ${maxLength} characters. Current: ${totalLength}`);
                  isValid = false;
               }
            }
         } catch (e) {
            console.error("Error validating CKEditor content:", e);
         }
      }

      // Nếu form valid, thì submit
      if (isValid) {
         // Đặt form timeout phòng tránh vấn đề mobile
         setTimeout(() => {
            this.submit();
         }, 100);
      }
      
      return false; // Ngăn submit mặc định
   });

   // Xóa thông báo lỗi khi người dùng nhập - hỗ trợ cả mobile
   $(document).on('input touchend', "input[name='trafficurl[]'], #dynamicTrafficFields input[name='trafficurl[]']", function() {
      $(this).next('.traffic-url-error').remove();
   });
  
   $("#mySelect, #trafficTypeSelect").on('change touchend', function() {
      $("#crequestError").text('');
   });

   $("#trafficUrl").on('input touchend', function() {
      $("#trafficurlError").text('');
   });

   $("#subject").on('input touchend', function() {
      $("#subjectError").text('');
   });

   // Xử lý modal hiển thị
   $('#editModal').on('show.bs.modal', function(e) {
      // Đảm bảo CKEditor được khởi tạo lại khi mở modal
      setTimeout(function() {
         if (typeof CKEDITOR !== 'undefined') {
            // Hủy instance cũ nếu tồn tại để tránh xung đột
            if (CKEDITOR.instances['soanthao']) {
               CKEDITOR.instances['soanthao'].destroy(true);
            }
            // Khởi tạo lại
            initCKEditor();
         }
      }, 300);
   });

   // Khi thay đổi danh sách Traffic Type, cập nhật lại Traffic URL Container
   $('#trafficTypeSelect').on('change', function() {
      var selected = $(this).val() || [];
      // Lọc ra các loại không bao gồm "Email Traffic"
      var nonEmail = selected.filter(function(t) { return t !== "Email Traffic"; });
      
      // Lấy giá trị đã nhập hiện tại để giữ lại nếu có
      var existing = {};
      $('#trafficUrlContainer .trafficUrlInput').each(function() {
         var type = $(this).data('traffic-type');
         var val = $(this).find('input').val();
         existing[type] = val;
      });
      
      // Xóa container hiện tại
      $('#trafficUrlContainer').empty();
      
      // Với mỗi loại không phải Email, tạo input URL
      nonEmail.forEach(function(type, index) {
         var val = (existing[type] !== undefined) ? existing[type] : '';
         var html = '<div class="col-md-6 mt-2 trafficUrlInput" data-traffic-type="'+ type +'">' +
                     '<label for="traffic_'+ index +'" class="form-label">'+ type +'</label>' +
                     '<input type="text" name="trafficurl[]" id="traffic_'+ index +'" class="form-control" value="'+ val +'" placeholder="Enter URL for '+ type +'">' +
                  '</div>';
         $('#trafficUrlContainer').append(html);
      });
      
      // Hiển thị/ẩn Email Content Card
      if (selected.indexOf("Email Traffic") !== -1) {
         $('#emailContentCard').show();
         // Đảm bảo rằng CKEditor được khởi tạo nếu Email Traffic được chọn
         setTimeout(function() {
            if (!CKEDITOR.instances['soanthao']) {
               initCKEditor();
            }
         }, 200);
      } else {
         $('#emailContentCard').hide();
         $('#subject').val('');
         if (CKEDITOR.instances['soanthao']) {
            CKEDITOR.instances['soanthao'].setData('');
         }
      }
   });

   // phần này xữ lý khi click close trong modal edit 
   var initialModalData = {};
   $('#editModal').on('show.bs.modal', function(e) {
      // Lưu giá trị ban đầu của traffic type
      initialModalData.selectedTrafficTypes = $('#trafficTypeSelect').val();
      
      // Lưu giá trị ban đầu của các trường URL
      initialModalData.trafficUrls = {};
      $('#trafficUrlContainer .trafficUrlInput').each(function() {
         var type = $(this).data('traffic-type');
         var value = $(this).find('input').val();
         initialModalData.trafficUrls[type] = value;
      });
      
      // Lưu giá trị của Email Traffic nếu có
      initialModalData.charCount = $('#charCount').text();
      initialModalData.subject = $('#subject').val();
      
      // Lấy dữ liệu từ textarea thô nếu CKEditor chưa được khởi tạo
      if (!CKEDITOR.instances['soanthao']) {
         initialModalData.message = $('#soanthao').val();
      } else {
         initialModalData.message = CKEDITOR.instances['soanthao'].getData();
      }
   });

   $('#editModal').on('hidden.bs.modal', function(e) {
      // Khôi phục lại select Traffic Type
      $('#trafficTypeSelect').val(initialModalData.selectedTrafficTypes).trigger('change');
      
      // Sau khi select thay đổi (sau khi trigger change), khôi phục dữ liệu URL tương ứng
      setTimeout(function(){
         $.each(initialModalData.trafficUrls, function(type, value) {
            $('#trafficUrlContainer').find('[data-traffic-type="'+type+'"] input').val(value);
         });
      }, 100);
      
      // Khôi phục Email Traffic nếu có
      $('#charCount').text(initialModalData.charCount);
      $('#subject').val(initialModalData.subject);
      
      // Khôi phục nội dung
      setTimeout(function() {
         if (CKEDITOR.instances['soanthao']) {
            CKEDITOR.instances['soanthao'].setData(initialModalData.message);
         } else {
            $('#soanthao').val(initialModalData.message);
         }
      }, 200);
   });

   // Xử lý trạng thái các thành phần trong message 
   $("#modal-body *").each(function () {
      if ($(this).css("position") !== "static") {
         $(this).css("position", "initial !important");
      }
   });

   
   // Đảm bảo nội dung hiển thị đúng khi trang tải
   $(window).on('load', function() {
      setTimeout(function() {
         // Kiểm tra xem đã có nội dung trong textarea
         var initialContent = $('#soanthao').val();
         if (initialContent && CKEDITOR.instances['soanthao']) {
            // Đảm bảo hiển thị đúng
            CKEDITOR.instances['soanthao'].setData(initialContent);
         }
      }, 1000);
   });
});

// Xử lý modal cho thiết bị di động và desktop
document.addEventListener('DOMContentLoaded', function() {
   var modalElement = document.getElementById('emailModal');
   if (modalElement) {
      var myModal = new bootstrap.Modal(modalElement, { keyboard: true });

      var label = document.getElementById('traffic_EmailTrafficLB');
      var icon = document.getElementById('document');
      var input = document.getElementById('traffic_EmailTraffic');

      // Hàm mở modal
      function openModal(event) {
         event.preventDefault(); // Ngăn label focus vào input
         event.stopPropagation(); // Ngăn chặn sự kiện lan rộng
         myModal.show();
      }

      // Gán sự kiện click và touch cho input, label và icon
      function addEventListeners(element) {
         if (element) {
            element.addEventListener('click', openModal);
            element.addEventListener('touchend', function(e) {
               e.preventDefault();
               openModal(e);
            }, false);
         }
      }

      // Thêm event listeners cho các phần tử
      addEventListeners(input);
      addEventListeners(label);
      addEventListeners(icon);
   }
});

// Hàm để mở CKFinder
function BrowseServer() {
   if (typeof CKFinder !== 'undefined') {
      var finder = new CKFinder();
      finder.basePath = base_url + 'ckeditor/ckfinder/';
      finder.selectActionFunction = SetFileField;
      finder.popup();
   }
}

// Hàm để thiết lập giá trị file URL vào trường input
function SetFileField(fileUrl) {
   document.getElementById('xFilePath').value = fileUrl;
}
   
</script>