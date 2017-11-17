<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.10.2017
 * Time: 11:50
 */

namespace service;

use domain\Customer;
use http\HTTPStatusCode;
use http\HTTPHeader;

class ServiceEndpoint
{

    public static function findAllCustomer(){
        /* TODO: write findAllCustomer */
    }

    public static function readCustomer($id){
        /* TODO: write readCustomer */
    }

    public static function updateCustomer($customerId = null){
        $requestData = json_decode(file_get_contents("php://input"), true);
        $customer = Customer::Deserialize($requestData);
        if (is_null($customerId)) {
            /* TODO: createCustomer */
        } else {
            /* TODO: updateCustomer */
        }
        return true;
    }

    public static function createCustomer(){
        return self::updateCustomer();
    }

    public static function deleteCustomer($id){
        /* TODO: write deleteCustomer */
    }

}