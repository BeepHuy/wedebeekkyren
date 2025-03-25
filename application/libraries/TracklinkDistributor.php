<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TracklinkDistributor {
    private $redis;

    public function __construct($params) {
        // Nhận Redis instance từ controller
        $this->redis = $params['redis'];
    }

    /**
     * Chọn tracklink (A hoặc B) theo tỷ lệ đặt trước cho từng user riêng biệt
     * @param string $offerid
     * @param string $userid
     * @param int $rateA
     * @return string
     */
    public function distribute_tracklink($offerid, $userid, $rateA = 30) {
        // Tự động tính tỷ lệ B
        $rateB = 100 - $rateA;

        // Redis hash key
        $offerKey = "offer_:{$offerid}"; // Hash chứa thông tin của offer
        

        // Lấy số lượt truy cập của A và B cho user
        $userCountA = (null !== $this->redis->hGet($offerKey, "user:{$userid}:countA")) ? (int) $this->redis->hGet($offerKey, "user:{$userid}:countA") : 0;
        $userCountB = (null !== $this->redis->hGet($offerKey, "user:{$userid}:countB")) ? (int) $this->redis->hGet($offerKey, "user:{$userid}:countB") : 0;

        // Tính tỷ lệ cho user
        $totalUser = $userCountA + $userCountB;
        $currentRateA = $totalUser > 0 ? ($userCountA / $totalUser) * 100 : 0;

        // Phân phối dựa trên tỷ lệ thực tế của user
        if ($currentRateA < $rateA) {
            $selected = 'A';
            $this->redis->hIncrBy($offerKey, "user:{$userid}:countA", 1); // Tăng số lượt của A cho user
        } else {
            $selected = 'B';
            $this->redis->hIncrBy($offerKey, "user:{$userid}:countB", 1); // Tăng số lượt của B cho user
        }

       
        return $selected;
    }
    /**
     * Xóa tất cả các key Redis liên quan đến offer (có tiền tố "offer")
     */
    public function clearTracklinkByOffer() {
        // Tiền tố cho các key liên quan đến offer
        $offerPrefix = "offer";

        // Sử dụng SCAN để quét và xóa tất cả key có tiền tố là "offer"
        $iterator = null;
        do {
            // Lấy các key có tiền tố "offer" trong Redis
            $keys = $this->redis->scan($iterator, $offerPrefix . '*');
            
            // Xóa tất cả các key tìm được
            if (!empty($keys)) {
                $this->redis->del($keys);
            }
        } while ($iterator > 0); // Lặp lại cho đến khi quét hết tất cả các key

    }
    /**
     * Tăng giá trị biến capByPub của user
     * @param string $offerid
     * @param string $userid
     * @param int $value
     * @return void
     */
    public function incrementCapByPub($offerid, $userid, $value = 1) {
        // Redis key cho capByPub của user
        $offerKey = "offer_:{$offerid}";

        // Tăng giá trị capByPub cho user trong Redis
        $this->redis->hIncrBy($offerKey, "user:{$userid}:capByPub", $value);
    }
     /**
     * Đọc giá trị biến capByPub của user
     * @param string $offerid
     * @param string $userid
     * @return int
     */
    public function getCapByPub($offerid, $userid) {
        // Redis key cho capByPub của user
        $offerKey = "offer_:{$offerid}";

        // Lấy giá trị capByPub của user từ Redis
        $capByPub = $this->redis->hGet($offerKey, "user:{$userid}:capByPub");

        // Nếu không có giá trị, trả về 0
        return $capByPub !== false ? (int) $capByPub : 0;
    }
}
