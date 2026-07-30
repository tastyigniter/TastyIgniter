<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Igniter\Flame\Html\HtmlFacade as Html;

/**
 * Toolbar Button definition
 */
class ToolbarButton
{
    /** Display mode. Link, Button or Dropdown */
    public string $type = 'link';

    public ?string $label = null;

    public null|string|array $context = null;

    public null|string|array $permission = null;

    public ?bool $disabled = null;

    public ?string $cssClass = null;

    public array $config = [];

    protected ?array $menuItems = null;

    /**
     * Constructor.
     */
    public function __construct(public string $name) {}

    /**
     * Specifies a Toolbar button rendering mode. Supported modes are:
     * - text - text column, aligned left
     * - number - numeric column, aligned right
     *
     * @param string $type Specifies a render mode as described above
     */
    public function displayAs(string $type, array $config): static
    {
        $this->type = strtolower($type) ?: $this->type;
        $this->config = $this->evalConfig($config);

        return $this;
    }

    /**
     * Returns the attributes for this item.
     */
    public function getAttributes(bool $htmlBuild = true): array|string
    {
        $config = array_except($this->config, [
            'label', 'context', 'permission', 'partial',
        ]);

        $attributes = [];
        foreach ($config as $key => $value) {
            if (!is_string($value)) {
                continue;
            }

            $value = ($key == 'href' && !preg_match('#^(\w+:)?//#i', $value))
                ? admin_url($value)
                : $value;

            $attributes[$key] = is_lang_key($value) ? lang($value) : $value;
        }

        if ($this->disabled) {
            $attributes['disabled'] = 'disabled';
        }

        return $htmlBuild ? Html::attributes($attributes) : $attributes;
    }

    public function menuItems(?array $value = null): self|array
    {
        if (is_null($value)) {
            return $this->menuItems ?? [];
        }

        $this->menuItems = $value;

        return $this;
    }

    protected function evalConfig(array $config): array
    {
        $applyConfigValues = [
            'context',
            'disabled',
            'permission',
        ];

        foreach ($applyConfigValues as $value) {
            if (array_key_exists($value, $config)) {
                $this->{$value} = $config[$value];
            }
        }

        if (isset($config['label'])) {
            $this->label = lang($config['label']);
        }

        if (isset($config['class'])) {
            $this->cssClass = lang($config['class']);
        }

        return $config;
    }
}
