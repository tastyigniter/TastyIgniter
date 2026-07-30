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

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Automatically map JSON structures into objects.
 *
 * @category Netresearch
 * @package  JsonMapper
 * @author   Christian Weiske <christian.weiske@netresearch.de>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     http://www.netresearch.de/
 */
class JsonMapper
{
    /**
     * PSR-3 compatible logger object
     *
     * @link http://www.php-fig.org/psr/psr-3/
     * @var  object
     * @see  setLogger()
     */
    protected $logger;

    /**
     * Throw an exception when JSON data contain a property
     * that is not defined in the PHP class
     *
     * @var boolean
     */
    public $bExceptionOnUndefinedProperty = false;

    /**
     * Calls this method on the PHP class when an undefined property
     * is found. This method should receive two arguments, $key
     * and $value for the property key and value. Only works if
     * $bExceptionOnUndefinedProperty is set to false.
     *
     * @var string
     */
    public $sAdditionalPropertiesCollectionMethod = null;

    /**
     * Throw an exception if the JSON data miss a property
     * that is marked with @required in the PHP class
     *
     * @var boolean
     */
    public $bExceptionOnMissingData = false;

    /**
     * If the types of map() parameters shall be checked.
     * You have to disable it if you're using the json_decode "assoc" parameter.
     *
     *     `json_decode($str, false)`
     *
     * @var boolean
     */
    public $bEnforceMapType = true;

    /**
     * Contains user provided map of class names vs their child classes.
     * This is only needed if discriminators are to be used. PHP reflection is not
     * used to get child classes because most code bases use autoloaders where
     * classes are lazily loaded.
     *
     * @var array
     */
    public $arChildClasses = array();

    /**
     * Contains user provided map of discriminators substitution along with
     * its actual value.
     * This is only needed if discriminators are to be used in type combinators,
     * and their actual values are substituted in the type combinator templates.
     *
     * @var array<string,string>
     */
    public $discriminatorSubs = array();

    /**
     * Runtime cache for inspected classes. This is particularly effective if
     * mapArray() is called with a large number of objects
     *
     * @var array property inspection result cache
     */
    protected $arInspectedClasses = array();

    /**
     * An array of directives from php defined configuration files.
     *
     * @var array|null Array of values from the configuration files.
     */
    protected $config = null;

    protected $zendOptimizerPlusExtensionLoaded = null;

    /**
     * Constructor for JsonMapper.
     *
     * @throws JsonMapperException
     */
    function __construct()
    {
        $zendOptimizerPlus = "Zend Optimizer+";
        $zendOptimizerPlusSaveCommentKey = "zend_optimizerplus.save_comments";
        $opCacheSaveCommentKey = "opcache.save_comments";

        if (!isset($this->config)) {
            $iniPath = php_ini_loaded_file();
            $functionEnabled = !in_array(
                'parse_ini_file',
                explode(',', ini_get('disable_functions'))
            );
            $accessAllowed = $this->isPathAllowed($iniPath, ini_get('open_basedir'));
            if ($accessAllowed && $functionEnabled && is_readable($iniPath)) {
                $this->config = parse_ini_file($iniPath);
            }
        }
        if (!isset($this->zendOptimizerPlusExtensionLoaded)) {
            $this->zendOptimizerPlusExtensionLoaded
                = extension_loaded($zendOptimizerPlus);
        }

        $zendOptimizerDiscardedComments
            = $this->zendOptimizerPlusExtensionLoaded === true
            && $this->commentsDiscardedFor($zendOptimizerPlusSaveCommentKey);

        $opCacheDiscardedComments
            = $this->commentsDiscardedFor($opCacheSaveCommentKey);
        
        if ($zendOptimizerDiscardedComments || $opCacheDiscardedComments) {
            throw JsonMapperException::commentsDisabledInConfigurationException(
                array($zendOptimizerPlusSaveCommentKey, $opCacheSaveCommentKey)
            );
        }
    }

    /**
     * Returns true if the provided file path is accessible and
     * not restricted by open_basedir restriction.
     *
     * @param string|false $filePath     Real file path to be checked.
     * @param string|false $allowedPaths Allowed paths separated by os
     *                                   path separator.
     *
     * @return bool Whether the provided path is allowed to access.
     */
    protected function isPathAllowed($filePath, $allowedPaths)
    {
        if (empty($filePath)) {
            return false;
        }
        if (empty($allowedPaths)) {
            return true;
        }
        $allowedPathArray = explode(PATH_SEPARATOR, $allowedPaths);
        if (!in_array(dirname($filePath), $allowedPathArray)) {
            return false;
        }
        return true;
    }

    /**
     * Returns true if comments are disabled locally or in php.ini file.
     * However, if comments are enabled locally by overwriting global
     * php.ini configurations then returns false.
     *
     * @param string $configKey Configuration key to be checked.
     *
     * @return bool Whether comments are disabled in environment or php.ini file.
     */
    protected function commentsDiscardedFor($configKey)
    {
        $localConfigVal = strtolower(ini_get($configKey));
        $phpIniConfigVal = !isset($this->config[$configKey]) ? ''
            : strtolower($this->config[$configKey]);

        $enableValues = ["1", "on", "true", "yes"];
        $disableValues = ["0", "off", "false", "no"];

        $notEnabled = in_array($localConfigVal, $enableValues, true) === false;
        $isDisabled = in_array($localConfigVal, $disableValues, true) === true;
        $isDisabledInPhpIniFile = in_array(
            $phpIniConfigVal, $disableValues, true
        ) === true;

        return $notEnabled && ($isDisabled || $isDisabledInPhpIniFile);
    }

    /**
     * Map data all data in $json into the given $object instance.
     *
     * @param object $json   JSON object structure from json_decode()
     * @param object $object Object to map $json data into
     * @param bool   $strict True if looking to map with strict type checking,
     *                       Default: false
     *
     * @return object Mapped object is returned.
     * @see    mapArray()
     */
    public function map($json, $object, $strict = false)
    {
        if ($this->bEnforceMapType && !is_object($json)) {
            throw new \InvalidArgumentException(
                'JsonMapper::map() requires first argument to be an object'
                . ', ' . gettype($json) . ' given.'
            );
        }
        if (!is_object($object)) {
            throw new \InvalidArgumentException(
                'JsonMapper::map() requires second argument to be an object'
                . ', ' . gettype($object) . ' given.'
            );
        }

        $strClassName = get_class($object);
        $rc = new ReflectionClass($object);
        $providedProperties = array();
        $additionalPropertiesMethod = $this->getAdditionalPropertiesMethod($rc);

        foreach ($json as $key => $jvalue) {
            // $providedProperties[$key] = true;
            $isAdditional = false;

            // Store the property inspection results so we don't have to do it
            // again for subsequent objects of the same type
            if (!isset($this->arInspectedClasses[$strClassName][$key])) {
                $this->arInspectedClasses[$strClassName][$key]
                    = $this->inspectProperty($rc, $key);
            }

            list($hasProperty, $accessor, $type, $factoryMethod, $mapsBy, $namespace)
                = $this->arInspectedClasses[$strClassName][$key];

            if ($accessor !== null) {
                $providedProperties[$accessor->getName()] = true;
            }

            if (!$hasProperty) {
                if ($this->bExceptionOnUndefinedProperty) {
                    throw JsonMapperException::undefinedPropertyException(
                        $key,
                        $strClassName
                    );
                }
                $isAdditional = true;
                $this->log(
                    'info',
                    'Property {property} does not exist in {class}',
                    array('property' => $key, 'class' => $strClassName)
                );
            }

            if ($accessor === null) {
                if ($this->bExceptionOnUndefinedProperty) {
                    throw JsonMapperException::undefinedPropertyException(
                        $key,
                        $strClassName,
                        true
                    );
                }

                $isAdditional = true;
                $this->log(
                    'info',
                    'Property {property} has no public setter method in {class}',
                    array('property' => $key, 'class' => $strClassName)
                );
            }

            //FIXME: check if type exists, give detailled error message if not
            if ($type === '') {
                throw JsonMapperException::missingTypePropertyException(
                    $key,
                    $strClassName
                );
            }

            if ($isAdditional) {
                $this->addAdditionalProperty(
                    $additionalPropertiesMethod,
                    $object,
                    $key,
                    $jvalue
                );
                continue;
            }
            $value = $this->getMappedValue(
                $jvalue,
                $type,
                $mapsBy,
                $factoryMethod,
                $namespace,
                $rc->getName(),
                $strict
            );
            $this->setProperty($object, $accessor, $value);
        }

        if ($this->bExceptionOnMissingData) {
            $this->checkMissingData($providedProperties, $rc);
        }

        return $object;
    }

