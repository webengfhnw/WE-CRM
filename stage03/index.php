<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("router/router.php");
require_once("view/layout.php");
require_once("config/config.php");

session_start();

$auth = function() {
    if(isset($_SESSION["agentLogin"])){
        return true;
    }
    redirect("/login");
    return false;
};

$error = function() {
    errorHeader();
    require_once("view/404.php");
};

route("GET", "/login", function() {
    require_once("view/agentLogin.php");
});

route("GET", "/register", function() {
    require_once("view/agentEdit.php");
});

route("POST", "/register", function() {
    redirect("/logout");
});

route("POST", "/login", function() {
    $_SESSION["agentLogin"]["email"]=$_POST["email"];
    $_SESSION["agentLogin"]["id"]=1;
    redirect("/");
});

route("GET", "/logout", function() {
    session_destroy();
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
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    if($id==="")
    {
        require("database/database.php");
        $pdoInstance = connect();
        $stmt = $pdoInstance->prepare('
            INSERT INTO customer (name, email, mobile, agentid)
            VALUES (:name, :email , :mobile, :agentid)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':mobile', $mobile);
        $stmt->bindValue(':agentid', 1);
        $stmt->execute();
    }
    redirect("/");
});

call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);