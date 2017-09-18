<?php
require_once(realpath(dirname(__FILE__)) . '/Customer.php');

/**
 * @access public
 * @author andreas.martin
 */
interface CustomerService {

	/**
	 * @access public
	 * @param Customer customer
	 * @param int currentAgentId
	 * @return Customer
	 * @ParamType customer Customer
	 * @ParamType currentAgentId int
	 * @ReturnType Customer
	 */
	public function createCustomer(Customer $customer, $currentAgentId);

	/**
	 * @access public
	 * @param int customerId
	 * @param int currentAgentId
	 * @return Customer
	 * @ParamType customerId int
	 * @ParamType currentAgentId int
	 * @ReturnType Customer
	 */
	public function readCustomer($customerId, $currentAgentId);

	/**
	 * @access public
	 * @param Customer customer
	 * @param int currentAgentId
	 * @return Customer
	 * @ParamType customer Customer
	 * @ParamType currentAgentId int
	 * @ReturnType Customer
	 */
	public function updateCustomer(Customer $customer, $currentAgentId);

	/**
	 * @access public
	 * @param Customer customer
	 * @param int currentAgentId
	 * @ParamType customer Customer
	 * @ParamType currentAgentId int
	 */
	public function deleteCustomer(Customer $customer, $currentAgentId);

	/**
	 * @access public
	 * @param int currentAgentId
	 * @return Customer[]
	 * @ParamType currentAgentId int
	 * @ReturnType Customer[]
	 */
	public function findAll($currentAgentId);
}
?>