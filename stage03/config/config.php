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
    /** TODO: Init the $config array
     */
}elseif(isset($_ENV["DATABASE_URL"])){
    $dbopts = parse_url(getenv('DATABASE_URL'));
    $config["pdo"]["dsn"] = "pgsql" . ":host=" . $dbopts["host"] . ";port=" . $dbopts["port"] . "; dbname=" . ltrim($dbopts["path"],'/') . "; sslmode=require";
    $config["pdo"]["user"] = $dbopts["user"];
    $config["pdo"]["password"] = $dbopts["pass"];
}