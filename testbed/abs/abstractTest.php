<?php
/**
 * Created by PhpStorm.
 * User: Ali-Surface
 * Date: 11/7/2017
 * Time: 8:23 AM
 */

abstract class Person{
    public function greet(){
        echo "hello Person";
    }


}

// $objPerson = new Person(); doesn't work

class Man extends Person {



}

$per = new Man();
$per ->greet();