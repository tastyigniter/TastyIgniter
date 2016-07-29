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

		Events::trigger('after_main_controller');
	}

	protected function showMaintenance() {
		if ($this->config->item('maintenance_mode') === '1') {
			$this->load->library('user');
			if ($this->uri->rsegment(1) !== 'maintenance' AND !$this->user->isLogged()) {
				show_error($this->config->item('maintenance_message'), '503', 'Maintenance Enabled');
			}
		}
	}
}

/* End of file Main_Controller.php */
/* Location: ./system/tastyigniter/core/Main_Controller.php */