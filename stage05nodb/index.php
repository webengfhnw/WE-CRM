<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */

/* TODO: include Autoloader.
*/
require_once("view/layout.php");

require_once ("router/router.php");
/* TODO: import Router class by use statement.
*/

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
        redirect("/logout");
    });

    route("POST", "/login", function () {
        session_regenerate_id(true);
        $_SESSION['agentLogin']=$_POST['email'];
        redirect("/");
    });

    route("GET", "/logout", function () {
        session_destroy();
        redirect("/login");
    });

    route_auth("GET", "/", $authFunction, function () {
        layoutSetContent("customers.php");
    });

    route_auth("GET", "/agent/edit", $authFunction, function () {
        require_once("view/agentEdit.php");
    });

    route_auth("GET", "/customer/create", $authFunction, function () {
        layoutSetContent("customerEdit.php");
    });

    route_auth("GET", "/customer/edit", $authFunction, function () {
        layoutSetContent("customerEdit.php");
    });

    route_auth("GET", "/customer/delete", $authFunction, function () {
        $id = $_GET["id"];
        redirect("/");
    });

    route_auth("POST", "/customer/update", $authFunction, function () {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        redirect("/");
    });

call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);