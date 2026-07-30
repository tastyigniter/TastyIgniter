<?php

/**
 * Part of JsonMapper
 *
 * PHP version 5
 *
 * @category Apimatic
 * @package  JsonMapper
 * @author   Asad Ali <asad.ali@apimatic.io>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://www.apimatic.io/
 */
namespace apimatic\jsonmapper;

/**
 * OneOf Validation Exception.
 *
 * @category Apimatic
 * @package  JsonMapper
 * @author   Asad Ali <asad.ali@apimatic.io>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://www.apimatic.io/
 */
class AnyOfValidationException extends JsonMapperException
{
    /**
     * JSON does not match any of the types provided.
     * 
     * @param string $type The type JSON could not be mapped to.
     * @param string $json JSON string.
     * 
     * @return AnyOfValidationException
     */
    static function cannotMapAnyOfException($type, $json)
    {
        return new self(
            "We could not match any acceptable type from" .
            " $type on: $json"
        );
    }
}
