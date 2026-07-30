<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Pagic\TemplateCode;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component as BladeComponent;
use Livewire\Component as LivewireComponent;
use Livewire\Livewire;

/**
 * Components class for TastyIgniter.
 * Provides utility functions for working with components.
 */
class ComponentManager
{
    public const array ALLOWED_PROPERTY_TYPES = [
        'text',
        'textarea',
        'number',
        'checkbox',
        'radio',
        'select',
        'selectlist',
        'switch',
    ];

    /** Cache of registration components callbacks. */
    protected array $componentsCallbacks = [];

    /** An array where keys are codes and values are class paths. */
    protected array $codeMap = [];

    /** An array where keys are class paths and values are codes. */
    protected array $classMap = [];

    /** A cached array of components component_meta. */
    protected ?array $components = null;

    protected ?array $componentObjects = null;

    public function bootComponents(): void
    {
        if ($this->components === null) {
            $this->loadComponents();
        }
    }

    public function listComponentObjects(): ?array
    {
        if ($this->componentObjects) {
            return $this->componentObjects;
        }

        foreach ($this->listComponents() as $code => $definition) {
            $definition['component'] = $this->makeComponent($code);

            $this->componentObjects[$code] = (object)$definition;
        }

        return $this->componentObjects;
    }

    /**
     * Scans each extension and loads it components.
     */
    protected function loadComponents(): ?array
    {
        $this->components = [];

        // Load manually registered components
        foreach ($this->componentsCallbacks as $callback) {
            $callback($this);
        }

        // Load extensions components
        $extensions = resolve(ExtensionManager::class)->getRegistrationMethodValues('registerComponents');
        foreach ($extensions as $components) {
            $this->registerComponents($components);
        }

        return $this->components;
    }

    /**
     * Manually registers a component.
     * Usage:
     * <pre>
     *   resolve(ComponentManager::class)->registerComponents(function($manager){
     *       $manager->registerComponent('account_module/components/Account_module', array(
     *          'name' => 'account_module',
     *            'title' => 'Account Component',
     *            'description' => '..',
     *        );
     *   });
     * </pre>
     */
    public function registerCallback(callable $definitions): void
    {
        $this->componentsCallbacks[] = $definitions;
    }

    public function registerComponents(array $components): void
    {
        foreach ($components as $className => $definition) {
            if (!is_string($className)) {
                $className = $definition;
                $definition = method_exists($className, 'componentMeta')
                    ? $className::componentMeta()
                    : [];
            }

            $this->registerComponent($className, $definition);
        }
    }

    /**
     * Registers a single component.
     */
    public function registerComponent(string $className, null|string|array $definition = null): void
    {
        if (!$this->classMap) {
            $this->classMap = [];
        }

        if (!$this->codeMap) {
            $this->codeMap = [];
        }

        if (is_string($definition)) {
            $definition = ['code' => $definition];
        }

        $code = $definition['code'] ?? strtolower(basename($className));

        $definition = array_merge([
            'code' => $code,
            'name' => 'Component',
            'description' => null,
            'path' => $className,
        ], $definition ?? []);

        $this->codeMap[$code] = $className;
        $this->classMap[$className] = $code;
        $this->components[$code] = $definition;

        if (is_subclass_of($className, LivewireComponent::class)) {
            Livewire::component($code, $className);
        } elseif (is_subclass_of($className, BladeComponent::class)) {
            Blade::component($code, $className);
        }
    }

    /**
     * Returns a list of registered components.
     */
    public function listComponents(): ?array
    {
        return $this->components ?? $this->loadComponents();
    }

    /**
     * Returns a class name from a component code
     * Normalizes a class name or converts an code to it's class name.
     */
    public function resolve(string $name): ?string
    {
        $this->listComponents();

        return $this->codeMap[$name] ?? null;
    }

    /**
     * Checks to see if a component has been registered.
     */
    public function hasComponent(string $name): bool
    {
        $class_path = $this->resolve($name);
        if (!$class_path) {
            return false;
        }

        return isset($this->classMap[$class_path]);
    }

    /**
     * Returns component details based on its name.
     */
    public function findComponent(string $name): ?array
    {
        if (!$this->hasComponent($name)) {
            return null;
        }

        return $this->components[$name];
    }

    public function findComponentCodeByClass(string $className)
    {
        return $this->classMap[$className] ?? null;
    }

