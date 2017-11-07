<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 07.11.2017
 * Time: 14:04
 */

require_once("config/Autoloader.php");

use view\View;

$contentView = new View("view/dynamicContent.php");
$contentView->title = "My title";
$contentView->text = "My text";

$view = new View("view/layout.php");
$view->header = (new View("view/header.php"))->render();
$view->content = $contentView->render();
$view->footer = (new View("view/footer.php"))->render();
echo $view->render();