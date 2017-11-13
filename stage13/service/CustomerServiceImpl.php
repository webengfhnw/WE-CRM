<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.11.2017
 * Time: 08:09
 */

namespace service;

use domain\Customer;
use dao\CustomerDAO;
use http\HTTPException;
use http\HTTPStatusCode;

class CustomerServiceImpl implements CustomerService
{
    /**
     * @access public
     * @param Customer customer
     * @return Customer
     * @ParamType customer Customer
     * @ReturnType Customer
     * @throws HTTPException
     */
    public function createCustomer(Customer $customer) {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            $customer->setAgentId(AuthServiceImpl::getInstance()->getCurrentAgentId());
            return $customerDAO->create($customer);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    /**
     * @access public
     * @param int customerId
     * @return Customer
     * @ParamType customerId int
     * @ReturnType Customer
     * @throws HTTPException
     */
    public function readCustomer($customerId) {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            return $customerDAO->read($customerId);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    /**
     * @access public
     * @param Customer customer
     * @return Customer
     * @ParamType customer Customer
     * @ReturnType Customer
     * @throws HTTPException
     */
    public function updateCustomer(Customer $customer) {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            return $customerDAO->update($customer);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    /**
     * @access public
     * @param int customerId
     * @ParamType customerId int
     */
    public function deleteCustomer($customerId) {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            $customer = new Customer();
            $customer->setId($customerId);
            $customerDAO->delete($customer);
        }
    }

    /**
     * @access public
     * @return Customer[]
     * @ReturnType Customer[]
     * @throws HTTPException
     */
    public function findAllCustomer() {
        if(AuthServiceImpl::getInstance()->verifyAuth()){
            $customerDAO = new CustomerDAO();
            return $customerDAO->findByAgent(AuthServiceImpl::getInstance()->getCurrentAgentId());
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }
}