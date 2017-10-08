<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 21:48
 */

namespace controller;

use domain\Customer;
use service\WECRMServiceImpl;
use view\View;

class CustomerController
{
    public static function create(){
        $contentView = new View("customerEdit.php");
        layoutRendering($contentView);
    }

    public static function readAll(){
        $contentView = new View("customers.php");
        $contentView->customers = WECRMServiceImpl::getInstance()->findAllCustomer();
        layoutRendering($contentView);
    }

    public static function edit(){
        $id = $_GET["id"];
        $contentView = new View("customerEdit.php");
        $contentView->customer = WECRMServiceImpl::getInstance()->readCustomer($id);
        layoutRendering($contentView);
    }

    public static function update(){
        $customer = new Customer();
        $customer->setId($_POST["id"]);
        $customer->setName($_POST["name"]);
        $customer->setEmail($_POST["email"]);
        $customer->setMobile($_POST["mobile"]);
        if ($customer->getId() === "") {
            WECRMServiceImpl::getInstance()->createCustomer($customer);
        } else {
            WECRMServiceImpl::getInstance()->updateCustomer($customer);
        }
    }

    public static function delete(){
        $id = $_GET["id"];
        WECRMServiceImpl::getInstance()->deleteCustomer($id);
    }

    protected function layoutRendering(View $contentView){
        $view = new View("layout.php");
        $view->header = (new View("header.php"))->render();
        $view->content = $contentView->render();
        $view->footer = (new View("footer.php"))->render();
        echo $view->render();
    }

}