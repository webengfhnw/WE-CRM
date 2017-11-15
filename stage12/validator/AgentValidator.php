<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 11.10.2017
 * Time: 11:27
 */

namespace validator;

use domain\Agent;

class AgentValidator
{
    private $valid = true;
    private $nameError = null;
    private $emailError = null;
    private $passwordError = null;

    public function __construct(Agent $agent = null)
    {
        if (!is_null($agent)) {
            $this->validate($agent);
        }
    }

    public function validate(Agent $agent)
    {
        if (!is_null($agent)) {
            if (empty($agent->getName())) {
                $this->nameError = 'Please enter a name';
                $this->valid = false;
            }

            if (empty($agent->getEmail())) {
                $this->emailError = 'Please enter an email address';
                $this->valid = false;
            } else if (!filter_var($agent->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $this->emailError = 'Please enter a valid email address';
                $this->valid = false;
            }

            if (empty($agent->getPassword())) {
                $this->passwordError = 'Please enter a password';
                $this->valid = false;
            }
        } else {
            $this->valid = false;
        }
        return $this->valid;

    }

    public function isValid()
    {
        return $this->valid;
    }

    public function isNameError()
    {
        return isset($this->nameError);
    }

    public function getNameError()
    {
        return $this->nameError;
    }

    public function isEmailError()
    {
        return isset($this->emailError);
    }

    public function getEmailError()
    {
        return $this->emailError;
    }

    public function setEmailError($emailError)
    {
        $this->emailError = $emailError;
        $this->valid = false;
    }

    public function isPasswordError()
    {
        return isset($this->passwordError);
    }

    public function getPasswordError()
    {
        return $this->passwordError;
    }
}