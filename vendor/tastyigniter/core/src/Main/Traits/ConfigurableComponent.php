<?php

declare(strict_types=1);

namespace Igniter\Main\Traits;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\SystemException;
use Igniter\System\Classes\ComponentManager;
use Illuminate\Support\Collection;
use Livewire\Component as LivewireComponent;
use Livewire\Livewire;
use LogicException;

trait ConfigurableComponent
{
    public ?string $alias = null;

    public bool $isHidden = false;

    public static function componentMeta(): array
    {
        throw new LogicException('Method componentMeta() must be implemented in the extended class: '.static::class);
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties(): array
    {
        return [];
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias(string $alias)
    {
        $this->alias = $alias;

        return $this;
    }

    public function isHidden()
    {
        return $this->isHidden;
    }

    public function validateProperties(array $properties): array
    {
        $defaultProperties = $this->all();

        $definedProperties = [];
        foreach ($this->defineProperties() as $name => $information) {
            if (array_key_exists($name, $defaultProperties)) {
                $definedProperties[$name] = $defaultProperties[$name];
            }
        }

        return array_merge($definedProperties, $properties);
    }

    /**
     * Returns a defined property value or default if one is not set.
     */
    public function property(string $name, mixed $default = null): mixed
    {
        return $this->$name ?? $default;
    }

    /**
     * Returns options for multi-option properties (drop-downs, etc.)
     *
     * @return array|Collection Return an array of option values and descriptions
     */
    public static function getPropertyOptions(Form $form, FormField $field): array|Collection
    {
        return [];
    }

    //
    //
    //

    public static function resolve($data)
    {
        // When loading a Livewire component from the template editor
        if (is_subclass_of(static::class, LivewireComponent::class)) {
            $component = Livewire::new(static::class);
            $component->fill($component->validateProperties($data));

            return $component;
        }

        if (!$componentName = resolve(ComponentManager::class)->findComponentCodeByClass(static::class)) {
            throw new SystemException(sprintf('Component "%s" is not registered.', static::class));
        }

        $attributes = controller()->getConfiguredComponent($componentName);

        return parent::resolve(array_merge($attributes, $data));
    }
}
