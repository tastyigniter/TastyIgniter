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
defined('BASEPATH') or exit('No direct script access allowed');

/* load the HMVC_Loader class */
require IGNITEPATH . 'third_party/MX/Loader.php';

/**
 * TastyIgniter Loader Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Loader.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Loader extends MX_Loader {

    protected $_ci_view_paths =	array(VIEWPATH	=> TRUE, THEMEPATH => TRUE);

    protected $_ci_library_paths =	array(IGNITEPATH, BASEPATH, APPPATH);

    protected $_ci_model_paths =	array(IGNITEPATH, APPPATH);

    protected $_ci_helper_paths =	array(IGNITEPATH, BASEPATH);

    protected $_db_config_loaded =	FALSE;

	/**
     * Initializer
     *
     * @param null $controller
     */
    public function initialize($controller = NULL)
    {
        // Load system configuration from database
        $this->_load_db_config();

        parent::initialize($controller);
    }

    // --------------------------------------------------------------------

    /**
     * Remove later
     * @param $class
     * @param null $params
     * @param null $object_name
     */
    protected function _ci_load_class($class, $params = NULL, $object_name = NULL) {
        return $this->_ci_load_library($class, $params, $object_name);
    }

    // --------------------------------------------------------------------

    /** Load a module view **/
    public function view($view, $vars = array(), $return = FALSE)
    {
        $theme_paths = array(
            $this->config->item(APPDIR, 'default_themes'), $this->config->item(APPDIR.'_parent', 'default_themes')
        );

        foreach (array_filter($theme_paths) as $theme_path) {
            $theme_path = rtrim($theme_path, '/');

            foreach (array('/', '/layouts/', '/partials/') as $folder) {
                $t_view = (pathinfo($view, PATHINFO_EXTENSION)) ? $view : $view.EXT;

                if (file_exists(THEMEPATH . $theme_path . $folder . $t_view)) {
                    $path = THEMEPATH . $theme_path . $folder;
                    $this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
                    break;
                }
            }
        }

        if (empty($path)) {
            list($path, $_view) = Modules::find($view, $this->_module, 'views/');

            if ($path != FALSE) {
                $this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
                $view = $_view;
            }
        }

        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
    }

    // --------------------------------------------------------------------

    /**
     * CI Autoloader
     *
     * Loads component listed in the config/autoload.php file.
     *
     * @used-by CI_Loader::initialize()
     * @return  void
     */
    protected function _ci_autoloader()
    {
        if (file_exists(IGNITEPATH.'config/autoload.php'))
        {
            include(IGNITEPATH.'config/autoload.php');
        }

        if (file_exists(IGNITEPATH.'config/'.ENVIRONMENT.'/autoload.php'))
        {
            include(IGNITEPATH.'config/'.ENVIRONMENT.'/autoload.php');
        }

        if ( ! isset($autoload))
        {
            return;
        }

        // Autoload packages
        if (isset($autoload['packages']))
        {
            foreach ($autoload['packages'] as $package_path)
            {
                $this->add_package_path($package_path);
            }
        }

        // Load any custom config file
        if (count($autoload['config']) > 0)
        {
            foreach ($autoload['config'] as $val)
            {
                $this->config($val);
            }
        }

        // Autoload helpers and languages
        foreach (array('helper', 'language') as $type)
        {
            if (isset($autoload[$type]) && count($autoload[$type]) > 0)
            {
                $this->$type($autoload[$type]);
            }
        }

        // Autoload drivers
        if (isset($autoload['drivers']))
        {
            $this->driver($autoload['drivers']);
        }

        // Load libraries
        if (isset($autoload['libraries']) && count($autoload['libraries']) > 0)
        {
            // Load the database driver.
            if (in_array('database', $autoload['libraries']))
            {
                $this->database();
                $autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
            }

            // Load all other libraries
            $this->library($autoload['libraries']);
        }

        // Autoload models
        if (isset($autoload['model']))
        {
            $this->model($autoload['model']);
        }
    }

    // --------------------------------------------------------------------

	/**
     * Load config from database
     *
     * Fetches the config values from the database and adds them to config array
     *
     */
    protected function _load_db_config() {
        if ($this->_db_config_loaded === TRUE) {
            return;
        }

        $this->database();

        // Make sure the database is connected and settings table exists
        if ($this->db->conn_id !== FALSE AND $this->db->table_exists('settings')) {

            $this->db->query("SET SESSION sql_mode=''");

            $this->db->from('settings');

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $setting) {
                    if ( ! empty($setting['serialized'])) {
                        $this->config->set_item($setting['item'], unserialize($setting['value']));
                    } else {
                        $this->config->set_item($setting['item'], $setting['value']);
                    }
                }

                if ($this->config->item('timezone')) {
                    date_default_timezone_set($this->config->item('timezone'));
                }

                if ($this->config->item('site_url')) {
                    $this->config->set_item('base_url', trim($this->config->item('site_url'), '/') . '/' . (APPDIR === MAINDIR) ? '' : APPDIR);
                }

                $this->_db_config_loaded = TRUE;

                log_message('info', 'Database Config Loaded');
            }
        }
    }
}

/* End of file TI_Loader.php */
/* Location: ./system/tastyigniter/core/TI_Loader.php */