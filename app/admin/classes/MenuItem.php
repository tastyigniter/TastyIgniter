<?php namespace Admin\Classes;

use Html;

/**
 * Menu item definition
 * A translation of the menu item configuration
 *
 * @package Admin
 */
class MenuItem
{
    /**
     * @var string Item name.
     */
    public $itemName;

    /**
     * @var string A prefix to the field identifier so it can be totally unique.
     */
    public $idPrefix;

    /**
     * @var string Menu item label.
     */
    public $label;

    /**
     * @var string Menu item anchor.
     */
    public $anchor;

    /**
     * @var string Menu item type.
     */
    public $type = 'link';

    /**
     * @var string Menu dropdown menu options.
     */
    public $options;

    /**
     * @var string Specifies contextual visibility of this menu item.
     */
    public $context = null;

    /**
     * @var bool Specify if the item is disabled or not.
     */
    public $disabled = FALSE;

    /**
     * @var array Contains a list of attributes specified in the item configuration.
     */
    public $icon;

    /**
     * @var array Contains a list of attributes specified in the item configuration.
     */
    public $badge;

    /**
     * @var array Contains a list of attributes specified in the item configuration.
     */
    public $viewMoreUrl;

    /**
     * @var array Contains a list of attributes specified in the item configuration.
     */
    public $optionsView;

    /**
     * @var string Specifies a path for partial-type fields.
     */
    public $path;

    /**
     * @var string Specifies a path to override partial for non partial-type fields.
     */
    public $partial;

    /**
     * @var array Contains a list of attributes specified in the item configuration.
     */
    public $attributes = [];

    /**
     * @var string Specifies a CSS class to attach to the item container.
     */
    public $cssClass;

    /**
     * @var array Raw item configuration.
     */
    public $config;

    public function __construct($itemName, $label)
    {
        $this->itemName = $itemName;
        $this->label = $label;
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
            elseif (is_callable($this->options)) {
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
     *
     * @return $this
     */
    public function displayAs($type, $config = [])
    {
        $this->type = strtolower($type) ?: $this->type;
        $this->config = $this->evalConfig($config);

        return $this;
    }

    /**
     * Process options and apply them to this object.
     *
     * @param array $config
     *
     * @return array
     */
    protected function evalConfig($config)
    {
        if (isset($config['anchor']))
            $this->anchor = $config['anchor'];

        if (isset($config['options']))
            $this->options = $config['options'];

        if (isset($config['context']))
            $this->context = $config['context'];

        if (isset($config['icon']))
            $this->icon = $config['icon'];

        if (isset($config['badge']))
            $this->badge = $config['badge'];

        if (isset($config['viewMoreUrl']))
            $this->viewMoreUrl = $config['viewMoreUrl'];

        if (isset($config['optionsView']))
            $this->optionsView = $config['optionsView'];

        if (isset($config['path']))
            $this->path = $config['path'];

        if (isset($config['partial']))
            $this->partial = $config['partial'];

        if (isset($config['cssClass']))
            $this->cssClass = $config['cssClass'];

        if (isset($config['attributes']))
            $this->attributes = $config['attributes'];

        if (array_key_exists('disabled', $config))
            $this->disabled = $config['disabled'];

        return $config;
    }

    /**
     * Returns the attributes for this item.
     **
     *
     * @param bool $htmlBuild
     *
     * @return array|string
     */
    public function getAttributes($htmlBuild = TRUE)
    {
        $attributes = $this->attributes;

        if ($this->disabled) {
            $attributes = $attributes + ['disabled' => 'disabled'];
        }

        foreach ($attributes as $key => $value) {
            if ($key == 'href') $value = preg_match('#^(\w+:)?//#i', $value) ? $value : admin_url($value);
            $attributes[$key] = (is_string($value) AND sscanf($value, 'lang:%s', $__line) === 1) ? lang($__line) : $value;
        }

        return $htmlBuild ? Html::attributes($attributes) : $attributes;
    }

    /**
     * Returns a value suitable for the item id property.
     *
     * @param null $suffix
     *
     * @return string
     */
    public function getId($suffix = null)
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
}
