<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 31.10.2017
 * Time: 08:08
 */

//require_once "config\Config.php";
//require_once "database\Database.php";
/* TODO: include Autoloader.
*/
require_once "config\Autoloader.php";
require_once("view/layout.php");

/** TODO: Use the Database class */
use database\Database;
/** TODO: Use the Router class */
use router\Router;

echo Database::connect();

$errorFunction = function () {
    Router::errorHeader();
    require_once("view/404.php");
};

/** TODO: Write a basic route function */
Router::route("GET", "/", function () {
    layoutSetContent("customers.php");
});

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);