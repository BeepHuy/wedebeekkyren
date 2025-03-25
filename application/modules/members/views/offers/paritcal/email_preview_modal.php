<div class="col-md-12 mt-4">
    <label for="traffic_EmailTraffic" id="traffic_EmailTrafficLB" class="form-label fw-bold" style="cursor: pointer !important;">Email Traffic
        <span class="ms-1" id="spankey" data-bs-toggle="tooltip" data-bs-placement="top" title="Di chuột vào đây để xem thông tin chi tiết của message" style="cursor: pointer !important;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#2C3E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" fill="#ECF0F1"/>
                <circle cx="12" cy="12" r="3.5" fill="#3498DB"/>
                <circle cx="13.5" cy="10.5" r="0.8" fill="white"/>
            </svg>
        </span>
    </label>
    <input type="text" name="trafficurl[]" id="traffic_EmailTraffic" class="form-control text-truncate" value="<?php echo $emailSubject; ?>" readonly style="cursor: pointer !important;">
</div>