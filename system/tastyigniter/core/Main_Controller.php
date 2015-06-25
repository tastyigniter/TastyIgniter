<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Main Controller Class
 *
 */
class Main_Controller extends Base_Controller {

    /**
     * Class constructor
     *
     */
	public function __construct()
	{
        parent::__construct();

		log_message('info', 'Main Controller Class Initialized');

        $this->load->library('template');

        $this->load->library('extension');

        // Load permalink
        $this->load->library('permalink');

        $this->load->library('customer');

        $this->load->library('customer_online');

        $this->load->model('Pages_model');

		$this->load->library('location');

        // Set default theme
        if ($default_theme = $this->config->item(MAINDIR, 'default_themes')) {
            $this->template->setTheme($default_theme);
        }
    }
}

/* End of file Main_Controller.php */
/* Location: ./system/tastyigniter/core/Main_Controller.php */