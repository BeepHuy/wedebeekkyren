<div class="row">
    <div class="col-md-12">
       <?php echo $this->session->userdata('thongbao')?:'';
       $this->session->unset_userdata('thongbao');  ?>
       
    </div>
    <div class="col-md-12">
        <?php
            $mes = $this->session->userdata('messenger');
            if($mes){     
                $class='alert-success';
                if($mes=='Error!'){$class='alert-warning';}
                echo '<div class="alert '.$class.'" role="alert">'.$mes.'</div>';
                $this->session->unset_userdata('messenger');
            }
    
        ?>
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Search</div>
            <div class="panel-body">
                <?php
                    $orsearch = $this->session->userdata('orsearch');
                    $pid = $oid = '';
                    if(!empty($orsearch)){
                        $pid = isset($orsearch['userid']) ? $orsearch['userid'] : '';
                        $oid = isset($orsearch['offerid']) ? $orsearch['offerid'] : '';
                    }
                ?>

                <!-- loc offer type-->
                <form method="post" class="form-inline"
                    action="<?php echo base_url($this->uri->segment(1));?>/offersrequest/search/">
                    <div class="form-group">
                        <label for="pid">Pubid</label>
                        <input type="text" class="form-control" id="pid" name="pid" value="<?php echo $pid;?>"
                            placeholder="PubID">
                    </div>
                    <div class="form-group">
                        <label for="oid">Offers Id</label>
                        <input type="text" name="oid" class="form-control" id="oid" value="<?php echo $oid;?>"
                            placeholder="Offers Id">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>

                </form>
                <!--end loc theo offer type-->
            </div>
        </div>
    </div>
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-phone-alt"></i><span class="break"></span>Manager</h2>
            <div class="box-icon">
                <a class="btn-add"
                    href="<?php echo base_url().$this->config->item('manager').'/route/request/add/';?>"><i
                        class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">

                <div class="col-md-3">
                    <div class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3);?>" name="show_num" size="1"
                            class="form-control input-sm">
                            <?php 
                            $limit = $this->session->userdata('limit');
                            for($i=1;$i<11;$i++){
                                echo '
                                <option value="'.$i*(10).'"';
                                echo $i*(10)==$limit['0']?' selected="selected"':'';
                                echo 
                                '>'.$i*(10).'</option>
                                ';
                            }
                            ?>
                        </select>
                        <label>records per page</label>
                    </div>
                </div>

            </div>
            <?php $mcategory['0']->title= 'none';?>
            <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Traffic Type</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Offer Id</th>
                        <th>User ID</th>
                        <th>IP</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($dulieu)): ?>
                    <?php foreach ($dulieu as $row): ?>
                        <?php
                        // Xác định class màu cho từng dòng theo status
                        if ($row->status == 'Approved') {
                            $cllk = 'success';
                        } elseif ($row->status == 'Deny') {
                            $cllk = 'danger';
                        } elseif ($row->status == 'Pending') {
                            $cllk = 'warning';
                        } 
                        ?>
                        <tr class="<?php echo $cllk; ?>">
                            <td><?php echo $row->id; ?></td>
                            <td style="max-width: 270px; white-space: normal; word-wrap: break-word;">
                                <?php echo !empty($row->crequest) ? $row->crequest : ''; ?>
                            </td>
                            <td>
                                <select id="<?php echo $row->id; ?>" class="rqst">
                                    <option value="Pending"  <?php echo $row->status == 'Pending'  ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Approved" <?php echo $row->status == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                    <option value="Deny"     <?php echo $row->status == 'Deny'     ? 'selected' : ''; ?>>Deny</option>
                                </select>
                            </td>
                            <td><?php echo $row->date; ?></td>
                            <td><?php echo $row->offerid; ?></td>
                            <td><?php echo $row->userid; ?></td>
                            <td><?php echo $row->ip; ?></td>
                            <td>
                                <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#detailModal-<?php echo $row->id; ?>">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                                <a href="<?php echo base_url() . $this->config->item('manager') . '/route/request/edit/' . $row->id; ?>" class="btn btn-info btn-xs">
                                    <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal-<?php echo $row->id; ?>">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($dulieu)): ?>
            <?php foreach ($dulieu as $row): ?>
                <div class="modal fade" id="detailModal-<?php echo $row->id; ?>" tabindex="-1" role="dialog"
                aria-labelledby="detailModalLabel-<?php echo $row->id; ?>">
                <div class="modal-dialog modal-lg" role="document" style="width: auto; margin: auto; overflow: hidden;">>
                    <div class="modal-content w-auto m-auto" style="width: 60%;  max-width: 80%; margin: auto;">
                        <div class="modal-header bg-primary text-white" style="margin-top: 20px;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1; color: #fff;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="detailModalLabel-<?php echo $row->id; ?>">
                                <strong>Request Details</strong>
                            </h4>
                        </div>
                        <!-- Body -->
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto; padding: 0px 15px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong>General Info</strong></div>
                                        <div class="panel-body">
                                            <p><strong>ID:</strong> <?php echo $row->id; ?></p>
                                            <p><strong>Status:</strong> <span class="status-text"><?php echo $row->status; ?></span></p>
                                            <p><strong>Date:</strong> <?php echo $row->date; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong>Offer & User</strong></div>
                                        <div class="panel-body">
                                            <p><strong>Offer ID:</strong> <?php echo $row->offerid; ?></p>
                                            <p><strong>User ID:</strong> <?php echo $row->userid; ?></p>
                                            <p><strong>IP:</strong> <?php echo $row->ip; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($row->status == 'Deny'): ?>
                        <div class="panel panel-default panel-denial-reason">
                            <div class="panel-heading"><strong>Deny Reason</strong></div>
                            <div class="panel-body" style="display: flex; flex-direction: column;">
                                <div style="display: flex; justify-content: space-around; margin-bottom: 5px;">
                                    <input type="text" class="form-control reason-input" data-id="<?php echo $row->id; ?>" style="max-width: 90%;" value="<?php echo isset($row->denyreason) ? htmlspecialchars($row->denyreason) : ''; ?>" maxlength="200">
                                    <button type="submit" class="btn btn-primary update-reason">Update</button>
                                </div>
                                <div class="char-feedback" style="text-align: right; font-size: 12px; color: #6c757d;"><?php echo isset($row->denyreason) ? strlen($row->denyreason) : '0'; ?>/200</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                            <!-- Traffic URL -->
                            <?php if (!empty($row->trafficurl)): ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><strong>Traffic URL</strong></div>
                                    <div class="panel-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Traffic Type</th>
                                                    <th>URL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $trafficUrls = explode(',', $row->trafficurl);
                                                $crequests   = explode(',', $row->crequest);
                                                $urlIndex    = 0;
                                                foreach ($crequests as $crequest):
                                                    $crequest = trim($crequest);
                                                    if ($crequest !== 'Email Traffic'):
                                                        $currentUrl = isset($trafficUrls[$urlIndex]) ? trim($trafficUrls[$urlIndex]) : '';
                                                ?>
                                                <tr>
                                                    <td><?php echo $crequest; ?></td>
                                                    <td>
                                                        <a href="<?php echo $currentUrl; ?>" target="_blank">
                                                            <?php echo $currentUrl; ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                        $urlIndex++;
                                                    endif;
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty(trim($row->subject)) || !empty(trim($row->message))): ?>
                                <div class="panel panel-default">
                                    <div class="sticky-top p-2 border-bottom z-index-1000" style="margin: 0; top: 0; position: sticky; background-color: #f8f9fa;">
                                    <div class="panel-heading bg-light p-2 border-bottom m-0">
                                            <strong style="color: #333;">Email Traffic</strong>
                                        </div>
                                        <div class="panel-heading bg-light p-2 border-bottom m-0" style="color: #646464;">
                                            <strong>Subject</strong>
                                        </div>
                                        <div class="panel-body" style="background-color: #f8f9fa;">
                                            <?php echo $row->subject; ?>
                                        </div>
                                        <div class="panel-heading" style="color: #646464;">
                                            <strong>Message</strong>
                                        </div>
                                    </div>
                                    <div class="panel-body p-2 bg-white border" style="max-height: 400px;overflow-y: auto; word-wrap: break-word;">
                                        <?php echo htmlspecialchars_decode($row->message); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal-<?php echo $row->id; ?>" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel-<?php echo $row->id; ?>">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #d9534f; color: #fff;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="deleteModalLabel-<?php echo $row->id; ?>">
                                <strong>Confirm Delete</strong>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this record?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="<?php echo base_url() . $this->config->item('manager') . '/route/request/delete/' . $row->id; ?>"
                            class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        <?php endif; ?>

            <div class="row">
                <!--div class="col-md-12">
                    Showing 1 to 10 of 32 entries
                </div--->

                <div class="col-md-6">
                    <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3);?>" name="filter_cat" size="1"
                            class="form-control input-sm">
                            <option value="0">all</option>
                            <?php 
                                if(!empty($category)){
                                    $where = $this->session->userdata('where');
                                   
                                    foreach($category as $category1){
                                        echo '
                                            <option value="'.$category1->id.'"';
                                            if(!empty($where['manager'])){
                                                echo $where['manager']==$category1->id?' selected':'';
                                            }                                                
                                            echo '>'.$category1->title.'</option>
                                        ';
                                    }
                                }
                                ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class=" pagination">
                        <?php echo $this->pagination->create_links();?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
    <!-- Thêm div reason form -->
    <div id="reasonFormContainer" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 400px; background: white; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 style="margin: 0; color: #6c757d; font-weight: normal;">
                <i class="glyphicon glyphicon-info-sign"></i> Please provide a reason
            </h4>
            <button id="closeReasonForm" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="position: relative; margin-bottom: 15px;">
            <textarea id="denyReason" style="width: 100%; height: 100px; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; resize: none;"></textarea>
            <div style="text-align: right; margin-top: 5px;">
                <small id="charCount" style="color: #6c757d;">0/200</small>
            </div>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button id="cancelReason" class="btn btn-default" style="background-color: #f8f9fa; border-color: #ced4da;">Cancel</button>
            <button id="submitReason" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Submit</button>
        </div>
    </div>

    <!-- Thêm overlay để làm mờ nền -->
    <div id="reasonOverlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 999;"></div>
