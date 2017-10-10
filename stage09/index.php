<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("config/Autoloader.php");

use router\Router;
use domain\Customer;
use service\WECRMServiceImpl;
use view\View;

session_start();

function layoutRendering(View $contentView){
    $view = new View("layout.php");
    $view->header = (new View("header.php"))->render();
    $view->content = $contentView->render();
    $view->footer = (new View("footer.php"))->render();
    echo $view->render();
}

$authFunction = function () {
    if (isset($_SESSION["agentLogin"])) {
        if(WECRMServiceImpl::getInstance()->validateToken($_SESSION["agentLogin"]["token"])) {
            return true;
        }
    }
    Router::redirect("/login");
    return false;
};

$errorFunction = function () {
    Router::errorHeader();
    echo (new View("404.php"))->render();
};

Router::route("GET", "/login", function () {
    echo (new View("agentLogin.php"))->render();
});

Router::route("GET", "/register", function () {
    echo (new View("agentRegister.php"))->render();
});

Router::route("POST", "/register", function () {
    WECRMServiceImpl::getInstance()->registerAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    Router::redirect("/logout");
});

Router::route("POST", "/login", function () {
    $weCRMService = WECRMServiceImpl::getInstance();
    if($weCRMService->verifyAgent($_POST["email"],$_POST["password"]))
    {
        $_SESSION["agentLogin"]["token"] = $weCRMService->issueToken();
    }
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    session_destroy();
    Router::redirect("/login");
});

Router::route_auth("GET", "/", $authFunction, function () {
    $contentView = new View("customers.php");
    $contentView->customers = WECRMServiceImpl::getInstance()->findAllCustomer();
    layoutRendering($contentView);
});

Router::route_auth("GET", "/agent/edit", $authFunction, function () {
    $view = new View("agentEdit.php");
    $view->agent = WECRMServiceImpl::getInstance()->readAgent();
    echo $view->render();
});

Router::route_auth("POST", "/agent/edit", $authFunction, function () {
    WECRMServiceImpl::getInstance()->editAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    Router::redirect("/logout");
});

Router::route_auth("GET", "/customer/create", $authFunction, function () {
    $contentView = new View("customerEdit.php");
    layoutRendering($contentView);
});

Router::route_auth("GET", "/customer/edit", $authFunction, function () {
    $id = $_GET["id"];
    $contentView = new View("customerEdit.php");
    $contentView->customer = WECRMServiceImpl::getInstance()->readCustomer($id);
    layoutRendering($contentView);
});

Router::route_auth("GET", "/customer/delete", $authFunction, function () {
    $id = $_GET["id"];
    WECRMServiceImpl::getInstance()->deleteCustomer($id);
    Router::redirect("/");
});

Router::route_auth("POST", "/customer/update", $authFunction, function () {
    $customer = new Customer();
    $customer->setId($_POST["id"]);
    $customer->setName($_POST["name"]);
    $customer->setEmail($_POST["email"]);
    $customer->setMobile($_POST["mobile"]);
    if ($customer->getId() === "") {
        WECRMServiceImpl::getInstance()->createCustomer($customer);
    } else {
        WECRMServiceImpl::getInstance()->updateCustomer($customer);
    }
    Router::redirect("/");
});

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);