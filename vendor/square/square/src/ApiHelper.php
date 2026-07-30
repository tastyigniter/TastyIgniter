<?php

declare(strict_types=1);

namespace Square;

use Core\Utils\CoreHelper;
use Core\Utils\JsonHelper;
use InvalidArgumentException;
use stdClass;

/**
 * API utility class
 */
class ApiHelper
{
    /**
     * @var JsonHelper
     */
    private static $jsonHelper;

    public static function getJsonHelper(): JsonHelper
    {
        if (self::$jsonHelper == null) {
            self::$jsonHelper = new JsonHelper([], null, 'Square\\Models');
        }
        return self::$jsonHelper;
    }

    /**
     * Serialize any given mixed value.
     *
     * @param mixed $value Any value to be serialized
     *
     * @return string|null serialized value
     */
    public static function serialize($value): ?string
    {
        return CoreHelper::serialize($value);
    }

    /**
     * Deserialize a Json string
     *
     * @param string $json A valid Json string
     *
     * @return mixed Decoded Json
     */
    public static function deserialize(string $json)
    {
        return CoreHelper::deserialize($json);
    }

    /**
     * Merge headers
     *
     * Header names are compared using case-insensitive comparison. This method
     * preserves the original header name. If the $newHeaders overrides an existing
     * header, then the new header name (with its casing) is used.
     */
    public static function mergeHeaders(array $headers, array $newHeaders): array
    {
        $headerKeys = [];

        // Create a map of lower-cased-header-name to original-header-names
        foreach ($headers as $headerName => $val) {
            $headerKeys[\strtolower($headerName)] = $headerName;
        }

        // Override headers with new values
        foreach ($newHeaders as $headerName => $headerValue) {
            $lowerCasedName = \strtolower($headerName);
            if (isset($headerKeys[$lowerCasedName])) {
                unset($headers[$headerKeys[$lowerCasedName]]);
            }
            $headerKeys[$lowerCasedName] = $headerName;
            $headers[$headerName] = $headerValue;
        }

        return $headers;
    }

    /**
     * Assert if headers array is valid.
     *
     * @throws InvalidArgumentException
     */
    public static function assertHeaders(array $headers): void
    {
        foreach ($headers as $header => $value) {
            // Validate header name (must be string, must use allowed chars)
            // Ref: https://tools.ietf.org/html/rfc7230#section-3.2
            if (!is_string($header)) {
                throw new InvalidArgumentException(sprintf(
                    'Header name must be a string but %s provided.',
                    is_object($header) ? get_class($header) : gettype($header)
                ));
            }

            if (preg_match('/^[a-zA-Z0-9\'`#$%&*+.^_|~!-]+$/', $header) !== 1) {
                throw new InvalidArgumentException(
                    sprintf(
                        '"%s" is not a valid header name.',
                        $header
                    )
                );
            }

            // Validate value (must be scalar)
            if (!is_scalar($value) || null === $value) {
                throw new InvalidArgumentException(sprintf(
                    'Header value must be scalar but %s provided for header "%s".',
                    is_object($value) ? get_class($value) : gettype($value),
                    $header
                ));
            }
        }
    }

    /**
     * Decodes a valid json string into an array to send in Api calls.
     *
     * @param  mixed  $json         Must be null or array or a valid string json to be translated into a php array.
     * @param  string $name         Name of the argument whose value is being validated in $json parameter.
     * @param  bool   $associative  Should check for associative? Default: true.
     *
     * @return array|null    Returns an array made up of key-value pairs in the provided json string
     *                       or throws exception, if the provided json is not valid.
     * @throws InvalidArgumentException
     */
    public static function decodeJson($json, string $name, bool $associative = true): ?array
    {
        if (is_null($json) || (is_array($json) && (!$associative || CoreHelper::isAssociative($json)))) {
            return $json;
        }
        if ($json instanceof stdClass) {
            $json = json_encode($json);
        }
        if (is_string($json)) {
            $decoded = json_decode($json, true);
            if (is_array($decoded) && (!$associative || CoreHelper::isAssociative($decoded))) {
                return $decoded;
            }
        }
        throw new InvalidArgumentException("Invalid json value for argument: '$name'");
    }

    /**
     * Decodes a valid jsonArray string into an array to send in Api calls.
     *
     * @param  mixed  $json   Must be null or array or a valid string jsonArray to be translated into a php array.
     * @param  string $name   Name of the argument whose value is being validated in $json parameter.
     * @param  bool   $asMap  Should decode as map? Default: false.
     *
     * @return array|null    Returns an array made up of key-value pairs in the provided jsonArray string
     *                       or throws exception, if the provided json is not valid.
     * @throws InvalidArgumentException
     */
    public static function decodeJsonArray($json, string $name, bool $asMap = false): ?array
    {
        $decoded = self::decodeJson($json, $name, false);
        if (is_null($decoded)) {
            return null;
        }
        $isAssociative = CoreHelper::isAssociative($decoded);
        if (($asMap && $isAssociative) || (!$asMap && !$isAssociative)) {
            return array_map(function ($v) use ($name) {
                return self::decodeJson($v, $name);
            }, $decoded);
        }
        $type = $asMap ? 'map' : 'array';
        throw new InvalidArgumentException("Invalid json $type value for argument: '$name'");
    }
}
