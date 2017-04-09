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
namespace Igniter\Database;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Events\Dispatcher;

/**
 * TastyIgniter Database Manager Class
 *
 * @category       Libraries
 * @package        Igniter\Database\Manager.php
 * @link           http://docs.tastyigniter.com
 */
class Manager
{
	protected static $dbManager;

	/**
	 * Initialize capsule and store reference to connection
	 */
	public static function init()
	{
		if (is_null(self::$dbManager)) {
			$db = self::getConfiguration();

			$capsule = new CapsuleManager;
			$capsule->addConnection([
				'driver'    => $db->dbdriver == 'mysqli' ? 'mysql' : $db->dbdriver,
				'host'      => $db->hostname,
				'database'  => $db->database,
				'username'  => $db->username,
				'password'  => $db->password,
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => $db->dbprefix,
			]);

			$capsule->setEventDispatcher(new Dispatcher(new Container));

			// Set the cache manager instance used by connections... (optional)
			// $capsule->setCacheManager(...);

			// Make this Capsule instance available globally via static methods... (optional)
			$capsule->setAsGlobal();

			$capsule->getConnection()->setFetchMode(\PDO::FETCH_ASSOC);

			// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
			$capsule->bootEloquent();

			self::registerQueryLogEvent($capsule);

			self::$dbManager = $capsule;
		}
	}

	/**
	 * @param $db
	 * @param $params
	 */
	protected static function getConfiguration()
	{
		$CI =& get_instance();
		if (isset($CI->db)) return $CI->db;

		// Is the config file in the environment folder?
		if (!file_exists($file_path = ROOTPATH.'config/' . ENVIRONMENT . '/database.php')
			&& !file_exists($file_path = ROOTPATH.'config/database.php')
		) {
			show_error('The configuration file database.php does not exist.');
		}

		include($file_path);

		if (!isset($db) OR count($db) === 0) {
			show_error('No database connection settings were found in the database config file.');
		}

		if (!isset($active_group)) {
			show_error('You have not specified a database connection group via $active_group in your config/database.php file.');
		} elseif (!isset($db[$active_group])) {
			show_error('You have specified an invalid database connection group (' . $active_group . ') in your config/database.php file.');
		}

		return (object)$db[$active_group];
	}

	/**
	 * @param $capsule
	 */
	protected static function registerQueryLogEvent($capsule)
	{
		$capsule->getConnection()->enableQueryLog();

		$capsule->getConnection()->listen(function ($queryExecuted) {
			if (!$queryExecuted instanceof QueryExecuted)
				return NULL;

			$bindings = $queryExecuted->bindings;

			// Format binding data for sql insertion
			foreach ($bindings as $i => $binding) {
				if ($binding instanceof \DateTime) {
					$bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
				} else if (is_string($binding)) {
					$bindings[$i] = "'$binding'";
				}
			}

			// Insert bindings into query
			$query = str_replace(['%', '?'], ['%%', '%s'], $queryExecuted->sql);
			$query = vsprintf($query, $bindings);

			$CI =& get_instance();
			$CI->db->query_times[] = $queryExecuted->time;
			$CI->db->queries[] = $query;
		});
	}
}