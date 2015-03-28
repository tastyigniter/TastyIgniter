<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extensions Controller Class
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

        log_message('debug', 'Base Controller Class Initialized');

        $this->load->library('alert');

        // Load system settings
        $this->load->library('setting');

        // Load session
        $this->load->driver('session');

        if ($this->config->item('ti_version') !== 'v1.3-beta' AND APPDIR !== 'setup') {
            redirect(root_url('setup/'));
        }

        if ($this->config->item('maintenance_mode') === '1') {  													// if customer is not logged in redirect to account login page
            $this->setting->setMaintainance();
        }

        $this->form_validation->CI =& $this;
    }
}

/* End of file Ext_Controller.php */
/* Location: ./system/tastyigniter/core/Ext_Controller.php */