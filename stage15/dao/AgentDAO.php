<?php

namespace dao;

use domain\Agent;

/**
 * @access public
 * @author andreas.martin
 */
class AgentDAO extends BasicDAO {

	/**
	 * @access public
	 * @param Agent agent
	 * @return Agent
	 * @ParamType agent Agent
	 * @ReturnType Agent
	 */
	public function create(Agent $agent) {
        $stmt = $this->pdoInstance->prepare('
        INSERT INTO agent (name, email, password)
          SELECT :name,:email,:password
          WHERE NOT EXISTS (
            SELECT email FROM agent WHERE email = :emailExist
        );');
        $stmt->bindValue(':name', $agent->getName());
        $stmt->bindValue(':email', $agent->getEmail());
        $stmt->bindValue(':emailExist', $agent->getEmail());
        $stmt->bindValue(':password', $agent->getPassword());
        $stmt->execute();
        return $this->read($this->pdoInstance->lastInsertId());
	}

	/**
	 * @access public
	 * @param int agentId
	 * @return Agent
	 * @ParamType agentId int
	 * @ReturnType Agent
	 */
	public function read($agentId) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM agent WHERE id = :id;');
        $stmt->bindValue(':id', $agentId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Agent")[0];
        }
        return null;
    }

	/**
	 * @access public
	 * @param Agent agent
	 * @return Agent
	 * @ParamType agent Agent
	 * @ReturnType Agent
	 */
	public function update(Agent $agent) {
        $stmt = $this->pdoInstance->prepare('
                UPDATE agent SET name=:name, email=:email, password=:password WHERE id = :id;');
        $stmt->bindValue(':id', $agent->getId());
        $stmt->bindValue(':name', $agent->getName());
        $stmt->bindValue(':email', $agent->getEmail());
        $stmt->bindValue(':password', $agent->getPassword());
        $stmt->execute();
        return $this->read($agent->getId());
	}

	/**
	 * @access public
	 * @param String email
	 * @return Agent
	 * @ParamType email String
	 * @ReturnType Agent
	 */
	public function findByEmail($email) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM agent WHERE email = :email;');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Agent")[0];
        return null;
    }
}
?>