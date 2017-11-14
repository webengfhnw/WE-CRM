<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.11.2017
 * Time: 08:08
 */

namespace service;

use domain\Customer;

/**
 * @access public
 * @author andreas.martin
 */
interface CustomerService {

    /**
     * @access public
     * @param Customer customer
     * @return Customer
     * @ParamType customer Customer
     * @ReturnType Customer
     */
    public function createCustomer(Customer $customer);

    /**
     * @access public
     * @param int customerId
     * @return Customer
     * @ParamType customerId int
     * @ReturnType Customer
     */
    public function readCustomer($customerId);

    /**
     * @access public
     * @param Customer customer
     * @return Customer
     * @ParamType customer Customer
     * @ReturnType Customer
     */
    public function updateCustomer(Customer $customer);

    /**
     * @access public
     * @param int customerId
     * @ParamType customerId int
     */
    public function deleteCustomer($customerId);

    /**
     * @access public
     * @return Customer[]
     * @ReturnType Customer[]
     */
    public function findAllCustomer();
}