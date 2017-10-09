<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 22:20
 */

namespace controller;

use service\WECRMServiceImpl;
use view\View;

class AgentController
{
    public static function edit(){
        $view = new View("agentEdit.php");
        $view->agent = WECRMServiceImpl::getInstance()->readAgent();
        echo $view->render();
    }

    public static function update(){
        WECRMServiceImpl::getInstance()->editAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    }

    public static function register(){
        WECRMServiceImpl::getInstance()->registerAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    }

    public static function registerView(){
        echo (new View("agentRegister.php"))->render();
    }

    public static function loginView(){
        echo (new View("agentLogin.php"))->render();
    }
}