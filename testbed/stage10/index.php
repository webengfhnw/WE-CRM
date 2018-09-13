<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("config/Autoloader.php");

use router\Router;
use http\HTTPException;
use controller\CustomerController;
use controller\AgentController;
use controller\AuthController;
use controller\ErrorController;

session_start();

$authFunction = function () {
    if (AuthController::authenticate())
        return true;
    Router::redirect("/login");
    return false;
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

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("GET", "/", $authFunction, function () {
    CustomerController::readAll();
});

Router::route_auth("GET", "/agent/edit", $authFunction, function () {
    AgentController::edit();
});

Router::route_auth("POST", "/agent/edit", $authFunction, function () {
    AgentController::update();
    Router::redirect("/logout");
});

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("GET", "/customer/create", $authFunction, function () {
    CustomerController::create();
});

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("GET", "/customer/edit", $authFunction, function () {
    CustomerController::edit();
});

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("GET", "/customer/delete", $authFunction, function () {
    CustomerController::delete();
    Router::redirect("/");
});

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("POST", "/customer/update", $authFunction, function () {
    CustomerController::update();
    Router::redirect("/");
});

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
    ErrorController::show404();
}