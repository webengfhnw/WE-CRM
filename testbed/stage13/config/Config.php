<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.09.2017
 * Time: 14:56
 */

namespace config;

class Config
{
    protected static $iniFile = "config/config.env";
    protected static $config = [];

    public static function init()
    {
        if (file_exists(self::$iniFile)) {
            $data = parse_ini_file(self::$iniFile, true);
            self::$config["email"]["sendgrid-apikey"] = $data["email"]["sendgrid-apikey"];
        }
    }

    public static function emailConfig($key)
    {
        if (empty(self::$config))
            self::init();
        return self::$config["email"][$key];
    }
}