<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 20.09.2017
 * Time: 18:47
 */

/** TODO: Transfer this procedural implementation into a class
    you may have a static init() and a pdoConfig() method
    pdoConfig() return a pdo config array*/

// self:: is the same as This, but with static variables (while this is with static functions)
namespace config;
class Config{

    protected  static $iniFile = "config/config.env";
    protected static $config = [];

    public static function init(){

        if(file_exists(self::$iniFile)) {
            $databaseConfig = parse_ini_file(self::$iniFile, true)["database"];
            self::$config["pdo"]["dsn"] = $databaseConfig ["driver"] . ":host=" . $databaseConfig ["host"] . ";port=" . $databaseConfig["port"] . "; dbname=" . $databaseConfig ["database"] . "; sslmode=require";
            self::$config["pdo"]["user"] = $databaseConfig["user"];
            self::$config["pdo"]["password"] = $databaseConfig["password"];
        }elseif(isset($_ENV["DATABASE_URL"])){
            $dbopts = parse_url(getenv('DATABASE_URL'));
            self::$config["pdo"]["dsn"] = "pgsql" . ":host=" . $dbopts["host"] . ";port=" . $dbopts["port"] . "; dbname=" . ltrim($dbopts["path"],'/') . "; sslmode=require";
            self::$config["pdo"]["user"] = $dbopts["user"];
            self::$config["pdo"]["password"] = $dbopts["pass"];
        }


    }
    //here we didn't use a constructor cuz we don't want to make an object since the config will
    //not change during execution
    public static function pdoConfig($key){
        if (empty(self::$config)) {
            self::init();
        }
        return self::$config["pdo"][$key];

    }




}