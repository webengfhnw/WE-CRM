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
        $authService = AuthServiceImpl::getInstance();
        header("Authorization: " . $authService->issueToken(), NULL, 204);
    }

    public static function validateToken(){
        header(NULL, NULL, 200);
    }

    public static function findAllCustomer(){
        $responseData = (new CustomerServiceImpl())->findAllCustomer();
        header("Content-Type: application/json", NULL, 200);
        echo json_encode($responseData);
    }

    public static function readCustomer($id){
        $responseData = (new CustomerServiceImpl())->readCustomer($id);
        header("Content-Type: application/json", NULL, 200);
        echo json_encode($responseData);
    }

    public static function update($customerId = null){
        $requestData = json_decode(file_get_contents("php://input"), true);
        $customer = Customer::Deserialize($requestData);
        $customerValidator = new CustomerValidator($customer);
        if($customerValidator->isValid()) {
            if (is_null($customerId)) {
                (new CustomerServiceImpl())->createCustomer($customer);
            } else {
                $customer->setId($customerId);
                (new CustomerServiceImpl())->updateCustomer($customer);
            }
        }
        else{
            return false;
        }
        return true;
    }

    public static function create(){
        return self::update();
    }

    public static function delete($id){
        (new CustomerServiceImpl())->deleteCustomer($id);
        header("Content-Type: application/json", NULL, 204);
    }

}