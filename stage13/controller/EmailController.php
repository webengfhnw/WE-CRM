<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 01.11.2017
 * Time: 13:51
 */

namespace controller;

use service\WECRMServiceImpl;
use view\View;
use service\EmailServiceClient;

class EmailController
{
    public static function sendMeMyCustomers(){
        $emailView = new View("customerListEmail.php");
        $emailView->customers = WECRMServiceImpl::getInstance()->findAllCustomer();
        return EmailServiceClient::sendEmail(WECRMServiceImpl::getInstance()->readAgent()->getEmail(), "My current customers", $emailView->render());
    }
}