</div>

<script>
    var adminurl = '<?php echo base_url() . $this->config->item('manager'); ?>/';
    $(document).ready(function(){
    var currentRowId; // Biến lưu trữ ID của hàng hiện tại
    
    $('.rqst').on('change', function(){
        var newStatus = $(this).val();
        var row = $(this).closest('tr');
        currentRowId = $(this).attr('id'); // Lưu ID để sử dụng sau này
        
        // Cập nhật màu của dòng
        row.removeClass('success warning danger');
        if(newStatus === 'Approved'){
            row.addClass('success');
        } else if(newStatus === 'Deny'){
            row.addClass('danger');
            // Hiển thị form nhập lý do khi chọn Deny
            $('#reasonFormContainer, #reasonOverlay').show();
            $('#denyReason').val('').focus(); // Clear và focus vào textarea
            $('#charCount').text('0/200');
            return; // Không gửi Ajax ngay vì hiển thị form
        } else if(newStatus === 'Pending'){
            row.addClass('warning');
        }
        
        // Cập nhật nội dung status trong modal tương ứng
        $('#detailModal-' + currentRowId).find('.status-text').text(newStatus);
        
        // Xóa panel reason trong modal chi tiết nếu có
        $('#detailModal-' + currentRowId).find('.panel-denial-reason').remove();
        
        // Gửi Ajax cho các trạng thái khác ngoài Deny
        $.ajax({
            url: adminurl+'ajax/requestoff/',
            method: 'POST',
            data: { 
                id: currentRowId, 
                status: newStatus,
                reason: '' // Gửi chuỗi rỗng để xóa reason
            },
            success: function(response){
                // Thông báo thành công xong tự động biến mất
                var alertHTML = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                    'Status updated successfully.' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></button></div>';
                
                var alertElement = $(alertHTML).prependTo('.col-md-12:first');
                
                // Tự động ẩn thông báo sau 3 giây
                setTimeout(function() {
                    alertElement.fadeOut('slow', function() {
                        $(this).remove(); // Xóa khỏi DOM sau khi fade out
                    });
                }, 3000);
            }
        });
    });
    
     // Thêm sự kiện cho các nút update reason có sẵn khi trang tải
     $(document).on('click', '.update-reason', function() {
        var reasonInput = $(this).closest('.panel-body').find('.reason-input');
        var rowId = reasonInput.data('id') || currentRowId;
        var newReason = reasonInput.val().trim();
        
        // Đảm bảo reason không vượt quá 200 ký tự
        if (newReason.length > 200) {
            newReason = newReason.substring(0, 200);
            reasonInput.val(newReason);
        }
        
        $.ajax({
            url: adminurl+'ajax/requestoff/',
            method: 'POST',
            data: { 
                id: rowId, 
                status: 'Deny',
                reason: newReason 
            },
            success: function(response){
                // Thông báo thành công với hiệu ứng tự động biến mất
                var updateAlertHTML = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                    'Reason updated successfully.' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></button></div>';
                
                var updateAlertElement = $(updateAlertHTML).prependTo('.col-md-12:first');
                
                // Tự động ẩn thông báo sau 3 giây
                setTimeout(function() {
                    updateAlertElement.fadeOut('slow', function() {
                        $(this).remove(); // Xóa khỏi DOM sau khi fade out
                    });
                }, 3000);
            }
        });
    });
    
    // Đếm ký tự cho các input trong panel có sẵn
    $(document).on('input', '.reason-input', function() {
        var maxLength = 200;
        var currentLength = $(this).val().length;
        var charFeedback = $(this).closest('.panel-body').find('.char-feedback');
        
        // Hiển thị số ký tự
        charFeedback.text(currentLength + '/' + maxLength);
        
        // Kiểm tra nếu vượt quá số ký tự tối đa
        if(currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            charFeedback.text(maxLength + '/' + maxLength);
            charFeedback.css('color', '#dc3545');
        } else {
            charFeedback.css('color', '#6c757d');
        }
    });

    // Đếm ký tự và validate - giới hạn 200 ký tự
    $('#denyReason').on('input', function() {
        var maxLength = 200;
        var currentLength = $(this).val().length;
        
        // Hiển thị số ký tự
        $('#charCount').text(currentLength + '/' + maxLength);
        
        // Kiểm tra nếu vượt quá số ký tự tối đa
        if(currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            $('#charCount').text(maxLength + '/' + maxLength);
            $('#charCount').css('color', '#dc3545');
        } else {
            $('#charCount').css('color', '#6c757d');
        }
    });
    
    // Xử lý khi nhấn nút Submit - cho phép reason rỗng
    $('#submitReason').click(function() {
        var reason = $('#denyReason').val().trim();
        // Đảm bảo reason không vượt quá 200 ký tự
        if (reason.length > 200) {
            reason = reason.substring(0, 200);
        }
        
        // Gửi Ajax với reason (có thể rỗng)
        $.ajax({
            url: adminurl+'ajax/requestoff/',
            method: 'POST',
            data: { 
                id: currentRowId, 
                status: 'Deny',
                reason: reason 
            },
            success: function(response){
                // Đóng form
                $('#reasonFormContainer, #reasonOverlay').hide();
                
                // Cập nhật status trong modal detail
                $('#detailModal-' + currentRowId).find('.status-text').text('Deny');
                
                // Luôn thêm panel reason, ngay cả khi reason rỗng
                var detailModal = $('#detailModal-' + currentRowId);
                
                // Kiểm tra xem đã có panel denial reason chưa
                if (detailModal.find('.panel-denial-reason').length) {
                    // Nếu đã có, cập nhật nội dung input
                    detailModal.find('.panel-denial-reason input.form-control').val(reason);
                } else {
                    // Nếu chưa có, thêm panel mới với input có thể chỉnh sửa và validate
                    var reasonHTML = 
                    '<div class="panel panel-default panel-denial-reason">' +
                        '<div class="panel-heading"><strong>Deny Reason</strong></div>' +
                        '<div class="panel-body" style="display: flex; flex-direction: column;">' +
                            '<div style="display: flex; justify-content: space-around; margin-bottom: 5px;">' +
                                '<input type="text" class="form-control reason-input" style="max-width: 90%;" value="' + reason + '" maxlength="200">' +
                                '<button type="submit" class="btn btn-primary update-reason">Update</button>' +
                            '</div>' +
                            '<div class="char-feedback" style="text-align: right; font-size: 12px; color: #6c757d;">0/200</div>' +
                        '</div>' +
                    '</div>';
                    
                    // Thêm vào sau row đầu tiên trong modal
                    detailModal.find('.row:first').after(reasonHTML);
                    
                    // Cập nhật ban đầu cho đếm ký tự
                    detailModal.find('.char-feedback').text(reason.length + '/200');
                    
                    // Thêm sự kiện đếm ký tự cho input
                    detailModal.find('.reason-input').on('input', function() {
                        var maxLength = 200;
                        var currentLength = $(this).val().length;
                        
                        // Hiển thị số ký tự
                        detailModal.find('.char-feedback').text(currentLength + '/' + maxLength);
                        
                        // Kiểm tra nếu vượt quá số ký tự tối đa
                        if(currentLength > maxLength) {
                            $(this).val($(this).val().substring(0, maxLength));
                            detailModal.find('.char-feedback').text(maxLength + '/' + maxLength);
                            detailModal.find('.char-feedback').css('color', '#dc3545');
                        } else {
                            detailModal.find('.char-feedback').css('color', '#6c757d');
                        }
                    });
                    
                    // Thêm sự kiện cho nút Update (luôn cho update)
                    detailModal.find('.update-reason').on('click', function() {
                        var newReason = detailModal.find('.reason-input').val().trim();
                        // Đảm bảo reason không vượt quá 200 ký tự
                        if (newReason.length > 200) {
                            newReason = newReason.substring(0, 200);
                            detailModal.find('.reason-input').val(newReason);
                        }
                        
                        $.ajax({
                            url: adminurl+'ajax/requestoff/',
                            method: 'POST',
                            data: { 
                                id: currentRowId, 
                                status: 'Deny',
                                reason: newReason 
                            },
                            success: function(response){
                                // Thông báo thành công với hiệu ứng tự động biến mất
                                var updateAlertHTML = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                    'Reason updated successfully.' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                    '<span aria-hidden="true">&times;</span></button></div>';
                                
                                var updateAlertElement = $(updateAlertHTML).prependTo('.col-md-12:first');
                                
                                // Tự động ẩn thông báo sau 3 giây
                                setTimeout(function() {
                                    updateAlertElement.fadeOut('slow', function() {
                                        $(this).remove(); // Xóa khỏi DOM sau khi fade out
                                    });
                                }, 3000);
                            }
                        });
                    });
                }
                
                // Thêm thông báo thành công với hiệu ứng tự động biến mất
                var alertHTML = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                    'Status updated successfully.' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></button></div>';
                
                var alertElement = $(alertHTML).prependTo('.col-md-12:first');
                
                // Tự động ẩn thông báo sau 3 giây
                setTimeout(function() {
                    alertElement.fadeOut('slow', function() {
                        $(this).remove(); // Xóa khỏi DOM sau khi fade out
                    });
                }, 3000);
            }
        });
    });
    
    // Đóng form khi nhấn nút Cancel hoặc X
    $('#cancelReason, #closeReasonForm').click(function() {
        $('#reasonFormContainer, #reasonOverlay').hide();
        
        // Reset lại trạng thái dropdown
        $('#' + currentRowId).val($('#' + currentRowId).find('option[selected]').val());
        
        // Reset lại màu của hàng
        var row = $('#' + currentRowId).closest('tr');
        var originalStatus = $('#' + currentRowId).find('option[selected]').val();
        
        row.removeClass('success warning danger');
        if(originalStatus === 'Approved'){
            row.addClass('success');
        } else if(originalStatus === 'Deny'){
            row.addClass('danger');
        } else if(originalStatus === 'Pending'){
            row.addClass('warning');
        }
    });
    
    // Đóng form khi click bên ngoài
    $('#reasonOverlay').click(function() {
        $('#cancelReason').click(); // Trigger cancel button
    });
});
</script>