<?php namespace System\Classes;

use Config;
use File;
use Igniter\Flame\Pagic\TemplateCode;
use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Traits\EventEmitter;
use Main\Classes\MainController;
use System\Traits\AssetMaker;

/**
 * Base Component Class
 *
 * @package System
 */
abstract class BaseComponent extends Extendable
{
    use EventEmitter;
    use AssetMaker;

    public $defaultPartial = 'default';

    /**
     * @var string Alias used for this component.
     */
    public $alias;

    /**
     * @var string Component class name or class alias.
     */
    public $name;

    /**
     * @var boolean Determines whether the component is hidden from the admin UI.
     */
    public $isHidden = FALSE;

    /**
     * @var string Icon of the extension that defines the component.
     * This field is used internally.
     */
    public $extensionIcon;

    /**
     * @var string Specifies the component directory name.
     */
    protected $dirName;

    /**
     * @var array Holds the component layout settings array.
     */
    protected $properties;

    /**
     * @var MainController Controller object.
     */
    protected $controller;

    /**
     * @var \Main\Template\Page Page template object.
     */
    protected $page;

    /**
     * Class constructor
     *
     * @param \Igniter\Flame\Pagic\TemplateCode $page
     * @param array $properties
     */
    public function __construct($page = null, $properties = [])
    {
        if ($page instanceof TemplateCode) {
            $this->page = $page;
            $this->controller = $page->controller;
        }

        $this->properties = $this->validateProperties($properties);

        $this->dirName = strtolower(str_replace('\\', '/', get_called_class()));
        $this->assetPath = extension_path(dirname(dirname($this->dirName))).'/assets';
        $this->assetCollection = 'component';

        parent::__construct();
    }

    /**
     * Returns the absolute component path.
     */
    public function getPath()
    {
        return extension_path($this->dirName);
    }

    /**
     * Executed when this component is first initialized, before AJAX requests.
     */
    public function initialize()
    {
    }

    /**
     * Executed when this component is bound to a layout.
     */
    public function onRun()
    {
    }

    /**
     * Executed when this component is rendered on a layout.
     */
    public function onRender()
    {
    }

    /**
     * Renders a requested partial in context of this component,
     * @see \Main\Classes\MainController::renderPartial for usage.
     *
     * @return mixed
     */
    public function renderPartial()
    {
        $this->controller->setComponentContext($this);
        $result = call_user_func_array([$this->controller, 'renderPartial'], func_get_args());
        $this->controller->setComponentContext(null);

        return $result;
    }

    /**
     * Executes an AJAX handler.
     */
    public function runEventHandler($handler)
    {
        $result = $this->{$handler}();

        return $result;
    }

    public function getEventHandler($handler)
    {
        return $this->alias.'::'.$handler;
    }

    //
    // Property helpers
    //

    /**
     * Validates the properties against the defined properties of the class.
     * This method also sets default properties.
     *
     * @param array $properties The supplied property values.
     *
     * @return array The validated property set, with defaults applied.
     */
    public function validateProperties(array $properties)
    {
        $definedProperties = $this->defineProperties();

        // Determine and implement default values
        $defaultProperties = [];
        foreach ($definedProperties as $name => $information) {
            if (array_key_exists('default', $information)) {
                $defaultProperties[$name] = $information['default'];
            }
        }

        $properties = array_merge($defaultProperties, $properties);

        return $properties;
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties()
    {
        return [];
    }

    /**
     * Sets multiple properties.
     *
     * @param array $properties
     *
     * @return array
     */
    public function setProperties($properties)
    {
        $this->properties = $this->validateProperties($properties);
    }

    /**
     * Sets a property value
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;
    }

    /**
     * Returns all properties.
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Returns a defined property value or default if one is not set.
     *
     * @param string $name The property name to look for.
     * @param string $default A default value to return if no name is found.
     *
     * @return mixed The property value or the default specified.
     */
    public function property($name, $default = null)
    {
        return array_key_exists($name, $this->properties)
            ? $this->properties[$name]
            : $default;
    }

    /**
     * Returns options for multi-option properties (drop-downs, etc.)
     *
     * @param string $property Specifies the property name
     *
     * @return array Return an array of option values and descriptions
     */
    public function getPropertyOptions($property)
    {
        return [];
    }

    public function param($name, $default = null)
    {
        if (is_null($segment = $this->controller->uri->segment($name)))
            $segment = input($name);

        return is_null($segment) ? $default : $segment;
    }

//    public function __get($key)
//    {
//        if (isset(get_instance()->$key)) {
//            return get_instance()->$key;
//        }
//
//        return parent::__get($key);
//    }

    public function __toString()
    {
        return $this->alias;
    }
}
