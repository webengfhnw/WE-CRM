<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 15:51
 */
$routes = [];
$protocol = isset($_SERVER['HTTPS'])||(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") ? 'https' : 'http';
strpos($_SERVER['SERVER_PORT'],"80") !== false ? $serverPort = "" : $serverPort = ":" . $_SERVER['SERVER_PORT'];
$GLOBALS["ROOT_URL"] = $protocol . "://" . $_SERVER['SERVER_NAME'] . $serverPort . strstr($_SERVER['PHP_SELF'], $_SERVER['ORIGINAL_PATH'], true);
if(!empty($_SERVER['REDIRECT_ORIGINAL_PATH'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REDIRECT_ORIGINAL_PATH'];
}
else {
    $_SERVER['PATH_INFO'] = "/";
}

function route($method, $path, $routeFunction) {
    route_auth($method, $path, null, $routeFunction);
}

function route_auth($method, $path, $authFunction, $routeFunction) {
    global $routes;
    $path = trim($path, '/');
    $routes[$method][$path] = array("authFunction" => $authFunction, "routeFunction" => $routeFunction);
}

function call_route($method, $path) {
    global $routes;
    global $errorFunction;
    $path = trim(parse_url($path, PHP_URL_PATH), '/');
    if(!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
        $errorFunction(); return;
    }
    $route = $routes[$method][$path];
    if(isset($route["authFunction"])) {
        if (!$route["authFunction"]()) {
            return;
        }
    }
    $route["routeFunction"]();
}

function redirect($redirect_path) {
    header("Location: " . $GLOBALS["ROOT_URL"] . $redirect_path);
}

function errorHeader() {
    header("HTTP/1.0 404 Not Found");
}