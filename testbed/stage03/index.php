<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 16.10.2017
 * Time: 08:38
 */

$iniFile = "config.env";
$config = [];
if(file_exists($iniFile)) {
    $databaseConfig = parse_ini_file($iniFile, true)["database"];
    /** TODO: Create a Data Source Name (DSN) and store it in $config["pdo"]["dsn"] based on the following example:
     * pgsql:host=123456.eu-west-1.compute.amazonaws.com;port=5432; dbname=abc; sslmode=require
     * <driver>:host=<host>;port=<port>; dbname=<db name>; sslmode=require
     */
    $config["pdo"]["user"] = $databaseConfig["user"];
    $config["pdo"]["password"] = $databaseConfig["password"];
}

function register($name, $email, $password)
{
    global $config;
    /** TODO: Initialize a PDO instance using the $config parameters dsn, user and password */
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /** TODO: create a prepared SQL statement to insert agent data if the email does not already exist */
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':emailExist', $email);
    /** TODO: bind the password value, but hash the password right before */
    $stmt->execute();
}

function login($email, $password){
    global $config;
    /** TODO: Initialize a PDO instance using the $config parameters dsn, user and password */
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /** TODO: create a prepared SQL statement to select an agent by email */
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        /** TODO: retrieve one agent entry as associative array */
        if (/** TODO: verify the password */) {
            /** TODO: start a session
             * and add some agent data to the $_SESSION["agentLogin"] session array */
            if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
                /** TODO: create a prepared SQL statement to update the password if it needs an update */
                $stmt = $pdoInstance->prepare('
                UPDATE agent SET password=:password WHERE id = :id;');
                $stmt->bindValue(':id', $agent["id"]);
                /** TODO: bind the password value, but hash the password right before */
                $stmt->execute();
            }
        }
    }
}

register("John Test","john@test.com","password");
login("john@test.com","password");
echo $_SESSION["agentLogin"]["name"];