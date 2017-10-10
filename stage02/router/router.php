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
    $path = trim($path, "/");
    $routes[$method][$path] = array("auth" => $auth, "function" => $function);
}

function call_route($method, $path) {
    global $routes;
    global $error;
    $path = trim(parse_url($path, PHP_URL_PATH), '/');
    /* TODO: check if method (GET, POST...) or path exists in array.
     * If one of both does not exist call the error Lambda:
     * call_user_func($error); return;
     */
    $route = $routes[$method][$path]; // get the route
    /* TODO: check if authentication is required. If yes, call the authentication function.
     * If authentication fails, return immediately.
     */
    /* TODO: call the callback function.
     * $route["function"]
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