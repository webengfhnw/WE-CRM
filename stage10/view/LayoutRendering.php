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

    public static function basicLayout(View $contentView){
        $view = new View("layout.php");
        $view->header = (new View("header.php"))->render();
        $view->content = $contentView->render();
        $view->footer = (new View("footer.php"))->render();
        echo $view->render();
    }

}