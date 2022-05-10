<?php

namespace Admin\Classes;

use Igniter\Flame\Html\HtmlFacade as Html;

/**
 * Toolbar Button definition
 */
class ToolbarButton
{
    /**
     * @var string Toolbar button name.
     */
    public $name;

    /**
     * @var string Display mode. Link, Button or Dropdown
     */
    public $type = 'link';

    public $label;

    public $context;

    public $permission;

    public $disabled;

    /**
     * @var mixed|string|null
     */
    public $cssClass;

    /**
     * @var array Raw field configuration.
     */
    public $config;

    protected $menuItems;

    /**
     * Constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Specifies a Toolbar button rendering mode. Supported modes are:
     * - text - text column, aligned left
     * - number - numeric column, aligned right
     *
     * @param string $type Specifies a render mode as described above
     * @param $config
     *
     * @return $this
     */
    public function displayAs($type, $config)
    {
        $this->type = strtolower($type) ?: $this->type;
        $this->config = $this->evalConfig($config);

        return $this;
    }

    /**
     * Returns the attributes for this item.
     **
     *
     * @param bool $htmlBuild
     *
     * @return array|string
     */
    public function getAttributes($htmlBuild = true)
    {
        $config = array_except($this->config, [
            'label', 'context', 'permission', 'partial',
        ]);

        $attributes = [];
        foreach ($config as $key => $value) {
            if (!is_string($value)) continue;

            $value = ($key == 'href' && !preg_match('#^(\w+:)?//#i', $value))
                ? admin_url($value)
                : $value;

            $attributes[$key] = is_lang_key($value) ? lang($value) : $value;
        }

        if ($this->disabled)
            $attributes['disabled'] = 'disabled';

        return $htmlBuild ? Html::attributes($attributes) : $attributes;
    }

    public function menuItems($value = null)
    {
        if (is_null($value)) {
            return $this->menuItems ?? [];
        }
        else {
            $this->menuItems = $value;
        }

        return $this;
    }

    protected function evalConfig($config)
    {
        if (is_null($config)) {
            $config = [];
        }

        $applyConfigValues = [
            'context',
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
