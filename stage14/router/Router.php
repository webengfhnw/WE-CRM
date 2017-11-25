<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.09.2017
 * Time: 10:42
 */

namespace router;

use http\Exception;
use http\HTTPException;
use http\HTTPStatusCode;
use http\HTTPHeader;

class Router
{
    protected static $routes = [];

    public static function init(){
        $protocol = isset($_SERVER['HTTPS'])||(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") ? 'https' : 'http';
        $_SERVER['SERVER_PORT'] === "80" ? $serverPort = "" : $serverPort = ":" . $_SERVER['SERVER_PORT'];
        $GLOBALS["ROOT_URL"] = $protocol . "://" . $_SERVER['SERVER_NAME'] . $serverPort . strstr($_SERVER['PHP_SELF'], $_SERVER['ORIGINAL_PATH'], true);
        if(!empty($_SERVER['REDIRECT_ORIGINAL_PATH'])) {
            $_SERVER['PATH_INFO'] = $_SERVER['REDIRECT_ORIGINAL_PATH'];
        }
        else {
            $_SERVER['PATH_INFO'] = "/";
        }
    }

    public static function route($method, $path, $routeFunction) {
        self::route_auth($method, $path, null, $routeFunction);
    }

    public static function route_auth($method, $path, $authFunction, $routeFunction) {
        if(empty(self::$routes))
            self::init();
        $path = trim($path, '/');
        self::$routes[$method][$path] = array("authFunction" => $authFunction, "routeFunction" => $routeFunction);
    }

    public static function call_route($method, $path) {
        $path = trim(parse_url($path, PHP_URL_PATH), '/');
        if(!array_key_exists($method, self::$routes) || !array_key_exists($path, self::$routes[$method])) {
            throw new HTTPException(HTTPStatusCode::HTTP_404_NOT_FOUND);
        }
        $route = self::$routes[$method][$path];
        if(isset($route["authFunction"])) {
            if (!$route["authFunction"]()) {
                return;
            }
        }
        $route["routeFunction"]();
    }

    public static function errorHeader() {
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_404_NOT_FOUND);
    }

    public static function redirect($redirect_path) {
        HTTPHeader::redirect($redirect_path);
    }

}