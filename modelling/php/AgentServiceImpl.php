<?php
require_once(realpath(dirname(__FILE__)) . '/AgentService.php');

/**
 * @access public
 * @author andreas.martin
 */
class AgentServiceImpl implements AgentService {

	/**
	 * @access public
	 * @param String email
	 * @return int
	 * @ParamType email String
	 * @ReturnType int
	 */
	public function getAgentId($email) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param String email
	 * @param String password
	 * @return int
	 * @ParamType email String
	 * @ParamType password String
	 * @ReturnType int
	 */
	public function verifyAgent($email, $password) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param String email
	 * @param String password
	 * @ParamType email String
	 * @ParamType password String
	 */
	public function registerAgent($email, $password) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param String email
	 * @param String password
	 * @param int currentAgentId
	 * @ParamType email String
	 * @ParamType password String
	 * @ParamType currentAgentId int
	 */
	public function editAgent($email, $password, $currentAgentId) {
		// Not yet implemented
	}
}
?>