    /**
     * Add additional properties by invoking the specified method.
     *
     * @param ReflectionMethod|null $method Method to be called to add
     *                                      additional properties to the class.
     * @param object                $object Class instance on which the method
     *                                      is invoked.
     * @param int|string            $key    The name of additional property.
     * @param mixed                 $value  The value of additional property.
     *
     * @return void
     */
    protected function addAdditionalProperty($method, $object, $key, $value)
    {
        if (is_null($method)) {
            return;
        }
        $annotations = $this->parseAnnotations($method->getDocComment());
        try {
            $type = $this->getDocTypeForArrayOrMixed(
                $this->getParameterType($method->getParameters()[1]),
                $annotations,
                1
            );
            $mapsBy = $this->getMapByAnnotationFromParsed($annotations);
            $factoryMethods = $this->getFactoryMethods($annotations);
            $value = $this->getMappedValue(
                $value,
                $type,
                $mapsBy,
                $factoryMethods,
                $method->getDeclaringClass()->getNamespaceName(),
                $method->getDeclaringClass()->getName(),
                true
            );
            $method->invoke($object, $key, $value);
        } catch (Exception $_) {
            // Ignore the thrown error to skip this additional property
        }
    }

    /**
     * Checks if type is an array, and extracts its dimensions and inner type.
     *
     * @param string $type       Type to be checked for array.
     * @param int    $dimensions Dimensions passed in recursions, initial: 0.
     *
     * @return array
     */
    public function getArrayTypeAndDimensions($type, $dimensions = 0)
    {
        list($isMap, $isArray, $innerType) = TypeCombination::extractTypeInfo($type);
        if ($isMap || $isArray) {
            // if it's an array or map of some type
            // increment dimension and check for innerType
            return $this->getArrayTypeAndDimensions($innerType, ++$dimensions);
        }
        return array($type, $dimensions);
    }

    /**
     * Try calling the factory method if exists, otherwise throw JsonMapperException
     *
     * @param string $factoryMethod factory method in the format
     *                              'path/to/callable/function argType'
     * @param mixed  $value         value to be passed in as param into factory
     *                              method.
     * @param string $strClassName  strClassName referencing this factory method
     *
     * @return mixed|false
     * @throws JsonMapperException
     */
    protected function callFactoryMethod($factoryMethod, $value, $strClassName)
    {
        $factoryMethod = explode(' ', $factoryMethod)[0];
        if (!is_callable($factoryMethod)) {
            throw JsonMapperException::unCallableFactoryMethodException(
                $factoryMethod,
                $strClassName
            );
        }

        return call_user_func($factoryMethod, $value);
    }

    /**
     * Try calling the given function with value, return [true, updatedValue]
     * if call successful.
     *
     * @param mixed  $value         value to be passed in argument of factory method.
     * @param string $factoryMethod factory method string in the format
     *                              'path/to/callable/function argType'.
     *
     * @return array Return an array [bool $success, $value] and value will be the
     *               failure cause if not success.
     */
    protected function callFactoryWithErrorHandling($value, $factoryMethod)
    {
        $success = true;
        if (version_compare(phpversion(), '7.0', '<')) {
            try {
                $value = $this->callFactoryMethod($factoryMethod, $value, '');
            } catch (Exception $e) {
                // In Php versions < 7.0 catching only exceptions but not typeErrors
                // since strict types were not available for php < 7.0
                // also we can't use throwable since its only available after php 7.0
                $success = false;
                $value = $e->getMessage();
            }
        } else {
            try {
                $value = $this->callFactoryMethod($factoryMethod, $value, '');
            } catch (\Throwable $e) {
                // In Php versions >= 7.0 catching exceptions including typeErrors
                // using Throwable since its base interface for Exceptions & Errors
                // since types can be strict for php >= 7.0
                $success = false;
                $value = $e->getMessage();
            }
        }
        return [$success, $value];
    }

    /**
     * Get mapped value for a property in an object.
     *
     * @param mixed         $jvalue         Raw normalized data for the property
     * @param string        $type           Type found by inspectProperty()
     * @param string|null   $mapsBy         OneOf/AnyOf types hint found by
     *                                      inspectProperty in mapsBy annotation
     * @param string[]|null $factoryMethods Callable factory methods for property
     * @param string        $namespace      Namespace of the class
     * @param string        $className      Name of the class
     * @param bool          $strict         True if looking to map with strict
     *                                      type checking.
     *
     * @return array|false|mixed|object|null
     * @throws JsonMapperException|ReflectionException
     */
    protected function getMappedValue(
        $jvalue,
        $type,
        $mapsBy,
        $factoryMethods,
        $namespace,
        $className,
        $strict
    ) {
        if ($mapsBy) {
            return $this->mapFor(
                $jvalue,
                $mapsBy,
                $namespace,
                $factoryMethods,
                $className
            );
        }
        //use factory method generated value if factory provided
        if ($factoryMethods !== null && isset($factoryMethods[0])) {
            return $this->callFactoryMethod(
                $factoryMethods[0],
                $jvalue,
                $className
            );
        }

        if ($this->isNullable($type)) {
            if ($jvalue === null) {
                return null;
            }
            $type = $this->removeNullable($type);
        }

        if ($type === null || $type === 'mixed' || $type === '') {
            //no given type - simply return the json data
            return $jvalue;
        }

        if ($this->isObjectOfSameType($type, $jvalue)) {
            return $jvalue;
        }

        if ($this->isSimpleType($type)) {
            if ($strict && !$this->isSimpleValue($jvalue, $type)) {
                // if mapping strictly for multipleTypes
                throw JsonMapperException::unableToSetTypeException(
                    $type,
                    json_encode($jvalue)
                );
            }
            settype($jvalue, $type);
            return $jvalue;
        }

        list($array, $innerArrayType, $dimension) = $this->getArrayInfo(
            $type,
            $namespace
        );

        $fullTypeName = $this->getFullNamespace($type, $namespace);
        if (is_null($array)) {
            // Handling non array types
            if ($this->isFlatType(gettype($jvalue)) && !$strict) {
                // use constructor parameter if we have a class
                // but only a flat type (i.e. string, int)
                if ($jvalue === null) {
                    return null;
                }

                return new $fullTypeName($jvalue);
            }

            return $this->mapClass($jvalue, $fullTypeName, $strict);
        }

        // Handling array types
        if ($jvalue === null) {
            return null;
        }

        if ($this->isNullable($innerArrayType)) {
            $innerArrayType = $this->removeNullable($innerArrayType);
        }

        $fullTypeName = $this->getFullNamespace($innerArrayType, $namespace);
        if (!$this->isSimpleType($innerArrayType)) {
            $innerArrayType = $fullTypeName;
        }

        if ($this->isRegisteredType($fullTypeName)) {
            return $this->mapClassArray(
                $jvalue,
                $innerArrayType,
                $dimension,
                $strict
            );
        }

        return $this->mapArray(
            $jvalue,
            $array,
            $innerArrayType,
            $dimension,
            $strict
        );
    }

