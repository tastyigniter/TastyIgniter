<?php

declare(strict_types=1);

namespace Igniter\Flame\Traits;

use BadMethodCallException;
use Igniter\Flame\Support\ClassLoader;
use LogicException;
use ReflectionClass;
use ReflectionMethod;

/**
 * Extendable Trait
 * Allows for "Private traits"
 *
 * Adapted from the October ExtendableTrait
 * @link https://github.com/octobercms/library/tree/master/src/Extension/ExtendableTrait.php
 */
trait ExtendableTrait
{
    /**
     * A list of controller behavours/traits to be implemented
     */
    public array $implement = [];

    /**
     * @var array Class reflection information, including behaviors.
     */
    protected array $extensionData = [
        'extensions' => [],
        'methods' => [],
        'dynamicMethods' => [],
        'dynamicProperties' => [],
    ];

    /**
     * @var array Used to extend the constructor of an extendable class.
     * Eg: Class::extend(function($obj) { })
     */
    protected static array $extendableCallbacks = [];

    /**
     * @var array Collection of static methods used by behaviors.
     */
    protected static array $extendableStaticMethods = [];

    /**
     * @var bool Indicates if dynamic properties can be created.
     */
    protected static bool $extendableGuardProperties = true;

    /**
     * @var ClassLoader|null Class loader instance.
     */
    protected static ?ClassLoader $extendableClassLoader = null;

    /**
     * Constructor.
     */
    public function extendableConstruct(): void
    {
        // Apply init callbacks
        $classes = array_merge([$this::class], class_parents($this));
        foreach ($classes as $class) {
            if (isset(self::$extendableCallbacks[$class]) && is_array(self::$extendableCallbacks[$class])) {
                foreach (self::$extendableCallbacks[$class] as $callback) {
                    $callback($this);
                }
            }
        }

        // Apply extensions
        foreach (array_unique($this->implement) as $use) {
            $useClass = $this->extensionNormalizeClassName($use);

            // Soft implement
            if (str_starts_with((string)$useClass, '?')) {
                $useClass = substr((string)$useClass, 1);
                if (!class_exists($useClass)) {
                    continue;
                }
            }

            $this->extendClassWith($useClass);
        }
    }

