<?php

declare(strict_types=1);

namespace Core\TestCase;

use Closure;
use Core\Client;
use Core\Types\Sdk\CoreFileWrapper;
use Core\Utils\CoreHelper;
use Exception;

class TestParam
{
    /**
     * Returns a typeGroup type TestParam.
     *
     * @param string $json          Json value to be mapped by the typeGroup
     * @param string $typeGroup     Group of types in string format i.e. oneof(...), anyof(...)
     * @param array  $deserializers Methods required for the de-serialization of specific types in
     *                              in the provided typeGroup, should be an array in the format:
     *                              ['path/to/method returnType', ...]. Default: []
     * @return mixed Returns the mapped value from json
     * @throws Exception
     */
    public static function typeGroup(string $json, string $typeGroup, array $deserializers = [])
    {
        return Client::getJsonHelper()->mapTypes(CoreHelper::deserialize($json, false), $typeGroup, $deserializers);
    }

    /**
     * Returns an object type TestParam.
     *
     * @param string       $json     Json value to be mapped by the class
     * @param string|null $classname Name of the class inclusive of its namespace,
     *                               Default: object
     * @param int         $dimension Greater than 0 if trying to map an array of
     *                               class with some dimensions, Default: 0
     * @return mixed Returns the mapped value from json
     * @throws Exception
     */
    public static function object(string $json, ?string $classname = null, int $dimension = 0)
    {
        if (is_null($classname)) {
            return CoreHelper::deserialize($json);
        }
        return Client::getJsonHelper()->mapClass(CoreHelper::deserialize($json, false), $classname, $dimension);
    }

    /**
     * Returns a custom TestParam.
     *
     * @param string   $json     Json value to be deserialized using custom callback
     * @param callable $callback Callback use to deserialize the given value
     * @return mixed Returns the result from the callback
     */
    public static function custom(string $json, callable $callback)
    {
        return Closure::fromCallable($callback)(CoreHelper::deserialize($json, false));
    }

    /**
     * Returns a file type TestParam.
     *
     * @param string $url URL of the file to download
     */
    public static function file(string $url)
    {
        $realPath = CoreFileWrapper::getDownloadedRealFilePath($url);
        return self::localFile($realPath);
    }

    /**
     * Returns a localFile TestParam.
     *
     * @param string $realPath Local path to the file
     */
    public static function localFile(string $realPath)
    {
        return Client::getConverter()->createFileWrapper($realPath, null, '');
    }
}
