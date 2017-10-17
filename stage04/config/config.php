<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 20.09.2017
 * Time: 18:47
 */

$iniFile = "config/config.env";
$config = [];
if(file_exists($iniFile)) {
    $databaseConfig = parse_ini_file($iniFile, true)["database"];
    $config["pdo"]["dsn"] = $databaseConfig ["driver"] . ":host=" . $databaseConfig ["host"] . ";port=" . $databaseConfig["port"] . "; dbname=" . $databaseConfig ["database"] . "; sslmode=require";
    $config["pdo"]["user"] = $databaseConfig["user"];
    $config["pdo"]["password"] = $databaseConfig["password"];
}elseif(isset($_ENV["DATABASE_URL"])){
    $dbopts = parse_url(getenv('DATABASE_URL'));
    $config["pdo"]["dsn"] = "pgsql" . ":host=" . $dbopts["host"] . ";port=" . $dbopts["port"] . "; dbname=" . ltrim($dbopts["path"],'/') . "; sslmode=require";
    $config["pdo"]["user"] = $dbopts["user"];
    $config["pdo"]["password"] = $dbopts["pass"];
}