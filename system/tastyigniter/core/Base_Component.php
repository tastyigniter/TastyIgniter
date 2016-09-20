<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 2.2
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Component Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Base_Component.php
 * @link           http://docs.tastyigniter.com
 */
class Base_Component extends Main_Controller
{

	/**
	 * @var string Component class name or class alias used in the component declaration in a template.
	 */
	public $name;

	/**
	 * @var string Specifies the component extension directory name.
	 */
	protected $directory;

	/**
	 * @var string Holds the component layout settings array.
	 */
	protected $properties;

	/**
	 * @var string Holds the component extension settings array.
	 */
	protected $settings;

	/**
	 * @var string Controller name.
	 */
	protected $controller;

	/**
	 * Class constructor
	 *
	 * @param string $controller
	 * @param array $params
	 */
	public function __construct($controller = NULL, $params = array()) {
		parent::__construct();

		if ($controller !== NULL) {
			$this->controller = $controller;
		}

		$this->properties = $params;

		$class_name = get_called_class();
		$extension = Components::find_component_extension(strtolower($class_name));
		if ($extension instanceof Base_Extension) {
			$reflection = new ReflectionClass(get_class($extension));
			$this->directory = basename(dirname($reflection->getFileName()));

			$this->settings = $this->Extensions_model->getSettings($this->directory);
			$this->settings['code'] = $this->directory;
		}

		log_message('info', 'Base Component Class Initialized');
	}

	public function setting($item, $default = NULL) {
		return isset($this->settings[$item]) ? $this->settings[$item] : $default;
	}

	public function property($item, $default = NULL) {
		return isset($this->properties[$item]) ? $this->properties[$item] : $default;
	}

	/**
	 * __get magic
	 *
	 * Allows components to access TI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param    string $key
	 */
	public function __get($key) {
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/tastyigniter/core/Base_Component.php', it's
		//	most likely a typo in your component code.
		return get_instance()->$key;
	}
}

/* End of file Base_Component.php */
/* Location: ./system/tastyigniter/core/Base_Component.php */