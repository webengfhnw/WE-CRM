<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 06.11.2017
 * Time: 09:36
 */

class BaseClassA{
    public function fooBaseClassA(){
        return "Foo base class A" . PHP_EOL;
    }
}

class BaseClassB{
    public function fooBaseClassB(){
        return "Foo base class B" . PHP_EOL;
    }
}

trait SharedTrait{
    public function fooSharedTrait(){
        return "Foo shared Trait" . PHP_EOL;
    }
}

class SubClassA extends BaseClassA{
    use SharedTrait;
}

class SubClassB extends BaseClassB{
    use SharedTrait;
}

$objSubClassA = new SubClassA();
echo $objSubClassA->fooBaseClassA();
echo $objSubClassA->fooSharedTrait();

$objSubClassB = new SubClassB();
echo $objSubClassB->fooBaseClassB();
echo $objSubClassB->fooSharedTrait();