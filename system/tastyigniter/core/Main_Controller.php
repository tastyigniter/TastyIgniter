<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
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

        // Load permalink
        $this->load->library('permalink');

		$this->load->library('customer');

		$this->load->library('activity');

		$this->load->library('template');

        // Set default theme
        if ($default_theme = $this->config->item(MAINDIR, 'default_themes')) {
            $this->template->setTheme($default_theme);
        }

//		$this->load->model('Extensions_model');
        $this->load->library('extension');

		$this->load->model('Pages_model');

		$this->load->library('location');
	}
}

/* End of file Main_Controller.php */
/* Location: ./system/tastyigniter/core/Main_Controller.php */