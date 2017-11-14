<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("router/router.php");
require_once("view/layout.php");
require_once("config/config.php");

session_start();

$authFunction = function () {
    if (isset($_SESSION["agentLogin"])) {
        return true;
    }
    redirect("/login");
    return false;
};

$errorFunction = function () {
    errorHeader();
    require_once("view/404.php");
};

route("GET", "/login", function () {
    require_once("view/agentLogin.php");
});

route("GET", "/register", function () {
    require_once("view/agentEdit.php");
});

route("POST", "/register", function () {
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
    redirect("/logout");
});

route("POST", "/login", function () {
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
    redirect("/");
});

route("GET", "/logout", function () {
    session_destroy();
    redirect("/login");
});

route_auth("GET", "/", $authFunction, function () {


    /** TODO: create a prepared SQL statement to retrieve all customers */

        $agentID = $_SESSION["agentLogin"]["agentId"];

        require("database/database.php");
        $pdoInstance = connect();
        $stmt = $pdoInstance->prepare('
            SELECT * FROM customer WHERE agentid = :id;');
        $stmt->bindValue(':id', $agentID);
        $stmt->execute();
       global $customers;
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    /** TODO: extend the customers.php file to show the data */
    layoutSetContent("customers.php");
});

route_auth("GET", "/agent/edit", $authFunction, function () {
    require_once("view/agentEdit.php");
});

route_auth("GET", "/customer/create", $authFunction, function () {
    layoutSetContent("customerEdit.php");
});

route_auth("GET", "/customer/edit", $authFunction, function () {
    $id = $_GET["id"];
    require("database/database.php");
    /** TODO: create a prepared SQL statement to read customer data */
    /** TODO: extend the customerEdit.php file to show the data */
    layoutSetContent("customerEdit.php");
});

route_auth("GET", "/customer/delete", $authFunction, function () {
    $id = $_GET["id"];
    require("database/database.php");
    /** TODO: create a prepared SQL statement to delete customer data */
    redirect("/");
});

route_auth("POST", "/customer/update", $authFunction, function () {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    if ($id === "") {
        require("database/database.php");
        $pdoInstance = connect();
        /** TODO: create a prepared SQL statement to insert customer data */
        $stmt->execute();
    } else {
        require("database/database.php");
        $pdoInstance = connect();
        /** TODO: create a prepared SQL statement to update customer data */
        $stmt->execute();
    }
    redirect("/");
});

call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);