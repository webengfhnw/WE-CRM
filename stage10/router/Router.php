<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.09.2017
 * Time: 10:42
 */

namespace router;

class Router
{
    protected static $routes = [];

    public static function init($indexFileName){
        $GLOBALS["ROOT_URL"] = str_replace($indexFileName,"",$_SERVER['PHP_SELF']);
        if(!empty($_SERVER['REDIRECT_ORIGINAL_PATH'])) {
            $_SERVER['PATH_INFO'] = $_SERVER['REDIRECT_ORIGINAL_PATH'];
        }
        else {
            $_SERVER['PATH_INFO'] = "/";
        }
    }

    public static function route($method, $path, $function) {
        self::route_auth($method, $path, null, $function);
    }

    public static function route_auth($method, $path, $auth, $function) {
        if(empty(self::$routes))
            self::init("/index.php");
        $path = trim($path, '/');
        self::$routes[$method][$path] = array("auth" => $auth, "function" => $function);
    }

    public static function call_route($method, $path, $error) {
        $path = trim(parse_url($path, PHP_URL_PATH), '/');
        if(!array_key_exists($method, self::$routes) || !array_key_exists($path, self::$routes[$method])) {
            call_user_func($error); return;
        }
        $route = self::$routes[$method][$path];
        if(isset($route["auth"])) {
            if (!call_user_func($route["auth"])) {
                return;
            }
        }
        call_user_func($route["function"]);
    }

    public static function errorHeader() {
        header("HTTP/1.0 404 Not Found");
    }

    public static function redirect($redirect_path) {
        header("Location: " . $GLOBALS["ROOT_URL"] . $redirect_path);
    }

}