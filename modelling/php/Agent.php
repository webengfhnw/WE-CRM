<?php
require_once(realpath(dirname(__FILE__)) . '/Customer.php');

/**
 * @access private
 * @author andreas.martin
 */
class Agent {
	/**
	 * @AttributeType int
	 */
	private $id;
	/**
	 * @AttributeType String
	 */
	private $email;
	/**
	 * @AttributeType String
	 */
	private $password;
	/**
	 * @AssociationType Customer
	 * @AssociationMultiplicity 0..*
	 */
	public $customer = array();

	/**
	 * @access public
	 * @return int
	 * @ReturnType int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @access public
	 * @param int id
	 * @return void
	 * @ParamType id int
	 * @ReturnType void
	 */
	public function setId(&$id) {
		$this->id = $id;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @access public
	 * @param String email
	 * @return void
	 * @ParamType email String
	 * @ReturnType void
	 */
	public function setEmail(&$email) {
		$this->email = $email;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @access public
	 * @param String password
	 * @return void
	 * @ParamType password String
	 * @ReturnType void
	 */
	public function setPassword(&$password) {
		$this->password = $password;
	}
}
?>