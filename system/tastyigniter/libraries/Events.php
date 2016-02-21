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
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Events Class
 *
 * Adapted from Bonfire Dev Team's Events Class.
 * @link   http://cibonfire.com
 *
 * Allows you to create hook points throughout the application that any other
 * module can tap into without hacking core code.
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Customizer.php
 * @link           http://docs.tastyigniter.com
 */
class Events {

	/**
	 * @var object The CI instance, only retrieved if required in the init() method.
	 */
	private static $CI;

	/**
	 * @var array Holds the registered events.
	 */
	private static $events = array();

	/**
	 * @var array Holds the installed extensions.
	 */
	private static $extensions = array();

	/**
	 * This if here solely for CI loading to work. Just calls the initialize() method.
	 *
	 */
	public function __construct() {
		self::initialize();
	}

	/**
	 * Loads the library's dependencies and configuration.
	 *
	 * @return void
	 */
	public static function initialize() {
		// get all installed extensions
		if (empty(self::$extensions)) {
			self::$CI =& get_instance();
			self::$extensions = self::$CI->extension->getInstalledExtensions();
		}

		// Merge events from indivdual modules.
		foreach (Modules::list_modules() as $module) {
			// Skip if module is not installed
			if ( ! isset(self::$extensions[$module])) {
				continue;
			}

			$path = ROOTPATH . EXTPATH . "{$module}/config/";
			if (is_file($path . 'events.php')) {
				$module_events = Modules::load_file('events', $path, 'config');

				if (is_array($module_events)) {
					self::$events = array_merge_recursive(self::$events, $module_events);
				}
			}
		}

		if (self::$events === FALSE) {
			self::$events = array();
		}
	}

	/**
	 * Triggers an individual event.
	 *
	 * @param string $event_name A string with the name of the event to trigger. Case sensitive.
	 * @param mixed  $payload    (optional) An array to send to the event method.
	 *
	 * @return void
	 */
	public static function trigger($event_name = NULL, $payload = NULL) {
		if (empty($event_name)
			|| ! is_string($event_name)
			|| ! array_key_exists($event_name, self::$events)
		) {
			return;
		}

		foreach (self::$events[$event_name] as $subscriber) {
			if (strpos($subscriber['filename'], '.php') === FALSE) {
				$subscriber['filename'] .= '.php';
			}

			$file_path = Modules::file_path($subscriber['module'], $subscriber['filepath'], $subscriber['filename']);

			if ( ! file_exists($file_path)) {
				continue;
			}

			include_once($file_path);

			if ( ! class_exists($subscriber['class'])) {
				// if class doesn't exist check that the function is callable
				// could be just a helper function
				if (is_callable($subscriber['method'])) {
					call_user_func($subscriber['method'], $payload);
				}

				continue;
			}

			$class = new $subscriber['class'];

			if ( ! is_callable(array($class, $subscriber['method']))) {
				unset($class);
				continue;
			}

			$class->{$subscriber['method']}($payload);
			unset($class);
		}
	}
}

// END Events Class

/* End of file Events.php */
/* Location: ./system/tastyigniter/libraries/Events.php */