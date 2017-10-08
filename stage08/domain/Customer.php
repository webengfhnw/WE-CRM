<?php

namespace domain;

/**
 * @access private
 * @author andreas.martin
 */
class Customer {
	/**
	 * @AttributeType int
	 */
	private $id;
	/**
	 * @AttributeType String
	 */
	private $name;
	/**
	 * @AttributeType String
	 */
	private $email;
	/**
	 * @AttributeType String
	 */
	private $mobile;
	/**
	 * @AssociationType int
	 * @AssociationMultiplicity 1
	 */
	private $agentId;

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
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @access public
	 * @param String name
	 * @return void
	 * @ParamType name String
	 * @ReturnType void
	 */
	public function setName($name) {
		$this->name = $name;
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
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getMobile() {
		return $this->mobile;
	}

	/**
	 * @access public
	 * @param String mobile
	 * @return void
	 * @ParamType mobile String
	 * @ReturnType void
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
	}

	/**
	 * @access public
	 * @return int
	 * @ReturnType int
	 */
	public function getAgentId() {
		return $this->agentId;
	}

	/**
	 * @access public
	 * @param int agentId
	 * @return void
	 * @ParamType agentId int
	 * @ReturnType void
	 */
	public function setAgentId($agentId) {
		$this->agentId = $agentId;
	}
}
?>