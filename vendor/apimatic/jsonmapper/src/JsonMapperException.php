<?php

/**
 * Part of JsonMapper
 *
 * PHP version 5
 *
 * @category Netresearch
 * @package  JsonMapper
 * @author   Christian Weiske <christian.weiske@netresearch.de>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     http://www.netresearch.de/
 */

namespace apimatic\jsonmapper;

use RuntimeException;

/**
 * Simple exception
 *
 * @category Netresearch
 * @package  JsonMapper
 * @author   Christian Weiske <christian.weiske@netresearch.de>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     http://www.netresearch.de/
 */
class JsonMapperException extends RuntimeException
{
    /**
     * Exception for discarded comments setting in configuration.
     * 
     * @param array $concernedKeys Keys (PHP directives) with issues.
     * 
     * @return JsonMapperException
     */
    static function commentsDisabledInConfigurationException($concernedKeys)
    {
        return new self(
            "Comments cannot be discarded in the configuration file i.e." .
            " the php.ini file; doc comments are a requirement for JsonMapper." .
            " Following configuration keys must have a value set to \"1\": " .
            implode(", ", $concernedKeys) . "."
        );
    }

    /**
     * Exception for non-existent key in an object.
     * 
     * @param string $key             The missing key/property.
     * @param string $class           The class in which the key is missing.
     * @param bool   $setterException Raise an exception specific to 
     *                                missing a setter within the class for 
     *                                the specified string.
     * 
     * @return JsonMapperException
     */
    static function undefinedPropertyException(
        $key,
        $class,
        $setterException = false
    ) {
        $err = $setterException ? 'has no public setter method' : 'does not exist';
        return new self("JSON property '$key' $err in object of type '$class'");
    }

    /**
     * Exception for non-existent key in an object.
     * 
     * @param string $key          The property missing type.
     * @param string $strClassName The class in which the property is missing type.
     * 
     * @return JsonMapperException
     */
    static function missingTypePropertyException($key, $strClassName)
    {
        return new self("Empty type at property '$strClassName::$$key'");
    }

    /**
     * Exception for an unCallable Factory Method.
     *
     * @param string $factoryMethod The concerned factory method.
     * @param string $strClassName  Related class name.
     *
     * @return JsonMapperException
     */
    static function unCallableFactoryMethodException($factoryMethod, $strClassName)
    {
        return new self(
            "Factory method '$factoryMethod' referenced by " .
            "'$strClassName' is not callable."
        );
    }

    /**
     * Exception for not able to call factory method with the given value.
     *
     * @param string $argType Type of the argument passed in method.
     * @param string $reasons Exception message received from factory method.
     *
     * @return JsonMapperException
     */
    static function invalidArgumentFactoryMethodException($argType, $reasons)
    {
        return new self(
            "Provided factory methods are not callable with " .
             "the value of Type: $argType\n$reasons"
        );
    }

    /**
     * Exception when it is not possible to map an object to a specific type.
     * 
     * @param string $typeName  Name of type to map json object on.
     * @param string $typeGroup Group name of the type provided.
     * @param string $value     Value that should be mapped by typeGroup
     *                          i.e. JSON string.
     * 
     * @return JsonMapperException
     */
    static function unableToMapException($typeName, $typeGroup, $value)
    {
        return new self("Unable to map $typeName: $typeGroup on: $value");
    }

    /**
     * A property marked as required was missing in the object provided.
     * 
     * @param string $propertyName Concerned property's name.
     * @param string $className    The class name in which the property wasn't found.
     * 
     * @return JsonMapperException
     */
    static function requiredPropertyMissingException($propertyName, $className)
    {
        return new self(
            "Required property '$propertyName' of class " .
            "'$className' is missing in JSON data"
        );
    }

    /**
     * No required arguments were provided.
     *
     * @param string $class              The concerned class name.
     * @param int    $ctorReqParamNumber The number of req params in constructor.
     *
     * @return JsonMapperException
     */
    static function noArgumentsException($class, $ctorReqParamNumber)
    {
        return new self(
            "$class class requires $ctorReqParamNumber "
            . "arguments in constructor but none provided"
        );
    }

    /**
     * Provided arguments were less than required.
     *
     * @param string $class                  The concerned class name.
     * @param array  $ctorRequiredParamsName Required parameters array.
     *
     * @return JsonMapperException
     */
    static function fewerArgumentsException($class, $ctorRequiredParamsName)
    {
        return new self(
            "Could not find required constructor arguments for $class: "
            . implode(", ", $ctorRequiredParamsName)
        );
    }

    /**
     * Provided type was not applicable on the given value.
     *
     * @param string $type  The type value could not be mapped to.
     * @param string $value Concerned value.
     *
     * @return JsonMapperException
     */
    static function unableToSetTypeException($type, $value)
    {
        return new self("Could not set type '$type' on value: $value");
    }
}
