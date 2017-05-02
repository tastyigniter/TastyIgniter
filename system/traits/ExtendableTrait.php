<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
namespace Igniter\Traits;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extendable Trait
 * Allows for "Private traits"
 *
 * Adapted from the October ExtendableTrait
 * @link https://github.com/octobercms/library/tree/master/src/Extension/ExtendableTrait.php
 *
 * @package Igniter\Traits
 * @author TastyIgniter Dev Team
 * @link https://docs.tastyigniter.com
 */
trait ExtendableTrait
{

    /**
     * @var array Class reflection information, including behaviors.
     */
    protected $extensionData = [
        'extensions'     => [],
        'methods'        => [],
        'dynamicMethods' => [],
    ];

    /**
     * @var array Used to extend the constructor of an extendable class.
     * Eg: Class::extend(function($obj) { })
     */
    protected static $extendableCallbacks = [];

    /**
     * @var array Collection of static methods used by behaviors.
     */
    protected static $extendableStaticMethods = [];

    /**
     * @var bool Indicates if dynamic properties can be created.
     */
    protected static $extendableGuardProperties = TRUE;

    /**
     * Constructor.
     */
    public function extendableConstruct()
    {
        // Apply extensions
        if (!$this->implement)
            return;

        if (is_string($this->implement)) {
            $uses = explode(',', $this->implement);
        } elseif (is_array($this->implement)) {
            $uses = $this->implement;
        } else {
            show_error(sprintf('Class %s contains an invalid $implement value', get_class($this)));
        }

        foreach ($uses as $use) {
            $useClass = str_replace('.', '\\', trim(basename($use)));

            $this->extendClassWith($useClass);
        }
    }

    /**
     * Helper method for ::extend() static method
     *
     * @param  callable $callback
     *
     * @return void
     */
    public static function extendableExtendCallback($callback)
    {
        $class = get_called_class();
        if (
            !isset(self::$extendableCallbacks[$class]) ||
            !is_array(self::$extendableCallbacks[$class])
        ) {
            self::$extendableCallbacks[$class] = [];
        }

        self::$extendableCallbacks[$class][] = $callback;
    }

    /**
     * Clear the list of extended classes so they will be re-extended.
     * @return void
     */
    public static function clearExtendedClasses()
    {
        self::$extendableCallbacks = [];
    }

    /**
     * Dynamically extend a class with a specified behavior
     *
     * @param  string $extensionName
     *
     * @return void|self
     */
    public function extendClassWith($extensionName)
    {
        if (!strlen($extensionName))
            return $this;

        if (isset($this->extensionData['extensions'][$extensionName])) {
            show_error(sprintf(
                'Class %s has already been extended with %s',
                get_class($this),
                $extensionName
            ));
        }

        $this->extensionData['extensions'][$extensionName] = $extensionObject = new $extensionName($this);
        $this->extensionExtractMethods($extensionName, $extensionObject);
    }

    /**
     * Extracts the available methods from a behavior and adds it to the
     * list of callable methods.
     *
     * @param  string $extensionName
     * @param  object $extensionObject
     *
     * @return void
     */
    protected function extensionExtractMethods($extensionName, $extensionObject)
    {
        $extensionMethods = get_class_methods($extensionName);
        foreach ($extensionMethods as $methodName) {
            if ($methodName == '__construct' OR $methodName == '__remap'
                OR $extensionObject->extensionIsHiddenMethod($methodName)
            ) {
                continue;
            }

            $this->extensionData['methods'][$methodName] = $extensionName;
        }
    }

    /**
     * Programatically adds a method to the extendable class
     *
     * @param string $dynamicName
     * @param callable $method
     * @param string $extension
     */
    public function addDynamicMethod($dynamicName, $method, $extension = null)
    {
        if (
            is_string($method) &&
            $extension &&
            ($extensionObj = $this->getClassExtension($extension))
        ) {
            $method = [$extensionObj, $method];
        }

        $this->extensionData['dynamicMethods'][$dynamicName] = $method;
    }

    /**
     * Programatically adds a property to the extendable class
     *
     * @param string $dynamicName
     * @param string $value
     */
    public function addDynamicProperty($dynamicName, $value = null)
    {
        self::$extendableGuardProperties = FALSE;

        if (!property_exists($this, $dynamicName)) {
            $this->{$dynamicName} = $value;
        }

        self::$extendableGuardProperties = TRUE;
    }

    /**
     * Check if extendable class is extended with a behavior object
     *
     * @param  string $name Fully qualified behavior name
     *
     * @return boolean
     */
    public function isClassExtendedWith($name)
    {
        $name = str_replace('.', '\\', trim($name));

        return isset($this->extensionData['extensions'][$name]);
    }

    /**
     * Returns a behavior object from an extendable class, example:
     *
     *   $this->getClassExtension('Backend.Behaviors.FormController')
     *
     * @param  string $name Fully qualified behavior name
     *
     * @return mixed
     */
    public function getClassExtension($name)
    {
        $name = str_replace('.', '\\', trim($name));

        return (isset($this->extensionData['extensions'][$name]))
            ? $this->extensionData['extensions'][$name]
            : null;
    }

    /**
     * Short hand for getClassExtension() method, except takes the short
     * extension name, example:
     *
     *   $this->asExtension('FormController')
     *
     * @param  string $shortName
     *
     * @return mixed
     */
    public function asExtension($shortName)
    {
        $hints = [];
        foreach ($this->extensionData['extensions'] as $class => $obj) {
            if (
                preg_match('@\\\\([\w]+)$@', $class, $matches) &&
                $matches[1] == $shortName
            ) {
                return $obj;
            }
        }
    }

