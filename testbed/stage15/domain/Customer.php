<?php

namespace domain;

class Customer implements \JsonSerializable {

    protected $id;
    protected $name;
    protected $email;
    protected $mobile;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function Deserialize($decodedJSON)
    {
        $customerInstance = new self();

        foreach ($decodedJSON as $key => $value) {
            if (property_exists($customerInstance, $key)) {
                $customerInstance->{$key} = $value;
            }
        }

        return $customerInstance;
    }
}
?>