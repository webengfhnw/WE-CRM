<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("config/Autoloader.php");

use router\Router;
use service\ServiceEndpoint;
use http\HTTPException;

/* TODO: write API routes */

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
}