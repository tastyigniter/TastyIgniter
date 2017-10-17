<?php namespace Igniter\Libraries;
use Closure;
use Modules;


/**
 * Events Class
 *
 * Adapted from Bonfire Dev Team's Events Class.
 *
 * Allows you to create hook points throughout the application that any other
 * module can tap into without hacking core code.
 *
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
     * @var array Collection of registered events to be fired once only.
     */
    protected static $singleEventCollection = [];

    /**
     * @var array Collection of registered events.
     */
    protected static $eventCollection = [];

    /**
     * @var array Sorted collection of events.
     */
    protected static $eventSorted = [];

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
		foreach (ExtensionManager::instance()->listExtensions() as $module) {
			// Skip if module is not installed
			if (ExtensionManager::instance()->isDisabled($module)) {
				continue;
			}

			list($path, $file) = ExtensionManager::instance()->find('events', $module, 'config/');

            if ($path) {
                $moduleEvents = ExtensionManager::instance()->load_file('events', $path, 'config');

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

                $filePath = ExtensionManager::instance()->file_path($subscriber['module'], $subscriber['filepath'], $subscriber['filename']);

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

    /**
     * Create a new event binding.
     *
     * @param $event
     * @param $callback
     */
    public static function bind($event, $callback, $priority = 0)
    {
        if ($callback instanceof Closure) {
            self::$eventCollection[$event][$priority][] = $callback;
            unset(self::$eventSorted[$event]);

            return;
        }

        if (!is_array($callback))
            $callback = ['method' => $callback];

        self::$configEventCollection[$event][] = $callback;
    }

    /**
     * Create a new event binding that fires once only
     * @return self
     */
    public static function bindOnce($event, $callback)
    {
        self::$singleEventCollection[$event][] = $callback;

        return;
    }

    /**
     * Destroys an event binding.
     *
     * @param string $event Event to destroy
     *
     * @return self
     */
    public static function unbind($event = null)
    {
        /*
         * Multiple events
         */
        if (is_array($event)) {
            foreach ($event as $_event) {
                self::unbind($_event);
            }

            return;
        }

        if ($event === null) {
            unset(self::$singleEventCollection);
            unset(self::$eventCollection);
            unset(self::$eventSorted);

            return;
        }

        if (isset(self::$singleEventCollection[$event]))
            unset(self::$singleEventCollection[$event]);

        if (isset(self::$eventCollection[$event]))
            unset(self::$eventCollection[$event]);

        if (isset(self::$eventSorted[$event]))
            unset(self::$eventSorted[$event]);

        return;
    }

    /**
     * Sort the listeners for a given event by priority.
     *
     * @param  string $eventName
     *
     * @return array
     */
    protected static function sortEvents($eventName)
    {
        self::$eventSorted[$eventName] = [];

        if (isset(self::$eventCollection[$eventName])) {
            krsort(self::$eventCollection[$eventName]);

            self::$eventSorted[$eventName] = call_user_func_array('array_merge', self::$eventCollection[$eventName]);
        }
    }

    /**
     * Fire an event and call the listeners.
     *
     * @param string $event Event name
     * @param array $params Event parameters
     * @param boolean $halt Halt after first non-null result
     *
     * @return array Collection of event results / Or single result (if halted)
     */
    public static function fire($event, $params = [], $halt = FALSE)
    {
        if (!is_array($params)) $params = [$params];
        $result = [];

        // Single events
        if (isset(self::$singleEventCollection[$event])) {
            foreach (self::$singleEventCollection[$event] as $callback) {
                $response = call_user_func_array($callback, $params);
                if (is_null($response)) continue;
                if ($halt) return $response;
                $result[] = $response;
            }

            unset(self::$singleEventCollection[$event]);
        }

        // Recurring events, with priority
        if (isset(self::$eventCollection[$event])) {

            if (!isset(self::$eventSorted[$event]))
                self::sortEvents($event);

            foreach (self::$eventSorted[$event] as $callback) {
                $response = call_user_func_array($callback, $params);
                if (is_null($response)) continue;
                if ($halt) return $response;
                $result[] = $response;
            }
        }

        return $halt ? null : $result;
    }
}

// END Events Class

/* End of file Events.php */
/* Location: ./system/libraries/Events.php */