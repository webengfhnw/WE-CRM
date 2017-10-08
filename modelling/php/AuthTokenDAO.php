<?php
require_once(realpath(dirname(__FILE__)) . '/AuthToken.php');

/**
 * @access public
 * @author andreas.martin
 */
class AuthTokenDAO {

	/**
	 * @access public
	 * @param AuthToken authToken
	 * @return AuthToken
	 * @ParamType authToken AuthToken
	 * @ReturnType AuthToken
	 */
	public function create(AuthToken $authToken) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param AuthToken authToken
	 * @ParamType authToken AuthToken
	 */
	public function delete(AuthToken $authToken) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param String selector
	 * @return AuthToken
	 * @ParamType selector String
	 * @ReturnType AuthToken
	 */
	public function findBySelector($selector) {
		// Not yet implemented
	}
}
?>