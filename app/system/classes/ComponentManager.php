<?php namespace System\Classes;

use SystemException;

/**
 * Components class for TastyIgniter.
 * Provides utility functions for working with components.
 */
class ComponentManager
{
    use \Igniter\Flame\Traits\Singleton;

    /**
     * @var array Cache of registration callbacks.
     */
    public $registry = [];

    /**
     * @var array Cache of registration components callbacks.
     */
    protected $componentsCallbacks = [];

    /**
     * @var array An array where keys are codes and values are class paths.
     */
    protected $codeMap = [];

    /**
     * @var array An array where keys are class paths and values are codes.
     */
    protected $classMap = [];

    /**
     * @var array An array containing references to a corresponding extension for each component class.
     */
    protected $extensionMap = [];

    /**
     * @var array A cached array of components component_meta.
     */
    protected $components = [];

    /**
     * Scans each extension and loads it components.
     * @return void
     */
    protected function loadComponents()
    {
        // Load manually registered components
        foreach ($this->componentsCallbacks as $callback) {
            $callback($this->instance);
        }

        // Load extensions components
        $extensions = ExtensionManager::instance()->getExtensions();
        foreach ($extensions as $name => $extension) {
            $components = $extension->registerComponents();
            if (!is_array($components)) {
                continue;
            }

            foreach ($components as $class_path => $component) {
                $this->registerComponent($class_path, $component, $extension);
            }
        }
    }

    /**
     * Manually registers a component.
     * Usage:
     * <pre>
     *   ComponentManager::instance()->registerComponents(function($manager){
     *       $manager->registerComponent('account_module/components/Account_module', array(
     *          'name' => 'account_module',
     *            'title' => 'Account Component',
     *            'description' => '..',
     *        );
     *   });
     * </pre>
     *
     * @param callable $definitions
     *
     * @return void
     */
    public function registerComponents(callable $definitions)
    {
        $this->componentsCallbacks[] = $definitions;
    }

    /**
     * Registers a single component.
     *
     * @param string $class_path
     * @param array $component
     * @param object $extension Extension
     */
    public function registerComponent($class_path, $component = null, $extension = null)
    {
        if (!$this->classMap) {
            $this->classMap = [];
        }

        if (!$this->codeMap) {
            $this->codeMap = [];
        }

        if (is_string($component))
            $component = ['code' => $component];

        $component = array_merge([
            'code' => null,
            'name' => 'Component',
            'description' => null,
        ], $component);

        $code = $component['code'] ?? strtolower(basename($class_path));

        $this->codeMap[$code] = $class_path;
        $this->classMap[$class_path] = $code;
        $this->components[$code] = array_merge($component, [
            'code' => $code,
            'path' => $class_path
        ]);

        if ($extension !== null) {
            $this->extensionMap[$class_path] = $extension;
        }
    }

    /**
     * Returns a list of registered components.
     * @return array Array keys are codes, values are component meta array.
     */
    public function listComponents()
    {
        if ($this->components == null) {
            $this->loadComponents();
        }

        return $this->components;
    }

    /**
     * Returns a class name from a component code
     * Normalizes a class name or converts an code to it's class name.
     *
     * @param string $name
     *
     * @return string The class name resolved, or null.
     */
    public function resolve($name)
    {
        $this->listComponents();

        if (isset($this->codeMap[$name])) {
            return $this->codeMap[$name];
        }

        $name = $this->convertCodeToPath($name);
        if (isset($this->classMap[$name])) {
            return $name;
        }

        return null;
    }

    /**
     * Checks to see if a component has been registered.
     *
     * @param string $name A component class name or alias.
     *
     * @return bool Returns true if the component is registered, otherwise false.
     */
    public function hasComponent($name)
    {
        $class_path = $this->resolve($name);
        if (!$class_path) {
            return FALSE;
        }

        return isset($this->classMap[$class_path]);
    }

