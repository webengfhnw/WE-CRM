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

ini_set( 'session.cookie_httponly', 1 );
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
    $contentView = new View("customers.php");
    $contentView->customers = (new CustomerServiceImpl())->findAllCustomer();
    layoutRendering($contentView);
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
    $contentView = new View("customerEdit.php");
    layoutRendering($contentView);
});

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("GET", "/customer/edit", $authFunction, function () {
    $id = $_GET["id"];
    $contentView = new View("customerEdit.php");
    $contentView->customer = (new CustomerServiceImpl())->readCustomer($id);
    layoutRendering($contentView);
});

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("GET", "/customer/delete", $authFunction, function () {
    $id = $_GET["id"];
    (new CustomerServiceImpl())->deleteCustomer($id);
    Router::redirect("/");
});

/* TODO: Refactor the following code and use the customer controller */
Router::route_auth("POST", "/customer/update", $authFunction, function () {
    $customer = new Customer();
    $customer->setId($_POST["id"]);
    $customer->setName($_POST["name"]);
    $customer->setEmail($_POST["email"]);
    $customer->setMobile($_POST["mobile"]);
    if ($customer->getId() === "") {
        (new CustomerServiceImpl())->createCustomer($customer);
    } else {
        (new CustomerServiceImpl())->updateCustomer($customer);
    }
    Router::redirect("/");
});

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
    ErrorController::show404();
}