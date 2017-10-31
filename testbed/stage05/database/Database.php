<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 31.10.2017
 * Time: 08:05
 */

namespace database;

use config\Config;

//require_once "config\Config.php";

class Database
{
    public static function connect()
    {
        return Config::pdoConfig("");
    }
}