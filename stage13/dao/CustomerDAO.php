<?php

namespace dao;

use domain\Customer;

/**
 * @access public
 * @author andreas.martin
 */
class CustomerDAO extends BasicDAO {

	/**
	 * @access public
	 * @param Customer customer
	 * @return Customer
	 * @ParamType customer Customer
	 * @ReturnType Customer
	 */
	public function create(Customer $customer) {
        $stmt = $this->pdoInstance->prepare('
            INSERT INTO customer (name, email, mobile, agentid)
            VALUES (:name, :email , :mobile, :agentId)');
        $stmt->bindValue(':name', $customer->getName());
        $stmt->bindValue(':email', $customer->getEmail());
        $stmt->bindValue(':mobile', $customer->getMobile());
        $stmt->bindValue(':agentId', $customer->getAgentId());
        $stmt->execute();
        return $this->read($this->pdoInstance->lastInsertId());
	}

	/**
	 * @access public
	 * @param int customerId
	 * @return Customer
	 * @ParamType customerId int
	 * @ReturnType Customer
	 */
	public function read($customerId) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM customer WHERE id = :id;');
        $stmt->bindValue(':id', $customerId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Customer")[0];
        }
        return null;
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @return Customer
	 * @ParamType customer Customer
	 * @ReturnType Customer
	 */
	public function update(Customer $customer) {
        $stmt = $this->pdoInstance->prepare('
            UPDATE customer SET name = :name,
                email = :email,
                mobile = :mobile
            WHERE id = :id');
        $stmt->bindValue(':name', $customer->getName());
        $stmt->bindValue(':email', $customer->getEmail());
        $stmt->bindValue(':mobile', $customer->getMobile());
        $stmt->bindValue(':id', $customer->getId());
        $stmt->execute();
        return $this->read($customer->getId());
	}

	/**
	 * @access public
	 * @param Customer customer
	 * @ParamType customer Customer
	 */
	public function delete(Customer $customer) {
        $stmt = $this->pdoInstance->prepare('
            DELETE FROM customer
            WHERE id = :id
        ');
        $stmt->bindValue(':id', $customer->getId());
        $stmt->execute();
	}

	/**
	 * @access public
	 * @param int agentId
	 * @return Customer[]
	 * @ParamType agentId int
	 * @ReturnType Customer[]
	 */
	public function findByAgent($agentId) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM customer WHERE agentid = :agentId ORDER BY id;');
        $stmt->bindValue(':agentId', $agentId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Customer");
	}
}
?>