    /**
     * Helper method for ::extend() static method
     */
    public static function extendableExtendCallback(callable $callback): void
    {
        $class = static::class;
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
     */
    public static function clearExtendedClasses(): void
    {
        self::$extendableCallbacks = [];
        self::$extendableStaticMethods = [];
    }

    /**
     * Normalizes the provided extension name allowing for the ClassLoader to inject aliased classes
     */
    protected function extensionNormalizeClassName(string $name): string
    {
        return str_replace('.', '\\', trim($name));
    }

    /**
     * Dynamically extend a class with a specified behavior
     */
    public function extendClassWith(string $extensionName): void
    {
        if (empty($extensionName)) {
            return;
        }

        $extensionName = $this->extensionNormalizeClassName($extensionName);

        if (isset($this->extensionData['extensions'][$extensionName])) {
            throw new LogicException(sprintf('Class %s has already been extended with %s', $this::class, $extensionName));
        }

        $this->extensionData['extensions'][$extensionName] = $extensionObject = new $extensionName($this);
        $this->extensionExtractMethods($extensionName, $extensionObject);
        $extensionObject->extensionApplyInitCallbacks();
    }

    /**
     * Extracts the available methods from a behavior and adds it to the
     * list of callable methods.
     */
    protected function extensionExtractMethods(string $extensionName, object $extensionObject): void
    {
        if (!method_exists($extensionObject, 'extensionIsHiddenMethod')) {
            throw new LogicException(sprintf(
                'Extension %s should implement Igniter\Flame\Traits\ExtensionTrait.',
                $extensionName,
            ));
        }

        $extensionMethods = get_class_methods($extensionName);
        foreach ($extensionMethods as $methodName) {
            if ($methodName === '__construct' || $methodName === '__remap'
                || $extensionObject->extensionIsHiddenMethod($methodName)
            ) {
                continue;
            }

            $this->extensionData['methods'][$methodName] = $extensionName;
        }
    }

    /**
     * Programmatically adds a method to the extendable class
     */
    public function addDynamicMethod(string $dynamicName, string|callable $method, ?string $extension = null): void
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
     * Programmatically adds a property to the extendable class
     */
    public function addDynamicProperty(string $dynamicName, mixed $value = null): void
    {
        if (array_key_exists($dynamicName, $this->getDynamicProperties())) {
            return;
        }

        self::$extendableGuardProperties = false;

        if (!property_exists($this, $dynamicName)) {
            $this->{$dynamicName} = $value;
        }

        $this->extensionData['dynamicProperties'][] = $dynamicName;

        self::$extendableGuardProperties = true;
    }

    /**
     * Check if extendable class is extended with a behavior object
     *
     * @param string $name Fully qualified behavior name
     */
    public function isClassExtendedWith(string $name): bool
    {
        $name = str_replace('.', '\\', trim($name));

        return isset($this->extensionData['extensions'][$name]);
    }

    /**
     * Returns a behavior object from an extendable class, example:
     *
     *   $this->getClassExtension('Admin.Actions.FormController')
     *
     * @param string $name Fully qualified behavior name
     */
    public function getClassExtension(string $name): mixed
    {
        return $this->extensionData['extensions'][$this->extensionNormalizeClassName($name)] ?? null;
    }

    public function asExtension(string $shortName): mixed
    {
        foreach ($this->extensionData['extensions'] as $class => $obj) {
            if (
                preg_match('@\\\\([\w]+)$@', (string)$class, $matches) &&
                $matches[1] === $shortName
            ) {
                return $obj;
            }
        }

        return $this->getClassExtension($shortName);
    }

    /**
     * Checks if a method exists, extension equivalent of method_exists()
     */
    public function methodExists(string $name): bool
    {
        return
            method_exists($this, $name) ||
            isset($this->extensionData['methods'][$name]) ||
            isset($this->extensionData['dynamicMethods'][$name]);
    }

    /**
     * Get a list of class methods, extension equivalent of get_class_methods()
     */
    public function getClassMethods(): array
    {
        return array_values(array_unique(array_merge(
            get_class_methods($this),
            array_keys($this->extensionData['methods']),
            array_keys($this->extensionData['dynamicMethods']),
        )));
    }

    /**
     * Returns all dynamic properties and their values
     * @return array ['property' => 'value']
     */
    public function getDynamicProperties(): array
    {
        $result = [];
        $propertyNames = $this->extensionData['dynamicProperties'];
        foreach ($propertyNames as $propName) {
            $result[$propName] = $this->{$propName};
        }

        return $result;
    }

    /**
     * Checks if a property exists, extension equivalent of property_exists()
     */
    public function propertyExists(string $name): bool
    {
        if (property_exists($this, $name)) {
            return true;
        }

        foreach ($this->extensionData['extensions'] as $extensionObject) {
            if (
                property_exists($extensionObject, $name) &&
                $this->extendableIsAccessible($extensionObject, $name)
            ) {
                return true;
            }
        }

        return array_key_exists($name, $this->getDynamicProperties());
    }

    /**
     * Checks if a property is accessible, property equivalent of is_callabe()
     */
    protected function extendableIsAccessible(string|object $class, string $propertyName): bool
    {
        $reflector = new ReflectionClass($class);
        $property = $reflector->getProperty($propertyName);

        return $property->isPublic();
    }

    /**
     * Magic method for __get()
     */
    public function extendableGet(string $name): mixed
    {
        foreach ($this->extensionData['extensions'] as $extensionObject) {
            if (
                property_exists($extensionObject, $name) &&
                $this->extendableIsAccessible($extensionObject, $name)
            ) {
                return $extensionObject->{$name};
            }
        }

        $parent = get_parent_class(self::class);
        if ($parent !== false && method_exists($parent, '__get')) {
            return parent::__get($name);
        }

        return null;
    }

    /**
     * Magic method for __set()
     */
    public function extendableSet(string $name, mixed $value): void
    {
        foreach ($this->extensionData['extensions'] as $extensionObject) {
            if (!property_exists($extensionObject, $name)) {
                continue;
            }

            $extensionObject->{$name} = $value;
        }

        // This targets trait usage in particular
        $parent = get_parent_class(self::class);
        if ($parent !== false && method_exists($parent, '__set')) {
            parent::__set($name, $value);
        }

        // Setting an undefined property
        if (!self::$extendableGuardProperties) {
            $this->{$name} = $value;
        }
    }

    /**
     * Magic method for __call()
     */
    public function extendableCall(string $name, ?array $params = null): mixed
    {
        if (isset($this->extensionData['methods'][$name])) {
            $extension = $this->extensionData['methods'][$name];
            $extensionObject = $this->extensionData['extensions'][$extension];

            if (method_exists($extension, $name)) {
                return call_user_func_array([$extensionObject, $name], array_values($params ?? []));
            }
        }

        if (isset($this->extensionData['dynamicMethods'][$name])) {
            $dynamicCallable = $this->extensionData['dynamicMethods'][$name];

            if (is_callable($dynamicCallable)) {
                return call_user_func_array($dynamicCallable, array_values($params ?? []));
            }
        }

        $parent = get_parent_class(self::class);
        if ($parent !== false && method_exists($parent, '__call')) {
            return parent::__call($name, $params);
        }

        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()',
            $this::class,
            $name,
        ));
    }

    /**
     * Magic method for __callStatic()
     */
    public static function extendableCallStatic(string $name, ?array $params = null): mixed
    {
        $className = static::class;

        if (!array_key_exists($className, self::$extendableStaticMethods)) {
            self::$extendableStaticMethods[$className] = [];

            $class = new ReflectionClass($className);
            $defaultProperties = $class->getDefaultProperties();
            if (
                array_key_exists('implement', $defaultProperties) &&
                ($implement = $defaultProperties['implement'])
            ) {
                // Apply extensions
                foreach ($implement as $use) {
                    // Class alias checks not required here as the current name of the extension class doesn't
                    // matter because as long as $useClassName is able to be instantiated the method will resolve
                    $useClassName = str_replace('.', '\\', trim((string)$use));
                    // Soft implement
                    if (str_starts_with($useClassName, '?')) {
                        $useClassName = substr($useClassName, 1);
                        if (!class_exists($useClassName)) {
                            continue;
                        }
                    }

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
                $result = forward_static_call_array([$extension, $name], $params ?? []);
                $extension::$extendableStaticCalledClass = null;

                return $result;
            }
        }

        $parent = get_parent_class(self::class);
        if ($parent !== false && method_exists($parent, '__callStatic')) {
            return parent::__callStatic($name, $params);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method %s::%s()', $className, $name));
    }
}
