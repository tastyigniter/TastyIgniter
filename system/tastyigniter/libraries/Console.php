<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Console Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Console.php
 * @link           http://docs.tastyigniter.com
 */
class Console
{

	/*
	 * Contains all of the logs that are collected.
	 */
	private static $logs = [
		'console'      => [],
		'log_count'    => 0,
		'memory_count' => 0,
	];

	/*
	 * An instance of the CI super object.
	 */
	private static $ci;

	//--------------------------------------------------------------------

	/**
	 * This constructor is here purely for CI's benefit, as this is a
	 *    static class.
	 *
	 * @return void
	 */
	public function __construct()
	{
		self::init();

		log_message('debug', 'Console library loaded');
	}

	//--------------------------------------------------------------------

	/**
	 * Grabs an instance of CI and gets things ready to run.
	 *
	 * @return void
	 */
	public static function init()
	{
		self::$ci =& get_instance();
	}

	//--------------------------------------------------------------------

	/**
	 * Logs a variable to the console.
	 *
	 * @param  $data - The variable to log.
	 *
	 * @return void
	 */
	public function log($data = null)
	{
		if ($data !== 0 && empty($data)) {
			$data = 'empty';
		}

		$log_item = [
			'data' => $data,
			'type' => 'log',
		];

		self::add_to_console('log_count', $log_item);
	}

	//--------------------------------------------------------------------

	/**
	 * Logs the memory usage a single variable, or the entire script.
	 *
	 * @param $object - The object to store the memory usage of.
	 * @param $name   - The name to be displayed in the console.
	 *
	 * @return void
	 */
	public static function log_memory($object = FALSE, $name = 'PHP')
	{
		$memory = memory_get_usage();

		if ($object) {
			$memory = strlen(serialize($object));
		}

		$log_item = [
			'data'      => $memory,
			'type'      => 'memory',
			'name'      => $name,
			'data_type' => gettype($object),
		];

		self::add_to_console('memory_count', $log_item);
	}

	//--------------------------------------------------------------------

	/*
	 * Returns the logs array for use in external classes.
	 *
	 * @return void
	 */
	public function get_logs()
	{
		return self::$logs;
	}

	//--------------------------------------------------------------------

	public static function add_to_console($log = null, $item = null)
	{
		if (empty($log) || empty($item)) {
			return;
		}

		self::$logs['console'][] = $item;
		self::$logs[$log] += 1;
	}

	//--------------------------------------------------------------------

}

/* End of file Console.php */
/* Location: ./system/tastyigniter/libraries/Console.php */