    /**
     * Checks if a method exists, extension equivalent of method_exists()
     *
     * @param  string $name
     *
     * @return boolean
     */
    public function methodExists($name)
    {
        return (
            method_exists($this, $name) ||
            isset($this->extensionData['methods'][$name]) ||
            isset($this->extensionData['dynamicMethods'][$name])
        );
    }

    /**
     * Checks if a property exists, extension equivalent of property_exists()
     *
     * @param  string $name
     *
     * @return boolean
     */
    public function propertyExists($name)
    {
        if (property_exists($this, $name)) {
            return TRUE;
        }

        foreach ($this->extensionData['extensions'] as $extensionObject) {
            if (
                property_exists($extensionObject, $name) &&
                $this->extendableIsAccessible($extensionObject, $name)
            ) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Checks if a property is accessible, property equivalent of is_callabe()
     *
     * @param  mixed $class
     * @param  string $propertyName
     *
     * @return boolean
     */
    protected function extendableIsAccessible($class, $propertyName)
    {
        $reflector = new ReflectionClass($class);
        $property = $reflector->getProperty($propertyName);

        return $property->isPublic();
    }

    /**
     * Magic method for __get()
     *
     * @param  string $name
     *
     * @return string
     */
    public function extendableGet($name)
    {
        foreach ($this->extensionData['extensions'] as $extensionObject) {
            if (
                property_exists($extensionObject, $name) &&
                $this->extendableIsAccessible($extensionObject, $name)
            ) {
                return $extensionObject->{$name};
            }
        }

        $parent = get_parent_class();
        if ($parent !== FALSE && method_exists($parent, '__get')) {
            return parent::__get($name);
        }
    }

    /**
     * Magic method for __set()
     *
     * @param  string $name
     * @param  string $value
     *
     * @return string
     */
    public function extendableSet($name, $value)
    {
        foreach ($this->extensionData['extensions'] as $extensionObject) {
            if (!property_exists($extensionObject, $name)) {
                continue;
            }

            $extensionObject->{$name} = $value;
        }

        /*
         * This targets trait usage in particular
         */
        $parent = get_parent_class();
        if ($parent !== FALSE && method_exists($parent, '__set')) {
            parent::__set($name, $value);
        }

        /*
         * Setting an undefined property
         */
        if (!self::$extendableGuardProperties) {
            $this->{$name} = $value;
        }
    }

    /**
     * Magic method for __call()
     *
     * @param  string $name
     * @param  array $params
     *
     * @return mixed
     */
    public function extendableCall($name, $params = null)
    {
        if (isset($this->extensionData['methods'][$name])) {
            $extension = $this->extensionData['methods'][$name];
            $extensionObject = $this->extensionData['extensions'][$extension];

            if (method_exists($extension, $name) && is_callable([$extension, $name])) {
                return call_user_func_array([$extensionObject, $name], $params);
            }
        }

        if (isset($this->extensionData['dynamicMethods'][$name])) {
            $dynamicCallable = $this->extensionData['dynamicMethods'][$name];

            if (is_callable($dynamicCallable)) {
                return call_user_func_array($dynamicCallable, $params);
            }
        }

        $parent = get_parent_class();
        if ($parent !== FALSE && method_exists($parent, '__call')) {
            return parent::__call($name, $params);
        }

        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()',
            get_class($this),
            $name
        ));
    }

    /**
     * Magic method for __callStatic()
     *
     * @param  string $name
     * @param  array $params
     *
     * @return mixed
     */
    public static function extendableCallStatic($name, $params = null)
    {
        $className = get_called_class();

        if (!array_key_exists($className, self::$extendableStaticMethods)) {

            self::$extendableStaticMethods[$className] = [];

            $class = new ReflectionClass($className);
            $defaultProperties = $class->getDefaultProperties();
            if (
                array_key_exists('implement', $defaultProperties) &&
                ($implement = $defaultProperties['implement'])
            ) {
                /*
                 * Apply extensions
                 */
                if (is_string($implement)) {
                    $uses = explode(',', $implement);
                } elseif (is_array($implement)) {
                    $uses = $implement;
                } else {
                    throw new Exception(sprintf('Class %s contains an invalid $implement value', $className));
                }

                foreach ($uses as $use) {
                    $useClassName = str_replace('.', '\\', trim($use));

                    $useClass = new ReflectionClass($useClassName);
                    $staticMethods = $useClass->getMethods(ReflectionMethod::IS_STATIC);
                    foreach ($staticMethods as $method) {
                        self::$extendableStaticMethods[$className][$method->getName()] = $useClassName;
                    }
                }
            }
        }

        if (isset(self::$extendableStaticMethods[$className][$name])) {
            $extension = self::$extendableStaticMethods[$className][$name];

            if (method_exists($extension, $name) && is_callable([$extension, $name])) {
                $extension::$extendableStaticCalledClass = $className;
                $result = forward_static_call_array([$extension, $name], $params);
                $extension::$extendableStaticCalledClass = null;

                return $result;
            }
        }

        // $parent = get_parent_class($className);
        // if ($parent !== false && method_exists($parent, '__callStatic')) {
        //    return parent::__callStatic($name, $params);
        // }

        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()',
            $className,
            $name
        ));
    }

}

/* End of file ExtendableTrait.php */
/* Location: ./system/tastyigniter/traits/ExtendableTrait.php */
