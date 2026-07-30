<?php

declare(strict_types=1);

namespace Igniter\System\Traits;

use Illuminate\Support\Collection;

trait PropertyContainer
{
    /** Holds the component layout settings array. */
    protected array $properties = [];

    /**
     * Validates the properties against the defined properties of the class.
     * This method also sets default properties.
     *
     * @param array $properties The supplied property values.
     *
     * @return array The validated property set, with defaults applied.
     */
    public function validateProperties(array $properties): array
    {
        $definedProperties = [];
        foreach ($this->defineProperties() as $name => $information) {
            if (array_key_exists('default', $information)) {
                $definedProperties[$name] = $information['default'];
            }
        }

        return array_merge($definedProperties, $properties);
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties(): array
    {
        return [];
    }

    /**
     * Sets multiple properties.
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $this->validateProperties($properties);
    }

    /**
     * Merge multiple properties.
     */
    public function mergeProperties(array $properties): void
    {
        $this->properties = array_merge($this->properties, $this->validateProperties($properties));
    }

    /**
     * Sets a property value
     */
    public function setProperty(string $name, mixed $value): void
    {
        $this->properties[$name] = $value;
    }

    /**
     * Returns all properties.
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Returns a defined property value or default if one is not set.
     */
    public function property(string $name, mixed $default = null): mixed
    {
        return array_key_exists($name, $this->properties)
            ? $this->properties[$name]
            : $default;
    }

    /**
     * Returns options for multi-option properties (drop-downs, etc.)
     *
     * @param string $form
     * @param string $field
     *
     * @return array|Collection Return an array of option values and descriptions
     */
    public static function getPropertyOptions($form, $field): array|Collection
    {
        return [];
    }
}