    /**
     * Returns component details based on its name.
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function findComponent($name)
    {
        if (!$this->hasComponent($name)) {
            return null;
        }

        return $this->components[$name];
    }

    /**
     * Returns payment gateway details based on its name.
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function getMeta($name)
    {
        if (!$this->hasComponent($name)) {
            return null;
        }

        if (isset($this->components[$name])) {
            return $this->components[$name];
        }

//        if (isset($this->paymentGateways[$name])) {
//            return $this->paymentGateways[$name];
//        }

        return null;
    }

    /**
     * Makes a component/gateway object with properties set.
     *
     * @param string $name A component/gateway class name or code.
     * @param \Main\Template\Code\PageCode $page The page that spawned this component.
     * @param array $params The properties set by the Page or Layout.
     *
     * @return \System\Classes\BaseComponent The component object.
     * @throws \SystemException
     */
    public function makeComponent($name, $page = null, $params = [])
    {
        $className = $this->resolve($name);
        if (!$className)
            throw new SystemException(sprintf(
                'Component "%s" is not registered.', $name
            ));

        if (!class_exists($className))
            throw new SystemException(sprintf(
                'Component class "%s" not found.', $className
            ));

        // Create and register the new controller.
        $component = new $className($page, $params);
        $component->name = $name;

        return $component;
    }

    /**
     * Returns a parent extension for a specific component.
     *
     * @param mixed $component A component to find the extension for.
     *
     * @return mixed Returns the extension object or null.
     */
    public function findComponentExtension($component)
    {
        $class_path = $this->resolve($component);
        if (isset($this->extensionMap[$class_path])) {
            return $this->extensionMap[$class_path];
        }

        return null;
    }

    /**
     * Convert class alias to class path
     *
     * @param string $alias
     *
     * @return string
     */
    public function convertCodeToPath($alias)
    {
        if (strpos($alias, '/') === FALSE) {
            return $alias;
        }

        return $alias.'/components/'.ucfirst($alias);
    }

    //
    // Helpers
    //

    /**
     * Returns a component property configuration as a JSON string or array.
     *
     * @param mixed $component The component object
     * @param boolean $addAliasProperty Determines if the Alias property should be added to the result.
     *
     * @return array
     */
    public function getComponentPropertyConfig($component, $addAliasProperty = TRUE)
    {
        $result = [];

        if ($addAliasProperty) {
            $property = [
                'property' => 'alias',
                'label' => '',
                'type' => 'text',
                'comment' => '',
                'validationPattern' => '^[a-zA-Z]+[0-9a-z\_]*$',
                'validationMessage' => '',
                'required' => TRUE,
                'showExternalParam' => FALSE,
            ];
            $result['alias'] = $property;
        }

        $properties = $component->defineProperties();
        foreach ($properties as $name => $params) {
            $propertyType = array_get($params, 'type', 'text');

            if (!$this->checkComponentPropertyType($propertyType)) continue;

            $property = [
                'property' => $name,
                'label' => array_get($params, 'label', $name),
                'type' => $propertyType,
                'showExternalParam' => array_get($params, 'showExternalParam', FALSE),
            ];

            if (!in_array($propertyType, ['text', 'number']) AND !array_key_exists('options', $params)) {
                $methodName = 'get'.studly_case($name).'Options';
                $property['options'] = [get_class($component), $methodName];
            }

            foreach ($params as $paramName => $paramValue) {
                if (isset($property[$paramName])) continue;

                $property[$paramName] = $paramValue;
            }

            // Translate human values
            $translate = ['label', 'description', 'options', 'group', 'validationMessage'];
            foreach ($property as $propertyName => $propertyValue) {
                if (!in_array($propertyName, $translate)) continue;

                if (is_array($propertyValue)) {
                    array_walk($property[$propertyName], function (&$_propertyValue) {
                        $_propertyValue = lang($_propertyValue);
                    });
                }
                else {
                    $property[$propertyName] = lang($propertyValue);
                }
            }

            $result[$name] = $property;
        }

        return $result;
    }

    /**
     * Returns a component property values.
     *
     * @param mixed $component The component object
     *
     * @return array
     */
    public function getComponentPropertyValues($component)
    {
        $result = [];

        $result['alias'] = $component->alias;

        $properties = $component->defineProperties();
        foreach ($properties as $name => $params) {
            $result[$name] = $component->property($name);
        }

        return $result;
    }

    protected function checkComponentPropertyType($type)
    {
        return in_array($type, [
            'text',
            'number',
            'checkbox',
            'radio',
            'select',
            'selectlist',
            'switch',
        ]);
    }
}
