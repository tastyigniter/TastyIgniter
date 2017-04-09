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

if (!function_exists('get_app_dir')) {
    /**
     * Loads the main config.php file
     *
     * This function lets us grab the config file even if the Config class
     * hasn't been instantiated yet
     *
     * @param    array
     *
     * @return    array
     */
    function get_app_dir()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $parsedUri = parse_url('http://dummy'.$_SERVER['REQUEST_URI']);
            $uri = isset($parsedUri['path']) ? $parsedUri['path'] : '';
        } else {
            $uri = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
            $explodedUri = explode('?', $uri, 2);
            $uri = isset($explodedUri[0]) ? $explodedUri[0] : '';
        }

        $appDir = MAINDIR;
        if (!(trim($uri, '/') === '')) {
            $uriParts = explode('/', trim($uri, '/'));
            if (isset($uriParts[0]) AND in_array($uriParts[0], [ADMINDIR, 'setup']))
                $appDir = $uriParts[0];
        }

        return $appDir;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('get_default_view_path')) {
    /**
     * Loads the main config.php file
     *
     * This function lets us grab the config file even if the Config class
     * hasn't been instantiated yet
     *
     * @param    array
     *
     * @return    array
     */
    function get_default_view_path()
    {
        $viewFolder = 'themes';
        $viewPath = THEMEPATH.DIRECTORY_SEPARATOR;
        if (APPDIR != MAINDIR) {
            $viewFolder = 'views';
            $viewPath = TI_APPPATH.$viewFolder.DIRECTORY_SEPARATOR;
        }

        return [$viewFolder, $viewPath];
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('base_path'))
{
    /**
     * Get the path to the base folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function base_path($path = null)
    {
        return rtrim(ROOTPATH, DIRECTORY_SEPARATOR) . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('app_path'))
{
    /**
     * Get the path to the application folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function app_path($path = null)
    {
        return rtrim(ROOTPATH, DIRECTORY_SEPARATOR) . APPDIR . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('extension_path'))
{
    /**
     * Get the path to the extensions folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function extension_path($path = null)
    {
        return rtrim(key(config_item('modules_locations')), DIRECTORY_SEPARATOR) . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('assets_path'))
{
    /**
     * Get the path to the assets folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function assets_path($path = null)
    {
        return rtrim(ASSETPATH, DIRECTORY_SEPARATOR) . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('image_path'))
{
    /**
     * Get the path to the assets image folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function image_path($path = null)
    {
        return rtrim(IMAGEPATH, DIRECTORY_SEPARATOR) . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('storage_path'))
{
    /**
     * Get the path to the assets downloads folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function storage_path($path = null)
    {
        return config_item('storage_path') . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('temp_path'))
{
    /**
     * Get the path to the downloads temp folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function temp_path($path = null)
    {
        return rtrim(ASSETPATH, DIRECTORY_SEPARATOR) .'/downloads/temp' . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
// ------------------------------------------------------------------------

if (!function_exists('get_mimes')) {
    /**
     * Returns the MIME types array from config/mimes.php
     *
     * @return    array
     */
    function &get_mimes()
    {
        static $_mimes;

        if (empty($_mimes)) {
            if (file_exists(ROOTPATH.'config/' . ENVIRONMENT . '/mimes.php')) {
                $_mimes = include(ROOTPATH.'config/' . ENVIRONMENT . '/mimes.php');
            } elseif (file_exists(ROOTPATH.'config/mimes.php')) {
                $_mimes = include(ROOTPATH.'config/mimes.php');
            } else {
                $_mimes = [];
            }
        }

        return $_mimes;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('load_class')) {
    /**
     * Class registry
     *
     * This function acts as a singleton. If the requested class does not
     * exist it is instantiated and set to a static variable. If it has
     * previously been instantiated the variable is returned.
     *
     * @param    string    the class name being requested
     * @param    string    the directory where the class should be found
     * @param    string    an optional argument to pass to the class constructor
     *
     * @return    object
     */
    function &load_class($class, $directory = 'libraries', $param = null)
    {
        static $_classes = [];

        // Does the class exist? If so, we're done...
        if (isset($_classes[$class])) {
            return $_classes[$class];
        }

        $name = FALSE;

        // Look for the class first in the local application/libraries folder
        // then in the native system/libraries folder
        foreach ([IGNITEPATH, BASEPATH] as $path) {
            if (file_exists($path . $directory . '/' . $class . '.php')) {
                $name = 'CI_' . $class;

                if (class_exists($name, FALSE) === FALSE) {
                    require_once($path . $directory . '/' . $class . '.php');
                }

                break;
            }
        }

        // Is the request a class extension? If so we load it too
        if (file_exists(IGNITEPATH . $directory . '/' . config_item('subclass_prefix') . $class . '.php')) {
            $name = config_item('subclass_prefix') . $class;

            if (class_exists($name, FALSE) === FALSE) {
                require_once(IGNITEPATH . $directory . '/' . $name . '.php');
            }
        }

        // Did we find the class?
        if ($name === FALSE) {
            // Note: We use exit() rather than show_error() in order to avoid a
            // self-referencing loop with the Exceptions class
            set_status_header(503);
            echo 'Unable to locate the specified class: ' . $class . '.php';
            exit(5); // EXIT_UNK_CLASS
        }

        // Keep track of what we just loaded
        is_loaded($class);

        $_classes[$class] = isset($param)
            ? new $name($param)
            : new $name();

        return $_classes[$class];
    }
}

// --------------------------------------------------------------------

if (!function_exists('get_config')) {
    /**
     * Loads the main config.php file
     *
     * This function lets us grab the config file even if the Config class
     * hasn't been instantiated yet
     *
     * @param    array
     *
     * @return    array
     */
    function &get_config(Array $replace = [])
    {
        static $config;

        if (empty($config)) {
            $file_path = ROOTPATH.'config/config.php';
            $found = FALSE;
            if (file_exists($file_path)) {
                $found = TRUE;
                require($file_path);
            }

            // Is the config file in the environment folder?
            if (file_exists($file_path = ROOTPATH.'config/' . ENVIRONMENT . '/config.php')) {
                require($file_path);
            } elseif (!$found) {
                set_status_header(503);
                echo 'The configuration file does not exist.';
                exit(3); // EXIT_CONFIG
            }

            // Does the $config array exist in the file?
            if (!isset($config) OR !is_array($config)) {
                set_status_header(503);
                echo 'Your config file does not appear to be formatted correctly.';
                exit(3); // EXIT_CONFIG
            }
        }

        // Are any values being dynamically added or replaced?
        foreach ($replace as $key => $val) {
            $config[$key] = $val;
        }

        return $config;
    }
}

// ------------------------------------------------------------------------
