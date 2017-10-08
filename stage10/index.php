<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("config/Autoloader.php");

use router\Router;
use service\WECRMServiceImpl;
use view\View;
use controller\CustomerController;
use controller\AgentController;

session_start();

function layoutRendering(View $contentView){
    $view = new View("layout.php");
    $view->header = (new View("header.php"))->render();
    $view->content = $contentView->render();
    $view->footer = (new View("footer.php"))->render();
    echo $view->render();
}

$auth = function () {
    if (isset($_SESSION["agentLogin"])) {
        if(WECRMServiceImpl::getInstance()->validateToken($_SESSION["agentLogin"]["token"])) {
            return true;
        }
    }
    Router::redirect("/login");
    return false;
};

$error = function () {
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
    AgentController::register();
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