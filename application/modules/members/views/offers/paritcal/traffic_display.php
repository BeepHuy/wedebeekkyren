<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="myyForm" method="POST" action="<?= base_url('v2/offers/requpdate/'.$rq->id) ?>">
      <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editModalLabel">Edit Traffic Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      <div class="container my-4 p-0">
         <div class="card shadow-sm">
            <div class="card-body">
            <!-- Traffic Type (Select2) -->
            <div class="mb-3">
               <label for="trafficTypeSelect" class="form-label fw-bold">
                  Traffic Type <span class="text-danger" id="crequestError"></span>
               </label>
               <select id="trafficTypeSelect" name="crequest[]" multiple="multiple" class="form-select" data-placeholder="Select Traffic Type" style="font-size:13.5px">
               <?php
                  $selectedTrafficTypes = explode(', ', $rq->crequest);
                  foreach ($traftype as $type) {
                     $selected = in_array($type->name, $selectedTrafficTypes) ? 'selected' : '';
                     echo '<option value="' . $type->name . '" ' . $selected . '>' . $type->name . '</option>';
                  }
                  ?>
               </select>
            </div>
            
            <div id="trafficUrlContainer" class="row">
            <?php
               if (isset($rq->crequest)) {
                  $selectedTrafficTypes = explode(', ', $rq->crequest);
                  $urlIndex = 0; // Biến để theo dõi index của trafficurl
                  foreach ($selectedTrafficTypes as $index => $type) {
                        $type = trim($type);
                        if ($type !== 'Email Traffic') {
                           $url = isset($trafficurl[$urlIndex]) ? $trafficurl[$urlIndex] : '';
                           echo '<div class="col-md-6 mt-2 trafficUrlInput" data-traffic-type="' . $type . '">' .
                                 '<label for="traffic_' . $urlIndex . '" class="form-label">' . $type . '</label>' .
                                 '<input type="text" name="trafficurl[]" id="traffic_' . $urlIndex . '" class="form-control" value="' . $url . '" placeholder="Enter URL for ' . $type . '">' .
                                 '</div>';
                           $urlIndex++; // Tăng index của trafficurl
                        }
                  }
               }
               ?>
            </div>
            
            <!-- Card chứa Subject và Message (chỉ hiển thị khi chọn Email Traffic) -->
            <div class="card shadow-sm p-3 mt-4" id="emailContentCard" style="display: <?= (isset($rq->crequest) && strpos($rq->crequest, 'Email Traffic') !== false) ? 'block' : 'none'; ?>;">
               <label for="traffic_Email" class="form-label fw-bold">Email Traffic</label>
               <!-- Subject -->
               <div class="mb-3">
                  <label for="subject" class="form-label">Subject <span class="text-danger" id="subjectError"></span></label>
                  <input style="font-size:13.5px" type="text" class="form-control" name="subject" id="subject" value="<?= isset($rq->subject) ? $rq->subject : ''; ?>" placeholder="Enter your Subject" />
               </div>
               <!-- Message -->
               <div class="mb-3">
                  <label for="message" class="form-label">Creative Content <span class="text-danger" id="soanthaoError"></span> </label>
                  <textarea id="soanthao" name="message" class="form-control" rows="4" placeholder="Enter your message..."><?php echo (isset($rq->message) ? $rq->message : ''); ?></textarea>
                  <p id="charCount">0 / 50.000 characters</p>
               </div>
            </div>
            
            <!-- Nút Submit -->
            <div class="modal-footer justify-content-between">
               <button type="submit" class="btn d-flex align-items-center p-0 rounded-3 border-0">
                  <span class="text-white px-3 py-2 d-flex align-items-center rounded-start" style="background-color:#35669f;">♻</span>
                  <span class="px-3 py-2 text-white rounded-end" style="background: #3d76b9;">Submit</span>
               </button>
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  ❗ Close
               </button>
            </div>
            </div>
         </div>
      </div>
      </form>
    </div>
  </div>
</div>