<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 31.10.2017
 * Time: 08:05
 */

namespace database;

//require_once "config\Config.php";

/** TODO: Use the Config class */
use config\Config;

class Database
{
    public static function connect()
    {
        return Config::get("");
    }
}