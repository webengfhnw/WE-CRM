<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 31.10.2017
 * Time: 08:08
 */

//require_once "config\Config.php";
require_once "database\Database.php";
/* TODO: include Autoloader.
*/

require_once("view/layout.php");

/** TODO: Use the Database class */

/** TODO: Use the Router class */

echo Database::connect();

$errorFunction = function () {
    Router::errorHeader();
    require_once("view/404.php");
};

/** TODO: Write a basic route function */

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);