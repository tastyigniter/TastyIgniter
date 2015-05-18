<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
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

        if (!$this->user->isLogged() AND $this->uri->segment(1) !== 'login') {
            redirect(root_url('admin/login'));
        }

        if ($this->user->isLogged()) {
            if (!$this->user->hasPermissions('modify') AND $this->user->hasPermissions('access')) {
                $this->alert->set('warning', 'Warning: You do not have permission to modify!');
                redirect(referrer_url());
            } else if (!$this->user->hasPermissions('access') OR !$this->user->hasPermissions('modify')) {
                redirect(root_url('admin/permission'));
            }
        }

        $this->load->library('template');

        // Set default theme
        if ($default_theme = $this->config->item(ADMINDIR, 'default_themes')) {
            $this->template->setTheme($default_theme);
        }
    }
}

/* End of file Admin_Controller.php */
/* Location: ./system/tastyigniter/core/Admin_Controller.php */