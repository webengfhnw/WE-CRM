<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 21:48
 */

namespace controller;

use domain\Customer;
use service\CustomerServiceImpl;
use view\TemplateView;
use view\LayoutRendering;

class CustomerController
{
    public static function create(){
        $contentView = new TemplateView("customerEdit.php");
        LayoutRendering::basicLayout($contentView);
    }

    public static function readAll(){
        $contentView = new TemplateView("customers.php");
        $contentView->customers = (new CustomerServiceImpl())->findAllCustomer();
        LayoutRendering::basicLayout($contentView);
    }

    public static function edit(){
        $id = $_GET["id"];
        $contentView = new TemplateView("customerEdit.php");
        $contentView->customer = (new CustomerServiceImpl())->readCustomer($id);
        LayoutRendering::basicLayout($contentView);
    }

    public static function update(){
        $customer = new Customer();
        $customer->setId($_POST["id"]);
        $customer->setName($_POST["name"]);
        $customer->setEmail($_POST["email"]);
        $customer->setMobile($_POST["mobile"]);
        if ($customer->getId() === "") {
            (new CustomerServiceImpl())->createCustomer($customer);
        } else {
            (new CustomerServiceImpl())->updateCustomer($customer);
        }
    }

    public static function delete(){
        $id = $_GET["id"];
        (new CustomerServiceImpl())->deleteCustomer($id);
    }

}