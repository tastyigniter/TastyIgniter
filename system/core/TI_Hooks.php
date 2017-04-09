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
 * TastyIgniter Hooks Class
 *
 * @category       Libraries
 * @package        Igniter\Core\TI_Hooks.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Hooks extends CI_Hooks
{

    public $defaultHooks = [
        'pre_system'                  => [
            'class'    => 'System',
            'function' => 'preSystem',
            'filename' => 'System.php',
            'filepath' => 'hooks',

        ],
        'pre_router'                  => [
            'class'    => 'System',
            'function' => 'preRouter',
            'filename' => 'System.php',
            'filepath' => 'hooks',

        ],
        'post_controller_constructor' => [
            'class'    => 'System',
            'function' => 'postControllerConstructor',
            'filename' => 'System.php',
            'filepath' => 'hooks',

        ],
        'post_controller'             => [
            'class'    => 'System',
            'function' => 'postController',
            'filename' => 'System.php',
            'filepath' => 'hooks',

        ],
    ];

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {
        $CFG =& load_class('Config', 'core');
        log_message('info', 'Hooks Class Initialized');

        // If hooks are not enabled in the config file
        // there is nothing else to do
        if ($CFG->item('enable_hooks') === FALSE) {
            return;
        }

        // Grab the "hooks" definition file.
        if (file_exists(ROOTPATH.'config/hooks.php')) {
            include(ROOTPATH.'config/hooks.php');
        }

        if (file_exists(ROOTPATH.'config/'.ENVIRONMENT.'/hooks.php')) {
            include(ROOTPATH.'config/'.ENVIRONMENT.'/hooks.php');
        }

        // If there are no hooks, we're done.
        if (!isset($hook) OR !is_array($hook)) {
            return;
        }

        $this->hooks =& $this->hooks;
        $this->enabled = TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Call Hook
     *
     * Calls a particular hook. Called by CodeIgniter.php.
     *
     * @uses    CI_Hooks::_run_hook()
     *
     * @param    string $which Hook name
     *
     * @return    bool    TRUE on success or FALSE on failure
     */
    public function call_hook($which = '')
    {
        if (isset($this->defaultHooks[$which]))
            $this->_run_hook($this->defaultHooks[$which]);

        return parent::call_hook($which);
    }

    // --------------------------------------------------------------------

    /**
     * Run Hook
     *
     * Runs a particular hook
     *
     * @param    array $data Hook details
     *
     * @return    bool    TRUE on success or FALSE on failure
     */
    protected function _run_hook($data)
    {
        // Closures/lambda functions and array($object, 'method') callables
        if (is_callable($data)) {
            is_array($data)
                ? $data[0]->{$data[1]}()
                : $data();

            return TRUE;
        } elseif (!is_array($data)) {
            return FALSE;
        }

        // -----------------------------------
        // Safety - Prevents run-away loops
        // -----------------------------------

        // If the script being called happens to have the same
        // hook call within it a loop can happen
        if ($this->_in_progress === TRUE) {
            return;
        }

        // -----------------------------------
        // Set file path
        // -----------------------------------

        if (!isset($data['filepath'], $data['filename'])) {
            return FALSE;
        }

        $filepath = IGNITEPATH.$data['filepath'].'/'.$data['filename'];

        if (!file_exists($filepath)) {
            $filepath = TI_APPPATH.$data['filepath'].'/'.$data['filename'];
            if (!file_exists($filepath)) {
                return FALSE;
            }
        }

        if (!file_exists($filepath)) {
            return FALSE;
        }

        // Determine and class and/or function names
        $class = empty($data['class']) ? FALSE : $data['class'];
        $function = empty($data['function']) ? FALSE : $data['function'];
        $params = isset($data['params']) ? $data['params'] : '';

        if (empty($function)) {
            return FALSE;
        }

        // Set the _in_progress flag
        $this->_in_progress = TRUE;

        // Call the requested class and/or function
        if ($class !== FALSE) {
            // The object is stored?
            if (isset($this->_objects[$class])) {
                if (method_exists($this->_objects[$class], $function)) {
                    $this->_objects[$class]->$function($params);
                } else {
                    return $this->_in_progress = FALSE;
                }
            } else {
                class_exists($class, FALSE) OR require_once($filepath);

                if (!class_exists($class, FALSE) OR !method_exists($class, $function)) {
                    return $this->_in_progress = FALSE;
                }

                // Store the object and execute the method
                $this->_objects[$class] = new $class();
                $this->_objects[$class]->$function($params);
            }
        } else {
            function_exists($function) OR require_once($filepath);

            if (!function_exists($function)) {
                return $this->_in_progress = FALSE;
            }

            $function($params);
        }

        $this->_in_progress = FALSE;

        return TRUE;
    }
}
