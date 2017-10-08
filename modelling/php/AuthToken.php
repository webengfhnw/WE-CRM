<?php
/**
 * @access public
 * @author andreas.martin
 */
class AuthToken {
	/**
	 * @AttributeType int
	 */
	private $id;
	/**
	 * @AttributeType String
	 */
	private $selector;
	/**
	 * @AttributeType String
	 */
	private $validator;
	/**
	 * @AttributeType Timestamp
	 */
	private $expiration;
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
	public function getSelector() {
		return $this->selector;
	}

	/**
	 * @access public
	 * @param String selector
	 * @return void
	 * @ParamType selector String
	 * @ReturnType void
	 */
	public function setSelector($selector) {
		$this->selector = $selector;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getValidator() {
		return $this->validator;
	}

	/**
	 * @access public
	 * @param String validator
	 * @return void
	 * @ParamType validator String
	 * @ReturnType void
	 */
	public function setValidator($validator) {
		$this->validator = $validator;
	}

	/**
	 * @access public
	 * @return Timestamp
	 * @ReturnType Timestamp
	 */
	public function getExpiration() {
		return $this->expiration;
	}

	/**
	 * @access public
	 * @param Timestamp expiration
	 * @return void
	 * @ParamType expiration Timestamp
	 * @ReturnType void
	 */
	public function setExpiration(Timestamp $expiration) {
		$this->expiration = $expiration;
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