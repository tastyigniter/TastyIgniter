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
class OneOfValidationException extends JsonMapperException
{
    /**
     * Exception raised when a json object maps to more 
     * than one type within the types specified in OneOf.
     * 
     * @param string $matchedType First type.
     * @param string $mappedWith  Second type.
     * @param string $json        JSON string.
     * 
     * @return OneOfValidationException
     */
    static function moreThanOneOfException($matchedType, $mappedWith, $json)
    {
        return new self(
            "There are more than one matching types i.e." .
            " { $matchedType and $mappedWith } on: $json"
        );
    }
    /**
     * JSON does not match any of the provided types.
     *
     * @param string $type The type JSON could not be mapped to.
     * @param string $json JSON string.
     *
     * @return OneOfValidationException
     */
    static function cannotMapAnyOfException($type, $json)
    {
        return new self(
            "We could not match any acceptable type from" .
            " $type on: $json"
        );
    }
}
