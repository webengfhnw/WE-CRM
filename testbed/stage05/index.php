<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 31.10.2017
 * Time: 08:08
 */

//require_once "config\Config.php";
//require_once "database\Database.php";
require_once "config\Autoloader.php";

use database\Database;

echo Database::connect();