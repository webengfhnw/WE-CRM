<?php
require_once(realpath(dirname(__FILE__)) . '/Customer.php');
require_once(realpath(dirname(__FILE__)) . '/CustomerService.php');

/**
 * @access public
 * @author andreas.martin
 */
class CustomerImpl implements CustomerService {

	/**
	 * @access public
	 * @param Customer customer
	 * @param int currentAgentId
	 * @return Customer
	 * @ParamType customer Customer
	 * @ParamType currentAgentId int
	 * @ReturnType Customer
	 */
	public function createCustomer(Customer $customer, $currentAgentId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int customerId
	 * @param int currentAgentId
	 * @return Customer
	 * @ParamType customerId int
	 * @ParamType currentAgentId int
	 * @ReturnType Customer
	 */
	public function readCustomer($customerId, $currentAgentId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @param int currentAgentId
	 * @return Customer
	 * @ParamType customer Customer
	 * @ParamType currentAgentId int
	 * @ReturnType Customer
	 */
	public function updateCustomer(Customer $customer, $currentAgentId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @param int currentAgentId
	 * @ParamType customer Customer
	 * @ParamType currentAgentId int
	 */
	public function deleteCustomer(Customer $customer, $currentAgentId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int currentAgentId
	 * @return Customer[]
	 * @ParamType currentAgentId int
	 * @ReturnType Customer[]
	 */
	public function findAll($currentAgentId) {
		// Not yet implemented
	}
}
?>