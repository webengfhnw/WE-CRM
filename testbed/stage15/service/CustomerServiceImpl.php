<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.11.2017
 * Time: 08:09
 */

namespace service;

use domain\Customer;
use http\HTTPException;
use http\HTTPHeader;
use http\HTTPStatusCode;

class CustomerServiceImpl
{
    private $customerRepository = [];

    public function __construct()
    {
        if(file_exists("customerRepository.db"))
            $this->customerRepository = unserialize(file_get_contents("customerRepository.db"));
    }

    public function __destruct()
    {
        file_put_contents("customerRepository.db", serialize($this->customerRepository));
    }

    public function createCustomer(Customer $customer) {
        $key = 1;
        /* @var Customer $lastCustomer */
        if(sizeof($this->customerRepository)) {
            $lastCustomer = end($this->customerRepository);
            $key = $lastCustomer->getId() + 1;
        }
        $customer->setId($key);
        $this->customerRepository[$key] = $customer;
        return $customer;
    }

    public function readCustomer($customerId) {
        $key = $customerId;
        if(array_key_exists($customerId, $this->customerRepository)) {
            return $this->customerRepository[$key];
        }
        throw new HTTPException(HTTPStatusCode::HTTP_404_NOT_FOUND);
    }

    public function updateCustomer(Customer $customer) {
        $key = $customer->getId();
        if(array_key_exists($key, $this->customerRepository)) {
            $this->customerRepository[$key] = $customer;
            return $customer;
        }
        throw new HTTPException(HTTPStatusCode::HTTP_404_NOT_FOUND);
    }

    public function deleteCustomer($customerId) {
        $key = $customerId;
        if(array_key_exists($key, $this->customerRepository)) {
            unset($this->customerRepository[$key]);
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return true;
        }
        throw new HTTPException(HTTPStatusCode::HTTP_404_NOT_FOUND);
    }

    public function findAllCustomer() {
        return $this->customerRepository;
    }
}