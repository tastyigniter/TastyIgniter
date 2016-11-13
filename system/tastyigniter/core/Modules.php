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

(defined('EXT')) OR define('EXT', '.php');

global $CFG;

/* get module locations from config settings or use the default module location and offset */
is_array(Modules::$locations = $CFG->item('modules_locations'))
OR Modules::$locations = array(
	ROOTPATH . EXTPATH          => '../../' . EXTPATH,
);

/* PHP5 spl_autoload */
spl_autoload_register('Modules::autoload');

/**
 * Modules class for TastyIgniter.
 *
 * Adapted from Wiredesignz Modular Extensions - HMVC.
 * @link https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
 *
 * Provides utility functions for working with modules.
 */
class Modules
{
	public static $routes;
	public static $registry;
	public static $locations;

	/**
	 * @var array used for storing extension information objects.
	 */
	protected static $extensions = array();

	/**
	 * @var array of disabled extensions.
	 */
	protected static $installed_extensions = array();

	/**
	 * @var array of extensions and their directory paths.
	 */
	protected static $paths = array();

	/**
	 * @var array used for storing extension information objects.
	 */
	protected static $auto_loaded = FALSE;

	public static function initialize() {
		self::load_installed();
		self::load_extensions();
	}

	/**
	 * Run a module controller method. Output from module is buffered and returned.
	 *
	 * @param string $module The module/controller/method to run.
	 *
	 * @return mixed The output from the module.
	 */
	public static function run($module) {
		$method = 'index';

		// If a directory separator is found in $module, use the right side of the
		// separator as $method, the left side as $module.
		if (($pos = strrpos($module, '/')) != FALSE) {
			$method = substr($module, $pos + 1);
			$module = substr($module, 0, $pos);
		}

		// Load the class indicated by $module and check whether $method exists.
		$class = self::load($module);
		if (!$class || !method_exists($class, $method)) {
			log_message('error', "Module controller failed to run: {$module}/{$method}");

			return;
		}

		// Buffer the output.
		ob_start();

		// Get the remaining arguments and pass them to $method.
		$args = func_get_args();
		$output = call_user_func_array(array($class, $method), array_slice($args, 1));

		// Get/clean the current buffer.
		$buffer = ob_get_clean();

		// If $output is not null, return it, otherwise return the buffered content.
		return $output !== NULL ? $output : $buffer;
	}

	/**
	 * Load a module controller.
	 *
	 * @param string $module The module/controller to load.
	 *
	 * @return mixed The loaded controller.
	 */
	public static function load($module) {
		// If $module is an array, the first item is $module and the remaining items
		// are $params.
		is_array($module) ? list($module, $params) = each($module) : $params = NULL;

		// Get the requested controller class name.
		$alias = strtolower(basename($module));

		// Maintain a registry of controllers.
		// - If the controller is not found in the registry, attempt to find and
		//   load it, then add it to the registry.
		// - If the controller was already in the registry or is found, loaded,
		//   and added to the registry successfully, return the registered controller.
		if (!isset(self::$registry[$alias])) {
			// If the controller was not found in the registry, find it.
			list($class) = CI::$APP->router->locate(explode('/', $module));

			/* controller cannot be located */
			if (empty($class)) return;

			// Set the module directory and load the controller.
			$path = APPPATH . 'controllers/' . CI::$APP->router->directory;
			$class = $class . CI::$APP->config->item('controller_suffix');
			self::load_file($class, $path);

			// Create and register the new controller.
			$controller = ucfirst($class);
			self::$registry[$alias] = new $controller($params);
		}

		// Return the controller from the registry.
		return self::$registry[$alias];
	}

	/**
	 * Library base class autoload.
	 *
	 * @param string $class The class to load.
	 *
	 * @return void
	 */
	public static function autoload($class) {
		// Don't autoload CI_ prefixed classes or those using the config subclass_prefix.
		if (strstr($class, 'CI_') OR strstr($class, config_item('subclass_prefix'))) return;

		// Autoload Modular Extensions MX core classes.
		if (strstr($class, 'MX_')) {
			if (is_file($location = IGNITEPATH . 'third_party/MX/' . substr($class, 3) . '.php')) {
				include_once $location;

				return;
			}
			show_error('Failed to load MX core class: '.$class);
		}

		// Autoload core classes.
		if (is_file($location = BASEPATH . 'core/' . ucfirst($class) . EXT)) {
			include_once $location;

			return;
		}

		// Autoload library classes.
		if (is_file($location = BASEPATH . 'libraries/' . ucfirst($class) . EXT)) {
			include_once $location;

			return;
		}
	}

