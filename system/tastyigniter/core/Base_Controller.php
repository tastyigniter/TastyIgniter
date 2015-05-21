<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller Class
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

        $this->load->library('alert');

        // Load database and system configuration from database
        $this->load->database();
        if (!empty($this->db->username)) {
            $this->config->load_db_config();
        }

        // Load system settings
        $this->load->library('setting');

        // Load session
        $this->load->library('session');

        $this->form_validation->CI =& $this;
    }
}

/* End of file Base_Controller.php */
/* Location: ./system/tastyigniter/core/Base_Controller.php */