<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.10.2017
 * Time: 11:50
 */

namespace service;

use domain\Customer;
use validator\CustomerValidator;
use http\HTTPStatusCode;
use http\HTTPHeader;

class ServiceEndpoint
{

    public static function authenticateToken(){
        if (isset($_SERVER["HTTP_AUTHORIZATION"])){
            if(strripos($_SERVER["HTTP_AUTHORIZATION"], " ")){
                list($type, $data) = explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2);
                if (strcasecmp($type, "Bearer") == 0) {
                    if(AuthServiceImpl::getInstance()->validateToken($data)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function authenticateBasic(){
        if (isset($_SERVER["HTTP_AUTHORIZATION"])){
            if(strripos($_SERVER["HTTP_AUTHORIZATION"], " ")) {
                list($type, $data) = explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2);
                if (strcasecmp($type, "Basic") == 0) {
                    list($name, $password) = explode(':', base64_decode($data));
                    if (AuthServiceImpl::getInstance()->verifyAgent($name, $password)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function loginBasicToken(){
        HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
        $authService = AuthServiceImpl::getInstance();
        HTTPHeader::setHeader("Authorization: " . $authService->issueToken(), HTTPStatusCode::HTTP_204_NO_CONTENT, false);
    }

    public static function validateToken(){
        HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_202_ACCEPTED);
    }

    public static function findAllCustomer(){
        HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
        $responseData = (new CustomerServiceImpl())->findAllCustomer();
        HTTPHeader::setHeader("Content-Type: application/json", HTTPStatusCode::HTTP_200_OK, true);
        echo json_encode($responseData);
    }

    public static function readCustomer($id){
        HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
        $responseData = (new CustomerServiceImpl())->readCustomer($id);
        HTTPHeader::setHeader("Content-Type: application/json", HTTPStatusCode::HTTP_200_OK, true);
        echo json_encode($responseData);
    }

    public static function updateCustomer($customerId = null){
        HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
        $requestData = json_decode(file_get_contents("php://input"), true);
        $customer = Customer::Deserialize($requestData);
        $customerValidator = new CustomerValidator($customer);
        if($customerValidator->isValid()) {
            if (is_null($customerId)) {
                $customer = (new CustomerServiceImpl())->createCustomer($customer);
                $location = $GLOBALS["ROOT_URL"] . $_SERVER['PATH_INFO'] . $customer->getId();
                HTTPHeader::setHeader("Location: " . $location, HTTPStatusCode::HTTP_201_CREATED, true);
            } else {
                $customer->setId($customerId);
                (new CustomerServiceImpl())->updateCustomer($customer);
                HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            }
        }
        else{
            return false;
        }
        return true;
    }

    public static function createCustomer(){
        HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
        return self::updateCustomer();
    }

    public static function deleteCustomer($id){
        HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
        (new CustomerServiceImpl())->deleteCustomer($id);
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
    }

}