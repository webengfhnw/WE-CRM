<?php
/**
 * @access public
 * @author andreas.martin
 */
abstract class BasicDAO {
	/**
	 * @AttributeType PDO
	 */
	protected $pdoInstance;

	/**
	 * @access public
	 * @param PDO pdoInstance
	 * @ParamType pdoInstance PDO
	 */
	public function __construct(PDO $pdoInstance = null) {
		// Not yet implemented
	}
}
?>