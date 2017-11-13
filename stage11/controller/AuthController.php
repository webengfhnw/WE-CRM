<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 09.10.2017
 * Time: 08:30
 */

namespace controller;

use service\AuthServiceImpl;

class AuthController
{

    public static function authenticate(){
        if (isset($_SESSION["agentLogin"])) {
            if(AuthServiceImpl::getInstance()->validateToken($_SESSION["agentLogin"]["token"])) {
                return true;
            }
        }
        return false;
    }

    public static function login(){
        $weCRMService = AuthServiceImpl::getInstance();
        if($weCRMService->verifyAgent($_POST["email"],$_POST["password"]))
        {
            $_SESSION["agentLogin"]["token"] = $weCRMService->issueToken();
        }
    }

}