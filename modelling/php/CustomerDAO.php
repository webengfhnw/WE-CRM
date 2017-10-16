<?php
require_once(realpath(dirname(__FILE__)) . '/Customer.php');
require_once(realpath(dirname(__FILE__)) . '/BasicDAO.php');

/**
 * @access public
 * @author andreas.martin
 */
class CustomerDAO extends BasicDAO {

	/**
	 * @access public
	 * @param Customer customer
	 * @return Customer
	 * @ParamType customer Customer
	 * @ReturnType Customer
	 */
	public function create(Customer $customer) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int customerId
	 * @return Customer
	 * @ParamType customerId int
	 * @ReturnType Customer
	 */
	public function read($customerId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @return Customer
	 * @ParamType customer Customer
	 * @ReturnType Customer
	 */
	public function update(Customer $customer) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @ParamType customer Customer
	 */
	public function delete(Customer $customer) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int agentId
	 * @return Customer[]
	 * @ParamType agentId int
	 * @ReturnType Customer[]
	 */
	public function findByAgent($agentId) {
		// Not yet implemented
	}
}
?>