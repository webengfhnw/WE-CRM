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
        $responseData = (new CustomerServiceImpl())->findAllCustomer();
        HTTPHeader::setHeader("Content-Type: application/json", HTTPStatusCode::HTTP_200_OK, true);
        echo json_encode($responseData);
    }

    public static function readCustomer($id){
        $responseData = (new CustomerServiceImpl())->readCustomer($id);
        HTTPHeader::setHeader("Content-Type: application/json", HTTPStatusCode::HTTP_200_OK, true);
        echo json_encode($responseData);
    }

    public static function updateCustomer($customerId = null){
        $requestData = json_decode(file_get_contents("php://input"), true);
        $customer = Customer::Deserialize($requestData);
        if (is_null($customerId)) {
            $customer = (new CustomerServiceImpl())->createCustomer($customer);
            $location = $GLOBALS["ROOT_URL"] . $_SERVER['PATH_INFO'] . $customer->getId();
            HTTPHeader::setHeader("Location: " . $location, HTTPStatusCode::HTTP_201_CREATED, true);
        } else {
            $customer->setId($customerId);
            (new CustomerServiceImpl())->updateCustomer($customer);
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
        }
        return true;
    }

    public static function createCustomer(){
        return self::updateCustomer();
    }

    public static function deleteCustomer($id){
        (new CustomerServiceImpl())->deleteCustomer($id);
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
    }

}