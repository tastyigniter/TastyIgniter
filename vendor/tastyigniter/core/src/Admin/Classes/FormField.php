<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Html\HtmlFacade as Html;
use Illuminate\Database\Eloquent\Model as IlluminateModel;

/**
 * Form Field definition
 * A translation of the form field configuration
 *
 * Adapted from october\backend\classes\FormField
 */
class FormField
{
    /** Value returned when the form field should not contribute any save data. */
    public const NO_SAVE_DATA = -1;

    /** If the field element names should be contained in an array. * Eg: <input name="nameArray[fieldName]" /> */
    public ?string $arrayName = null;

    /** A prefix to the field identifier so it can be totally unique. */
    public ?string $idPrefix = null;

    /** Form field value. */
    public mixed $value = null;

    /** Model attribute to use for the display value. */
    public ?string $valueFrom = null;

    /** Specifies a default value for supported fields. */
    public mixed $defaults = null;

    /** Model attribute to use for the default value. */
    public ?string $defaultFrom = null;

    /** Specifies if this field belongs to a tab. */
    public ?string $tab = null;

    /** Display mode. Text, textarea */
    public string $type = 'text';

    /** Field options. */
    public mixed $options = null;

    /** Specifies a side. Possible values: auto, left, right, full. */
    public string $span = 'full';

    /** Specifies a size. Possible values: tiny, small, large, huge, giant. */
    public string $size = 'large';

    /** Specifies contextual visibility of this form field. */
    public null|string|array $context = null;

    /** Specifies if this field is mandatory. */
    public bool $required = false;

    /** Specify if the field is read-only or not. */
    public bool $readOnly = false;

    /** Specify if the field is disabled or not. */
    public bool $disabled = false;

    /** Specify if the field is hidden. Hiddens fields are not included in postbacks. */
    public bool $hidden = false;

    /** Specifies if this field stretch to fit the page height. */
    public bool $stretch = false;

    /** Specifies a comment to accompany the field */
    public ?string $commentAbove = null;

    /** Specifies a comment to accompany the field */
    public ?string $comment = null;

    /** Specifies if the comment is in HTML format. */
    public bool $commentHtml = false;

    /** Specifies a message to display when there is no value supplied (placeholder). */
    public ?string $placeholder = null;

    /** Contains a list of attributes specified in the field configuration. */
    public array $attributes = [];

    /** Specifies a CSS class to attach to the field container. */
    public ?string $cssClass = null;

    /** Specifies a path for partial-type fields. */
    public ?string $path = null;

    /** Raw field configuration. */
    public array $config = [];

    /** Other field names this field depends on, when the other fields are modified, this field will update. */
    public array $dependsOn = [];

    /** Other field names this field can be triggered by, see the Trigger API documentation. */
    public array $trigger = [];

    /** Other field names text is converted in to a URL, slug or file name value in this field. */
    public string|array $preset = [];

    public function __construct(public ?string $fieldName, public ?string $label = null) {}

    /**
     * If this field belongs to a tab.
     */
    public function tab(string $value): self
    {
        $this->tab = $value;

        return $this;
    }

    /**
     * Sets a side of the field on a form.
     *
     * @param string $value Specifies a side. Possible values: left, right, full
     */
    public function span(string $value = 'full'): self
    {
        $this->span = $value;

        return $this;
    }

    /**
     * Sets a side of the field on a form.
     *
     * @param string $value Specifies a size. Possible values: tiny, small, large, huge, giant
     */
    public function size(string $value = 'large'): self
    {
        $this->size = $value;

        return $this;
    }

    /**
     * Sets field options, for dropdowns, radio lists and checkbox lists.
     */
    public function options(mixed $value = null): mixed
    {
        if ($value === null) {
            if (is_callable($this->options)) {
                $callable = $this->options;

                return $callable();
            }

            return is_array($this->options) ? $this->options : [];
        }

        $this->options = $value;

        return $this;
    }

    /**
     * Specifies a field control rendering mode. Supported modes are:
     * - text - creates a text field. Default for varchar column types.
     * - textarea - creates a textarea control. Default for text column types.
     * - select - creates a drop-down list. Default for reference-based columns.
     * - radio - creates a set of radio buttons.
     * - checkbox - creates a single checkbox.
     * - checkboxlist - creates a checkbox list.
     * - radiolist - creates a radio list.
     *
     * @param ?string $type Specifies a render mode as described above
     * @param array $config A list of render mode specific config.
     */
    public function displayAs(?string $type, array $config = []): self
    {
        $this->type = strtolower($type ?: $this->type);
        $this->config = $this->evalConfig($config);

        return $this;
    }

