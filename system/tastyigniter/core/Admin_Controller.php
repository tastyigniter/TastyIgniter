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
 * Admin Controller Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Admin_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Admin_Controller extends Authenticated_Controller
{
	/**
	 * @var string Link URL for the create page
	 */
	public $create_url = NULL;

	/**
	 * @var string Link URL for the edit page
	 */
	public $edit_url = NULL;

	/**
	 * @var string Link URL for the edit page
	 */
	public $delete_url = NULL;

	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		$this->libraries[] = 'form_validation';

		parent::__construct();

		log_message('info', 'Admin Controller Class Initialized');

		// Load template library
		$this->load->library('template');

		$this->form_validation->CI =& $this;

		if (!isset($this->index_url)) $this->index_url = $this->controller;
		if (!isset($this->create_url)) $this->create_url = $this->controller . '/edit';
		if (!isset($this->edit_url)) $this->edit_url = $this->controller . '/edit?id={id}';
		if (!isset($this->delete_url)) $this->delete_url = $this->controller;

		$this->createFilter();
		$this->createSorting();
	}

	protected function redirect($uri = NULL) {
		if (is_numeric($uri)) {
			$uri = ($this->input->post('save_close') !== '1') ? str_replace('{id}', $uri, $this->edit_url) : NULL;
		}

		parent::redirect($uri);
	}
}

/* End of file Admin_Controller.php */
/* Location: ./system/tastyigniter/core/Admin_Controller.php */