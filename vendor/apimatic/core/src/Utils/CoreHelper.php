<?php

declare(strict_types=1);

namespace Core\Utils;

use Core\Types\Sdk\CoreFileWrapper;
use InvalidArgumentException;

class CoreHelper
{
    /**
     * Serialize any given mixed value.
     *
     * @param mixed $value Any value to be serialized
     *
     * @return string|null serialized value
     */
    public static function serialize($value): ?string
    {
        if ($value instanceof CoreFileWrapper) {
            return $value->getFileContent();
        }
        if (is_string($value)) {
            return $value;
        }
        if (is_null($value)) {
            return null;
        }
        return json_encode($value);
    }

    /**
     * Deserialize a Json string
     *
     * @param string|null $json A valid Json string
     *
     * @return mixed Decoded Json
     */
    public static function deserialize(?string $json, bool $associative = true)
    {
        return json_decode($json, $associative) ?? $json;
    }

    /**
     * Validates and processes the given Url to ensure safe usage with cURL.
     * @param string $url The given Url to process
     * @return string Pre-processed Url as string
     * @throws InvalidArgumentException
     */
    public static function validateUrl(string $url): string
    {
        // ensure that the urls are absolute
        $matchCount = preg_match("#^(https?://[^/]+)#", $url, $matches);
        if ($matchCount == 0) {
            throw new InvalidArgumentException('Invalid Url format.');
        }
        // separate out protocol and path
        $protocol = $matches[1];
        $path = substr($url, strlen($protocol));

        // replace multiple consecutive forward slashes by single ones
        $path = preg_replace("#//+#", "/", $path);

        // remove forward slash from end
        $path = rtrim($path, '/');

        return $protocol . $path;
    }

    /**
     * Check if an array isAssociative (has string keys)
     *
     * @param  array $array Any value to be tested for associative array
     * @return boolean True if the array is Associative, false if it is Indexed
     */
    public static function isAssociative(array $array): bool
    {
        foreach ($array as $key => $value) {
            if (is_string($key)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if all the given value or values are present in the provided list.
     *
     * @param mixed $value        Value to be checked, could be scalar, array, 2D array, etc.
     * @param array $listOfValues List to be searched for values
     * @return bool Whether given value is present in the provided list
     */
    public static function checkValueOrValuesInList($value, array $listOfValues): bool
    {
        if (is_null($value)) {
            return true;
        }
        if (!is_array($value)) {
            return in_array($value, $listOfValues, true);
        }
        foreach ($value as $v) {
            if (!self::checkValueOrValuesInList($v, $listOfValues)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Clone the given value
     *
     * @param mixed $value Value to be cloned.
     * @return mixed Cloned value
     */
    public static function clone($value)
    {
        if (is_array($value)) {
            return array_map([self::class, 'clone'], $value);
        }
        if (is_object($value)) {
            return clone $value;
        }
        return $value;
    }

    /**
     * Converts provided value to ?string type.
     *
     * @param $value false|string
     */
    public static function convertToNullableString($value): ?string
    {
        if ($value === false) {
            return null;
        }
        return $value;
    }

    /**
     * Return basic OS info.
     */
    public static function getOsInfo(bool $test = false): string
    {
        if ($test || PHP_OS_FAMILY === 'Unknown') {
            return '';
        }
        return PHP_OS_FAMILY . '-' . php_uname('r');
    }
}
