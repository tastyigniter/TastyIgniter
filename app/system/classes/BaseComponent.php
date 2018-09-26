<?php namespace System\Classes;

use BadMethodCallException;
use Igniter\Flame\Pagic\TemplateCode;
use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Traits\EventEmitter;
use Lang;
use Main\Classes\MainController;
use System\Traits\AssetMaker;
use System\Traits\PropertyContainer;

/**
 * Base Component Class
 * @package System
 */
abstract class BaseComponent extends Extendable
{
    use EventEmitter;
    use AssetMaker;
    use PropertyContainer;

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

    public function param($name, $default = null)
    {
        if (is_null($segment = $this->controller->param($name, $default)))
            $segment = input($name);

        return is_null($segment) ? $default : $segment;
    }


    //
    // Magic methods
    //

    /**
     * Dynamically handle calls into the controller instance.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        try {
            return parent::__call($method, $parameters);
        }
        catch (BadMethodCallException $ex) {
        }

        if (method_exists($this->controller, $method)) {
            return call_user_func_array([$this->controller, $method], $parameters);
        }

        throw new BadMethodCallException(Lang::get('main::lang.not_found.method', [
            'name' => get_class($this),
            'method' => $method,
        ]));
    }

    public function __toString()
    {
        return $this->alias;
    }
}
