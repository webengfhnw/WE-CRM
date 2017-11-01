<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 21:48
 */

namespace controller;

use domain\Customer;
use validator\CustomerValidator;
use service\WECRMServiceImpl;
use view\View;
use view\LayoutRendering;

class CustomerController
{
    public static function create(){
        $contentView = new View("customerEdit.php");
        LayoutRendering::basicLayout($contentView);
    }

    public static function readAll(){
        $contentView = new View("customers.php");
        $contentView->customers = WECRMServiceImpl::getInstance()->findAllCustomer();
        LayoutRendering::basicLayout($contentView);
    }

    public static function edit(){
        $id = $_GET["id"];
        $contentView = new View("customerEdit.php");
        $contentView->customer = WECRMServiceImpl::getInstance()->readCustomer($id);
        LayoutRendering::basicLayout($contentView);
    }

    public static function update(){
        $customer = new Customer();
        $customer->setId($_POST["id"]);
        $customer->setName($_POST["name"]);
        $customer->setEmail($_POST["email"]);
        $customer->setMobile($_POST["mobile"]);
        $customerValidator = new CustomerValidator($customer);
        if($customerValidator->isValid()) {
            if ($customer->getId() === "") {
                WECRMServiceImpl::getInstance()->createCustomer($customer);
            } else {
                WECRMServiceImpl::getInstance()->updateCustomer($customer);
            }
        }
        else{
            $contentView = new View("customerEdit.php");
            $contentView->customer = $customer;
            $contentView->customerValidator = $customerValidator;
            LayoutRendering::basicLayout($contentView);
            return false;
        }
        return true;
    }

    public static function delete(){
        $id = $_GET["id"];
        WECRMServiceImpl::getInstance()->deleteCustomer($id);
    }

}