    /**
     * Process options and apply them to this object.
     */
    protected function evalConfig(array $config): array
    {
        /*
         * Standard config:property values
         */
        $applyConfigValues = [
            'commentHtml',
            'placeholder',
            'dependsOn',
            'required',
            'disabled',
            'readOnly',
            'cssClass',
            'stretch',
            'context',
            'hidden',
            'trigger',
            'preset',
            'path',
        ];

        foreach ($applyConfigValues as $value) {
            if (array_key_exists($value, $config)) {
                $this->{$value} = $config[$value];
            }
        }

        /*
         * Custom applicators
         */
        if (isset($config['options'])) {
            $this->options($config['options']);
        }

        if (isset($config['span'])) {
            $this->span($config['span']);
        }

        if (isset($config['size'])) {
            $this->size($config['size']);
        }

        if (isset($config['tab'])) {
            $this->tab($config['tab']);
        }

        if (isset($config['commentAbove'])) {
            $this->commentAbove = $config['commentAbove'];
        }

        if (isset($config['comment'])) {
            $this->comment = $config['comment'];
        }

        if (isset($config['default'])) {
            $this->defaults = $config['default'];
        }

        if (isset($config['defaultFrom'])) {
            $this->defaultFrom = $config['defaultFrom'];
        }

        if (isset($config['attributes'])) {
            $this->attributes($config['attributes']);
        }

        if (isset($config['containerAttributes'])) {
            $this->attributes($config['containerAttributes'], 'container');
        }

        $this->valueFrom = $config['valueFrom'] ?? $this->fieldName;

        return $config;
    }

    /**
     * Sets the attributes for this field in a given position.
     * - field: Attributes are added to the form field element (input, select, textarea, etc)
     * - container: Attributes are added to the form field container (div.form-group)
     */
    public function attributes(array $items, string $position = 'field'): self
    {
        $multiArray = array_filter($items, 'is_array');
        if (empty($multiArray)) {
            $this->attributes[$position] = $items;

            return $this;
        }

        foreach ($items as $_position => $_items) {
            $this->attributes($_items, $_position);
        }

        return $this;
    }

    /**
     * Checks if the field has the supplied [unfiltered] attribute.
     */
    public function hasAttribute(string $name, string $position = 'field'): bool
    {
        if (!isset($this->attributes[$position])) {
            return false;
        }

        return array_key_exists($name, $this->attributes[$position]);
    }

    /**
     * Returns the attributes for this field at a given position.
     */
    public function getAttributes(string $position = 'field', bool $htmlBuild = true): string|array
    {
        $result = array_get($this->attributes, $position, []);
        $result = $this->filterAttributes($result, $position);

        return $htmlBuild ? Html::attributes($result) : $result;
    }

    /**
     * Adds any circumstantial attributes to the field based on other
     * settings, such as the 'disabled' option.
     */
    protected function filterAttributes(array $attributes, string $position = 'field'): array
    {
        $position = strtolower($position);

        $attributes = $this->filterTriggerAttributes($attributes, $position);
        $attributes = $this->filterPresetAttributes($attributes, $position);

        if ($position === 'field' && $this->disabled) {
            $attributes += ['disabled' => 'disabled'];
        }

        if ($position === 'field' && $this->readOnly) {
            $attributes += ['readonly' => 'readonly'];

            if ($this->type === 'checkbox' || $this->type === 'switch') {
                $attributes += ['onclick' => 'return false;'];
            }
        }

        return $attributes;
    }

    /**
     * Adds attributes used specifically by the Trigger API
     */
    protected function filterTriggerAttributes(array $attributes, string $position = 'field'): array
    {
        if (!$this->trigger) {
            return $attributes;
        }

        $triggerAction = array_get($this->trigger, 'action');
        $triggerField = array_get($this->trigger, 'field');
        $triggerCondition = array_get($this->trigger, 'condition');

        // Apply these to container
        if (in_array($triggerAction, ['hide', 'show']) && $position === 'field') {
            return $attributes;
        }

        // Apply these to field/input
        if (in_array($triggerAction, ['enable', 'disable', 'empty']) && $position === 'container') {
            return $attributes;
        }

        if ($this->arrayName) {
            $fullTriggerField = $this->arrayName.'['.implode('][', name_to_array($triggerField)).']';
        } else {
            $fullTriggerField = $triggerField;
        }

        $newAttributes = [
            'data-trigger' => "[name='".trim((string)$fullTriggerField)."']",
            'data-trigger-action' => $triggerAction,
            'data-trigger-condition' => $triggerCondition,
            'data-trigger-closest-parent' => 'form',
        ];

        return $attributes + $newAttributes;
    }

