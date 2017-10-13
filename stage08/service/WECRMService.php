<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 14:39
 */

namespace service;

use domain\Customer;

/**
 * @access public
 * @author andreas.martin
 */
interface WECRMService {
    /**
     * @AttributeType int
     */
    const AGENT_TOKEN = 1;
    /**
     * @AttributeType int
     */
    const RESET_TOKEN = 2;
    /**
     * @AttributeType int
     */
    const JWT_TOKEN = 3;

    /**
     * @access public
     * @param String email
     * @param String password
     * @return boolean
     * @ParamType email String
     * @ParamType password String
     * @ReturnType boolean
     */
    public function verifyAgent($email, $password);

    /**
     * @access public
     * @return Agent
     * @ReturnType Agent
     */
    public function readAgent();

    /**
     * @access public
     * @param string name
     * @param String email
     * @param String password
     * @return boolean
     * @ParamType name string
     * @ParamType email String
     * @ParamType password String
     * @ReturnType boolean
     */
    public function editAgent($name, $email, $password);

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

    /**
     * @access public
     * @param String token
     * @param int type
     * @return boolean
     * @ParamType token String
     * @ParamType type int
     * @ReturnType boolean
     */
    public function validateToken($token, $type = self::AGENT_TOKEN);

    /**
     * @access public
     * @param int type
     * @return String
     * @ParamType type int
     * @ReturnType String
     */
    public function issueToken($type = self::AGENT_TOKEN);
}