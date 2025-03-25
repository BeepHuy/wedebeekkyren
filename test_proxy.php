<?php

function checkProxy($ip, $user_agent, $user_language, $strictness) {
            // Your API Key
            $key = '56b4f42494b6455d97fce1b5bac29f85';

            // Create parameters array
            $parameters = array(
            		'key' => $key,
            		'ip'	=> $ip,
                    'user_agent' => $user_agent,
                    'user_language' => $user_language,
                    'strictness' => $strictness
            );

            // Format Params
            $formatted_parameters = http_build_query($parameters);

            // Create API Call URL
            $url = sprintf(
                    'https://network.affmine.com/api/proxy/proxy_lookup.php?%s', 
                    $formatted_parameters
            );


            $timeout = 5;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

            $json = curl_exec($curl);
            curl_close($curl);

            return $json;
}


//Test Example
$ip_address = $_GET['ip'];

// Retrieve additional (optional) data to improve accuray.
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
$user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];//en-US,en;q=0.9
$strictness = (int)$_GET['strictness']; // 0 (light) -> 3 (strict)

$json_result = checkProxy($ip_address, $user_agent, $user_language, $strictness);
// Decode the result into an array.
$result = json_decode($json_result, true);
$fraud_score  = $proxy = '0';
if($result['success'] == true) {
        if($result['fraud_score'])$fraud_score = $result['fraud_score'];
        if($result['proxy'])$proxy = $result['proxy'];
        
}
echo 'Fraud score: '.$fraud_score.'<br/>Proxy: '.$proxy;
echo '<pre>';
print_r($json_result);
// // Decode the result into an array.
// $result = json_decode($json_result, true);
// if($result['success'] == true) {
// 	echo 'Fraud score: '.$result['fraud_score'].' | Proxy: '.$result['proxy'];
// }


?>