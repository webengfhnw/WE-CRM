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
use http\HTTPException;

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
    if(AgentController::register())
        Router::redirect("/logout");
});

Router::route("POST", "/login", function () {
    AuthController::login();
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    AuthController::logout();
    Router::redirect("/login");
});

Router::route_auth("GET", "/", $authFunction, function () {
    CustomerController::readAll();
});

Router::route_auth("GET", "/agent/edit", $authFunction, function () {
    AgentController::editView();
});

Router::route_auth("POST", "/agent/edit", $authFunction, function () {
    if(AgentController::update())
        Router::redirect("/logout");
});

Router::route_auth("GET", "/customer/create", $authFunction, function () {
    CustomerController::create();
});

Router::route_auth("GET", "/customer/edit", $authFunction, function () {
    CustomerController::edit();
});

Router::route_auth("GET", "/customer/delete", $authFunction, function () {
    CustomerController::delete();
    Router::redirect("/");
});

Router::route_auth("POST", "/customer/update", $authFunction, function () {
    if(CustomerController::update())
        Router::redirect("/");
});

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
    ErrorController::show404();
}