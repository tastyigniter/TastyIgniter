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
class Admin_Controller extends Base_Controller {

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
        parent::__construct();

		log_message('info', 'Admin Controller Class Initialized');

        $this->load->library('user');

        if (!$this->user->isLogged() AND $this->uri->rsegment(1) !== 'login' AND $this->uri->rsegment(1) !== 'logout') {
            $this->alert->set('danger', 'You must be logged in to access that page.');
            $this->session->set_tempdata('previous_url', current_url());
            redirect(root_url(ADMINDIR.'/login'));
        }
    }
}

/* End of file Admin_Controller.php */
/* Location: ./system/tastyigniter/core/Admin_Controller.php */