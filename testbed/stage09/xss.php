<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.11.2017
 * Time: 11:31
 */
require_once("config/Autoloader.php");

use view\View;

$contentView = new View("view/xssForm.php");
if(array_key_exists("comment", $_POST))
    $contentView->comment = View::noHTML($_POST["comment"]);
else
    $contentView->comment = "";

$view = new View("view/layout.php");
$view->header = (new View("view/header.php"))->render();
$view->content = $contentView->render();
$view->footer = (new View("view/footer.php"))->render();
echo $view->render();