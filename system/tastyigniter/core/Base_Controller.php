<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Base Controller Class
 *
 */
class Base_Controller extends MX_Controller {

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        log_message('info', 'Base Controller Class Initialized');

        // Load session
        $this->load->library('session');

        $this->load->library('alert');

        // Load database and system configuration from database
        $DATABASE = $this->load->database('default', TRUE);
        if ($DATABASE->conn_id !== FALSE) {
            $this->config->load_db_config();

            $this->load->library('extension');

            // Load template library
            $this->load->library('template');
        }

        // Redirect to setup if app requires setup
        if (APPDIR !== 'setup' AND TI_VERSION !== $this->config->item('ti_version')) redirect(root_url('setup/'));

        // Check app for setup or maintenance for production environments.
        if (ENVIRONMENT === 'production') {

            // Redirect to root url if app has already been set up
            if (APPDIR === 'setup' AND TI_VERSION === $this->config->item('ti_version')) redirect(root_url());

            // Saving queries can vastly increase the memory usage, so better to turn off in production
            $this->db->save_queries = FALSE;

            // Show maintenance message if maintenance is enabled
            if ($this->maintenanceEnabled()) {
                show_error($this->config->item('maintenance_message'), '503', 'Maintenance Enabled');
            }

        } else if (ENVIRONMENT === 'development') {
            $this->db->db_debug = TRUE;

            // Enable profiler for development environments.
            if ( ! $this->input->is_ajax_request()) {
                $this->output->enable_profiler(TRUE);
            }
        }

        // If the requested controller is a module controller then load the module config
        if (ENVIRONMENT !== 'testing') {
            if ($this->router AND $_module = $this->router->fetch_module()) {
                // Load the module configuration file and retrieve the configuration items
                $this->config->load($_module . '/' . $_module, TRUE);
                $config = $this->config->item($_module);

                // Check if the module configuration items are correctly set
                $this->checkModuleConfig($_module, $config);
            }
        }

        $this->form_validation->CI =& $this;
    }

    private function maintenanceEnabled() {
        if ($this->config->item('maintenance_mode') === '1') {
            $this->load->library('user');
            if (APPDIR === MAINDIR
                AND $this->uri->rsegment(1) !== 'maintenance'
                AND !$this->user->isLogged()
            ) {
                return TRUE;
            }
        }
    }

    private function checkModuleConfig($_module, $config) {
        if (!isset($config['ext_type']) OR !in_array($config['ext_type'], array('module', 'payment', 'widget'))) {
            show_error('Check that the extension [' . $_module . '] configuration type key is correctly set');
        }

        if (class_exists('admin_' . $_module, FALSE)) {
            $this->load->library('user');

            if (!isset($config['admin_options']) OR !is_bool($config['admin_options']) OR !class_exists('Admin_Controller', FALSE)) {
                show_error('Check that the extension [' . $_module . '] configuration admin_options key is correctly set');
            }
        }
    }
}

/* End of file Base_Controller.php */
/* Location: ./system/tastyigniter/core/Base_Controller.php */