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
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Events Class
 *
 * Adapted from Bonfire Dev Team's Events Class.
 * @link           http://cibonfire.com
 *
 * Allows you to create hook points throughout the application that any other
 * module can tap into without hacking core code.
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Customizer.php
 * @link           http://docs.tastyigniter.com
 */
class Events
{

    /**
     * @var array Holds the registered events.
     */
    protected static $configEventCollection = [];

	/**
	 * This if here solely for CI loading to work. Just calls the initialize() method.
	 *
	 */
	public function __construct()
	{
		self::initialize();

        log_message('info', 'Events Class Initialized');
    }

	/**
	 * Loads the library's dependencies and configuration.
	 *
	 * @return void
	 */
	public static function initialize()
	{
		// Merge events from indivdual modules.
		foreach (Modules::list_modules() as $module) {
			// Skip if module is not installed
			if (Modules::is_disabled($module)) {
				continue;
			}

			list($path, $file) = Modules::find('events', $module, 'config/');

            if ($path) {
                $moduleEvents = Modules::load_file('events', $path, 'config');

                if (is_array($moduleEvents)) {
                    self::$configEventCollection = array_merge_recursive(self::$configEventCollection, $moduleEvents);
                }
            }
        }

        if (self::$configEventCollection === FALSE) {
            self::$configEventCollection = [];
        }
    }

    /**
     * Create a new event binding.
     *
     * @param $event
     * @param $callback
     */
    public static function bind($event, $callback)
    {
        if (!is_array($callback))
            $callback = ['method' => $callback];

        self::$configEventCollection[$event][] = $callback;
    }

    /**
     * Triggers an individual event.
     *
     * @param string $eventName A string with the name of the event to trigger. Case sensitive.
     * @param mixed $payload (optional) An array to send to the event method.
     *
     * @return void
     */
    public static function trigger($eventName = null, $payload = null)
    {
        if (empty($eventName) OR !is_string($eventName)
            OR !array_key_exists($eventName, self::$configEventCollection)
        ) {
            return;
        }

        $result = null;

        foreach (self::$configEventCollection[$eventName] as $subscriber) {
            if (isset($subscriber['module'])) {
                if (strpos($subscriber['filename'], '.php') === FALSE) {
                    $subscriber['filename'] .= '.php';
                }

                $filePath = Modules::file_path($subscriber['module'], $subscriber['filepath'], $subscriber['filename']);

                if (!file_exists($filePath)) {
                    continue;
                }

                include_once($filePath);
            }

            if (!isset($subscriber['class']) OR !class_exists($subscriber['class'])) {
                // if class doesn't exist check that the function is callable
                // could be just a helper function
                if (is_callable($subscriber['method'])) {
                    $result = call_user_func($subscriber['method'], $payload);
                }

                continue;
            }

            $class = new $subscriber['class'];

            if (!is_callable([$class, $subscriber['method']])) {
                unset($class);
                continue;
            }

            $result = $class->{$subscriber['method']}($payload);
            unset($class);
        }

        return is_null($result) ? $payload : $result;
    }
}

// END Events Class

/* End of file Events.php */
/* Location: ./system/tastyigniter/libraries/Events.php */