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
class BaseComponent extends MX_Controller
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
     * @param BaseController $controller
     * @param array  $params
     */
    public function __construct($controller = null, $params = [])
    {
        parent::__construct();

        $this->controller = $controller;
        $this->properties = $params;

        $this->code = $className = get_called_class();
        $extension = Components::findComponentExtension(strtolower($className));
        if ($extension instanceof BaseExtension) {
            $reflection = new ReflectionClass(get_class($extension));
            $this->directory = basename(dirname($reflection->getFileName()));

            $this->load->model('Extensions_model');
            $this->settings = $this->Extensions_model->getSettings($this->directory);
            $this->settings['code'] = $this->directory;
        }

        log_message('info', 'Base Component Class Initialized');
    }

    public function setting($item = null, $default = null)
    {
        if (is_null($item))
            return $this->settings;

        return isset($this->settings[$item]) ? $this->settings[$item] : $default;
    }

    public function property($item, $default = null)
    {
        return isset($this->properties[$item]) ? $this->properties[$item] : $default;
    }

    public function redirect($uri = null)
    {
        redirect($uri);
    }

}

/* End of file BaseComponent.php */
/* Location: ./system/tastyigniter/core/BaseComponent.php */