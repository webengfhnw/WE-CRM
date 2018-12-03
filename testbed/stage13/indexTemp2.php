<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 16.10.2017
 * Time: 14:04
 */

class Send
{

    public static function send()
    {
        $jsonObj = createPDFJSONObj();
        $jsonObj->user = $_ENV["HYPDF_USER"];
        $jsonObj->password = $_ENV["HYPDF_PASSWORD"];
        $jsonObj->content = "<html><p>Hello, world!</p></html>";

        $options = ["http" => [
            "method" => "POST",
            "header" => ["Content-Type: application/json"],
            "content" => json_encode($jsonObj)
        ]];
        $context = stream_context_create($options);
        $response = file_get_contents("https://www.hypdf.com/htmltopdf", false, $context);

        $jsonObj = createEmailJSONObj();
        $jsonObj->personalizations[0]->to[0]->email = "andreas.martin@fhnw.ch";
        $jsonObj->subject = "Hello, World!";
        $jsonObj->content[0]->value = "<html><p>Hello, world!</p></html>";
        $jsonObj->attachments[0]->filename = "file.pdf";
        $jsonObj->attachments[0]->content = base64_encode($response);


        $options = ["http" => [
            "method" => "POST",
            "header" => ["Content-Type: application/json",
                "Authorization: Bearer " . $_ENV["SENDGRID_APIKEY"] . ""],
            "content" => json_encode($jsonObj)
        ]];
        $context = stream_context_create($options);
        $response = file_get_contents("https://api.sendgrid.com/v3/mail/send", false, $context);
        if (strpos($http_response_header[0], "202"))
            echo json_decode($response);

    }

    public static function createPDFJSONObj()
    {
        return json_decode('{"content": "HTML", "user": "HYPDF_USER", "password": "YOUR_HYPDF_PASSWORD", "test": "true"}');
    }

    public static function createEmailJSONObj()
    {
        return json_decode('{
          "personalizations": [
            {
              "to": [
                {
                  "email": "email"
                }
              ]
            }
          ],
          "from": {
            "email": "noreply@fhnw.ch",
            "name": "WE-CRM"
          },
          "subject": "subject",
          "content": [
            {
              "type": "text/html",
              "value": "value"
            }
          ],
          "attachments": [
            {
              "content": "content",
              "type": "application/pdf",
              "filename": "filename"
            }
          ]
        }');
    }
}

Send::send();
Send::send();
Send::send();