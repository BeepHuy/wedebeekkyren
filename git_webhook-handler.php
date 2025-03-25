<?php
$secret = 'Kdke344567890abcdefghijklmnopqrstuvwxyz';
// Kiểm tra nếu có dữ liệu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nếu payload được gửi dưới dạng JSON, hãy lấy từ php://input
    $payload = file_get_contents('php://input');
    // Nếu không có dữ liệu, ghi log và thoát
    if ($payload === false) {
        file_put_contents('webhook.log', date('Y-m-d H:i:s') . " - Failed to read input.\n", FILE_APPEND);
        exit;
    }

    // Tính toán hash HMAC
    $signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

    // Lấy signature từ header
    $received_signature = '';
    if (isset($_SERVER['HTTP_X_HUB_SIGNATURE_256'])) {
        $received_signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'];
    }
    file_put_contents('webhook.log', date('Y-m-d H:i:s') . " - Payload: " . $payload . "\n", FILE_APPEND);
    file_put_contents('webhook.log', date('Y-m-d H:i:s') . " - Calculated Signature: " . $signature . "\n", FILE_APPEND);
    file_put_contents('webhook.log', date('Y-m-d H:i:s') . " - Received Signature: " . $received_signature . "\n", FILE_APPEND);
    
    // Ghi log toàn bộ header
    file_put_contents('webhook.log', date('Y-m-d H:i:s') . " - Received headers: " . json_encode($_SERVER) . "\n", FILE_APPEND);

    // Kiểm tra signature
    if (hash_equals($signature, $received_signature)) {
        $data = json_decode($payload, true);
        // Kiểm tra nếu có push trên branch 'pro'
        if (isset($data['ref']) && $data['ref'] === 'refs/heads/product') {
            // Chạy lệnh pull code
            $output = shell_exec('cd /home/test && git pull origin product 2>&1');
            file_put_contents('git_pull.log', date('Y-m-d H:i:s') . " - Output: " . $output . "\n", FILE_APPEND);

            $env = shell_exec('printenv');
            file_put_contents('env.log', date('Y-m-d H:i:s') . " - Environment: " . $env . "\n", FILE_APPEND);

        }
    } else {
        // Ghi log hoặc xử lý nếu signature không khớp
        http_response_code(403);
        echo "Invalid signature.";
    }
} else {
    // Ghi log nếu không phải yêu cầu POST
    file_put_contents('webhook.log', date('Y-m-d H:i:s') . " - Invalid request method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
    http_response_code(405); // Method Not Allowed
}
?>

