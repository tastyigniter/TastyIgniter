<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Closure;

/**
 * Filter scope definition
 * A translation of the filter scope configuration
 *
 * Adapted from october\backend\classes\FilterScope
 */
class FilterScope
{
    /** A prefix to the field identifier so it can be unique. */
    public ?string $idPrefix = null;

    /** Column to display for the display name */
    public string $nameFrom = 'name';

    /** Column to display for the description (optional) */
    public ?string $descriptionFrom = null;

    /** Filter scope value. */
    public mixed $value = null;

    /** Filter mode. */
    public string $type = 'select';

    /** Filter options. */
    public null|string|array|Closure $options = null;

    /** Specifies contextual visibility of this form scope. */
    public null|string|array $context = null;

    /** Specify if the scope is disabled or not. */
    public bool $disabled = false;

    /** Specifies a default value for supported scopes. */
    public ?string $defaults = null;

    /** Raw SQL conditions to use when applying this scope. */
    public null|string|array $conditions = null;

    /** Model scope method to use when applying this filter scope. */
    public ?string $scope = null;

    /** Specifies a CSS class to attach to the scope container. */
    public ?string $cssClass = null;

    /** Filter scope mode. */
    public ?string $mode = null;

    public ?string $minDate = null;

    public ?string $maxDate = null;

    /** Raw scope configuration. */
    public array $config = [];

    public function __construct(public string $scopeName, public string $label) {}

    /**
     * Specifies a scope control rendering mode. Supported modes are:
     * - group - filter by a group of IDs. Default.
     * - checkbox - filter by a simple toggle switch.
     *
     * @param string $type Specifies a render mode as described above
     * @param array $config A list of render mode specific config.
     */
    public function displayAs(string $type, array $config = []): self
    {
        $this->type = strtolower($type) ?: $this->type;
        $this->config = $this->evalConfig($config);

        return $this;
    }

    /**
     * Process options and apply them to this object.
     */
    protected function evalConfig(array $config): array
    {
        if (isset($config['idPrefix'])) {
            $this->idPrefix = $config['idPrefix'];
        }

        if (isset($config['options'])) {
            $this->options = $config['options'];
        }

        if (isset($config['context'])) {
            $this->context = $config['context'];
        }

        if (isset($config['default'])) {
            $this->defaults = $config['default'];
        }

        if (isset($config['conditions'])) {
            $this->conditions = $config['conditions'];
        }

        if (isset($config['scope'])) {
            $this->scope = $config['scope'];
        }

        if (isset($config['cssClass'])) {
            $this->cssClass = $config['cssClass'];
        }

        if (isset($config['nameFrom'])) {
            $this->nameFrom = $config['nameFrom'];
        }

        if (isset($config['descriptionFrom'])) {
            $this->descriptionFrom = $config['descriptionFrom'];
        }

        if (array_key_exists('disabled', $config)) {
            $this->disabled = $config['disabled'];
        }

        if (isset($config['mode'])) {
            $this->mode = $config['mode'];
        }

        return $config;
    }

    /**
     * Returns a value suitable for the scope id property.
     */
    public function getId(?string $suffix = null): string
    {
        $id = 'scope';
        $id .= '-'.$this->scopeName;

        if ($suffix) {
            $id .= '-'.$suffix;
        }

        if ($this->idPrefix) {
            $id = $this->idPrefix.'-'.$id;
        }

        return name_to_id($id);
    }
}