    /**
     * Returns the complete array info with array instance, its subType and
     * its dimensions.
     *
     * @param string $type      Type to be checked for array info
     * @param string $namespace Models namespace in case the type is a model
     *
     * @return array An array where 1st element is array's instance, 2nd is
     *               inner type info, and 3rd is dimensions of array.
     * @throws ReflectionException
     */
    protected function getArrayInfo($type, $namespace)
    {
        list($subtype, $dimension) = $this->getArrayTypeAndDimensions($type);

        if ($dimension > 0) {
            return array(array(), $subtype, $dimension);
        }

        if (substr($type, -1) == ']') {
            list($propType, $subtype) = explode('[', substr($type, 0, -1));
            if (!$this->isSimpleType($propType)) {
                $propType = $this->getFullNamespace($propType, $namespace);
            }
            return array($this->createInstance($propType), $subtype, $dimension);
        }

        if ($type == 'ArrayObject' || is_subclass_of($type, 'ArrayObject')) {
            return array($this->createInstance($type), null, $dimension);
        }

        return array(null, $subtype, $dimension);
    }

    /**
     * Check if an array is Associative (has string keys) or
     * its Indexed (empty or non-string keys), returns [isAssociative, isIndexed]
     *
     * @param mixed $value A value that could be isAssociative or isIndexed array
     *
     * @return array Returns Array of result i.e [isAssociative, isIndexed]
     */
    protected function isAssociativeOrIndexed($value)
    {
        if (is_object($value)) {
            return [true, false];
        }
        if (!is_array($value)) {
            return [false, false];
        }
        foreach ($value as $key => $v) {
            if (is_string($key)) {
                return [true, false];
            }
        }
        return [false, true];
    }

    /**
     * Gets not nested type for the given value
     *
     * @param mixed $value Value to be checked for type
     *
     * @return string|false Return flat PHP types for the given value
     *                      and if not flat type return false.
     */
    protected function getFlatType($value)
    {
        $type = gettype($value);
        if (!$this->isFlatType($type)) {
            return false;
        }
        switch ($type) {
        case 'integer':
            $type = 'int';
            break;
        case 'double':
            $type = 'float';
            break;
        case 'boolean':
            $type = 'bool';
            break;
        case 'NULL':
            $type = 'null';
            break;
        }
        return $type;
    }

    /**
     * Check all given factory methods that can be called with given value.
     *
     * @param mixed    $value          Any value to be checked with factoryMethods.
     * @param mixed    $newVal         A copy of value to be updated.
     * @param string   $type           Extracted type of the value.
     * @param string[] $factoryMethods Methods in the format 'path/to/method argType'
     *                                 which will be converting $value into any
     *                                 desirable type.
     *
     * @return string Returns the type or typeGroup of value based on
     *                given factory methods.
     * @throws JsonMapperException
     */
    protected function applyFactoryMethods($value, &$newVal, $type, $factoryMethods)
    {
        $errorMsg = [];
        $types = [$type]; // list of possible types
        foreach ($factoryMethods as $m) {
            // checking each provided factory method
            $method = explode(' ', $m);
            // try calling factory method
            list($success, $val) = $this->callFactoryWithErrorHandling($value, $m);
            if ($success) {
                if ($type == $method[1]) {
                    // if method call is successful
                    // and given type equals to argType of factory method
                    // update the value with returned $val of factory method
                    // and return with type early
                    $newVal = $val;
                    return $type;
                }
                // if method call is successful
                // and given type is not same as argType of factory method
                // then add argType in list of possible types for $value
                array_push($types, $method[1]);
            } elseif ($type == $method[1]) {
                // if method call is failure given type equals to argType of
                // factory method then add reason $val as an error message
                array_push($errorMsg, "$method[0]: $val");
            }
        }
        if (!empty($errorMsg)) {
            // if any error msg is added then throw exception
            throw JsonMapperException::invalidArgumentFactoryMethodException(
                $type,
                join("\n", $errorMsg)
            );
        }
        // converting possible types array into the string format
        // of an anyof typeGroup
        $types = array_unique($types);
        asort($types);
        $type = join(',', $types);
        if (count($types) > 1) {
            // wrap in brackets for multiple types
            $type = "($type)";
        }
        return $type;
    }

    /**
     * Extract type from any given value.
     *
     * @param mixed    $value   Any value to be checked for type, should be
     *                          an array if checking for inner type
     * @param string[] $factory Methods in the format 'path/to/method argType'
     *                          which will be converting $value into any
     *                          desirable type, Default: []
     * @param string   $start   string to be appended at the start of the
     *                          extracted type, Default: ''
     * @param string   $end     string to be appended at the end of the
     *                          extracted type, Default: ''
     *
     * @return string Returns the type that could be mapped on the given value.
     * @throws JsonMapperException
     */
    protected function getType(&$value, $factory = [], $start = '', $end = '')
    {
        $type = $this->getFlatType($value);
        $newVal = $value;
        if (!$type && is_array($value)) {
            if ($this->isAssociativeOrIndexed($value)[0]) {
                // if value is associative array
                $start .= 'array<string,';
                $end = '>' . $end;
            } else {
                // if value is indexed array
                if (empty($value)) {
                    return 'array';
                }
                $end = '[]' . $end;
            }
            $types = [];
            foreach ($value as $k => $v) {
                array_push($types, $this->getType($v, $factory));
                $newVal[$k] = $v;
            }
            $types = array_unique($types);
            asort($types);
            $isOneOfOrAnyOf = !empty($types) && substr($types[0], -1) === ')';
            if (count($types) > 1 || $isOneOfOrAnyOf) {
                // wrap in brackets for multiple types or oneof/anyof type
                $start .= '(';
                $end = ')' . $end;
            }
            $type = join(',', $types);
        } elseif (!$type && is_object($value)) {
            $class = get_class($value); // returns full path of class
            $slashPos = strrpos($class, '\\');
            if (!$slashPos) {
                // if slash not found then replace with -1
                $slashPos = -1;
            }
            $type = substr($class, ++$slashPos);
        }
        $type = "$start$type$end";
        if (!empty($factory)) {
            $type = $this->applyFactoryMethods($value, $newVal, $type, $factory);
        }
        $value = $newVal;
        return $type;
    }

