<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 17.11.2017
 * Time: 07:05
 */

/* TODO: Change the JSON data to send you an email*/

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
    "email": "from Email",
    "name": "from Name"
  },
  "subject": "subject",
  "content": [
    {
      "type": "text/html",
      "value": "<html><p>text</p></html>"
    }
  ]
}';

/* TODO: add your API key*/
$options = ["http" => [
    "method" => "POST",
    "header" => ["Content-Type: application/json",
        "Authorization: Bearer <<YOUR_API_KEY>>"],
    "content" => $jsonData
]];

/* TODO: Use stream_context_create and file_get_contents to send the API request */

echo json_decode($response);

/* TODO: Implement and use the EmailServiceClient */