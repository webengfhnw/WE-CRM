<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 09.10.2017
 * Time: 08:39
 */

namespace controller;

use view\TemplateView;

class ErrorController
{
    public static function show404(){
        echo (new TemplateView("404.php"))->render();
    }
}