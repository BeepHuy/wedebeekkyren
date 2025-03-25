<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mailjet {

    private $api_key = 'f72d1ba0c0980ed9b2ab149300bf84ae';
    private $api_secret = 'f184f59f60e41ea5c956059af5197ab0';
    private $api_url = 'https://api.mailjet.com/v3.1/send';

    public function __construct() {
        // Constructor code here, if needed
    }

    public function send_email($to_email,  $subject, $message,$from ='',$name='') {
      
        $data = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $from,
                        'Name' => $name
                    ],
                    'To' => [
                        [
                            'Email' => $to_email
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => strip_tags($message),
                    'HTMLPart' => $message,
                    'CustomID' => 'AppGettingStartedTest'
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_key . ':' . $this->api_secret);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($http_code === 200);
    }
}
/*
user
$this->load->library('Mailjet'); 
 $this->mailjet->send_email($email ,$tieude,$noidung);

*/