    /**
     * Makes a component/gateway object with properties set.
     */
    public function makeComponent(
        string|array $name,
        ?TemplateCode $page = null,
        array $params = [],
    ): BaseComponent|LivewireComponent|BladeComponent {
        if (is_array($name)) {
            $alias = $name[1];
            $name = $name[0];
        } else {
            $alias = $name;
        }

        $className = $this->resolve($name);
        if (!$className) {
            throw new SystemException(sprintf('Component "%s" is not registered.', $name));
        }

        if (!class_exists($className)) {
            throw new SystemException(sprintf('Component class "%s" not found.', $className));
        }

        if (in_array(ConfigurableComponent::class, class_uses_recursive($className))) {
            $component = $className::resolve($params);
        } elseif (is_subclass_of($className, BaseComponent::class)) {
            $component = $className::resolve($name, $page, $params);
        } else {
            throw new SystemException(sprintf('Component class "%s" is not a valid component.', $className));
        }

        $component->setAlias($alias);

        return $component;
    }

    //
    // Helpers
    //

    public function isConfigurableComponent(string $name): bool
    {
        if (!$className = $this->resolve($name)) {
            return false;
        }

        return in_array(ConfigurableComponent::class, class_uses_recursive($className));
    }

    public function getCodeAlias(string $name): array
    {
        if (strpos($name, ' ')) {
            return explode(' ', $name);
        }

        return [$name, $name];
    }

    /**
     * Returns a component property configuration as a JSON string or array.
     */
    public function getComponentPropertyConfig(
        BaseComponent|LivewireComponent|BladeComponent $component,
        bool $addAliasProperty = true,
    ): array {
        $result = [];

        if ($addAliasProperty) {
            $result['alias'] = [
                'property' => 'alias',
                'label' => '',
                'type' => 'text',
                'comment' => '',
                'validationRule' => ['required', 'regex:^[a-zA-Z]+$'],
                'validationMessage' => '',
                'required' => true,
                'showExternalParam' => false,
            ];
        }

        $properties = $component->defineProperties();
        foreach ($properties as $name => $config) {
            $propertyType = array_get($config, 'type', 'text');

            if (!$this->checkComponentPropertyType($propertyType)) {
                continue;
            }

            $property = [
                'property' => $name,
                'label' => array_get($config, 'label', $name),
                'type' => $propertyType,
                'showExternalParam' => array_get($config, 'showExternalParam', false),
            ];

            if (in_array($property['type'], ['checkbox', 'radio', 'select', 'selectlist']) && !array_key_exists('options', $config)) {
                $methodName = 'get'.studly_case($name).'Options';
                $methodName = method_exists($component, $methodName) ? $methodName : 'getPropertyOptions';
                $property['options'] = [$component::class, $methodName];
            }

            $property += $config;

            // Translate human values
            $translate = ['label', 'description', 'options', 'group', 'validationMessage'];
            foreach ($property as $propertyName => $propertyValue) {
                if (!in_array($propertyName, $translate, true)) {
                    continue;
                }

                if (is_array($propertyValue)) {
                    array_walk($property[$propertyName], function(&$_propertyValue) {
                        $_propertyValue = lang($_propertyValue);
                    });
                } else {
                    $property[$propertyName] = is_string($propertyValue) ? lang($propertyValue) : $propertyValue;
                }
            }

            $result[$name] = $property;
        }

        return $result;
    }

    /**
     * Returns a component property values.
     */
    public function getComponentPropertyValues(BaseComponent|LivewireComponent|BladeComponent $component): array
    {
        $result = [];

        $result['alias'] = $component->getAlias();

        $properties = $component->defineProperties();
        foreach (array_keys($properties) as $name) {
            $result[$name] = $component->property($name);
        }

        return $result;
    }

    public function getComponentPropertyRules(BaseComponent|LivewireComponent|BladeComponent $component): array
    {
        $properties = $component->defineProperties();
        $rules = [];
        $attributes = [];
        foreach ($properties as $name => $params) {
            if (strlen((string)($rule = array_get($params, 'validationRule', ''))) !== 0) {
                $rules[$name] = $rule;
                $attributes[$name] = array_get($params, 'label', $name);
            }
        }

        return [$rules, $attributes];
    }

    protected function checkComponentPropertyType(string $type): bool
    {
        return in_array($type, self::ALLOWED_PROPERTY_TYPES, true);
    }
}
