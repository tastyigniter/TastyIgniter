<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

(defined('EXT')) OR define('EXT', '.php');

global $CFG;

/* get module locations from config settings or use the default module location and offset */
is_array(Modules::$locations = $CFG->item('modules_locations')) OR Modules::$locations = array(
	APPPATH.'modules/' => '../modules/',
);

/* PHP5 spl_autoload */
spl_autoload_register('Modules::autoload');

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library provides functions to load and instantiate controllers
 * and module controllers allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Modules.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class Modules
{
	public static $routes, $registry, $locations;
	
	/**
	* Run a module controller method
	* Output from module is buffered and returned.
	**/
	public static function run($module) 
	{	
		$method = 'index';
		
		if(($pos = strrpos($module, '/')) != FALSE) 
		{
			$method = substr($module, $pos + 1);		
			$module = substr($module, 0, $pos);
		}

		if($class = self::load($module)) 
		{	
			if (method_exists($class, $method))	{
				ob_start();
				$args = func_get_args();
				$output = call_user_func_array(array($class, $method), array_slice($args, 1));
				$buffer = ob_get_clean();
				return ($output !== NULL) ? $output : $buffer;
			}
		}
		
		log_message('error', "Module controller failed to run: {$module}/{$method}");
	}
	
	/** Load a module controller **/
	public static function load($module) 
	{
		(is_array($module)) ? list($module, $params) = each($module) : $params = NULL;

		/* get the requested controller class name */
		$alias = strtolower(basename($module));

		/* create or return an existing controller from the registry */
		if ( ! isset(self::$registry[$alias])) 
		{
			/* find the controller */
			list($class) = CI::$APP->router->locate(explode('/', $module));
	
			/* controller cannot be located */
			if (empty($class)) return;
	
			/* set the module directory */
			$path = APPPATH.'controllers/'.CI::$APP->router->directory;

			/* load the controller class */
			$class = $class.CI::$APP->config->item('controller_suffix');
			self::load_file(ucfirst($class), $path);
			
			/* create and register the new controller */
			$controller = ucfirst($class);	
			self::$registry[$alias] = new $controller($params);
		}
		
		return self::$registry[$alias];
	}
	
	/** Library base class autoload **/
	public static function autoload($class) 
	{	
		/* don't autoload CI_ prefixed classes or those using the config subclass_prefix */
		if (strstr($class, 'CI_') OR strstr($class, config_item('subclass_prefix'))) return;

		/* autoload Modular Extensions MX core classes */
		if (strstr($class, 'MX_')) 
		{
			if (is_file($location = dirname(__FILE__).'/'.substr($class, 3).EXT)) 
			{
				include_once $location;
				return;
			}
			show_error('Failed to load MX core class: '.$class);
		}
		
		/* autoload core classes */
		if(is_file($location = BASEPATH.'core/'.ucfirst($class).EXT))
		{
			include_once $location;
			return;
		}		
		
		/* autoload library classes */
		if(is_file($location = BASEPATH.'libraries/'.ucfirst($class).EXT))
		{
			include_once $location;
			return;
		}		
	}

	/** Load a module file **/
	public static function load_file($file, $path, $type = 'other', $result = TRUE)	
	{
		$file = str_replace(EXT, '', $file);		
		$location = $path.$file.EXT;
		
		if ($type === 'other') 
		{			
			if (class_exists($file, FALSE))	
			{
				log_message('debug', "File already loaded: {$location}");				
				return $result;
			}	
			include_once $location;
		} 
		else 
		{
			/* load config or language array */
			include $location;

			if ( ! isset($$type) OR ! is_array($$type))				
				show_error("{$location} does not contain a valid {$type} array");

			$result = $$type;
		}
		log_message('debug', "File loaded: {$location}");
		return $result;
	}

	/** 
	* Find a file
	* Scans for files located within modules directories.
	* Also scans application directories for models, plugins and views.
	* Generates fatal error if file not found.
	**/
	public static function find($file, $module, $base) 
	{
		$segments = explode('/', $file);

		$file = array_pop($segments);
		$file_ext = (pathinfo($file, PATHINFO_EXTENSION)) ? $file : $file.EXT;
		
		$path = ltrim(implode('/', $segments).'/', '/');	
		$module ? $modules[$module] = $path : $modules = array();
		
		if ( ! empty($segments)) 
		{
			$modules[array_shift($segments)] = ltrim(implode('/', $segments).'/','/');
		}	

		foreach (Modules::$locations as $location => $offset) 
		{					
			foreach($modules as $module => $subpath) 
			{			
				$fullpath = $location.$module.'/'.$base.$subpath;
				
				if ($base == 'libraries/' OR $base == 'models/')
				{
					if(is_file($fullpath.ucfirst($file_ext))) return array($fullpath, ucfirst($file));
				}
				else
				/* load non-class files */
				if (is_file($fullpath.$file_ext)) return array($fullpath, $file);
			}
		}
		
		return array(FALSE, $file);	
	}
	
	/** Parse module routes **/
	public static function parse_routes($module, $uri) 
	{
		/* load the route file */
		if ( ! isset(self::$routes[$module])) 
		{
			if (list($path) = self::find('routes', $module, 'config/'))
			{
				$path && self::$routes[$module] = self::load_file('routes', $path, 'route');
			}
		}

        if ( ! isset(self::$routes[$module])) return;

        /* parse module routes */
        foreach (self::$routes[$module] as $key => $val)
        {
            $key = str_replace(array(':any', ':num'), array('.+', '[0-9]+'), $key);

            if (preg_match('#^'.$key.'$#', $uri))
            {
                if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
                {
                    $val = preg_replace('#^'.$key.'$#', $val, $uri);
                }
                return explode('/', $module.'/'.$val);
            }
        }
    }

    /**
     * Find the path to a module's file.
     *
     * @param $module string The name of the module to find.
     * @param $folder string The folder within the module to search for the file
     * (ie. controllers).
     * @param $file   string The name of the file to search for.
     *
     * @return string The full path to the file.
     */
    public static function file_path($module = null, $folder = null, $file = null)
    {
        if (empty($module) || empty($folder) || empty($file)) {
            return false;
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
    public static function path($module = null, $folder = null)
    {
        foreach (Modules::folders() as $module_folder) {
            // Check each folder for the module's folder.
            if (is_dir("{$module_folder}{$module}")) {
                // If $folder was specified and exists, return it.
                if (! empty($folder)
                    && is_dir("{$module_folder}{$module}/{$folder}")
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
     * module.
     * @param $module_folder string  If not null, will return only files within
     * that sub-folder of each module (ie 'views').
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
        if ( ! function_exists('directory_map')) {
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
            if (empty($modules) || ! is_array($modules)) {
                continue;
            }

            foreach ($modules as $modDir => $values) {
                if (is_array($values)) {
                    if (empty($module_folder)) {
                        // Add the entire module.
                        $files[$modDir] = $values;
                    } elseif ( ! empty($values[$module_folder])) {
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
     *
     * @return array A list of all modules in the system.
     */
    public static function list_modules() {
        // Ensure the directory_map function is available.
        if ( ! function_exists('directory_map')) {
            get_instance()->load->helper('directory');
        }

        $map = array();
        foreach (Modules::folders() as $folder) {
            $dirs = directory_map($folder, 1);
            if (is_array($dirs)) {
                $map = array_merge($map, $dirs);
            }
        }

        $count = count($map);
        if ( ! $count) {
            return $map;
        }

        // Clean out any html or php files.
        for ($i = 0; $i < $count; $i ++) {
            if (stripos($map[$i], '.html') !== FALSE
                || stripos($map[$i], '.php') !== FALSE
            ) {
                unset($map[$i]);
            }
        }

        return $map;
    }
}