    /**
     * Adds attributes used specifically by the Input Preset API
     */
    protected function filterPresetAttributes(array $attributes, string $position = 'field'): array
    {
        if (!$this->preset || $position !== 'field') {
            return $attributes;
        }

        if (!is_array($this->preset)) {
            $this->preset = ['field' => $this->preset, 'type' => 'slug'];
        }

        $presetField = array_get($this->preset, 'field');
        $presetType = array_get($this->preset, 'type');

        if ($this->arrayName) {
            $fullPresetField = $this->arrayName.'['.implode('][', name_to_array($presetField)).']';
        } else {
            $fullPresetField = $presetField;
        }

        $newAttributes = [
            'data-input-preset' => '[name="'.$fullPresetField.'"]',
            'data-input-preset-type' => $presetType,
            'data-input-preset-closest-parent' => 'form',
        ];

        if ($prefixInput = array_get($this->preset, 'prefixInput')) {
            $newAttributes['data-input-preset-prefix-input'] = $prefixInput;
        }

        return $attributes + $newAttributes;
    }

    /**
     * Returns a value suitable for the field name property.
     */
    public function getName(null|false|string $arrayName = null): string
    {
        if ($arrayName === null) {
            $arrayName = $this->arrayName;
        }

        if ($arrayName) {
            return $arrayName.'['.implode('][', name_to_array($this->fieldName)).']';
        }

        return $this->fieldName;
    }

    /**
     * Returns a value suitable for the field id property.
     */
    public function getId(?string $suffix = null): string
    {
        $id = 'field';
        if ($this->arrayName) {
            $id .= '-'.$this->arrayName;
        }

        $id .= '-'.$this->fieldName;

        if ($suffix) {
            $id .= '-'.$suffix;
        }

        if ($this->idPrefix) {
            $id = $this->idPrefix.'-'.$id;
        }

        return strtolower(name_to_id($id));
    }

    /**
     * Returns a raw config item value.
     */
    public function getConfig(string $value, mixed $default = null): mixed
    {
        return array_get($this->config, $value, $default);
    }

    /**
     * Returns this fields value from a supplied data set, which can be
     * an array or a model or another generic collection.
     */
    public function getValueFromData(mixed $data, mixed $default = null): mixed
    {
        $fieldName = $this->valueFrom ?: $this->fieldName;

        return $this->getFieldNameFromData($fieldName, $data, $default);
    }

    /**
     * Returns the default value for this field, the supplied data is used
     * to source data when defaultFrom is specified.
     */
    public function getDefaultFromData(mixed $data): mixed
    {
        if ($this->defaultFrom) {
            return $this->getFieldNameFromData($this->defaultFrom, $data);
        }

        if (!is_null($this->defaults) && $this->defaults !== '') {
            return $this->defaults;
        }

        return null;
    }

    /**
     * Returns the final model and attribute name of a nested attribute.
     * Eg: list($model, $attribute) = $this->resolveAttribute('person[phone]');
     */
    public function resolveModelAttribute(Model|IlluminateModel $model, null|string|array $attribute = null): array
    {
        if ($attribute === null) {
            $attribute = $this->valueFrom ?: $this->fieldName;
        }

        $parts = is_array($attribute) ? $attribute : name_to_array($attribute);
        $last = array_pop($parts);

        foreach ($parts as $part) {
            $model = $model->{$part};
        }

        return [$model, $last];
    }

    /**
     * Internal method to extract the value of a field name from a data set.
     */
    protected function getFieldNameFromData(string $fieldName, mixed $data, mixed $default = null): mixed
    {
        // Array field name, eg: field[key][key2][key3]
        $keyParts = name_to_array($fieldName);
        $lastField = end($keyParts);
        $result = $data;

        // Loop the field key parts and build a value
        // To support relations only the last field should return th
        // relation value, all others will look up the relation object as normal.
        foreach ($keyParts as $key) {
            if ($result instanceof Model && $result->hasRelation($key)) {
                if ($key == $lastField) {
                    $result = $result->getRelationValue($key) ?: $default;
                } else {
                    $result = $result->{$key};
                }
            } elseif (is_array($result)) {
                if (!array_key_exists($key, $result)) {
                    return $default;
                }

                $result = $result[$key];
            } else {
                if (!isset($result->{$key})) {
                    return $default;
                }

                $result = $result->{$key};
            }
        }

        return $result;
    }
}
