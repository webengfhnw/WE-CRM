<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("config/Autoloader.php");
require_once("view/layout.php");
require_once("config/config.php");

use router\Router;

session_start();

$auth = function () {
    if (isset($_SESSION["agentLogin"])) {
        return true;
    }
    Router::redirect("/login");
    return false;
};

$error = function () {
    Router::errorHeader();
    require_once("view/404.php");
};

    Router::route("GET", "/login", function () {
        require_once("view/agentLogin.php");
    });

    Router::route("GET", "/register", function () {
        require_once("view/agentEdit.php");
    });

    Router::route("POST", "/register", function () {
        $name = $_POST["name"];
        $email = $_POST["email"];
        require("database/database.php");
        $pdoInstance = connect();
        $stmt = $pdoInstance->prepare('
        INSERT INTO agent (name, email, password)
          SELECT :name,:email,:password
          WHERE NOT EXISTS (
            SELECT email FROM agent WHERE email = :emailExist
        );');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':emailExist', $email);
        $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT));
        $stmt->execute();
        Router::redirect("/logout");
    });

    Router::route("POST", "/login", function () {
        $email = $_POST["email"];
        require("database/database.php");
        $pdoInstance = connect();
        $stmt = $pdoInstance->prepare('
            SELECT * FROM agent WHERE email = :email;');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $agent = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            if (password_verify($_POST["password"], $agent["password"])) {
                $_SESSION["agentLogin"]["name"] = $agent["name"];
                $_SESSION["agentLogin"]["email"] = $email;
                $_SESSION["agentLogin"]["id"] = $agent["id"];
                if (password_needs_rehash($agent["password"], PASSWORD_DEFAULT)) {
                    $stmt = $pdoInstance->prepare('
                UPDATE agent SET password=:password WHERE id = :id;');
                    $stmt->bindValue(':id', $agent["id"]);
                    $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT));
                    $stmt->execute();
                }
            }
        }
        Router::redirect("/");
    });

    Router::route("GET", "/logout", function () {
        session_destroy();
        Router::redirect("/login");
    });

    Router::route_auth("GET", "/", $auth, function () {
        require("database/database.php");
        $pdoInstance = connect();
        $stmt = $pdoInstance->prepare('
            SELECT * FROM customer WHERE agentid = :agentId ORDER BY id;');
        $stmt->bindValue(':agentId', $_SESSION["agentLogin"]["id"]);
        $stmt->execute();
        global $customers;
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        layoutSetContent("customers.php");
    });

    Router::route_auth("GET", "/agent/edit", $auth, function () {
        require_once("view/agentEdit.php");
    });

    Router::route_auth("GET", "/customer/create", $auth, function () {
        layoutSetContent("customerEdit.php");
    });

    Router::route_auth("GET", "/customer/edit", $auth, function () {
        $id = $_GET["id"];
        require("database/database.php");
        $pdoInstance = connect();
        $stmt = $pdoInstance->prepare('
            SELECT * FROM customer WHERE id = :id;');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        global $customer;
        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        layoutSetContent("customerEdit.php");
    });

    Router::route_auth("GET", "/customer/delete", $auth, function () {
        $id = $_GET["id"];
        require("database/database.php");
        $pdoInstance = connect();
        $stmt = $pdoInstance->prepare('
            DELETE FROM customer
            WHERE id = :id
        ');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        Router::redirect("/");
    });

    Router::route_auth("POST", "/customer/update", $auth, function () {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        if ($id === "") {
            require("database/database.php");
            $pdoInstance = connect();
            $stmt = $pdoInstance->prepare('
            INSERT INTO customer (name, email, mobile, agentid)
            VALUES (:name, :email , :mobile, :agentid)');
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':mobile', $mobile);
            $stmt->bindValue(':agentid', $_SESSION["agentLogin"]["id"]);
            $stmt->execute();
        } else {
            require("database/database.php");
            $pdoInstance = connect();
            $stmt = $pdoInstance->prepare('
            UPDATE customer SET name = :name,
                email = :email,
                mobile = :mobile
            WHERE id = :id');
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':mobile', $mobile);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        }
        Router::redirect("/");
    });

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $error);