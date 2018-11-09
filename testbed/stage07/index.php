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
use domain\Agent;
use dao\CustomerDAO;
use dao\AgentDAO;

/** TODO: Generate domain objects */
/** TODO: Generate and implement DAOs */
/** TODO: Transfer "POST /register" and "GET /" routes to use domain objects and DAOs */

ini_set( 'session.cookie_httponly', 1 );
session_start();

$authFunction = function () {
    if (isset($_SESSION["agentLogin"])) {
        return true;
    }
    Router::redirect("/login");
    return false;
};

Router::route("GET", "/login", function () {
    require_once("view/agentLogin.php");
});

Router::route("GET", "/register", function () {
    require_once("view/agentEdit.php");
});

/** TODO: Transfer "POST /register" to use domain objects and DAOs */
Router::route("POST", "/register", function () {
    $agent = new Agent();
    $agent->setName($_POST["name"]);
    $agent->setEmail($_POST["email"]);
    $agent->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
    $agentDAO = new AgentDAO();
    $agentDAO->create($agent);
    Router::redirect("/logout");
});

Router::route("POST", "/login", function () {
    $email = $_POST["email"];
    $agentDAO = new AgentDAO();
    $agent = $agentDAO->findByEmail($email);
    if (isset($agent)) {
        if (password_verify($_POST["password"], $agent->getPassword())) {
            session_regenerate_id(true);
            $_SESSION["agentLogin"]["name"] = $agent->getName();
            $_SESSION["agentLogin"]["email"] = $email;
            $_SESSION["agentLogin"]["id"] = $agent->getId();
            if (password_needs_rehash($agent->getPassword(), PASSWORD_DEFAULT)) {
                $agent->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
                $agentDAO->update($agent);
            }
        }
    }
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    session_destroy();
    Router::redirect("/login");
});

/** TODO: Transfer "GET /" to use domain objects and DAOs */
Router::route_auth("GET", "/", $authFunction, function () {
    $customerDAO = new CustomerDAO();
    global $customers;
    $customers = $customerDAO->findByAgent($_SESSION["agentLogin"]["id"]);
    layoutSetContent("customers.php");
});

Router::route_auth("GET", "/agent/edit", $authFunction, function () {
    require_once("view/agentEdit.php");
});

Router::route_auth("GET", "/customer/create", $authFunction, function () {
    layoutSetContent("customerEdit.php");
});

Router::route_auth("GET", "/customer/edit", $authFunction, function () {
    $id = $_GET["id"];
    $customerDAO = new CustomerDAO();
    global $customer;
    $customer = $customerDAO->read($id);
    layoutSetContent("customerEdit.php");
});

Router::route_auth("GET", "/customer/delete", $authFunction, function () {
    $id = $_GET["id"];
    $customerDAO = new CustomerDAO();
    $customer = new Customer();
    $customer->setId($id);
    $customerDAO->delete($customer);
    Router::redirect("/");
});

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