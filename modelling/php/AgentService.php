<?php
/**
 * @access public
 * @author andreas.martin
 */
interface AgentService {

	/**
	 * @access public
	 * @param String email
	 * @param String password
	 * @return int
	 * @ParamType email String
	 * @ParamType password String
	 * @ReturnType int
	 */
	public function verifyAgent($email, $password);

	/**
	 * @access public
	 * @param String email
	 * @param String password
	 * @ParamType email String
	 * @ParamType password String
	 */
	public function registerAgent($email, $password);

	/**
	 * @access public
	 * @param String email
	 * @param String password
	 * @param int currentAgentId
	 * @ParamType email String
	 * @ParamType password String
	 * @ParamType currentAgentId int
	 */
	public function editAgent($email, $password, $currentAgentId);
}
?>