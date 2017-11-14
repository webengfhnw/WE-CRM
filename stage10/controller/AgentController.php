<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 22:20
 */

namespace controller;

use service\AuthServiceImpl;
use view\TemplateView;

class AgentController
{
    public static function edit(){
        $view = new TemplateView("agentEdit.php");
        $view->agent = AuthServiceImpl::getInstance()->readAgent();
        echo $view->render();
    }

    public static function update(){
        AuthServiceImpl::getInstance()->editAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    }

    public static function register(){
        AuthServiceImpl::getInstance()->editAgent($_POST["name"],$_POST["email"], $_POST["password"]);
    }

    public static function registerView(){
        echo (new TemplateView("agentRegister.php"))->render();
    }

    public static function loginView(){
        echo (new TemplateView("agentLogin.php"))->render();
    }
}