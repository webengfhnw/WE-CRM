<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.09.2017
 * Time: 15:13
 */

namespace database;

use \PDO;
use config\Config;

class Database
{
    private static $pdoInstance = null;

    private function __construct()
    {
        self::$pdoInstance = new PDO (Config::pdoConfig("dsn"), Config::pdoConfig("user"), Config::pdoConfig("password"));
        self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function connect()
    {
        /** TODO: Implement the instantiation of the PDO instance and return it */
        if(self::$pdoInstance){
            return self::$pdoInstance;
        }
        // this calls a constructor within a class
        new self();

        return self::$pdoInstance;


    }


}

