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
    $config["pdo"]["dsn"] = $databaseConfig ["driver"] . ":host=" . $databaseConfig ["host"] . ";port=" . $databaseConfig["port"] . "; dbname=" . $databaseConfig ["database"] . "; sslmode=require";
    $config["pdo"]["user"] = $databaseConfig["user"];
    $config["pdo"]["password"] = $databaseConfig["password"];
}

function register($name, $email, $password)
{
    global $config;
    $pdoInstance = new PDO ($config["pdo"]["dsn"], $config["pdo"]["user"], $config["pdo"]["password"]);
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdoInstance->prepare('
        INSERT INTO agent (name, email, password)
          SELECT :name,:email,:password
          WHERE NOT EXISTS (
            SELECT email FROM agent WHERE email = :emailExist
        );');
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':emailExist', $email);
    $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    $stmt->execute();
}

function login($email, $password){
    global $config;
    $pdoInstance = new PDO ($config["pdo"]["dsn"], $config["pdo"]["user"], $config["pdo"]["password"]);
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdoInstance->prepare('
            SELECT * FROM agent WHERE email = :email;');
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $agent = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        if (password_verify($password, $agent["password"])) {
            session_start();
            session_regenerate_id(true);
            $_SESSION["agentLogin"]["name"] = $agent["name"];
            $_SESSION["agentLogin"]["email"] = $email;
            $_SESSION["agentLogin"]["id"] = $agent["id"];
            if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
                $stmt = $pdoInstance->prepare('
                UPDATE agent SET password=:password WHERE id = :id;');
                $stmt->bindValue(':id', $agent["id"]);
                $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
                $stmt->execute();
            }
        }
    }
}

register("John Test","john@test.com","password");
login("john@test.com","password");
echo $_SESSION["agentLogin"]["name"];