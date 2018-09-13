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

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':emailExist', $email);
    /** TODO: bind the password value, but hash the password right before */

    $stmt->execute();
}

function login($email, $password){
    $pdoInstance = Database::connect();
    $pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /** TODO: create a prepared SQL statement to select an agent by email */

    $stmt->bindValue(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        /** TODO: retrieve one agent entry as associative array */

        if () { /** TODO: verify the password */
            /** TODO: start a session
             * and add some agent data to the $_SESSION["agentLogin"] session array */

            session_regenerate_id(true);

            if () { /** TODO: create a prepared SQL statement to update the password if it needs an update */
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