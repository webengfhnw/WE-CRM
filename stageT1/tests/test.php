<?php

// Autoload files using the Composer autoloader.
require('../vendor/autoload.php');

use HelloWorld\Greetings;

echo Greetings::sayHelloWorld();
echo "<br>";
strpos($_SERVER['SERVER_PORT'],"80") ? $serverPort = "" : $serverPort = ":" . $_SERVER['SERVER_PORT'];
echo $serverPort;
echo "<br>";
echo $_SERVER['SERVER_PORT'];