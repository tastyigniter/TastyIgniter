<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
use Igniter\Core\BaseExtension;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Component Class
 *
 * @category       Libraries
 * @package        Igniter\Core\BaseComponent.php
 * @link           http://docs.tastyigniter.com
 */
class BaseComponent
{

    /**
     * @var string Code used for this component.
     */
    public $code;

    /**
     * @var string Component class name or class alias.
     */
    public $name;

    /**
     * @var string Specifies the component extension directory name.
     */
    protected $directory;

    /**
     * @var array Holds the component layout settings array.
     */
    protected $properties;

    /**
     * @var array Holds the component extension settings array.
     */
    protected $settings;

    /**
     * @var BaseController CI super object.
     */
    protected $page;

    /**
     * @var Main_Controller Controller object.
     */
    protected $controller;

    /**
     * Class constructor
     *
     * @param BaseController $CI
     * @param array  $params
     */
    public function __construct($CI = null, $params = [])
    {
        if ($CI !== null) {
            $this->page = $CI;
            $this->controller = $CI->controller;
        }

//        Modules::$registry[strtolower(get_class($this))] = $this;

        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);

        $this->properties = $params;

        $this->code = $className = get_called_class();
        $extension = Components::findComponentExtension(strtolower($className));
        if ($extension instanceof BaseExtension) {
            $reflection = new ReflectionClass(get_class($extension));
            $this->directory = basename(dirname($reflection->getFileName()));
            $this->settings['code'] = $this->directory;
        }

        log_message('info', 'Base Component Class Initialized');
    }

    public function setSettings()
    {
        if (count($this->settings) > 1)
            return $this->settings;

        $this->load->model('Extensions_model');
        $this->settings = $this->Extensions_model->getSettings($this->directory);

        return $this->settings;
    }

    public function setting($item, $default = null)
    {
        return isset($this->settings[$item]) ? $this->settings[$item] : $default;
    }

    public function property($item, $default = null)
    {
        return isset($this->properties[$item]) ? $this->properties[$item] : $default;
    }

    /**
     * __call magic
     *
     * Allows components to access TI's loaded classes using the same
     * syntax as controllers.
     *
     * @param $name
     * @param $params
     *
     * @return mixed
     * @internal param string $key
     */
    public function __call($name, $params)
    {
        if (method_exists($this->controller, $name) && is_callable([$this->controller, $name])) {
            return call_user_func_array([$this->controller, $name], $params);
        }
    }
}

/* End of file BaseComponent.php */
/* Location: ./system/tastyigniter/core/BaseComponent.php */