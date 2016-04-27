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

/**
 * Base Controller Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Base_Controller.php
 * @link           http://docs.tastyigniter.com
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

        // Load installer library and database config items
        $this->load->library('installer');

        // If 'config/updated.txt' exists, system needs upgrade
        if (is_file(IGNITEPATH . 'config/updated.txt')) {
            if ($this->installer->upgrade()) redirect(admin_url('dashboard'));
        }

        // Redirect to setup if app requires setup
        if (($installed = $this->installer->isInstalled()) !== TRUE AND APPDIR !== 'setup') {
            redirect(root_url('setup'));
        }

        // If database is connected, then app is ready
        if ($this->installer->db_exists === TRUE) {

            // Load extension library
            $this->load->library('extension');

            // Load events library
            $this->load->library('events');

            // If the requested controller is a module controller then load the module config
            if (ENVIRONMENT !== 'testing') {
                if ($this->extension AND $this->router AND $_module = $this->router->fetch_module()) {
                    // Load the module configuration file and retrieve its items.
                    // Shows 404 error message on failure to load
                    $this->extension->loadConfig($_module, TRUE);
                }
            }
        }

        // Check app for maintenance in production environments.
        if (ENVIRONMENT === 'production') {

            // Show maintenance message if maintenance is enabled
            if ($this->maintenanceEnabled()) {
                show_error($this->config->item('maintenance_message'), '503', 'Maintenance Enabled');
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