<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 07.11.2017
 * Time: 14:04
 */

require_once("config/Autoloader.php");

use view\TemplateView;

$contentView = new TemplateView("view/dynamicContent.php");
$contentView->title = "My title";
$contentView->text = "My text";

$view = new TemplateView("view/layout.php");
$view->header = (new TemplateView("view/header.php"))->render();
$view->content = $contentView->render();
$view->footer = (new TemplateView("view/footer.php"))->render();
echo $view->render();