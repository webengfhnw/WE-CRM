<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 14:39
 */

namespace service;

use domain\Customer;
use domain\Agent;
use dao\CustomerDAO;
use dao\AgentDAO;

/**
 * @access public
 * @author andreas.martin
 */
class WECRMServiceImpl implements WECRMService {
    /**
     * @AttributeType WECRMService
     */
    private static $instance = null;
    /**
     * @AttributeType int
     */
    private $currentAgentId;

    /**
     * @access public
     * @return WECRMService
     * @static
     * @ReturnType WECRMService
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @access protected
     */
    protected function __construct() { }

    /**
     * @access private
     */
    private function __clone() { }

    /**
     * @access protected
     * @return boolean
     * @ReturnType boolean
     */
    protected function verifyAuth() {
        if(isset($this->currentAgentId))
            return true;
        return false;
    }

    /**
     * @access public
     * @param String email
     * @param String password
     * @return boolean
     * @ParamType email String
     * @ParamType password String
     * @ReturnType boolean
     */
    public function verifyAgent($email, $password) {
        $agentDAO = new AgentDAO();
        $agent = $agentDAO->findByEmail($email);
        if (isset($agent)) {
            if (password_verify($password, $agent->getPassword())) {
                if (password_needs_rehash($agent->getPassword(), PASSWORD_DEFAULT)) {
                    $agent->setPassword(password_hash($password, PASSWORD_DEFAULT));
                    $agentDAO->update($agent);
                }
                $this->currentAgentId = $agent->getId();
                return true;
            }
        }
        return false;
    }

    /**
     * @access public
     * @param string name
     * @param String email
     * @param String password
     * @ParamType name string
     * @ParamType email String
     * @ParamType password String
     */
    public function registerAgent($name, $email, $password) {
        $agent = new Agent();
        $agent->setName($email);
        $agent->setEmail($password);
        $agent->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $agentDAO = new AgentDAO();
        $agentDAO->create($agent);
    }

    /**
     * @access public
     * @return Agent
     * @ReturnType Agent
     */
    public function readAgent() {
        if($this->verifyAuth()) {
            $agentDAO = new AgentDAO();
            return $agentDAO->read($this->currentAgentId);
        }
        return null;
    }

    /**
     * @access public
     * @param string name
     * @param String email
     * @param String password
     * @ParamType email String
     * @ParamType password String
     * @ParamType name string
     */
    public function editAgent($name, $email, $password) {
        if($this->verifyAuth()) {
            $agent = new Agent();
            $agent->setId($this->currentAgentId);
            $agent->setName($name);
            $agent->setEmail($email);
            $agent->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $agentDAO = new AgentDAO();
            $agentDAO->update($agent);
        }
    }

    /**
     * @access public
     * @param Customer customer
     * @return Customer
     * @ParamType customer Customer
     * @ReturnType Customer
     */
    public function createCustomer(Customer $customer) {
        if($this->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            $customer->setAgentId($this->currentAgentId);
            return $customerDAO->create($customer);
        }
        return null;
    }

    /**
     * @access public
     * @param int customerId
     * @return Customer
     * @ParamType customerId int
     * @ReturnType Customer
     */
    public function readCustomer($customerId) {
        if($this->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            return $customerDAO->read($customerId);
        }
        return null;
    }

    /**
     * @access public
     * @param Customer customer
     * @return Customer
     * @ParamType customer Customer
     * @ReturnType Customer
     */
    public function updateCustomer(Customer $customer) {
        if($this->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            return $customerDAO->update($customer);
        }
        return null;
    }

    /**
     * @access public
     * @param int customerId
     * @ParamType customerId int
     */
    public function deleteCustomer($customerId) {
        if($this->verifyAuth()) {
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
     */
    public function findAllCustomer() {
        if($this->verifyAuth()){
            $customerDAO = new CustomerDAO();
            return $customerDAO->findByAgent($this->currentAgentId);
        }
        return null;
    }

    /**
     * @access public
     * @param String token
     * @param int type
     * @return boolean
     * @ParamType token String
     * @ParamType type int
     * @ReturnType boolean
     */
    public function validateToken($token, $type = self::AGENT_TOKEN) {
        switch ($type){
            case self::AGENT_TOKEN :
                $tokenArray = explode(":", $token);
                if(count($tokenArray)>1) {
                    $this->currentAgentId = $tokenArray[0];
                    return true;
                }
                break;
            case self::RESET_TOKEN :
                break;
            case self::JWT_TOKEN :
                break;
        }
        return false;
    }

    /**
     * @access public
     * @param int type
     * @return String
     * @ParamType type int
     * @ReturnType String
     */
    public function issueToken($type = self::AGENT_TOKEN) {
        switch ($type){
            case self::AGENT_TOKEN :
                return $this->currentAgentId .":". bin2hex(random_bytes(20));
            case self::RESET_TOKEN :
                break;
            case self::JWT_TOKEN :
                break;
        }
        return null;
    }
}