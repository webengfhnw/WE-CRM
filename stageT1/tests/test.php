<?php

// Autoload files using the Composer autoloader.
require('../../vendor/autoload.php');

use HelloWorld\Greetings;

echo Greetings::sayHelloWorld();
