<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("config/Autoloader.php");

use router\Router;
use controller\CustomerController;
use controller\AgentController;
use controller\AuthController;
use controller\ErrorController;

session_start();

$auth = function () {
    if (AuthController::authenticate())
        return true;
    Router::redirect("/login");
    return false;
};

$error = function () {
    Router::errorHeader();
    ErrorController::show404();
};

Router::route("GET", "/login", function () {
    AgentController::loginView();
});

Router::route("GET", "/register", function () {
    AgentController::registerView();
});

Router::route("POST", "/register", function () {
    AgentController::register();
    Router::redirect("/logout");
});

Router::route("POST", "/login", function () {
    AuthController::login();
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    session_destroy();
    Router::redirect("/login");
});

Router::route_auth("GET", "/", $auth, function () {
    CustomerController::readAll();
});

Router::route_auth("GET", "/agent/edit", $auth, function () {
    AgentController::edit();
});

Router::route_auth("POST", "/agent/edit", $auth, function () {
    AgentController::update();
    Router::redirect("/logout");
});

Router::route_auth("GET", "/customer/create", $auth, function () {
    CustomerController::create();
});

Router::route_auth("GET", "/customer/edit", $auth, function () {
    CustomerController::edit();
});

Router::route_auth("GET", "/customer/delete", $auth, function () {
    CustomerController::delete();
    Router::redirect("/");
});

Router::route_auth("POST", "/customer/update", $auth, function () {
    CustomerController::update();
    Router::redirect("/");
});

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $error);