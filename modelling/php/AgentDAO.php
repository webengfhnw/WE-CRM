<?php
require_once(realpath(dirname(__FILE__)) . '/Agent.php');

/**
 * @access public
 * @author andreas.martin
 */
class AgentDAO {

	/**
	 * @access public
	 * @param Agent agent
	 * @return Agent
	 * @ParamType agent Agent
	 * @ReturnType Agent
	 */
	public function create(Agent $agent) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param int agentId
	 * @return Agent
	 * @ParamType agentId int
	 * @ReturnType Agent
	 */
	public function read($agentId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Agent agent
	 * @return Agent
	 * @ParamType agent Agent
	 * @ReturnType Agent
	 */
	public function update(Agent $agent) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param String email
	 * @return Agent
	 * @ParamType email String
	 * @ReturnType Agent
	 */
	public function findByEmail($email) {
		// Not yet implemented
	}
}
?>