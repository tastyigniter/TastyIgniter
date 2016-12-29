<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Controller Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Main_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Main_Controller extends Base_Controller
{

	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		$this->libraries[] = 'form_validation';
		$this->models[] = 'Extensions_model';

		parent::__construct();

		Events::trigger('before_main_controller');

		log_message('info', 'Main Controller Class Initialized');

		// Check app for maintenance in production environments.
		if (ENVIRONMENT === 'production') {
			// Show maintenance message if maintenance is enabled
			$this->showMaintenance();
		}

		// Load permalink
		$this->load->library('permalink');

		// Load template library
		$this->load->library('template');

		$this->load->library('customer');

		$this->load->library('customer_online');

		$this->load->model('Pages_model');

		$this->load->library('location');

		$this->form_validation->CI =& $this;

		if (!isset($this->index_url)) $this->index_url = $this->controller;

		if (!empty($this->filter)) $this->setFilter();
		if (!empty($this->sort)) $this->setSort();
		
		Events::trigger('after_main_controller');
	}
}

/* End of file Main_Controller.php */
/* Location: ./system/tastyigniter/core/Main_Controller.php */