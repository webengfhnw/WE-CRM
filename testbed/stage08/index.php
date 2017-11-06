<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 06.11.2017
 * Time: 10:14
 */

class SingletonImpl
{
    private static $instance = null;
    private $myData;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    { }

    private function __clone()
    { }

    public function getMyData()
    {
        return $this->myData;
    }

    public function setMyData($myData)
    {
        $this->myData = $myData;
    }
}

$objVar1 = SingletonImpl::getInstance();
$objVar1->setMyData("Data 1");
echo $objVar1->getMyData(), PHP_EOL;

$objVar2 = SingletonImpl::getInstance();
$objVar2->setMyData("Data 1");
echo $objVar1->getMyData(), PHP_EOL;