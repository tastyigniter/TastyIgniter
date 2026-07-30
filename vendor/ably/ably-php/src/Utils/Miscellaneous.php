<?php
namespace Ably\Utils;

class Miscellaneous
{
    public static function getNumeric($text)
    {
        preg_match("#^\d+(\.\d+)*#", $text, $match);
        if (isset($match[0])) {
            return $match[0];
        }
        return "";
    }

    /**
     * Returns local time
     * @return integer system time in milliseconds
     */
    public static function systemTime()
    {
        return intval(round(microtime(true) * 1000));
    }

    private static function deepConvertObjectToArrayRecursive(&$item , $_key)
    {
        if(!is_array($item) && !is_object($item))
            return;

        $item = array_filter(
            (array) $item,
            static function (string $key): bool {
                return strpos($key, "\0") !== 0;
            }, ARRAY_FILTER_USE_KEY);

        foreach($item as &$value){
            if(is_object($value)) {
                array_walk($value, [__CLASS__, __FUNCTION__]);
            }
        }
    }

    public static function deepConvertObjectToArray(&$object)
    {
        array_walk($object, [__CLASS__, 'deepConvertObjectToArrayRecursive']);
        $object = (array)$object;
    }

    private static function deepConvertArrayToObjectRecursive(&$item , $_key)
    {
        if(!is_array($item))
            return;

        foreach($item as &$value){
            if(is_array($value)) {
                array_walk($value, [__CLASS__, __FUNCTION__]);
                if(Miscellaneous::hasStringKeys($value))
                    $value = (object)$value;
            }
        }

        $item = (object)$item;
    }

    public static function deepConvertArrayToObject(&$array)
    {
        array_walk($array, [__CLASS__, 'deepConvertArrayToObjectRecursive']);
        if(Miscellaneous::hasStringKeys($array))
            $array = (object)$array;
    }

    public static function hasStringKeys(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}
