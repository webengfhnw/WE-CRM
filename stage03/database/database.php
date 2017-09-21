<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 20.09.2017
 * Time: 20:34
 */

function connect()
{
    global $pdoConfig;
    $pdoInstance = new PDO ($pdoConfig["dsn"], $pdoConfig["user"], $pdoConfig["password"]);
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdoInstance;
}