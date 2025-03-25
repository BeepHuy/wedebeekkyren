<div class="container my-4 p-0">
    <div class="card shadow-sm">
        <div class="card-body">
            <div id="apprivedShow">
                <div id="apprivedtraffic" class="row">
                <?php
                    if (!empty($rq->trafficurl) && !empty($rq->crequest)) {
                        $crequests   = array_map('trim', explode(',', $rq->crequest));
                        $trafficUrls = array_map('trim', explode(',', $rq->trafficurl));
                        $urlIndex = 0;
                        
                        foreach ($crequests as $index => $trafficType) {
                            if ($trafficType === 'Email Traffic') {
                                continue;
                            }
                            
                            $url = isset($trafficUrls[$urlIndex]) ? $trafficUrls[$urlIndex] : '';
                            ?>
                            <div class="col-md-6 mt-2">
                                <label for="traffic_<?php echo $urlIndex; ?>" class="form-label fw-bold"><?php echo $trafficType; ?></label>
                                <input type="text" name="trafficurl[]" id="traffic_<?php echo $urlIndex; ?>" class="form-control text-truncate" value="<?php echo $url; ?>" readonly>
                            </div>
                            <?php
                            $urlIndex++;
                        }
                    }
                    
                    // Xử lý Email Subject
                    $emailSubject = isset($rq->subject) ? $rq->subject : '';
                    if (!empty($rq->subject)) {
                        $this->load->view('offers/paritcal/email_preview_modal.php', [
                            'emailSubject' => $rq->subject,
                            'message' => isset($rq->message) ? $rq->message : ''
                        ]);
                    }
                ?>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button class="btn d-flex align-items-center p-0 rounded-3 border-0" data-bs-toggle="modal" data-bs-target="#editModal">
                    <span class="text-white px-3 py-2 d-flex align-items-center rounded-start" style="background-color:#35669f;">📝</span>
                    <span class="px-3 py-2 text-white rounded-end" style="background: #3d76b9;">EDIT</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Email Content Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered m-auto" style="width: auto; max-width: 80%; max-height: 80vh;">
            <div class="modal-content w-auto m-auto" style="max-width: 90%;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="emailModalLabel">Email Traffic Content</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="email-subject-container bg-light py-2 px-3 border-bottom">
                    <p class="mb-0 fw-bold text-center text-primary"><?php echo $emailSubject; ?></p>
                </div>
                <div class="modal-body overflow-auto" id="modal-body" style="max-height: 75vh;">
                    <div><?php echo (isset($rq->message) ? $rq->message : ''); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>