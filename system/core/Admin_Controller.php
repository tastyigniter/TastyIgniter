<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller Class
 *
 * @category       Libraries
 * @package        Igniter\Core\Admin_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Admin_Controller extends BaseController
{

    /**
     * @var bool Requires the admin user to be logged in.
     */
    protected $requireAuthentication = TRUE;

    /**
     * @var object Stores the logged in admin user.
     */
    protected $currentUser;

    /**
     * @var array Filters for list columns
     */
    public $filter = [];

    /**
     * @var array Default sort
     */
    public $default_sort = [];

    /**
     * @var array Sorting columns
     */
    public $sort = [];

    /**
     * @var string Link URL for the index page
     */
    public $index_url = null;

    /**
     * @var string Link URL for the create page
     */
    public $create_url = null;

    /**
     * @var string Link URL for the edit page
     */
    public $edit_url = null;

    /**
     * @var string Link URL for the edit page
     */
    public $delete_url = null;

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        // autoload libraries
        $this->libraries = array_merge([
            'form_validation',
            'user',
        ], $this->libraries);

        $this->models = array_merge([
            'Settings_model',
            'Locations_model',
        ], $this->models);

        parent::__construct();

        // Ensures that a user is logged in, if required
        if ($this->requireAuthentication === TRUE)
            $this->setUser();

        Events::trigger('before_admin_controller');

        if (!isset($this->index_url)) $this->index_url = $this->controller;
        if (!isset($this->create_url)) $this->create_url = $this->controller.'/edit';
        if (!isset($this->edit_url)) $this->edit_url = $this->controller.'/edit?id={id}';
        if (!isset($this->delete_url)) $this->delete_url = $this->controller;

        if (!empty($this->filter) OR !empty($this->default_sort)) $this->setFilter();
        if (!empty($this->sort)) $this->setSort();

        // @todo: use new template event binder instead..
        // Change nav menu if single location mode is activated
//		if (($this->user AND $this->user->isStrictLocation()) OR $this->config->item('site_location_mode') === 'single') {
//			$this->template->removeNavMenuItem('locations', 'restaurant');
//			$menu = array('priority' => '1', 'class' => 'locations', 'href' => site_url('locations/edit'), 'title' => lang('menu_setting'), 'permission' => 'Admin.Locations');
//			$this->template->addNavMenuItem('locations', $menu, 'restaurant');
//		}

		$this->form_validation->CI =& $this;

        log_message('info', 'Admin Controller Class Initialized');
    }

    protected function setUser()
    {
        if (!class_exists('User', FALSE))
            show_error('User library class must be loaded to use Authentication.');

        // Load the currently logged-in user for convenience
        if ($this->user->auth()) {
            $this->currentUser = $this->user->getUser();
        }
    }

    public function redirect($uri = null)
    {
        if (is_numeric($uri)) {
            $uri = ($this->input->post('save_close') != '1') ? str_replace('{id}', $uri, $this->edit_url) : null;
        }

        parent::redirect($uri);
    }
}

/* End of file Admin_Controller.php */
/* Location: ./system/tastyigniter/core/Admin_Controller.php */