    /**
     * Check the given type/types in the provided typeGroup, return true if
     * type(s) exists in the typeGroup
     *
     * @param TypeCombination|string $typeGroup TypesCombination object or string
     *                                          format for grouped types. All kind
     *                                          of groups are allowed here.
     * @param TypeCombination|string $type      Can be a normal type like string[],
     *                                          int, Car, etc. or a combination of
     *                                          types like (CarA,CarB)[], (int,Enum),
     *                                          or array<string,(CarA,CarB)>.
     * @param string                 $start     prefix used by string $type,
     *                                          Default: ""
     * @param string                 $end       postfix used by string $type,
     *                                          Default: ""
     *
     * @return bool
     */
    protected function checkForType($typeGroup, $type, $start = '', $end = '')
    {
        if (is_string($typeGroup)) {
            // convert into TypeCombination object
            $typeGroup = TypeCombination::withFormat($typeGroup);
        }
        if (is_string($type) && strpos($type, '(') !== false) {
            // for combination of types like: (A,B)[] or array<string,(A,(B,C)[])>
            // convert into TypeCombination object
            $type = TypeCombination::withFormat($type);
        }
        $checkAllInner = false; // required when $type instance of TypeCombination.
        if (is_string($type)) {
            // for checking simple types like: string, int[] or Car[]
            if ($typeGroup->getGroupName() == 'map') {
                $start .= 'array<string,';
                $end = '>' . $end;
            } elseif ($typeGroup->getGroupName() == 'array') {
                $end = '[]' . $end;
            }
            foreach ($typeGroup->getTypes() as $t) {
                if (is_string($t)) {
                    $matched = $type === "$start$t$end";
                } else {
                    $matched = $this->checkForType($t, $type, $start, $end);
                }
                if ($matched) {
                    // if any type in the typeGroup matched with given type,
                    // then early return true
                    return true;
                }
            }
            return false;
        } elseif (in_array($type->getGroupName(), ['array','map'])) {
            // To handle type if its array/map group of types
            // extract all internal groups from the given typeGroup that
            // are similar to $type
            $typeGroup = TypeCombination::with($typeGroup->extractSimilar($type));
            // update type to the innermost level of oneof/anyof
            $type = $type->extractOneOfAnyOfGroup();
            // check all inner elements of $type
            $checkAllInner = true;
        }
        // To handle type if its oneof/anyof group of types
        foreach ($type->getTypes() as $t) {
            $contains = $this->checkForType($typeGroup, $t);
            if (!$checkAllInner && $contains) {
                // if any type is found then
                // type is matched with $typeGroup
                return true;
            }
            if ($checkAllInner && !$contains) {
                // if any type is missing then
                // type is not matched with $typeGroup
                return false;
            }
        }
        return $checkAllInner;
    }

    /**
     * Converts the given typeCombination into its string format.
     *
     * @param TypeCombination|string $type Combined type/Single type.
     *
     * @return string
     */
    protected function formatType($type)
    {
        return is_string($type) ? $type : $type->getFormat();
    }

    /**
     * Checks if type of the given value is present in the type group,
     * also updates the value when necessary.
     *
     * @param string $typeGroup      String format for grouped types, i.e.
     *                               oneof(Car,Atom)
     * @param mixed  $value          Any value to be checked in type group
     * @param array  $factoryMethods Callable factory methods for the value, that
     *                               are required to serialize it into any of the
     *                               provided types in typeGroup in the format:
     *                               'path/to/method argType', Default: []
     *
     * @return mixed Returns the same value or updated one if any factory method
     *               is applied
     * @throws JsonMapperException Throws exception if a factory method is provided
     *                             but applicable on value, or also throws an
     *                             exception if type of value didn't match with type
     *                             group
     */
    public function checkTypeGroupFor($typeGroup, $value, $factoryMethods = [])
    {
        $type = self::getType($value, $factoryMethods);
        if ($this->checkForType($typeGroup, $type)) {
            return $value;
        }
        throw JsonMapperException::unableToMapException('Type', $type, $typeGroup);
    }

    /**
     * Map the data in $value by the provided $typeGroup i.e. oneOf(A,B)
     * will try to map value with only one of A or B, that matched. While
     * anyOf(A,B) will try to map it with any of A or B and sets its type to
     * the first one that matched.
     *
     * @param mixed                  $value          Raw normalized value to be
     *                                               mapped with any typeGroup
     * @param string|TypeCombination $typeGroup      TypesCombination object or
     *                                               string format for grouped types
     * @param string                 $namespace      Namespace of any customType
     *                                               class that's present in the
     *                                               provided typeGroup.
     * @param string[]|null          $factoryMethods Callable factory methods for
     *                                               the value, that are required
     *                                               to deserialize it into any of
     *                                               the provided types in typeGroup
     *                                               like ['path/to/method argType']
     * @param string|null            $className      Name of the parent class that's
     *                                               holding this property (if any)
     *
     * @return array|mixed|object
     * @throws JsonMapperException
     */
    public function mapFor(
        $value,
        $typeGroup,
        $namespace = '',
        $factoryMethods = null,
        $className = null
    ) {
        if (is_string($typeGroup)) {
            // convert into TypeCombination object
            $typeGroup = TypeCombination::withFormat(
                $typeGroup,
                isset($factoryMethods) ? $factoryMethods : []
            );
        }
        $isArrayGroup = $typeGroup->getGroupName() == 'array';
        $isMapGroup = $typeGroup->getGroupName() == 'map';
        if ($isArrayGroup || $isMapGroup) {
            list($isAssociative, $isIndexed) = $this->isAssociativeOrIndexed($value);
            if (($isMapGroup && !$isAssociative) || ($isArrayGroup && !$isIndexed)) {
                // Throw exception:
                // IF value is not associative array with groupType == map
                // Or value is not indexed array with groupType == array
                $typeName = $isMapGroup ? 'Associative Array' : 'Array';
                throw JsonMapperException::unableToMapException(
                    $typeName,
                    $this->formatType($typeGroup),
                    json_encode($value)
                );
            }
            $mappedObject = [];
            foreach ($value as $k => $v) {
                $mappedObject[$k] = $this->mapFor(
                    $v,
                    $typeGroup->getTypes()[0],
                    $namespace,
                    null,
                    $className
                );
            }
            return $mappedObject;
        }
        return $this->checkMappingsFor(
            $typeGroup,
            $value,
            $className,
            $namespace,
            function ($type, $value, $factoryMethods, $nspace, $className) {
                if (is_string($type)) {
                    return $this->getMappedValue(
                        $value,
                        $type,
                        null,
                        $factoryMethods,
                        $nspace,
                        $className,
                        true
                    );
                }
                return $this->mapFor(
                    $value,
                    $type,
                    $nspace,
                    null,
                    $className
                );
            }
        );
    }

