<?php
require_once(realpath(dirname(__FILE__)) . '/WECRMService.php');
require_once(realpath(dirname(__FILE__)) . '/Agent.php');
require_once(realpath(dirname(__FILE__)) . '/Customer.php');

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
		return self::$instance;
	}

	/**
	 * @access protected
	 */
	protected function __construct() {
		// Not yet implemented
	}

	/**
	 * @access private
	 */
	private function __clone() {
		// Not yet implemented
	}

	/**
	 * @access protected
	 * @return boolean
	 * @ReturnType boolean
	 */
	protected function verifyAuth() {
		// Not yet implemented
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
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return Agent
	 * @ReturnType Agent
	 */
	public function readAgent() {
		// Not yet implemented
	}

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
	public function editAgent($name, $email, $password) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @return Customer
	 * @ParamType customer Customer
	 * @ReturnType Customer
	 */
	public function createCustomer(Customer $customer) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int customerId
	 * @return Customer
	 * @ParamType customerId int
	 * @ReturnType Customer
	 */
	public function readCustomer($customerId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @return Customer
	 * @ParamType customer Customer
	 * @ReturnType Customer
	 */
	public function updateCustomer(Customer $customer) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int customerId
	 * @ParamType customerId int
	 */
	public function deleteCustomer($customerId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return Customer[]
	 * @ReturnType Customer[]
	 */
	public function findAllCustomer() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param String token
	 * @return boolean
	 * @ParamType token String
	 * @ReturnType boolean
	 */
	public function validateToken($token) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int type
	 * @param String email
	 * @return String
	 * @ParamType type int
	 * @ParamType email String
	 * @ReturnType String
	 */
	public function issueToken($type = self::AGENT_TOKEN, $email = null) {
		// Not yet implemented
	}
}
?>