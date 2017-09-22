<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 20.09.2017
 * Time: 20:34
 */

function connect()
{
    global $config;
    $pdoInstance = new PDO ($config["pdo"]["dsn"], $config["pdo"]["user"], $config["pdo"]["password"]);
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdoInstance;
}