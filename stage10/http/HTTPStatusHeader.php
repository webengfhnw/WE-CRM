<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 05.11.2017
 * Time: 14:44
 */

namespace http;


trait HTTPStatusHeader
{

    public static function setStatusHeader($statusCode = HTTPStatusCode::HTTP_200_OK, $replaceHeader = true, $statusPhrase = null){
        header(self::createHeader($statusCode, $statusPhrase), $replaceHeader, self::getStatusCodeNumber($statusCode));
    }

    public static function setHeader($header, $statusCode = HTTPStatusCode::HTTP_200_OK, $replaceHeader = true){
        header($header, $replaceHeader, self::getStatusCodeNumber($statusCode));
    }

    protected static function createHeader($statusCode = HTTPStatusCode::HTTP_200_OK, $statusPhrase = null)
    {
        if (null === $statusPhrase && isset($statusCode)) {
            $statusPhrase = $statusCode;
        }
        return sprintf('HTTP/1.1 %d %s', self::getStatusCodeNumber($statusCode), $statusPhrase);
    }

    protected static function getStatusCodeNumber($statusCode)
    {
        $class = new \ReflectionClass(__CLASS__);
        $constants = array_flip($class->getConstants());
        preg_match("/\d{3}/", $constants[$statusCode], $statusCodeNumber);
        return $statusCodeNumber[0];
    }

}