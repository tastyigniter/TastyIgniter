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
 * Base Extension Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Base_Extension.php
 * @link           http://docs.tastyigniter.com
 */
class Base_Extension
{
	/**
	 * @var boolean
	 */
	protected $loaded_config = FALSE;

	/**
	 * @var array Extension dependencies
	 */
	public $require = array();

	/**
	 * @var boolean Determine if this extension should be loaded (false) or not (true).
	 */
	public $disabled = FALSE;

	/**
	 * Returns information about this extension
	 *
	 * @return array
	 */
	public function extensionMeta() {
		$_module = get_class($this);

		$config = $this->getConfigFromFile(sprintf("The configuration file for extension <b>%s</b> does not exist. " .
			"Create the file or override extensionMeta() method in the extension class.", $_module));

		if (!array_key_exists('extension_meta', $config)) {
			show_error(sprintf("The configuration file for extension <b>%s</b> does not appear to contain a valid" .
				" configuration array.", $_module));
		}

		unset($config['type'], $config['settings']);

		return $config['extension_meta'];
	}

	/**
	 * Auto-load method called when the extension is first loaded.
	 * Can be used to load libraries, helpers, config...
	 *
	 * @return array
	 */
	public function autoload() {
	}

	/**
	 * Run method, called right before the request route.
	 *
	 * @return array
	 */
	public function run() {
	}

	/**
	 * Registers any front-end components implemented in this extension.
	 *
	 * The components must be returned in the following format:
	 * ['path/to/class' => 'class']
	 *
	 * @return array
	 */
	public function registerComponents() {
		$config = $this->getConfigFromFile();

		if (isset($config['layout_ready']) AND !empty($config['extension_meta']['type']) AND $config['extension_meta']['type'] == 'module') {
			$reflection = new ReflectionClass(get_class($this));
			$_module = basename(dirname($reflection->getFileName()));
			$_class = ucfirst($_module);

			return array("{$_module}/components/{$_class}" => $_module);
		}
	}

	/**
	 * Registers any payment gateway implemented in this extension.
	 *
	 * The payment gateway must be returned in the following format:
	 * ['path/to/class' => 'alias']
	 *
	 * @return array
	 */
	public function registerPaymentGateway() {
		$config = $this->getConfigFromFile();

		if (isset($config['layout_ready']) AND !empty($config['extension_meta']['type']) AND $config['extension_meta']['type'] == 'payment') {
			$reflection = new ReflectionClass(get_class($this));
			$_module = dirname($reflection->getFileName());
			$_class = ucfirst($_module);

			return array("{$_module}/components/{$_class}" => $_module);
		}
	}

	/**
	 * Registers back-end navigation menu items for this extension.
	 *
	 * @return array
	 */
	public function registerNavigation() {
		return array();
	}

	/**
	 * Registers any back-end permissions used by this extension.
	 *
	 * @return array
	 */
	public function registerPermissions() {
		$config = $this->getConfigFromFile();
		if (is_array($config) AND array_key_exists('extension_permission', $config)) {
			return $config['extension_permission'];
		}
	}

	/**
	 * Registers the back-end setting links used by this extension.
	 *
	 * @return array
	 */
	public function registerSettings() {
		$config = $this->getConfigFromFile();

		if (!empty($config['extension_meta']['settings'])) {
			$reflection = new ReflectionClass(get_class($this));
			$_module = basename(dirname($reflection->getFileName()));

			return admin_url($_module . '/settings');
		}
	}

	/**
	 * Registers any mail templates implemented by this extension.
	 * The templates must be returned in the following format:
	 * ['registration' => 'This is a description of the registration email to customer'],
	 * ['password_reset' => 'This is a description of the password reset email to customer'],
	 *
	 * @return array
	 */
	public function registerMailTemplates() {
		return array();
	}

	/**
	 * Read configuration from Config file
	 *
	 * @param string|null $error_message
	 *
	 * @return array|bool
	 */
	protected function getConfigFromFile($error_message = NULL) {
		if ($this->loaded_config !== FALSE) {
			return $this->loaded_config;
		}

		list($_module, ) = explode('\\', get_class($this));

		list($path, $file) = Modules::find($_module, $_module, 'config/');

		if ($path != FALSE) {
			$this->loaded_config = Modules::load_file($file, $path, 'config');
		} else if ($error_message) {
			show_error($error_message);
		}

		return $this->loaded_config;
	}
}

/* End of file Base_Extension.php */
/* Location: ./system/tastyigniter/core/Base_Extension.php */