<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 16.10.2017
 * Time: 08:38
 */

require_once "config\Autoloader.php";

use database\Database;

function register($name, $email, $password)
{
    $pdoInstance = Database::connect();
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /** TODO: create a prepared SQL statement to insert agent data if the email does not already exist */
    $stmt = $pdoInstance->prepare('
        INSERT INTO agent (name, email, password)
          SELECT :name,:email,:password
          WHERE NOT EXISTS (
            SELECT email FROM agent WHERE email = :emailExist
        );');
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':emailExist', $email);
    /** TODO: bind the password value, but hash the password right before */
    $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    $stmt->execute();
}

function login($email, $password){
    $pdoInstance = Database::connect();
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /** TODO: create a prepared SQL statement to select an agent by email */
    $stmt = $pdoInstance->prepare('
            SELECT * FROM agent WHERE email = :email;');
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        /** TODO: retrieve one agent entry as associative array */
        $agent = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        if (password_verify($password, $agent["password"])) { /** TODO: verify the password */
            /** TODO: start a session
             * and add some agent data to the $_SESSION["agentLogin"] session array */
            session_start();
            session_regenerate_id(true);
            $_SESSION["agentLogin"]["name"] = $agent["name"];
            $_SESSION["agentLogin"]["email"] = $email;
            $_SESSION["agentLogin"]["id"] = $agent["id"];
            if (password_needs_rehash($password, PASSWORD_DEFAULT)) { /** TODO: create a prepared SQL statement to update the password if it needs an update */
                $stmt = $pdoInstance->prepare('
                UPDATE agent SET password=:password WHERE id = :id;');
                $stmt->bindValue(':id', $agent["id"]);
                /** TODO: bind the password value, but hash the password right before */
                $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
                $stmt->execute();
            }
        }
    }
}

register("John Test","john@test.com","password");
login("john@test.com","password");
echo $_SESSION["agentLogin"]["name"];