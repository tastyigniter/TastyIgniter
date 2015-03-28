<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extensions Controller Class
 *
 */
class Ext_Controller extends Base_Controller {

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
        parent::__construct();

		log_message('debug', 'Extensions Controller Class Initialized');

		/*$this->load->library('customer');

		$this->load->library('template');
		$this->template->setTheme($this->config->item('main', 'default_themes'), MAINDIR);

		$this->load->library('extension');*/

		$this->load->library('extension');
		$this->load->model('Extensions_model');
	}
}

/* End of file Ext_Controller.php */
/* Location: ./system/tastyigniter/core/Ext_Controller.php */