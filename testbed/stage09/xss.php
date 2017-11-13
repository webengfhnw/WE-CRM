<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.11.2017
 * Time: 11:31
 *
 * TODO: enter "<script>alert("hacked")</script>" to test XSS
 */
require_once("config/Autoloader.php");

use view\View;

$contentView = new View("view/xssForm.php");
/* TODO: use the View class to prevent XSS */
if(array_key_exists("comment", $_POST))
    $contentView->comment = $_POST["comment"];
else
    $contentView->comment = "";

$view = new View("view/layout.php");
$view->header = (new View("view/header.php"))->render();
$view->content = $contentView->render();
$view->footer = (new View("view/footer.php"))->render();
echo $view->render();