    /**
     * Checks mappings for all types with mappedObject, provided by
     * mappedObjectCallback.
     *
     * @param TypeCombination $typeGroup         TypesCombination object or string
     *                                           format for grouped types
     * @param mixed           $value             Mixed typed value to be checked
     *                                           by mappings with each of the types
     * @param string|null     $className         Name of the class
     * @param string          $namespace         Namespace of the class
     * @param callable        $mappedObjCallback Callback function to be called with
     *                                           each type in provided types, this
     *                                           function must return the mapped
     *                                           Object, for which the mapping will
     *                                           be checked, and to ignore any type,
     *                                           it can throw JsonMapperException
     *
     * @return false|mixed|null     Returns the final mapped object after checking
     *                              for oneOf and anyOf cases
     * @throws JsonMapperException
     */
    protected function checkMappingsFor(
        $typeGroup,
        $value,
        $className,
        $namespace,
        $mappedObjCallback
    ) {
        $mappedObject = null;
        $mappedWith = '';
        $deserializers = $typeGroup->getDeserializers();
        $selectedDeserializer = null;
        $discSubs = isset($this->discriminatorSubs) ? $this->discriminatorSubs : [];
        // check json value for each type in types array
        foreach ($typeGroup->getTypes() as $type) {
            try {
                if (is_string($type)) {
                    list($matched, $method) = $this->isValueOfType(
                        $value,
                        $type,
                        $typeGroup->getDiscriminator($type, $discSubs),
                        $namespace,
                        $deserializers
                    );
                    if (!$matched) {
                        // skip this type as it can't be mapped on the given value.
                        continue;
                    }
                    $selectedDeserializer = isset($method) ? [$method] : null;
                }
                $mappedObject = call_user_func(
                    $mappedObjCallback,
                    $type,
                    $value,
                    $selectedDeserializer,
                    $namespace,
                    $className
                );
            } catch (Exception $e) {
                continue; // ignore the type if it can't be mapped for given value
            }
            $matchedType = $type;
            if ($typeGroup->getGroupName() == 'oneOf' && $mappedWith) {
                // if its oneOf and we have a value that is already mapped,
                // then throw jsonMapperException
                throw OneOfValidationException::moreThanOneOfException(
                    $this->formatType($matchedType),
                    $this->formatType($mappedWith),
                    json_encode($value)
                );
            }
            $mappedWith = $matchedType;
            if ($typeGroup->getGroupName() == 'anyOf') {
                break; // break if its anyOf, and we already have mapped its value
            }
        }

        if (!$mappedWith) {
            if ($typeGroup->getGroupName() == 'oneOf') {
                throw OneOfValidationException::cannotMapAnyOfException(
                    $this->formatType($typeGroup),
                    json_encode($value)
                );
            }
            throw AnyOfValidationException::cannotMapAnyOfException(
                $this->formatType($typeGroup),
                json_encode($value)
            );
        }

        return $mappedObject;
    }

    /**
     * Checks types against the value.
     *
     * @param mixed      $value   Value to be checked
     * @param string     $type    type defined in param's typehint
     * @param array|null $disc    An array with format discriminatorFieldName
     *                            as element 1 and discriminatorValue as
     *                            element 2
     * @param string     $nspace  Namespace of the class
     * @param string[]   $methods deserializer functions array in the format
     *                            ["pathToCallableFunction typeOfValue", ...]
     *                            Default: []
     *
     * @return array array(bool $matched, ?string $method) $matched represents if
     *               Type matched with value, $method represents the selected
     *               factory method (if any)
     * @throws ReflectionException
     * @throws JsonMapperException
     */
    protected function isValueOfType($value, $type, $disc, $nspace, $methods = [])
    {
        if (!empty($methods)) {
            $methodFound = false;
            foreach ($methods as $method) {
                if (isset($method) && explode(' ', $method)[1] == $type) {
                    $methodFound = true;
                    if ($this->callFactoryWithErrorHandling($value, $method)[0]) {
                        return array(true, $method);
                    }
                }
            }
            if ($methodFound) {
                // if any method was found but couldn't deserialize value
                return array(false, null);
            }
        }
        list($isMap, $isArray, $innerType) = TypeCombination::extractTypeInfo($type);
        if ($isMap || $isArray) {
            // if type is array like int[] or map like array<string,int>
            list($isAssociative, $isIndexed) = $this->isAssociativeOrIndexed($value);
            if (($isMap && $isAssociative) || ($isArray && $isIndexed)) {
                // Value must be associativeArray/object for MapType
                // Or it must be indexed array for ArrayType
                foreach ($value as $v) {
                    if (!$this->isValueOfType($v, $innerType, $disc, $nspace)[0]) {
                        // false if any element is not of same type
                        return array(false, null);
                    }
                }
                // true only if all elements in the array/map are of same type
                return array(true, null);
            }
            return array(false, null); // false if type is array/map but value is not
        }

        if ($type == 'mixed') {
            return array(true, null);
        }
        if ($type == 'null' || $this->isSimpleType($type) || !is_object($value)) {
            return array($this->isSimpleValue($value, $type), null);
        }
        if (!isset($disc)) {
            // if default discriminator is not provided
            // try getting it from the class annotations
            $rc = new ReflectionClass($this->getFullNamespace($type, $nspace));
            $disc = $this->getDiscriminator($rc);
        }
        return array($this->isComplexValue($value, $disc), null);
    }

    /**
     * Check if value is a complex type with provided discriminator
     *
     * @param mixed      $value         Value to be checked
     * @param array|null $discriminator An array with format discriminatorFieldName
     *                                  as element 1 and discriminatorValue as
     *                                  element 2
     *
     * @return bool True if value is a complexType with provided discriminator
     */
    protected function isComplexValue($value, $discriminator)
    {
        if (!isset($discriminator)) {
            // if discriminator is missing
            return true;
        }
        list($discriminatorField, $discriminatorValue) = $discriminator;
        if (!isset($value->{$discriminatorField})) {
            // if value didn't have discriminatorField
            return true;
        }
        // if discriminator field is set then decide w.r.t its value
        $discriminatorFieldValue = $value->{$discriminatorField};
        if (is_array($discriminatorValue)) {
            return !empty(
                array_filter(
                    $discriminatorValue,
                    function ($v) use ($discriminatorFieldValue) {
                        return $discriminatorFieldValue == $v;
                    }
                )
            );
        }
        return $discriminatorFieldValue == $discriminatorValue;
    }

    /**
     * Checks if the given type is a "simple type"
     *
     * @param string $type type name from gettype()
     *
     * @return boolean True if it is a simple PHP type
     */
    protected function isSimpleType($type)
    {
        return $type == 'string'
            || $type == 'boolean' || $type == 'bool'
            || $type == 'integer' || $type == 'int'   || $type == 'float'
            || $type == 'double'  || $type == 'array' || $type == 'object';
    }

    /**
     * Check if value is of simple type
     *
     * @param mixed  $value Value to be checked
     * @param string $type  Type defined in param's typehint
     *
     * @return bool True if value is of the given simple type
     */
    protected function isSimpleValue($value, $type)
    {
        return ($type == 'string' && is_string($value))
            || ($type == 'array' && (is_array($value) || is_object($value)))
            || ($type == 'object' && is_object($value))
            || ($type == 'bool' && is_bool($value))
            || ($type == 'boolean' && is_bool($value))
            || ($type == 'int' && is_int($value))
            || ($type == 'integer' && is_int($value))
            || ($type == 'float' && is_float($value))
            || ($type == 'double' && is_float($value))
            || ($type == 'null' && is_null($value));
    }

    /**
     * Map all data in $json into a new instance of $type class.
     *
     * @param object|null $json   JSON object structure from json_decode()
     * @param string      $type   The type of class instance to map into.
     * @param bool        $strict True if looking to map with strict type checking,
     *                            Default: false
     *
     * @return object|null Mapped object is returned.
     * @throws ReflectionException|JsonMapperException
     * @see    mapClassArray()
     */
    public function mapClass($json, $type, $strict = false)
    {
        if ($json === null) {
            return null;
        }

        if (!is_object($json)) {
            throw new \InvalidArgumentException(
                'JsonMapper::mapClass() requires first argument to be an object'
                . ', ' . gettype($json) . ' given.'
            );
        }

        $ttype = ltrim($type, "\\");

        if (!class_exists($type)) {
            throw new \InvalidArgumentException(
                'JsonMapper::mapClass() requires second argument to be a class name'
                . ', ' . $type . ' given.'
            );
        }

        $rc = new ReflectionClass($ttype);
        //try and find a class with matching discriminator
        $matchedRc = $this->getDiscriminatorMatch($json, $rc);
        //otherwise fallback to an instance of $type class
        if ($matchedRc === null) {
            $instance = $this->createInstance($ttype, $json, $strict);
        } else {
            $instance = $this->createInstance(
                $matchedRc->getName(),
                $json,
                $strict
            );
        }


        return $this->map($json, $instance, $strict);
    }

