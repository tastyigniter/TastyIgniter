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

        log_message('info', 'Base Controller Class Initialized');

        $this->load->library('alert');

        $this->config->load_db_config();

        // Load system settings
        $this->load->library('setting');

        // Load session
//        $this->load->driver('session');
        $this->load->library('session');


//        $this->load->library('extension');
        if (method_exists( $this->router, 'fetch_module' ) AND $this->router->fetch_module()) {
//            var_dump('is_module');var_dump($this->router->fetch_module());
//            $this->setting->setModule($this->router->fetch_module());
        }

        $this->form_validation->CI =& $this;
    }
}

/* End of file Ext_Controller.php */
/* Location: ./system/tastyigniter/core/Ext_Controller.php */