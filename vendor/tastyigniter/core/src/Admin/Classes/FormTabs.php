<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Override;
use Traversable;

/**
 * Form Tabs definition
 * A translation of the form field tab configuration
 *
 * Adapted from october\backend\class\FormTabs
 */
class FormTabs implements ArrayAccess, IteratorAggregate
{
    public const SECTION_OUTSIDE = 'outside';

    public const SECTION_PRIMARY = 'primary';

    /** Collection of panes fields to these tabs. */
    public array $fields = [];

    /** Default tab label to use when none is specified. */
    public string $defaultTab = 'igniter::admin.form.undefined_tab';

    /** Should these tabs stretch to the bottom of the page layout. */
    public ?bool $stretch = null;

    /** If set to TRUE, fields will not be displayed in tabs. */
    public bool $suppressTabs = false;

    /** Specifies a CSS class to attach to the tab container. */
    public ?string $cssClass = null;

    /**
     * Constructor.
     * Specifies a tabs rendering section. Supported sections are:
     * - outside - stores a section of "tabless" fields.
     * - primary - tabs section for primary fields.
     * - secondary - tabs section for secondary fields.
     *
     * @param string $section Specifies a section as described above.
     * @param array $config A list of render mode specific config.
     */
    public function __construct(public string $section = 'outside', public array $config = [])
    {
        $this->section = strtolower($section) ?: $this->section;
        $this->config = $this->evalConfig($config);

        if ($this->section === self::SECTION_OUTSIDE) {
            $this->suppressTabs = true;
        }
    }

    /**
     * Process options and apply them to this object.
     */
    protected function evalConfig(array $config): array
    {
        if (array_key_exists('defaultTab', $config)) {
            $this->defaultTab = $config['defaultTab'];
        }

        if (array_key_exists('stretch', $config)) {
            $this->stretch = $config['stretch'];
        }

        if (array_key_exists('suppressTabs', $config)) {
            $this->suppressTabs = $config['suppressTabs'];
        }

        if (array_key_exists('cssClass', $config)) {
            $this->cssClass = $config['cssClass'];
        }

        return $config;
    }

    /**
     * Add a field to the collection of tabs.
     */
    public function addField(string $name, FormField $field, ?string $tab = null): void
    {
        if (!$tab) {
            $tab = $this->defaultTab;
        }

        $this->fields[$tab][$name] = $field;
    }

    /**
     * Remove a field from all tabs by name.
     */
    public function removeField(string $name): bool
    {
        foreach ($this->fields as $tab => $fields) {
            foreach ($fields as $fieldName => $field) {
                if ($fieldName == $name) {
                    unset($this->fields[$tab][$fieldName]);

                    if (count($this->fields[$tab]) === 0) {
                        unset($this->fields[$tab]);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns true if any fields have been registered for these tabs
     */
    public function hasFields(): bool
    {
        return $this->fields !== [];
    }

    /**
     * Returns an array of the registered fields, including tabs.
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Returns an array of the registered fields, without tabs.
     */
    public function getAllFields(): array
    {
        $tablessFields = [];

        foreach ($this->getFields() as $tab) {
            $tablessFields += $tab;
        }

        return $tablessFields;
    }

    /**
     * Get an iterator for the items.
     */
    #[Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->suppressTabs
            ? $this->getAllFields()
            : $this->getFields(),
        );
    }

    /**
     * ArrayAccess implementation
     */
    #[Override]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->fields[$offset] = $value;
    }

    /**
     * ArrayAccess implementation
     */
    #[Override]
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->fields[$offset]);
    }

    /**
     * ArrayAccess implementation
     */
    #[Override]
    public function offsetUnset(mixed $offset): void
    {
        unset($this->fields[$offset]);
    }

    /**
     * ArrayAccess implementation
     *
     * @return mixed|null
     */
    #[Override]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->fields[$offset] ?? null;
    }
}
