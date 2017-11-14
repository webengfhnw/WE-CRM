<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 09.10.2017
 * Time: 11:07
 */

namespace view;


class LayoutRendering
{

    public static function basicLayout(TemplateView $contentView){
        $view = new TemplateView("layout.php");
        $view->header = (new TemplateView("header.php"))->render();
        $view->content = $contentView->render();
        $view->footer = (new TemplateView("footer.php"))->render();
        echo $view->render();
    }

}