	/**
	 * Load a module file.
	 *
	 * @param string $file The filename.
	 * @param string $path The path to the file.
	 * @param string $type The type of file.
	 * @param mixed  $result
	 *
	 * @return mixed
	 */
	public static function load_file($file, $path, $type = 'other', $result = TRUE) {
		// If $file includes the '.php' extension, remove it.
		$fileName = explode('.', $file);
		$ext = array_pop($fileName);
		if ($ext AND strcasecmp($ext, 'php') === 0) {
			$file = implode('.', $fileName);
		}
		unset($ext, $fileName);

		// Ensure proper directory separators.
		$path = rtrim(rtrim($path, '/'), "\\");
		$file = ltrim(ltrim($file, '/'), "\\");

		$location = "{$path}/{$file}.php";


		if ($type === 'other') {
			if (class_exists($file, FALSE)) {
				log_message('debug', "File already loaded: {$location}");

				return $result;
			}
			if (file_exists($location)) {
				include_once $location;
			} else {
				log_message('debug', "File not found: {$location}");

				return $result;
			}
		} else {
			// Load config or language array.
			include $location;

			if (!isset($$type) || !is_array($$type)) {
				show_error("{$location} does not contain a valid {$type} array");
			}

			$result = $$type;
		}

		log_message('debug', "File loaded: {$location}");

		return $result;
	}

	/**
	 * Find a file.
	 *
	 * Scans for files located within module directories. Also scans application
	 * directories for models, plugins, and views. Generates fatal error if file
	 * not found.
	 *
	 * @param string $file   The file.
	 * @param string $module The module.
	 * @param string $base
	 *
	 * @return array
	 */
	public static function find($file, $module, $base) {
		$segments = explode('/', $file);
		$file = array_pop($segments);
		$file_ext = pathinfo($file, PATHINFO_EXTENSION) ? $file : "{$file}.php";

		$path = ltrim(implode('/', $segments) . '/', '/');
		$module ? $modules[$module] = $path : $modules = array();

		if (!empty($segments)) {
			$modules[array_shift($segments)] = ltrim(implode('/', $segments) . '/', '/');
		}

		foreach (Modules::$locations as $location => $offset) {
			foreach ($modules as $module => $subpath) {
				$fullpath = "{$location}{$module}/{$base}{$subpath}";

				if (is_file($fullpath . $file_ext)) {
					return array($fullpath, $file);
				}

				if (is_file($fullpath . ucfirst($file_ext))) {
					return array($fullpath, ucfirst($file));
				}
			}
		}

		return array(FALSE, $file);
	}

