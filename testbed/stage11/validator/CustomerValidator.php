<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 11.10.2017
 * Time: 11:21
 */

namespace validator;

use domain\Customer;

class CustomerValidator
{
    private $valid = true;
    private $nameError = null;
    private $emailError = null;
    private $mobileError = null;

    public function __construct(Customer $customer = null)
    {
        if (!is_null($customer)) {
            $this->validate($customer);
        }
    }

    public function validate(Customer $customer)
    {
        /*Todo: implement the validation method*/
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

    public function isMobileError()
    {
        return isset($this->mobileError);
    }

    public function getMobileError()
    {
        return $this->mobileError;
    }
}