    /**
     * Get class instance that best matches the class
     *
     * @param object|null     $json JSON object structure from json_decode()
     * @param ReflectionClass $rc   Class to get instance of. This method
     *                              will try to first match the
     *                              discriminator field with the
     *                              discriminator value of the current
     *                              class or its child class. If no
     *                              matches is found, then the current
     *                              class's instance is returned.
     *
     * @return ReflectionClass|null Object instance if match is found.
     * @throws ReflectionException
     */
    protected function getDiscriminatorMatch($json, $rc)
    {
        $discriminator = $this->getDiscriminator($rc);
        if ($discriminator) {
            list($fieldName, $fieldValue) = $discriminator;
            if (isset($json->{$fieldName}) && $json->{$fieldName} === $fieldValue) {
                return $rc;
            }
            if (!$this->isRegisteredType($rc->name)) {
                return null;
            }
            foreach ($this->getChildClasses($rc) as $clazz) {
                $childRc = $this->getDiscriminatorMatch($json, $clazz);
                if ($childRc) {
                    return $childRc;
                }
            }
        }
        return null;
    }

    /**
     * Get discriminator info
     *
     * @param ReflectionClass $rc ReflectionClass of class to inspect
     *
     * @return array|null          An array with discriminator arguments
     *                             Element 1 is discriminator field name
     *                             and element 2 is discriminator value.
     */
    protected function getDiscriminator($rc)
    {
        $annotations = $this->parseAnnotations($rc->getDocComment());
        $annotationInfo = array();
        if (isset($annotations['discriminator'])) {
            $annotationInfo[0] = trim($annotations['discriminator'][0]);
            if (isset($annotations['discriminatorType'])) {
                $annotationInfo[1] = trim($annotations['discriminatorType'][0]);
            } else {
                $annotationInfo[1] = $rc->getShortName();
            }
            return $annotationInfo;
        }
        return null;
    }

    /**
     * Get child classes from a ReflectionClass
     *
     * @param ReflectionClass $rc ReflectionClass of class to inspect
     *
     * @return ReflectionClass[]  ReflectionClass instances for child classes
     * @throws ReflectionException
     */
    protected function getChildClasses($rc)
    {
        $children  = array();
        foreach ($this->arChildClasses[$rc->name] as $class) {
            $child = new ReflectionClass($class);
            if ($child->isSubclassOf($rc)) {
                $children[] = $child;
            }
        }
        return $children;
    }

    /**
     * Convert a type name to a fully namespaced type name.
     *
     * @param string $type  Type name (simple type or class name)
     * @param string $strNs Base namespace that gets prepended to the type name
     *
     * @return string Fully-qualified type name with namespace
     */
    protected function getFullNamespace($type, $strNs)
    {
        if (\is_string($type) && $type !== '' && $type[0] != '\\') {
            //create a full qualified namespace
            if ($strNs != '') {
                $type = '\\' . $strNs . '\\' . $type;
            }
        }
        return $type;
    }

    /**
     * Check required properties exist in json
     *
     * @param array           $providedProperties array with json properties
     * @param ReflectionClass $rc                 Reflection class to check
     *
     * @return void
     * @throws JsonMapperException
     */
    protected function checkMissingData($providedProperties, ReflectionClass $rc)
    {
        foreach ($rc->getProperties() as $property) {
            $rprop = $rc->getProperty($property->name);
            $docblock = $rprop->getDocComment();
            $annotations = $this->parseAnnotations($docblock);
            if (isset($annotations['required'])
                && !isset($providedProperties[$property->name])
            ) {
                throw JsonMapperException::requiredPropertyMissingException(
                    $property->name,
                    $rc->getName()
                );
            }
        }
    }

    /**
     * Get additional properties setter method for the class.
     *
     * @param ReflectionClass $rc Reflection class to check
     *
     * @return ReflectionMethod    Method or null if disabled.
     */
    protected function getAdditionalPropertiesMethod(ReflectionClass $rc)
    {
        if ($this->bExceptionOnUndefinedProperty !== false
            || $this->sAdditionalPropertiesCollectionMethod === null
        ) {
            return null;
        }
        $additionalPropertiesMethod = null;
        try {
            $additionalPropertiesMethod
                = $rc->getMethod($this->sAdditionalPropertiesCollectionMethod);
            if (!$additionalPropertiesMethod->isPublic()) {
                throw new  \InvalidArgumentException(
                    $this->sAdditionalPropertiesCollectionMethod .
                    " method is not public on the given class."
                );
            }
            if ($additionalPropertiesMethod->getNumberOfParameters() < 2) {
                throw new  \InvalidArgumentException(
                    $this->sAdditionalPropertiesCollectionMethod .
                    ' method does not receive two args, $key and $value.'
                );
            }
        } catch (\ReflectionException $_) {
            // Ignore if the method is not available on the given class
        }
        return $additionalPropertiesMethod;
    }

    /**
     * Map an array
     *
     * @param array         $jsonArray JSON array structure from json_decode()
     * @param mixed         $array     Array or ArrayObject that gets filled with
     *                                 data from $json.
     * @param string|object $class     Class name for children objects. All children
     *                                 will get mapped onto this type. Supports class
     *                                 names and simple types like "string".
     * @param int           $dimension Dimension of array to map, i.e. 2 for 2D
     *                                 array, Default: 1
     * @param bool          $strict    True if looking to map with strict type
     *                                 checking, Default: false
     *
     * @return mixed Mapped $array is returned
     */
    public function mapArray(
        $jsonArray,
        $array,
        $class = null,
        $dimension = 1,
        $strict = false
    ) {
        foreach ($jsonArray as $key => $jvalue) {
            if ($class === null) {
                $array[$key] = $jvalue;
            } else if ($dimension > 1) {
                $array[$key] = $this->mapArray(
                    $jvalue,
                    array(),
                    $class,
                    $dimension - 1,
                    $strict
                );
            } else if ($this->isFlatType(gettype($jvalue))) {
                // use constructor parameter if we have a class
                // but only a flat type (i.e. string, int)
                if ($jvalue === null) {
                    $array[$key] = null;
                } else {
                    if ($this->isSimpleType($class)) {
                        if ($strict && !$this->isSimpleValue($jvalue, $class)) {
                            // if mapping strictly for multipleTypes
                            throw JsonMapperException::unableToSetTypeException(
                                $class,
                                json_encode($jvalue)
                            );
                        }
                        settype($jvalue, $class);
                        $array[$key] = $jvalue;
                    } else {
                        $array[$key] = new $class($jvalue);
                    }
                }
            } else {
                $instance = $this->createInstance(
                    $class,
                    $jvalue,
                    $strict
                );
                $array[$key] = $this->map($jvalue, $instance, $strict);
            }
        }
        return $array;
    }

