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
use domain\Customer;
use service\AuthServiceImpl;
use service\CustomerServiceImpl;
use view\TemplateView;

session_start();

function layoutRendering(TemplateView $contentView){
    $view = new TemplateView("layout.php");
    $view->header = (new TemplateView("header.php"))->render();
    $view->content = $contentView->render();
    $view->footer = (new TemplateView("footer.php"))->render();
    echo $view->render();
}

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
    echo (new TemplateView("agentLogin.php"))->render();
});

Router::route("GET", "/register", function () {
    echo (new TemplateView("agentRegister.php"))->render();
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

Router::route_auth("GET", "/", $authFunction, function () {
    $contentView = new TemplateView("customers.php");
    $contentView->customers = (new CustomerServiceImpl())->findAllCustomer();
    layoutRendering($contentView);
});

Router::route_auth("GET", "/agent/edit", $authFunction, function () {
    $view = new TemplateView("agentEdit.php");
    $view->agent = AuthServiceImpl::getInstance()->readAgent();
    echo $view->render();
});

Router::route_auth("POST", "/agent/edit", $authFunction, function () {
    AuthServiceImpl::getInstance()->editAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    Router::redirect("/logout");
});

Router::route_auth("GET", "/customer/create", $authFunction, function () {
    $contentView = new TemplateView("customerEdit.php");
    layoutRendering($contentView);
});

Router::route_auth("GET", "/customer/edit", $authFunction, function () {
    $id = $_GET["id"];
    $contentView = new TemplateView("customerEdit.php");
    $contentView->customer = (new CustomerServiceImpl())->readCustomer($id);
    layoutRendering($contentView);
});

Router::route_auth("GET", "/customer/delete", $authFunction, function () {
    $id = $_GET["id"];
    (new CustomerServiceImpl())->deleteCustomer($id);
    Router::redirect("/");
});

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
    echo (new TemplateView("404.php"))->render();
}