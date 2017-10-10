<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("router/router.php");
require_once("view/layout.php");

/* TODO: start the session.
 */

$auth = function() {
    /* TODO: check is a session has been set.
    *  real authentication will be implemented later.
    */
    redirect("/login");
    return false;
};

$error = function() {
    errorHeader();
    /* TODO: add 404 page.
    */
};

route("GET", "/login", function() {
    /* TODO: add agentLogin page.
    */
});

route("GET", "/register", function() {
    /* TODO: add agentEdit page.
    */
});

route("POST", "/register", function() {
    redirect("/logout");
});

route("POST", "/login", function() {
    /* TODO: add the email address to the session.
    */
    redirect("/");
});

route("GET", "/logout", function() {
    /* TODO: remove the session.
    */
    redirect("/login");
});

route_auth("GET", "/", $auth, function() {
    layoutSetContent("customers.php");
});

route_auth("GET", "/agent/edit", $auth, function() {
    require_once("view/agentEdit.php");
});

route_auth("GET", "/customer/create", $auth, function() {
    layoutSetContent("customerEdit.php");
});

route_auth("GET", "/customer/edit", $auth, function() {
    layoutSetContent("customerEdit.php");
});

route_auth("GET", "/customer/delete", $auth, function() {
    $data = $_GET["id"];
    redirect("/");
});

route_auth("POST", "/customer/update", $auth, function() {
    $data = $_POST["name"];
    redirect("/");
});

/* TODO: call the router.
 * 1. Find out how the retrieve the request method and the path info from the PHP server variable.
 * 2. call: call_route("... request method and path info ...");
 */

layoutSetContent("customers.php");