    /**
     * Map an array
     *
     * @param array|null $jsonArray JSON array structure from json_decode()
     * @param string     $type      Class name
     * @param int        $dimension Dimension of array to map, i.e. 2 for 2D array,
     *                              Default: 1
     * @param bool       $strict    True if looking to map with strict type checking,
     *                              Default: false
     *
     * @return array|null           A new array containing object of $type
     *                              which is mapped from $jsonArray
     * @throws ReflectionException|JsonMapperException
     */
    public function mapClassArray($jsonArray, $type, $dimension = 1, $strict = false)
    {
        if ($jsonArray === null) {
            return null;
        }

        $array = array();
        foreach ($jsonArray as $key => $jvalue) {
            if ($dimension > 1) {
                $array[$key] = $this->mapClassArray(
                    $jvalue,
                    $type,
                    $dimension - 1,
                    $strict
                );
            } else {
                $array[$key] = $this->mapClass($jvalue, $type, $strict);
            }
        }

        return $array;
    }

    /**
     * Try to find out if a property exists in a given class.
     * Checks property first, falls back to setter method.
     *
     * @param ReflectionClass $rc   Reflection class to check
     * @param string          $name Property name
     *
     * @return array First value: if the property exists
     *               Second value: the accessor to use (
     *                 ReflectionMethod or ReflectionProperty, or null)
     *               Third value: type of the property
     *               Fourth value: factory method
     */
    protected function inspectProperty(ReflectionClass $rc, $name)
    {
        $rmeth = null;
        $annotations = [];
        $mapsBy = null;
        $namespace = $rc->getNamespaceName();
        foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $annotations = $this->parseAnnotations($method->getDocComment());
            if ($name === $this->getMapAnnotationFromParsed($annotations)) {
                $rmeth = $method;
                $mapsBy = $this->getMapByAnnotationFromParsed($annotations);
                break;
            }
        }

        if ($rmeth === null) {
            //try setter method
            $setter = 'set' . str_replace(
                ' ', '', ucwords(str_replace('_', ' ', $name))
            );
            if ($rc->hasMethod($setter)) {
                $rmeth = $rc->getMethod($setter);
                $annotations = $this->parseAnnotations($rmeth->getDocComment());
            }
        }
        if ($rmeth !== null && $rmeth->isPublic()) {
            $factoryMethod = $this->getFactoryMethods($annotations);
            $namespace = $rmeth->getDeclaringClass()->getNamespaceName();

            $type = null;
            $rparams = $rmeth->getParameters();
            if (count($rparams) > 0) {
                $type = $this->getParameterType($rparams[0]);
            }
            $type = $this->getDocTypeForArrayOrMixed($type, $annotations);

            return array(true, $rmeth, $type, $factoryMethod, $mapsBy, $namespace);
        }

        $rprop = null;
        // check for @maps annotation for hints
        foreach ($rc->getProperties(\ReflectionProperty::IS_PUBLIC) as $p) {
            $mappedName = $this->getMapAnnotation($p);
            if ($mappedName !== null && $name == $mappedName) {
                $mapsBy = $this->getMapByAnnotation($p);
                $rprop = $p;
                break;
            }
        }

        //now try to set the property directly
        if ($rprop === null) {
            if ($rc->hasProperty($name)
                && $this->getMapAnnotation($rc->getProperty($name)) === null
            ) {
                $rprop = $rc->getProperty($name);
            } else {
                //case-insensitive property matching
                foreach ($rc->getProperties(\ReflectionProperty::IS_PUBLIC) as $p) {
                    if ((strcasecmp($p->name, $name) === 0)
                        && $this->getMapAnnotation($p) === null
                    ) {
                        $rprop = $p;
                        break;
                    }
                }
            }
        }

        if ($rprop !== null) {
            if ($rprop->isPublic()) {
                $docblock      = $rprop->getDocComment();
                $annotations   = $this->parseAnnotations($docblock);
                $namespace = $rprop->getDeclaringClass()->getNamespaceName();
                $type          = null;
                $factoryMethod = $this->getFactoryMethods($annotations);

                //support "@var type description"
                if (isset($annotations['var'][0])) {
                    list($type) = explode(' ', $annotations['var'][0]);
                }

                return array(true, $rprop, $type, $factoryMethod, $mapsBy,
                    $namespace);
            } else {
                //no setter, private property
                return array(true, null, null, null, $mapsBy, $namespace);
            }
        }

