<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 20.09.2017
 * Time: 18:47
 */

$iniFile = "config/config.env";
$pdoConfig = [];
if(file_exists($iniFile)) {
    $databaseConfig = parse_ini_file($iniFile, true)["database"];
    $pdoConfig["dsn"] = $databaseConfig ["driver"] . ":host=" . $databaseConfig ["host"] . ";port=" . $databaseConfig["port"] . "; dbname=" . $databaseConfig ["database"] . "; sslmode=require";
    $pdoConfig["user"] = $databaseConfig["user"];
    $pdoConfig["password"] = $databaseConfig["password"];
}elseif(isset($_ENV["DATABASE_URL"])){
    $dbopts = parse_url(getenv('DATABASE_URL'));
    $pdoConfig["dsn"] = "pgsql" . ":host=" . $dbopts["host"] . ";port=" . $dbopts["port"] . "; dbname=" . ltrim($dbopts["path"],'/') . "; sslmode=require";
    $pdoConfig["user"] = $dbopts["user"];
    $pdoConfig["password"] = $dbopts["pass"];
}