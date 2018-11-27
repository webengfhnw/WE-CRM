<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 16.10.2017
 * Time: 14:04
 */
require_once("config/Autoloader.php");

$jsonData = '{
  "personalizations": [
    {
      "to": [
        {
          "email": "email",
          "name": "name"
        }
      ]
    }
  ],
  "from": {
    "email": "noreply@we-crm.com",
    "name": "WE-CRM"
  },
  "subject": "Hello, World!",
  "content": [
    {
      "type": "text/html",
      "value": "<html><p>Hello, world!</p></html>"
    }
  ]
}';

$options = ["http" => [
    "method" => "POST",
    "header" => ["Content-Type: application/json",
                "Authorization: Bearer <<YOUR_API_KEY>>"],
    "content" => $jsonData
]];
$context = stream_context_create($options);
$response = file_get_contents("https://api.sendgrid.com/v3/mail/send", false, $context);
if(strpos($http_response_header[0],"202"))
    echo json_decode($response);

/*
use service\EmailServiceClient;

EmailServiceClient::sendEmail("andreas.martin@fhnw.ch", "Test Email", "<html><body>Hi user<br><br>This is a test email.<br><br>Kind regards<br>Email Service</body></html>");
*/