<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 15:51
 */
$routes = [];
$GLOBALS["ROOT_URL"] = str_replace("/index.php","",$_SERVER['PHP_SELF']);
if(!empty($_SERVER['REDIRECT_ORIGINAL_PATH'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REDIRECT_ORIGINAL_PATH'];
}
else {
    $_SERVER['PATH_INFO'] = "/";
}

function route($method, $path, $function) {
    route_auth($method, $path, null, $function);
}

function route_auth($method, $path, $auth, $function) {
    global $routes;
    $path = trim($path, '/');
    $routes[$method][$path] = array("auth" => $auth, "function" => $function);
}

function call_route($method, $path) {
    global $routes;
    global $error;
    $path = trim(parse_url($path, PHP_URL_PATH), '/');
    if(!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
        call_user_func($error); return;
    }
    $route = $routes[$method][$path];
    if(isset($route["auth"])) {
        if (!call_user_func($route["auth"])) {
            return;
        }
    }
    call_user_func($route["function"]);
}

function redirect($redirect_path) {
    header("Location: " . $GLOBALS["ROOT_URL"] . $redirect_path);
}

function errorHeader() {
    header("HTTP/1.0 404 Not Found");
}