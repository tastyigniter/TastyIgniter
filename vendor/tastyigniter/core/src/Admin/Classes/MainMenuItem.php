<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Igniter\Flame\Html\HtmlFacade as Html;

/**
 * Menu item definition
 * A translation of the menu item configuration
 */
class MainMenuItem
{
    protected const LINK_TYPE = 'link';

    protected const TEXT_TYPE = 'text';

    protected const DROPDOWN_TYPE = 'dropdown';

    protected const PARTIAL_TYPE = 'partial';

    protected const WIDGET_TYPE = 'widget';

    /**
     * @var ?string A prefix to the field identifier so it can be totally unique.
     */
    public ?string $idPrefix = null;

    /**
     * @var ?string Menu item anchor.
     */
    public ?string $anchor = null;

    /**
     * @var string Menu item type.
     */
    public string $type = 'link';

    /**
     * @var mixed Menu dropdown menu options.
     */
    public mixed $options = null;

    /**
     * @var null|string|array Specifies contextual visibility of this menu item.
     */
    public null|string|array $context = null;

    /**
     * @var bool Specify if the item is disabled or not.
     */
    public bool $disabled = false;

    public ?string $icon = null;

    /**
     * @var ?string Specifies a path for partial-type fields.
     */
    public ?string $path = null;

    /**
     * @var array Contains a list of attributes specified in the item configuration.
     */
    public array $attributes = [];

    /**
     * @var null|string|array Specifies a CSS class to attach to the item container.
     */
    public null|string|array $cssClass = null;

    public int $priority = 0;

    public null|string|array $permission = null;

    public array $config = [];

    final public function __construct(
        /**
         * @var ?string Item name.
         */
        public ?string $itemName,
        /**
         * @var ?string Menu item label.
         */
        public ?string $label = null
    ) {}

    public static function make(string $name, ?string $type = null, array $config = []): static
    {
        $instance = new static($name);
        $instance->displayAs($type, $config);

        return $instance;
    }

    public static function dropdown(string $name): self
    {
        return static::make($name, static::DROPDOWN_TYPE);
    }

    public static function link(string $name): static
    {
        return static::make($name, static::LINK_TYPE);
    }

    public static function partial(string $name, ?string $path = null): MainMenuItem
    {
        return static::make($name, static::PARTIAL_TYPE)->path($path);
    }

    public static function widget(string $name, string $class): static
    {
        return static::make($name, static::WIDGET_TYPE, ['widget' => $class]);
    }

    /**
     * Sets item options, for dropdowns.
     *
     * @return self|array
     */
    public function options($value = null)
    {
        if ($value === null) {
            if (is_array($this->options)) {
                return $this->options;
            }

            if (is_callable($this->options)) {
                $callable = $this->options;

                return $callable();
            }

            return [];
        }

        $this->options = $value;

        return $this;
    }

    /**
     * Specifies a item control rendering mode. Supported modes are:
     * - group - menu by a group of IDs. Default.
     * - checkbox - menu by a simple toggle switch.
     *
     * @param string $type Specifies a render mode as described above
     * @param array $config A list of render mode specific config.
     */
    public function displayAs($type, array $config = []): static
    {
        $this->type = $type ?? $this->type;
        $this->config = $this->evalConfig($config);

        return $this;
    }

    /**
     * Process options and apply them to this object.
     */
    protected function evalConfig(array $config): array
    {
        if (isset($config['priority'])) {
            $this->priority = $config['priority'];
        }

        if (isset($config['anchor'])) {
            $this->anchor = $config['anchor'];
        }

        if (isset($config['options'])) {
            $this->options = $config['options'];
        }

        if (isset($config['context'])) {
            $this->context = $config['context'];
        }

        if (isset($config['icon'])) {
            $this->icon = $config['icon'];
        }

        if (isset($config['path'])) {
            $this->path = $config['path'];
        }

        if (isset($config['cssClass'])) {
            $this->cssClass = $config['cssClass'];
        }

        if (isset($config['attributes'])) {
            $this->attributes($config['attributes']);
        }

        if (array_key_exists('disabled', $config)) {
            $this->disabled = $config['disabled'];
        }

        return $config;
    }

    /**
     * Returns the attributes for this item.
     *
     * @param bool $htmlBuild
     *
     * @return array|string
     */
    public function getAttributes($htmlBuild = true)
    {
        $attributes = $this->attributes;

        if ($this->disabled) {
            $attributes += ['disabled' => 'disabled'];
        }

        foreach ($attributes as $key => $value) {
            if ($key == 'href') {
                $value = preg_match('#^(\w+:)?//#i', (string)$value) ? $value : admin_url($value);
            }

            $attributes[$key] = is_lang_key($value) ? lang($value) : $value;
        }

        return $htmlBuild ? Html::attributes($attributes) : $attributes;
    }

    /**
     * Returns a value suitable for the item id property.
     */
    public function getId($suffix = null): string
    {
        $id = 'menuitem';
        $id .= '-'.$this->itemName;

        if ($suffix) {
            $id .= '-'.$suffix;
        }

        if ($this->idPrefix) {
            $id = $this->idPrefix.'-'.$id;
        }

        return name_to_id($id);
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function idPrefix(string $idPrefix): self
    {
        $this->idPrefix = $idPrefix;

        return $this;
    }

    public function anchor(string $anchor): self
    {
        $this->anchor = $anchor;

        return $this;
    }

    public function disabled(): self
    {
        $this->disabled = true;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function attributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function path(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function priority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function permission(array|string|null $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    public function config(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function mergeConfig(array $config): self
    {
        $this->config = array_merge($this->config, $config);

        return $this;
    }
}
