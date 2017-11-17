<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 01.11.2017
 * Time: 13:52
 */

namespace service;

use config\Config;

class EmailServiceClient
{

    public static function sendEmail($toEmail, $subject, $htmlData){
        $jsonObj = self::createEmailJSONObj();
        $jsonObj->personalizations[0]->to[0]->email = $toEmail;
        $jsonObj->subject = $subject;
        $jsonObj->content[0]->value = $htmlData;

        /* TODO: Add your SendGrid API key to the config file */

        $options = ["http" => [
            "method" => "POST",
            "header" => ["Content-Type: application/json",
                "Authorization: Bearer ".Config::emailConfig("sendgrid-apikey").""],
            "content" => json_encode($jsonObj)
        ]];
        /* TODO: Use stream_context_create and file_get_contents to send the API request */
        if(strpos($http_response_header[0],"202"))
            return true;
        return false;
    }

    protected static function createEmailJSONObj(){
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
          ]
        }');
    }
}