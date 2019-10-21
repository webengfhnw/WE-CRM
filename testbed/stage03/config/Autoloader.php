<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.09.2017
 * Time: 17:13
 */

namespace config;

/* TODO: Try to understand how the autoloader class works - you may use the debugger.
 */

class Autoloader
{
    public static function autoload($className) {
        //replace namespace backslash to directory separator of the current operating system
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $fileName = $className . '.php';

        if (file_exists($fileName)) {
            include_once($fileName);
        }
    }
}

/* TODO: Google spl_autoload_register, what does this function do?
 */

spl_autoload_register('config\Autoloader::autoload');