<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 01.11.2017
 * Time: 13:51
 */

namespace controller;

use service\AuthServiceImpl;
use service\CustomerServiceImpl;
use view\TemplateView;
use service\EmailServiceClient;

class EmailController
{
    public static function sendMeMyCustomers(){
        $emailView = new TemplateView("customerListEmail.php");
        $emailView->customers = (new CustomerServiceImpl())->findAllCustomer();
        return EmailServiceClient::sendEmail(AuthServiceImpl::getInstance()->readAgent()->getEmail(), "My current customers", $emailView->render());
    }
}