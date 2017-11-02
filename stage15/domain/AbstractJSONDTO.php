<?php

namespace domain;

/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.11.2016
 * Time: 15:16
 */
abstract class AbstractJSONDTO implements \JsonSerializable
{
    /**
     * @param $decodedJSON
     * @return $this[]
     */
    public static function DeserializeArray($decodedJSON)
    {
        $items = [];
        foreach ($decodedJSON as $item)
            $items[] = self::Deserialize($item);
        return $items;
    }

    /**
     * @param $decodedJSON
     * @return $this
     */
    public static function Deserialize($decodedJSON)
    {
        $className = get_called_class();
        $classInstance = new $className();

        foreach ($decodedJSON as $key => $value) {
            if (property_exists($classInstance, $key)) {
                $classInstance->{$key} = $value;
            }
        }

        return $classInstance;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}