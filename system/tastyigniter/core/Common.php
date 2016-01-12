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
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('load_class'))
{
    /**
     * Class registry
     *
     * This function acts as a singleton. If the requested class does not
     * exist it is instantiated and set to a static variable. If it has
     * previously been instantiated the variable is returned.
     *
     * @param	string	the class name being requested
     * @param	string	the directory where the class should be found
     * @param	string	an optional argument to pass to the class constructor
     * @return	object
     */
    function &load_class($class, $directory = 'libraries', $param = NULL)
    {
        static $_classes = array();

        // Does the class exist? If so, we're done...
        if (isset($_classes[$class]))
        {
            return $_classes[$class];
        }

        $name = FALSE;

        // Look for the class first in the local application/libraries folder
        // then in the native system/libraries folder
        foreach (array(IGNITEPATH, BASEPATH) as $path)
        {
            if (file_exists($path.$directory.'/'.$class.'.php'))
            {
                $name = 'CI_'.$class;

                if (class_exists($name, FALSE) === FALSE)
                {
                    require_once($path.$directory.'/'.$class.'.php');
                }

                break;
            }
        }

        // Is the request a class extension? If so we load it too
        if (file_exists(IGNITEPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php'))
        {
            $name = config_item('subclass_prefix').$class;

            if (class_exists($name, FALSE) === FALSE)
            {
                require_once(IGNITEPATH.$directory.'/'.$name.'.php');
            }
        }

        // Did we find the class?
        if ($name === FALSE)
        {
            // Note: We use exit() rather than show_error() in order to avoid a
            // self-referencing loop with the Exceptions class
            set_status_header(503);
            echo 'Unable to locate the specified class: '.$class.'.php';
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

if ( ! function_exists('get_config'))
{
    /**
     * Loads the main config.php file
     *
     * This function lets us grab the config file even if the Config class
     * hasn't been instantiated yet
     *
     * @param	array
     * @return	array
     */
    function &get_config(Array $replace = array())
    {
        static $config;

        if (empty($config))
        {
            $file_path = IGNITEPATH.'config/config.php';
            $found = FALSE;
            if (file_exists($file_path))
            {
                $found = TRUE;
                require($file_path);
            }

            // Is the config file in the environment folder?
            if (file_exists($file_path = IGNITEPATH.'config/'.ENVIRONMENT.'/config.php'))
            {
                require($file_path);
            }
            elseif ( ! $found)
            {
                set_status_header(503);
                echo 'The configuration file does not exist.';
                exit(3); // EXIT_CONFIG
            }

            // Does the $config array exist in the file?
            if ( ! isset($config) OR ! is_array($config))
            {
                set_status_header(503);
                echo 'Your config file does not appear to be formatted correctly.';
                exit(3); // EXIT_CONFIG
            }
        }

        // Are any values being dynamically added or replaced?
        foreach ($replace as $key => $val)
        {
            $config[$key] = $val;
        }

        return $config;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_mimes'))
{
    /**
     * Returns the MIME types array from config/mimes.php
     *
     * @return	array
     */
    function &get_mimes()
    {
        static $_mimes;

        if (empty($_mimes))
        {
            if (file_exists(IGNITEPATH.'config/'.ENVIRONMENT.'/mimes.php'))
            {
                $_mimes = include(IGNITEPATH.'config/'.ENVIRONMENT.'/mimes.php');
            }
            elseif (file_exists(IGNITEPATH.'config/mimes.php'))
            {
                $_mimes = include(IGNITEPATH.'config/mimes.php');
            }
            else
            {
                $_mimes = array();
            }
        }

        return $_mimes;
    }
}

// ------------------------------------------------------------------------