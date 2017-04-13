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
 * User Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\User.php
 * @link           http://docs.tastyigniter.com
 */
class User extends \Igniter\Core\Auth
{

    protected $model = 'Users_model';
    protected $identifier = 'username';

	private $is_logged = FALSE;
	private $user_id;
	private $username;
	private $staff_id;
	private $permissions = [];
	private $permission_action = [];
	private $permitted_actions = [];
	private $available_actions = [];
	private $staff_name;
	private $staff_email;
	private $staff_group_name;
	private $staff_group_id;
	private $location_id;
	private $location_name;
	private $customer_account_access;
	private $location_access;
	private $unread;

	public function __construct()
	{
        parent::__construct();
        $this->initialize();
	}

	public function initialize()
	{
        if (is_null($userModel = $this->user()))
            return;

        foreach ($userModel->toArray() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->is_logged = TRUE;
    }

    /**
     * Redirect if the current user is not authenticated.
     */
    public function auth()
    {
        if (!$this->check()) {
            $this->alert->set('danger', $this->lang->line('alert_user_not_logged_in'));
            $prepend = empty($uri) ? '' : '?redirect='.str_replace(site_url(), '/', current_url());
            redirect(admin_url('login'.$prepend));
        }
    }

	public function restrict($permission, $uri = '')
	{
		// If user isn't logged in, redirect to the login page.
		if (!$this->is_logged AND $this->uri->rsegment(1) !== 'login') redirect(admin_url('login'));

		// Check whether the user has the proper permissions action.
		if (($has_permission = $this->checkPermittedActions($permission, TRUE)) === TRUE) return TRUE;

		if ($uri === '') { // get the previous page from the session.
			$uri = referrer_url();

			// If previous page and current page are the same, but the user no longer
			// has permission, redirect to site URL to prevent an infinite loop.
            if (empty($uri) OR $uri === current_url() AND !$this->input->post()) {
				$uri = site_url();
			}
		}

        if (!$this->input->is_ajax_request()) {  // remove later
			redirect($uri);
		}
	}

	public function restrictLocation($location_id, $permission, $redirect = FALSE)
	{
		if ($this->staff_group_id == '11') return FALSE;

		if (empty($location_id)) return FALSE;

		$is_strict_location = $this->isStrictLocation();
		if ($is_strict_location AND $location_id !== $this->getLocationId()) {
			$permission = (substr_count($permission, '.') === 2) ? substr($permission, 0, strrpos($permission, '.')) : $permission;
			$context = substr($permission, strpos($permission, '.') + 1);
			$action = end($this->permission_action);

            $this->alert->set('warning', sprintf($this->lang->line('alert_location_restricted'), $action, $context));
			if (!$redirect) {
				return TRUE;
			} else {
				redirect($redirect);
			}
		}

		return FALSE;
	}

	public function isLogged()
	{
        return $this->check();
	}

	public function getId()
	{
		return $this->user_id;
	}

	public function getUserName()
	{
		return $this->username;
	}

	public function getStaffId()
	{
		return $this->staff_id;
	}

	public function getStaffName()
	{
		return $this->staff_name;
	}

	public function getStaffEmail()
	{
		return $this->staff_email;
	}

	public function getLocationId()
	{
        return !empty($this->location_id) ? $this->location_id : $this->config->item('default_location_id');
	}

	public function getLocationName()
	{
        return !empty($this->location_name) ? $this->location_name : $this->config->item('location_name', 'main_address');
	}

	public function staffGroup()
	{
		return $this->staff_group_name;
	}

	public function getStaffGroupId()
	{
		return $this->staff_group_id;
	}

	public function isStrictLocation()
	{
        return ($this->location_access == '1' OR $this->config->item('site_location_mode') === 'single') ? TRUE : FALSE;
	}

	public function canAccessCustomerAccount()
	{
		return ($this->customer_account_access == '1') ? TRUE : FALSE;
	}

	public function unreadMessageTotal()
	{
		if (empty($this->unread)) {
            $this->load->model('Messages_model');
            $unread = $this->Messages_model->getUnreadCount($this->staff_id);
			$this->unread = ($unread < 1) ? '' : $unread;
		}

		return $this->unread;
	}

	public function hasPermission($permission)
	{
		if (!$this->is_logged) return FALSE;

		return $this->checkPermittedActions($permission);
	}

	protected function setPermissions()
	{
		$group_permissions = (!empty($this->permissions)) ? @unserialize($this->permissions) : null;

		if (is_array($group_permissions)) {
            $this->load->model('Permissions_model');
            $permissions = $this->Permissions_model->getPermissionsByIds();

			foreach ($permissions as $permission_id => $permission) {
				$this->available_actions[$permission['name']] = $permissions[$permission_id]['action'];
			}

			foreach ($group_permissions as $permission_name => $permitted_actions) {
				if (!empty($this->available_actions[$permission_name])) {
					$intersect = array_intersect($permitted_actions, $this->available_actions[$permission_name]);
					if (!empty($intersect)) $this->permitted_actions[$permission_name] = $permitted_actions;
				}
			}
		}
	}

	protected function checkPermittedActions($perm, $display_error = FALSE)
	{
		$action = $this->getPermissionAction($perm);

		// Ensure the permission string is matches pattern Domain.Context
		$perm = (substr_count($perm, '.') === 2) ? substr($perm, 0, strrpos($perm, '.')) : $perm;

		$available_actions = (isset($this->available_actions[$perm]) AND is_array($this->available_actions[$perm])) ? $this->available_actions[$perm] : [];
		$permitted_actions = (isset($this->permitted_actions[$perm]) AND is_array($this->permitted_actions[$perm])) ? $this->permitted_actions[$perm] : [];

		// Success if the staff_group_id is the default one
		if ($this->staff_group_id === '11') return TRUE;

		foreach ($action as $value) {

			// Fail if action is not available or permitted.
			if (in_array($value, $available_actions) AND !in_array($value, $permitted_actions)) {
				if ($display_error) {
					$context = substr($perm, strpos($perm, '.') + 1);

                    $this->alert->set('warning', sprintf($this->lang->line('alert_user_restricted'), $value, $context));
				}

				return FALSE;
			}
		}

		return TRUE;
	}

	protected function getPermissionAction($permission)
	{
		if (substr_count($permission, '.') === 2) {
			$this->permission_action[] = strtolower(substr($permission, strrpos($permission, '.') + 1));
		} else {
			// Specify the requested action if not present, based on the $_SERVER REQUEST_METHOD
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                if ($this->input->post('delete')) {
					$this->permission_action = ['access', 'delete'];
                } else if (is_numeric($this->input->get('id'))) {
					$this->permission_action = ['access', 'manage'];
				} else {
					$this->permission_action = ['access', 'add'];
				}
            } else if ($this->input->server('REQUEST_METHOD') === 'GET') {
				$this->permission_action = ['access'];
			}
		}

		return $this->permission_action;
	}

	public function logout()
	{
        parent::logout();

		$this->is_logged = FALSE;
		$this->user_id = '';
		$this->username = '';
		$this->staff_id = '';
		$this->staff_name = '';
		$this->staff_group_name = '';
		$this->staff_group_id = '';
		$this->location_id = '';
		$this->location_name = '';
		$this->customer_account_access = '';
	}
}

// END User Class

/* End of file User.php */
/* Location: ./system/tastyigniter/libraries/User.php */