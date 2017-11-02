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
use service\PDFServiceClient;

class PDFController
{
    public static function generatePDFCustomers(){
        $pdfView = new View("customerListPDF.php");
        $pdfView->customers = WECRMServiceImpl::getInstance()->findAllCustomer();
        $result = PDFServiceClient::sendPDF($pdfView->render());
        header("Content-Type: application/pdf", NULL, 200);
        echo $result;
    }
}