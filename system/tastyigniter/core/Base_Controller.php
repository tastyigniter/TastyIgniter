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

        // Load database if connected
        $DATABASE = $this->load->database('default', TRUE);
        if ($DATABASE->conn_id !== FALSE) {
            // Load system configuration from database
            $this->config->load_db_config();

            // Load extension library
            $this->load->library('extension');

            // Load template library
            $this->load->library('template');
        }

        // Redirect to setup if app requires setup
        if (APPDIR !== 'setup' AND TI_VERSION !== $this->config->item('ti_version')) redirect(root_url('setup/'));

        // Check app for setup or maintenance for production environments.
        if (ENVIRONMENT === 'production') {

            // Saving queries can vastly increase the memory usage, so better to turn off in production
            if ($DATABASE->conn_id !== FALSE) $this->db->save_queries = FALSE;

            // Show maintenance message if maintenance is enabled
            if ($this->maintenanceEnabled()) {
                show_error($this->config->item('maintenance_message'), '503', 'Maintenance Enabled');
            }

        } else if (ENVIRONMENT === 'development') {
            if ($DATABASE->conn_id !== FALSE) $this->db->db_debug = TRUE;
        }

        if (ENVIRONMENT !== 'testing') {
            // If the requested controller is a module controller then load the module config
            if ($this->extension AND $this->router AND $_module = $this->router->fetch_module()) {
                // Load the module configuration file and retrieve its items.
                // Shows 404 error message on failure to load
                $this->extension->loadConfig($_module, TRUE);
            }
        }

        // Enable profiler for development environments.
        if ( ! $this->input->is_ajax_request()) {
            $this->output->enable_profiler(TI_DEBUG);
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
}

/* End of file Base_Controller.php */
/* Location: ./system/tastyigniter/core/Base_Controller.php */