<?php
class Getgeo
{
    public function getCountry($ip = '')
    {
        if (empty($ip)) {
            return '';
        }
        
        try {
            // Sử dụng cURL để gọi GeoJS API
            $url = "https://get.geojs.io/v1/ip/country/{$ip}.json";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout 5 giây
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode !== 200 || empty($response)) {
                return '';
            }
            
            $data = json_decode($response, true);
            
            return isset($data['country']) ? strtolower($data['country']) : '';
            
        } catch (Exception $e) {
            return '';
        }
    }

}