        //no setter, no property
        return array(false, null, null, null, $mapsBy, $namespace);
    }

    /**
     * Get Phpdoc typehint for parameter
     *
     * @param \ReflectionParameter $param ReflectionParameter instance for parameter
     *
     * @return string|null
     */
    protected function getParameterType(\ReflectionParameter $param)
    {
        if (PHP_VERSION_ID < 80000 && null !== $class = $param->getClass()) {
            return "\\" . $class->getName();
        }

        if (is_callable([$param, 'hasType']) && $param->hasType()) {
            $type = $param->getType();
            if ($type->isBuiltIn()) {
                $typeName = $this->reflectionTypeToString($type);
            } else {
                $typeName = "\\" . $this->reflectionTypeToString($type);
            }
            return $type->allowsNull() ? "$typeName|null" : $typeName;
        }

        return null;
    }

    /**
     * Get name for a ReflectionType instance
     *
     * @param \ReflectionType $type Reflection type instance
     *
     * @return string
     */
    protected function reflectionTypeToString($type)
    {
        if (\class_exists('ReflectionNamedType')
            && $type instanceof \ReflectionNamedType
        ) {
            return $type->getName();
        } else {
            return (string)$type;
        }
    }

    /**
     * If the actual type is array or mixed, use the annotations to extract
     * the type.
     *
     * @param string|null $type        The actual type of the parameter.
     * @param array       $annotations The annotations to search the type.
     * @param int         $index       The position of parameter in the function.
     *
     * @return string|null
     */
    public function getDocTypeForArrayOrMixed($type, $annotations, $index = 0)
    {
        if (($type === null || $type === 'array' || $type === 'array|null')
            && isset($annotations['param'][$index])
        ) {
            list($type) = explode(' ', trim($annotations['param'][$index]));
        }

        return $type;
    }

    /**
     * Get all factory methods from the list of annotations.
     *
     * @param array $annotations The annotations list.
     *
     * @return string[]
     */
    public function getFactoryMethods(array $annotations)
    {
        $factoryMethod = null;
        if (isset($annotations['factory'])) {
            //support "@factory method_name"
            $factoryMethod = $annotations['factory'];
        }
        return $factoryMethod;
    }

    /**
     * Get map annotation value for a property
     *
     * @param object $property Property of a class
     *
     * @return string|null     Map annotation value
     */
    protected function getMapAnnotation($property)
    {
        $annotations = $this->parseAnnotations($property->getDocComment());
        return $this->getMapAnnotationFromParsed($annotations);
    }

    /**
     * Get map annotation value from a parsed annotation list
     *
     * @param array $annotations Parsed annotation list
     *
     * @return string|null       Map annotation value
     */
    protected function getMapAnnotationFromParsed($annotations)
    {
        if (isset($annotations['maps'][0])) {
            return $annotations['maps'][0];
        }
        return null;
    }

    /**
     * Get mapBy annotation value for a property
     *
     * @param object $property Property of a class
     *
     * @return string|null     MapBy annotation value
     */
    protected function getMapByAnnotation($property)
    {
        $annotations = $this->parseAnnotations($property->getDocComment());
        return $this->getMapByAnnotationFromParsed($annotations);
    }

    /**
     * Get mapsBy annotation value from a parsed annotation list
     *
     * @param array $annotations Parsed annotation list
     *
     * @return string|null       MapsBy annotation value
     */
    protected function getMapByAnnotationFromParsed($annotations)
    {
        if (isset($annotations['mapsBy'][0])) {
            return $annotations['mapsBy'][0];
        }
        return null;
    }

    /**
     * Set a property on a given object to a given value.
     *
     * Checks if the setter or the property are public are made before
     * calling this method.
     *
     * @param object $object   Object to set property on
     * @param object $accessor ReflectionMethod or ReflectionProperty
     * @param mixed  $value    Value of property
     *
     * @return void
     */
    protected function setProperty(
        $object,
        $accessor,
        $value
    ) {
        if ($accessor instanceof \ReflectionProperty) {
            $object->{$accessor->getName()} = $value;
        } else {
            $object->{$accessor->getName()}($value);
        }
    }

    /**
     * Create a new object of the given type.
     *
     * @param string $class   Class name to instantiate
     * @param object $jobject Use jobject for constructor args
     * @param bool   $strict  True if looking to map with strict type checking,
     *                        Default: false
     *
     * @return object Freshly created object
     * @throws ReflectionException|JsonMapperException
     */
    protected function createInstance($class, &$jobject = null, $strict = false)
    {
        $rc = new ReflectionClass($class);
        $ctor = $rc->getConstructor();
        if ($ctor === null
            || 0 === $ctorReqParamsCount = $ctor->getNumberOfRequiredParameters()
        ) {
            return new $class();
        } else if ($jobject === null) {
            throw JsonMapperException::noArgumentsException(
                $class,
                $ctor->getNumberOfRequiredParameters()
            );
        }

        $ctorRequiredParams = array_slice(
            $ctor->getParameters(),
            0,
            $ctorReqParamsCount
        );
        $ctorRequiredParamsName = array_map(
            function (\ReflectionParameter $param) {
                return $param->getName();
            }, $ctorRequiredParams
        );
        $ctorRequiredParams = array_combine(
            $ctorRequiredParamsName,
            $ctorRequiredParams
        );
        $ctorArgs = [];

        foreach ($jobject as $key => $jvalue) {
            if (count($ctorArgs) === $ctorReqParamsCount) {
                break;
            }

            // Store the property inspection results so we don't have to do it
            // again for subsequent objects of the same type
            if (!isset($this->arInspectedClasses[$class][$key])) {
                $this->arInspectedClasses[$class][$key]
                    = $this->inspectProperty($rc, $key);
            }

            list($hasProperty, $accessor, $type, $factoryMethod, $mapsBy, $namespace)
                = $this->arInspectedClasses[$class][$key];

            if (!$hasProperty) {
                // if no matching property or setter method found
                if (isset($ctorRequiredParams[$key])) {
                    $rp = $ctorRequiredParams[$key];
                    $jtype = null;
                } else {
                    continue;
                }
            } else if ($accessor instanceof \ReflectionProperty) {
                // if a property was found
                if (isset($ctorRequiredParams[$accessor->getName()])) {
                    $rp = $ctorRequiredParams[$accessor->getName()];
                    $jtype = $type;
                } else {
                    continue;
                }
            } else {
                // if a setter method was found
                $methodName = $accessor->getName();
                $methodName = substr($methodName, 0, 3) === 'set' ?
                    lcfirst(substr($methodName, 3)) : $methodName;
                if (isset($ctorRequiredParams[$methodName])) {
                    $rp = $ctorRequiredParams[$methodName];
                    $jtype = $type;
                } else {
                    continue;
                }
            }

            $ttype = $this->getParameterType($rp);
            if (($ttype !== null && $ttype !== 'array' && $ttype !== 'array|null')
                || $jtype === null
            ) {
                // when $ttype is too generic, fallback to $jtype
                $jtype = $ttype;
            }

            $ctorArgs[$rp->getPosition()] = $this->getMappedValue(
                $jvalue,
                $jtype,
                $mapsBy,
                $factoryMethod,
                $namespace,
                $rc->getName(),
                $strict
            );

            if (!$strict) {
                unset($jobject->{$key});
            }
            unset($ctorRequiredParamsName[$rp->getPosition()]);
        }

        if (count($ctorArgs) < $ctorReqParamsCount) {
            throw JsonMapperException::fewerArgumentsException(
                $class,
                $ctorRequiredParamsName
            );
        }

        ksort($ctorArgs);
        return $rc->newInstanceArgs($ctorArgs);
    }

    /**
     * Checks if the object is of this type or has this type as one of its parents
     *
     * @param string $type  class name of type being required
     * @param mixed  $value Some PHP value to be tested
     *
     * @return boolean True if $object has type of $type
     */
    protected function isObjectOfSameType($type, $value)
    {
        if (false === is_object($value)) {
            return false;
        }

        return is_a($value, $type);
    }

    /**
     * Checks if the given type is a type that is not nested
     * (simple type except array and object)
     *
     * @param string $type type name from gettype()
     *
     * @return boolean True if it is a non-nested PHP type
     */
    protected function isFlatType($type)
    {
        return $type == 'NULL'
            || $type == 'string'
            || $type == 'boolean' || $type == 'bool'
            || $type == 'integer' || $type == 'int'
            || $type == 'double';
    }

    /**
     * Is type registered with mapper
     *
     * @param string|null $type Class name
     *
     * @return boolean True if registered with $this->arChildClasses
     */
    protected function isRegisteredType($type)
    {
        if (!isset($type)) {
            return false;
        }
        return isset($this->arChildClasses[ltrim($type, "\\")]);
    }

    /**
     * Checks if the given type is nullable
     *
     * @param string $type type name from the phpdoc param
     *
     * @return boolean True if it is nullable
     */
    protected function isNullable($type)
    {
        return stripos('|' . $type . '|', '|null|') !== false;
    }

    /**
     * Remove the 'null' section of a type
     *
     * @param string $type type name from the phpdoc param
     *
     * @return string The new type value
     */
    protected function removeNullable($type)
    {
        return substr(
            str_ireplace('|null|', '|', '|' . $type . '|'),
            1,
            -1
        );
    }

    /**
     * Copied from PHPUnit 3.7.29, Util/Test.php
     *
     * @param string $docblock Full method docblock
     *
     * @return array
     */
    protected function parseAnnotations($docblock)
    {
        $annotations = array();
        // Strip away the docblock header and footer
        // to ease parsing of one line annotations
        $docblock = substr($docblock, 3, -2);

        $re = '/@(?P<name>[A-Za-z_-]+)(?:[ \t]+(?P<value>.*?))?[ \t]*\r?$/m';
        if (preg_match_all($re, $docblock, $matches)) {
            $numMatches = count($matches[0]);

            for ($i = 0; $i < $numMatches; ++$i) {
                $annotations[$matches['name'][$i]][] = $matches['value'][$i];
            }
        }

        return $annotations;
    }

    /**
     * Log a message to the $logger object
     *
     * @param string $level   Logging level
     * @param string $message Text to log
     * @param array  $context Additional information
     *
     * @return null
     */
    protected function log($level, $message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger PSR-3 compatible logger object
     *
     * @return null
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}
?>
