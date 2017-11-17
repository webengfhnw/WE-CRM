<?php

namespace domain;

/**
 * @access protected
 * @author andreas.martin
 */
class Customer extends AbstractJSONDTO {
    /**
     * @AttributeType int
     */
    protected $id;
    /**
     * @AttributeType String
     */
    protected $name;
    /**
     * @AttributeType String
     */
    protected $email;
    /**
     * @AttributeType String
     */
    protected $mobile;
    /**
     * @AssociationType int
     * @AssociationMultiplicity 1
     */
    private $agentid;

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
    public function getAgentid() {
        return $this->agentid;
    }

    /**
     * @access public
     * @param int agentid
     * @return void
     * @ParamType agentid int
     * @ReturnType void
     */
    public function setAgentid($agentid) {
        $this->agentid = $agentid;
    }
}
?>