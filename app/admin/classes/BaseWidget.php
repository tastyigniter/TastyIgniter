<?php namespace Admin\Classes;

use Admin\Traits\WidgetMaker;
use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Traits\EventEmitter;
use System\Traits\AssetMaker;
use System\Traits\ConfigMaker;
use System\Traits\SessionMaker;
use System\Traits\ViewMaker;

/**
 * Base Widget Class
 * Adapted from october\backend\classes\WidgetBase
 * @package Admin
 */
class BaseWidget extends Extendable
{
    use WidgetMaker;
    use SessionMaker;
    use ViewMaker;
    use AssetMaker;
    use ConfigMaker;
    use EventEmitter;

    /**
     * @var \Admin\Classes\AdminController Admin controller object.
     */
    protected $controller;

    /**
     * @var object Supplied configuration.
     */
    public $config;

    /**
     * @var string Defined alias used for this widget.
     */
    public $alias;

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'widget';

    /**
     * Constructor
     *
     * @param \System\Classes\BaseController $controller
     * @param array $config
     */
    public function __construct($controller, $config = [])
    {
        $this->controller = $controller;

        // Add paths from the controller context
        $this->partialPath = $controller->partialPath;

        // Add paths from the extension / module context
        $classPath = strtolower(str_replace('\\', '/', get_called_class()));
        $this->partialPath[] = '~/app/'.dirname($classPath); // match view folder/file
        $this->partialPath[] = '~/app/'.$classPath;

        $this->assetPath = '~/app/'.$classPath.'/assets';

        $this->configPath = $controller->configPath;

        // Set config values, if a parent constructor hasn't set already.
        if ($this->config === null)
            $this->setConfig($config);

        if (is_null($this->alias))
            $this->alias = $this->config['alias'] ?? $this->defaultAlias;

        $this->loadAssets();

        parent::__construct();

        $this->initialize();
    }

    /**
     * Initialize the widget called by the constructor.
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Renders the widgets primary contents.
     * @return string HTML markup supplied by this widget.
     */
    public function render()
    {
    }

    /**
     * Binds a widget to the controller for safe use.
     * @return void
     */
    public function bindToController()
    {
        $this->controller->widgets[$this->alias] = $this;
    }

    /**
     * Transfers config values stored inside the $config property directly
     * on to the root object properties.
     *
     * @param array $properties
     *
     * @return void
     */
    protected function fillFromConfig($properties = null)
    {
        if ($properties === null) {
            $properties = array_keys((array)$this->config);
        }

        foreach ($properties as $property) {
            if (property_exists($this, $property)) {
                $this->{$property} = $this->getConfig($property, $this->{$property});
            }
        }
    }

    /**
     * Returns a unique ID for this widget. Useful in creating HTML markup.
     *
     * @param string $suffix An extra string to append to the ID.
     *
     * @return string A unique identifier.
     */
    public function getId($suffix = null)
    {
        $id = class_basename(get_called_class());

        if ($this->alias != $this->defaultAlias) {
            $id .= '-'.$this->alias;
        }

        if ($suffix !== null) {
            $id .= '-'.$suffix;
        }

        return strtolower(name_to_id($id));
    }

    /**
     * Returns a fully qualified event handler name for this widget.
     *
     * @param string $name The ajax event handler name.
     *
     * @return string
     */
    public function getEventHandler($name)
    {
        return $this->alias.'::'.$name;
    }

    /**
     * Returns the controller using this widget.
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Sets the widget configuration values
     *
     * @param array $config
     * @param array $required Required config items
     */
    public function setConfig($config, array $required = [])
    {
        $this->config = $this->makeConfig($config, $required);
    }

    /**
     * Get the widget configuration values.
     *
     * @param string $name Config name, supports array names like "field[key]"
     * @param mixed $default Default value if nothing is found
     *
     * @return mixed
     */
    public function getConfig($name = null, $default = null)
    {
        if (is_null($name))
            return $this->config;

        $nameArray = name_to_array($name);

        $fieldName = array_shift($nameArray);
        $result = isset($this->config[$fieldName]) ? $this->config[$fieldName] : $default;

        foreach ($nameArray as $key) {
            if (!is_array($result) OR !array_key_exists($key, $result))
                return $default;

            $result = $result[$key];
        }

        return $result;
    }

    /**
     * Adds widget specific asset files.
     * use $this->addCss or $this->addJs
     * @return void
     */
    public function loadAssets()
    {
    }

    /**
     * Returns a unique session identifier for this widget and controller action.
     * @return string
     */
    protected function makeSessionKey()
    {
        // The controller action is intentionally omitted, session should be shared for all actions
        return 'widget.'.class_basename($this->controller).'-'.$this->getId();
    }
}
