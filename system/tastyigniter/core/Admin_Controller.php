<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 */
class Admin_Controller extends Base_Controller {

    public $_permission_rules = array();

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

        if ($this->user->isLogged() AND !empty($this->_permission_rules)) {
            $this->fetchPermission();
        }

        $this->load->library('template');

        // Set default theme
        if ($default_theme = $this->config->item(ADMINDIR, 'default_themes')) {
            $this->template->setTheme($default_theme);
        }
    }

    private function fetchPermission() {

        if (method_exists($this->router, 'fetch_module') AND $this->router->fetch_module()) {
            $controller = $this->CI->router->fetch_module();
        } else {
            $controller = $this->router->class;
        }

        $method = $this->router->method;

        if (!is_array($this->_permission_rules)) $this->_permission_rules = array($this->_permission_rules);

        foreach ($this->_permission_rules as $rule) {
            if (!is_string($rule)) continue;

            if (strpos($rule, '[') !== FALSE AND preg_match('/\[(.*?)\]/', $rule, $methods) === 1) {
                $type = substr($rule, 0, strpos($rule, '['));
                $methods = explode('|', $methods[1]);
            } else {
                $type = $rule;
                $methods = array('index');
            }

            if (in_array($method, $methods)) {
                if ($this->input->method() === 'post' AND $type === 'modify' AND !$this->user->hasPermissions($type, $controller)) {
                    $this->alert->set('warning', 'Warning: You do not have permission to modify!');
                    redirect(referrer_url());
                } else if ($this->input->method() !== 'post' AND $type === 'access' AND !$this->user->hasPermissions($type, $controller)) {
                    redirect(root_url('admin/permission'));
                }
            }
        }

    }
}

/* End of file Admin_Controller.php */
/* Location: ./system/tastyigniter/core/Admin_Controller.php */