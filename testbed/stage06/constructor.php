<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 31.10.2017
 * Time: 08:36
 */

class BaseClass {

    public function __construct($param1 = null, $param2 = null)
    {
        if(isset($param1)&&!isset($param2)){
            echo "BaseClass constructor called with param 1: " . $param1;
        }
        else if(isset($param1)&&isset($param2)){
            echo "BaseClass constructor called with param 1: " . $param1 . " param 2: " . $param2;
        } else{
            echo "BaseClass constructor called with param 1: " . "default";
        }

    }

    public function myFunction($param1 = "default", $param2 = 300)
    {
        echo "myFunction called with param 1: " . $param1 . " param 2: " . $param2;

    }

    public function myCoolFunction(...$paramArr)
    {
        foreach ($paramArr as $param){
            echo "data: " . $param;
        }
    }

    function __destruct()
    {
        echo " destructor called ";
    }

}

$baseObj = new BaseClass();
$baseObj = null;
$baseObj = new BaseClass();
