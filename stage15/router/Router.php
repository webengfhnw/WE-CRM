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
        strpos($_SERVER['SERVER_PORT'],"80") !== false ? $serverPort = "" : $serverPort = ":" . $_SERVER['SERVER_PORT'];
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
        preg_match_all("/{(.*?)}/", $path, $matches);
        foreach($matches[1] as $match_key => $match_value){
            $match_pos = strpos($path, $match_value);
            if($match_pos)
            {
                $path = substr_replace($path,"{parameter" . $match_key . "}",$match_pos-1, strlen($match_value)+2);
            }
        }
        self::$routes[$method][$path] = array("authFunction" => $authFunction, "routeFunction" => $routeFunction);
    }

    public static function call_route($method, $path) {
        $path = trim(parse_url($path, PHP_URL_PATH), '/');
        $path_pieces = explode('/', $path);
        $parameters = [];
        $parameter_number = 0;
        foreach($path_pieces as $path_value) {
            if(is_numeric($path_value)) {
                $parameters[$parameter_number] = $path_value;
                $path = str_replace("/".$path_value,"/"."{parameter" . $parameter_number++ . "}",$path);
            }
        }
        if(!array_key_exists($method, self::$routes) || !array_key_exists($path, self::$routes[$method])) {
            throw new HTTPException(HTTPStatusCode::HTTP_404_NOT_FOUND);
        }
        $route = self::$routes[$method][$path];
        if(isset($route["authFunction"])) {
            if (!$route["authFunction"]()) {
                return;
            }
        }
        $route["routeFunction"](...$parameters);
    }

    public static function errorHeader() {
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_404_NOT_FOUND);
    }

    public static function redirect($redirect_path) {
        HTTPHeader::redirect($redirect_path);
    }

}