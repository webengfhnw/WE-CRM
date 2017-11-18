<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("config/Autoloader.php");
require_once("view/layout.php");

use router\Router;
use http\HTTPException;
use domain\Customer;
use service\AuthServiceImpl;
use service\CustomerServiceImpl;

session_start();

$authFunction = function () {
    if (isset($_SESSION["agentLogin"])) {
        if(AuthServiceImpl::getInstance()->validateToken($_SESSION["agentLogin"]["token"])) {
            return true;
        }
    }
    Router::redirect("/login");
    return false;
};

Router::route("GET", "/login", function () {
    require_once("view/agentLogin.php");
});

Router::route("GET", "/register", function () {
    require_once("view/agentRegister.php");
});

Router::route("POST", "/register", function () {
    AuthServiceImpl::getInstance()->editAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    Router::redirect("/logout");
});

Router::route("POST", "/login", function () {
    $authService = AuthServiceImpl::getInstance();
    if($authService->verifyAgent($_POST["email"],$_POST["password"]))
    {
        $_SESSION["agentLogin"]["token"] = $authService->issueToken();
    }
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    session_destroy();
    Router::redirect("/login");
});

/* TODO: Generate and implement the customer service */
/* TODO: Refactor the following code and use the customer service */
Router::route_auth("GET", "/", $authFunction, function () {
    $customerDAO = new CustomerDAO();
    global $customers;
    $customers = $customerDAO->findByAgent($_SESSION["agentLogin"]["id"]);
    layoutSetContent("customers.php");
});

Router::route_auth("GET", "/agent/edit", $authFunction, function () {
    global $agent;
    $agent = AuthServiceImpl::getInstance()->readAgent();
    require_once("view/agentEdit.php");
});

Router::route_auth("POST", "/agent/edit", $authFunction, function () {
    AuthServiceImpl::getInstance()->editAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    Router::redirect("/logout");
});

Router::route_auth("GET", "/customer/create", $authFunction, function () {
    layoutSetContent("customerEdit.php");
});

/* TODO: Refactor the following code and use the customer service */
Router::route_auth("GET", "/customer/edit", $authFunction, function () {
    $id = $_GET["id"];
    $customerDAO = new CustomerDAO();
    global $customer;
    $customer = $customerDAO->read($id);
    layoutSetContent("customerEdit.php");
});

/* TODO: Refactor the following code and use the customer service */
Router::route_auth("GET", "/customer/delete", $authFunction, function () {
    $id = $_GET["id"];
    $customerDAO = new CustomerDAO();
    $customer = new Customer();
    $customer->setId($id);
    $customerDAO->delete($customer);
    Router::redirect("/");
});

/* TODO: Refactor the following code and use the customer service */
Router::route_auth("POST", "/customer/update", $authFunction, function () {
    $customer = new Customer();
    $customer->setId($_POST["id"]);
    $customer->setName($_POST["name"]);
    $customer->setEmail($_POST["email"]);
    $customer->setMobile($_POST["mobile"]);
    $customerDAO = new CustomerDAO();
    if ($customer->getId() === "") {
        $customer->setAgentId($_SESSION["agentLogin"]["id"]);
        $customerDAO->create($customer);
    } else {
        $customerDAO->update($customer);
    }
    Router::redirect("/");
});

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
    require_once("view/404.php");
}