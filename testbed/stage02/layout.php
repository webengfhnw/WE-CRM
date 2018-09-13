<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 18:29
 */

function layoutSetContent($content){
    require_once("header.php");
    require_once($content);
    require_once("footer.php");
}
