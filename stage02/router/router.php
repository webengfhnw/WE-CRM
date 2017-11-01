<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 15:51
 */
$routes = [];
$protocol = !isset($_SERVER['HTTPS'])||(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] !== "https") ? 'http' : 'https';
$GLOBALS["ROOT_URL"] = $protocol . "://" . $_SERVER['SERVER_NAME'] . strstr($_SERVER['PHP_SELF'], $_SERVER['ORIGINAL_PATH'], true);
if(!empty($_SERVER['REDIRECT_ORIGINAL_PATH'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REDIRECT_ORIGINAL_PATH'];
}
else {
    $_SERVER['PATH_INFO'] = "/";
}

function route($method, $path, $routeFunction) {
    route_auth($method, $path, null, $routeFunction);
}

function route_auth($method, $path, $auth, $routeFunction) {
    global $routes;

    /* TODO: add paths to $routes[] array.
     * 1. Maybe you will have to trim the $path first.
     * 2. Create a multi dimensional array (suggestion: $routes[$method][$path]) and store the authFunction and routeFunction Lambdas as one array.
     */
}

function call_route($method, $path) {
    global $routes;
    global $errorFunction;
    $path = trim(parse_url($path, PHP_URL_PATH), '/');
    /* TODO: check if method (GET, POST...) or path exists in array.
     * If one of both does not exist call the error Lambda:
     * $errorFunction(); return;
     */
    $route = $routes[$method][$path]; // get the route
    /* TODO: check if authentication is required. If yes, call the authentication function.
     * If authentication fails, return immediately.
     */
    /* TODO: call the callback function.
     * $route["routeFunction"]();
     */
}

function redirect($redirect_path) {
    /* TODO: create a redirection function, which redirects to a path.
     * You may need the root URL: $GLOBALS["ROOT_URL"]
     */
}

function errorHeader() {
    header("HTTP/1.0 404 Not Found");
}