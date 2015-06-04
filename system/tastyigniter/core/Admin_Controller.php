<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Admin Controller Class
 *
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

        if (!$this->user->isLogged() AND $this->uri->rsegment(1) !== 'login') {
            $this->alert->set('danger', 'You must be logged in to access that page.');
            $this->session->set_tempdata('previous_url', current_url());
            redirect(root_url(ADMINDIR.'/login'));
        }
    }
}

/* End of file Admin_Controller.php */
/* Location: ./system/tastyigniter/core/Admin_Controller.php */