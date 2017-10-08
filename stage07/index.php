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
use domain\Customer;
use domain\Agent;
use dao\CustomerDAO;
use dao\AgentDAO;

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

Router::route_auth("GET", "/", $auth, function () {
    $customerDAO = new CustomerDAO();
    global $customers;
    $customers = $customerDAO->findByAgent($_SESSION["agentLogin"]["id"]);
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
    $customerDAO = new CustomerDAO();
    global $customer;
    $customer = $customerDAO->read($id);
    layoutSetContent("customerEdit.php");
});

Router::route_auth("GET", "/customer/delete", $auth, function () {
    $id = $_GET["id"];
    $customerDAO = new CustomerDAO();
    $customer = new Customer();
    $customer->setId($id);
    $customerDAO->delete($customer);
    Router::redirect("/");
});

Router::route_auth("POST", "/customer/update", $auth, function () {
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

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $error);