	/**
	 * Parse module routes.
	 *
	 * @param  string $module The module.
	 * @param  string $uri    The URI.
	 *
	 * @return mixed The parsed route or void.
	 */
	public static function parse_routes($module, $uri) {
		// If the module's route is not already set, load the file and set it.
		if (!isset(self::$routes[$module])) {
			if (list($path) = self::find('routes', $module, 'config/') AND $path) {
				self::$routes[$module] = self::load_file('routes', $path, 'route');
			}
		}

		// If the module's route is still not set, return.
		if (!isset(self::$routes[$module])) {
			return;
		}

		// Parse module routes.
		foreach (self::$routes[$module] as $key => $val) {
			// Translate the placeholders for the regEx.
			$key = str_replace(array(':any', ':num'), array('.+', '[0-9]+'), $key);

			// Parse the route.
			if (preg_match('#^' . $key . '$#', $uri)) {
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE) {
					$val = preg_replace('#^' . $key . '$#', $val, $uri);
				}

				// Return the parsed route.
				return explode('/', "{$module}/{$val}");
			}
		}
	}

	/**
	 * Determine whether a controller exists for a module.
	 *
	 * @param $controller string The controller to look for (without the extension).
	 * @param $module     string The module to look in.
	 *
	 * @return boolean True if the controller is found, else false.
	 */
	public static function controller_exists($controller = NULL, $module = NULL) {
		if (empty($controller) || empty($module)) {
			return FALSE;
		}

		// Look in all module paths.
		foreach (Modules::folders() as $folder) {
			if (is_file("{$folder}{$module}/controllers/{$controller}.php")) {
				return TRUE;
			} elseif (is_file("{$folder}{$module}/controllers/" . ucfirst($controller) . '.php')) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Find the path to a module's file.
	 *
	 * @param $module string The name of the module to find.
	 * @param $folder string The folder within the module to search for the file
	 *                (ie. controllers).
	 * @param $file   string The name of the file to search for.
	 *
	 * @return string The full path to the file.
	 */
	public static function file_path($module = NULL, $folder = NULL, $file = NULL) {
		if (empty($module) || empty($folder) || empty($file)) {
			return FALSE;
		}

		foreach (Modules::folders() as $module_folder) {
			if (is_file("{$module_folder}{$module}/{$folder}/{$file}")) {
				return "{$module_folder}{$module}/{$folder}/{$file}";
			} elseif (is_file("{$module_folder}{$module}/{$folder}/" . ucfirst($file))) {
				return "{$module_folder}{$module}/{$folder}/" . ucfirst($file);
			}
		}
	}

	/**
	 * Return the path to the module and its specified folder.
	 *
	 * @param $module string The name of the module (must match the folder name).
	 * @param $folder string The folder name to search for (Optional).
	 *
	 * @return string The path, relative to the front controller.
	 */
	public static function path($module = NULL, $folder = NULL) {
		foreach (Modules::folders() as $module_folder) {
			// Check each folder for the module's folder.
			if (is_dir("{$module_folder}{$module}")) {
				// If $folder was specified and exists, return it.
				if (!empty($folder)
					AND is_dir("{$module_folder}{$module}/{$folder}")
				) {
					return "{$module_folder}{$module}/{$folder}";
				}

				// Return the module's folder.
				return "{$module_folder}{$module}/";
			}
		}
	}

	/**
	 * Return an associative array of files within one or more modules.
	 *
	 * @param $module_name   string  If not null, will return only files from that
	 *                       module.
	 * @param $module_folder string  If not null, will return only files within
	 *                       that sub-folder of each module (ie 'views').
	 *
	 * @return array An associative array, like:
	 * <code>
	 * array(
	 *     'module_name' => array(
	 *         'folder' => array('file1', 'file2')
	 *     )
	 * )
	 */
	public static function files($module_name = NULL, $module_folder = NULL) {
		// Ensure the directory_map() function is available.
		if (!function_exists('directory_map')) {
			get_instance()->load->helper('directory');
		}

		$files = array();
		foreach (Modules::folders() as $path) {
			// Only map the whole modules directory if $module_name isn't passed.
			if (empty($module_name)) {
				$modules = directory_map($path);
			} elseif (is_dir($path . $module_name)) {
				// Only map the $module_name directory if it exists.
				$path = $path . $module_name;
				$modules[$module_name] = directory_map($path);
			}

			// If the element is not an array, it's a file, so ignore it. Otherwise,
			// it is assumed to be a module.
			if (empty($modules) || !is_array($modules)) {
				continue;
			}

			foreach ($modules as $modDir => $values) {
				if (is_array($values)) {
					if (empty($module_folder)) {
						// Add the entire module.
						$files[$modDir] = $values;
					} elseif (!empty($values[$module_folder])) {
						// Add just the specified folder for this module.
						$files[$modDir] = array(
							$module_folder => $values[$module_folder],
						);
					}
				}
			}
		}

		return empty($files) ? FALSE : $files;
	}

	/**
	 * Returns an array of the folders in which modules may be stored.
	 *
	 * @return array The folders in which modules may be stored.
	 */
	public static function folders() {
		return array_keys(Modules::$locations);
	}

	/**
	 * Returns a list of all modules in the system.
	 *
	 * @return array A list of all modules in the system.
	 */
	public static function list_modules() {
		$map = array();
		foreach (Modules::paths() as $dir => $path) {
			$map[] = $dir;
		}

		$count = count($map);
		if (!$count) {
			return $map;
		}

		// Clean out any html or php files.
		for ($i = 0; $i < $count; $i++) {
			if (stripos($map[$i], '.html') !== FALSE
				|| stripos($map[$i], '.php') !== FALSE
			) {
				unset($map[$i]);
			}
		}

		return $map;
	}

	/**
	 * Create a Directory Map of all extensions
	 *
	 * @return array A list of all extensions in the system.
	 */
	public static function paths() {
		$filedata = array();
		foreach (self::folders() as $folder) {
			if ($fp = @opendir($folder)) {
				$folder = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

				while (FALSE !== ($extension = readdir($fp))) {
					// Remove '.', '..', and hidden files [optional]
					if ($extension === '.' OR $extension === '..' OR $extension[0] === '.') {
						continue;
					}

					if (!is_file($folder . $extension)) {
						$filedata[basename($extension)] = $folder . $extension;
					}
				}

				closedir($fp);
			}
		}

		return $filedata;

		return FALSE;
	}

	/**
	 * Finds all available extensions and loads them in to the $extensions array.
	 *
	 * @return array
	 */
	public static function load_extensions() {
		self::$extensions = [];

		foreach (self::paths() as $name => $path) {
			self::load_extension($name, $path);
		}

		return self::$extensions;
	}

	/**
	 * Loads a single extension in to the manager.
	 *
	 * @param string $name Eg: directory_name
	 * @param string $path Eg: ROOTPATH . EXTPATH.'directory_name';
	 *
	 * @return object|void
	 */
	public static function load_extension($name, $path) {
		if (!self::check_name($name)) return;

		if (isset(self::$extensions[$name])) {
			return self::$extensions[$name];
		}

		$extension_class = ucfirst($name) . '\Extension';
		$extension_class_path = $path . '/Extension.php';

		if (!class_exists('Base_Extension')) {
			if (is_file($location = IGNITEPATH . 'core/Base_Extension' . '.php')) {
				include_once $location;
			}
		}

		// Autoloader failed?
		if (!file_exists($extension_class_path)) {
			log_message('error', "Missing Extension class in '{$name}', create an Extension class to override extensionMeta() method.");

			return;
		}

		include_once $extension_class_path;

		$extension_class_obj = new $extension_class();

		// Check for disabled plugins
		if (self::is_disabled($name)) {
			$extension_class_obj->disabled = TRUE;
		}

		self::$extensions[$name] = $extension_class_obj;
		self::$paths[$name] = $path;

		return $extension_class_obj;
	}

	/**
	 * Runs the autoload() method on all extensions. Can only be called once.
	 *
	 * @return void
	 */
	public static function autoload_extensions() {
		if (self::$auto_loaded) {
			return;
		}

		foreach (self::$extensions as $name => $extension) {
			self::autoload_extension($extension);
		}

		self::$auto_loaded = TRUE;
	}

	/**
	 * Autoload a single extension object.
	 *
	 * @param Base_Extension $extension
	 *
	 * @return void
	 */
	public static function autoload_extension($extension = NULL) {
		if (!$extension) {
			return;
		}

		if ($extension->disabled) {
			return;
		}

		$extension->autoload();
	}

	/**
	 * Returns an array with all registered extensions
	 * The index is the extension name, the value is the extension object.
	 */
	public static function get_extensions() {
		$extensions = array();
		foreach (self::$extensions as $name => $extension) {
			if (!self::is_disabled($name))
				$extensions[$name] = $extension;
		}
		return $extensions;
	}

	/**
	 * Returns a plugin registration class based on its name.
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public static function find_extension($name) {
		if (!self::has_extension($name)) {
			return NULL;
		}

		return self::$extensions[$name];
	}

	/**
	 * Checks to see if an extension has been registered.
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public static function check_name($name) {
		return strpos($name, '_') === 0 ? NULL : $name;
	}

	/**
	 * Checks to see if an extension has been registered.
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public static function has_extension($name) {
		return isset(self::$extensions[$name]);
	}

	/**
	 * Determines if an extension is disabled by looking at the installed extensions config.
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public static function is_disabled($name) {
		if (!self::check_name($name) OR !array_key_exists($name, self::$installed_extensions)) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Loads all installed extension from application config.
	 */
	public static function load_installed() {
		if (($installed_extensions = config_item('installed_extensions')) AND is_array($installed_extensions)) {
			self::$installed_extensions = config_item('installed_extensions');
		}
	}

	/**
	 * Extract uploaded extension zip folder
	 *
	 * @param array $zip_file $_FILES[tmp_name]
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public static function extract_extension($zip_file) {
		if (file_exists($zip_file) AND class_exists('ZipArchive')) {
			chmod($zip_file, DIR_READ_MODE);
			$EXTPATH = ROOTPATH . EXTPATH;

			$zip = new ZipArchive;
			if ($zip->open($zip_file) === TRUE) {
				if ($zip->locateName('Extension.php') !== FALSE) {
					return FALSE;
				}

				$extension_dir = $zip->getNameIndex(0);
				if (preg_match('/\s/', $extension_dir) OR file_exists($EXTPATH . '/' . $extension_dir)) {
					return FALSE;
				}

				$zip->extractTo($EXTPATH);
				$zip->close();

				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Migrate to the latest version or drop all migrations
	 * for a given module migration
	 *
	 * @param string $module
	 * @param bool   $downgrade
	 *
	 * @return bool
	 */
	public static function run_migration($module, $downgrade = FALSE) {
		list($path) = Modules::find('migration', $module, 'config/');

		if (!$path) {
			return FALSE;
		}

		$migration = Modules::load_file('migration', $path, 'config');

		if (!isset($migration['migration_enabled'])) $migration['migration_enabled'] = TRUE;

		$CI =& get_instance();
		$CI->load->library('migration', $migration);

		if ($downgrade === TRUE) {
			$CI->migration->version('0', $module);
		} else {
			$CI->migration->current($module);
		}
	}
}