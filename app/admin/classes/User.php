<?php namespace Admin\Classes;

use Igniter\Flame\Auth\Manager;
use Redirect;
use Request;
use System\Models\Messages_model;
use System\Models\Permissions_model;

/**
 * Admin User authentication manager
 * @package Admin
 */
class User extends Manager
{
    protected $sessionKey = 'admin_info';

    protected $model = 'Admin\Models\Users_model';

    protected $groupModel = 'System\Models\User_group_model';

    protected $identifier = 'username';

    protected $belongsToSuperGroup = TRUE;

    protected $permissions = [];

    protected $permission_action = [];

    protected $permitted_actions = [];

    protected $available_actions = [];

    public function login($userModel, $remember = FALSE)
    {
        parent::login($userModel, $remember);

        if ($userModel = $this->user() AND $staffModel = $userModel->staff) {
            $this->belongsToSuperGroup = $staffModel->belongsToSuperGroup();
            $this->setPermissions();
        }
    }

    /**
     * Redirect if the current user is not authenticated.
     */
    public function auth()
    {
        if (!$this->check()) {
            flash()->danger(lang('admin::default.alert_user_not_logged_in'));
            $prepend = empty($uri) ? '' : '?redirect='.str_replace(site_url(), '/', current_url());
            redirect(admin_url('login'.$prepend));
        }
    }

    public function restrict($permission, $uri = '')
    {
        if (!is_array($permission))
            $permission = [$permission];

        // If user isn't logged in, redirect to the login page.
        if (!$this->check() AND Request::segment(1) !== 'login')
            return Redirect::to(admin_url('login'));

        // Check whether the user has the proper permissions action.
        foreach ($permission as $perms) {
            if ($this->checkPermittedActions($perms, TRUE) === TRUE)
                return TRUE;
        }

        if ($uri === '') { // get the previous page from the session.
            $uri = referrer_url();

            // If previous page and current page are the same, but the user no longer
            // has permission, redirect to site URL to prevent an infinite loop.
            if (empty($uri) OR $uri === current_url() AND !post()) {
                $uri = site_url();
            }
        }

        if (!Request::ajax()) {
            redirect($uri);
        }
    }

    public function restrictLocation($location_id, $permission, $redirect = FALSE)
    {
        if ($this->belongsToSuperGroup) return FALSE;

        if (empty($location_id)) return FALSE;

        $is_strict_location = $this->isStrictLocation();
        if ($is_strict_location AND $location_id !== $this->getLocationId()) {
            $permission = (substr_count($permission, '.') === 2) ? substr($permission, 0, strrpos($permission, '.')) : $permission;
            $context = substr($permission, strpos($permission, '.') + 1);
            $action = end($this->permission_action);

            flash()->warning(sprintf(lang('admin::users.alert_location_restricted'), $action, $context));
            if (!$redirect) {
                return TRUE;
            }
            else {
                redirect($redirect);
            }
        }

        return FALSE;
    }

    public function isLogged()
    {
        return $this->check();
    }

    public function isSuperUser()
    {
        return $this->user->super_user;
    }

    public function fromModel($key)
    {
        $user = $this->user();
        if (isset($user[$key]))
            return $user[$key];

        if (isset($user->staff[$key]))
            return $user->staff[$key];

        if (isset($user->staff->group[$key]))
            return $user->staff->group[$key];

        if (isset($user->staff->location[$key]))
            return $user->staff->location[$key];

        return null;
    }

    public function getId()
    {
        return $this->user->user_id;
    }

    public function getUserName()
    {
        return $this->user->username;
    }

    public function getStaffId()
    {
        return $this->fromModel('staff_id');
    }

    public function getStaffName()
    {
        return $this->fromModel('staff_name');
    }

    public function getStaffEmail()
    {
        return $this->fromModel('staff_email');
    }

    public function getLocationId()
    {
        return $this->fromModel('staff_email') ?: params('default_location_id');
    }

    public function getLocationName()
    {
        return $this->fromModel('location_name');
    }

    public function staffGroup()
    {
        return $this->fromModel('staff_group_name');
    }

    public function getStaffGroupId()
    {
        return $this->fromModel('staff_group_id');
    }

    public function isStrictLocation()
    {
        return ($this->fromModel('location_access') AND setting('site_location_mode') == 'single');
    }

    public function canAccessCustomerAccount()
    {
        return $this->fromModel('customer_account_access');
    }

    //
    // Permissions
    //

    public function hasPermission($permission, $display_error = FALSE)
    {
        if (!is_array($permission))
            $permission = [$permission];

        foreach ($permission as $perms) {
            if ($this->checkPermittedActions($perms, $display_error))
                return TRUE;
        }

        return FALSE;
    }

    protected function setPermissions()
    {
        $group_permissions = $this->permissions;

        if (is_array($group_permissions)) {
            $permissions = Permissions_model::getPermissionsByIds();

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
        // Bail out if the staff is a super user
        if ($this->belongsToSuperGroup) return TRUE;

        $action = $this->filterPermissionAction($perm);

        // Ensure the permission string matches pattern Domain.Context
        $permName = $this->filterPermissionName($perm);

        $available_actions = $this->getPermissionActions($permName, 'available_actions');
        $permitted_actions = $this->getPermissionActions($permName, 'permitted_actions');

        foreach ($action as $value) {

            // Fail if action is available and not permitted.
            if (in_array($value, $available_actions) AND !in_array($value, $permitted_actions)) {
                if ($display_error) {
                    $context = substr($permName, strpos($permName, '.') + 1);
                    flash()->warning(sprintf(lang('admin::users.alert_user_restricted'), $value, $context));
                }

                return FALSE;
            }
        }

        return TRUE;
    }

    protected function getPermissionActions($permission, $whichAction)
    {
        if (!isset($this->{$whichAction}[$permission]))
            return [];

        return (is_array($this->{$whichAction}[$permission]))
            ? $this->{$whichAction}[$permission] : [];
    }

    protected function filterPermissionName($permission)
    {
        return (substr_count($permission, '.') === 2)
            ? substr($permission, 0, strrpos($permission, '.'))
            : $permission;
    }

    protected function filterPermissionAction($permission)
    {
        $result = [];

        if (substr_count($permission, '.') === 2) {
            $result[] = strtolower(substr($permission, strrpos($permission, '.') + 1));
        }
        else {
            // Specify the requested action if not present, based on the $_SERVER REQUEST_METHOD
            $requestMethod = $this->input->server('REQUEST_METHOD');
            if (in_array($this->uri->rsegment(2), ['create', 'edit', 'manage', 'settings']))
                $requestMethod = $this->uri->rsegment(2);

            if (is_string(post('_method')))
                $requestMethod = post('_method');

            switch (strtolower($requestMethod)) {
                case 'get':
                    $result = ['access'];
                    break;
                case 'post':
                    $result = ['access', 'add'];
                    break;
                case 'delete':
                    $result = ['delete'];
                    break;
                case 'edit':
                case 'manage':
                case 'settings':
                case 'patch':
                    $result = ['access', 'manage'];
                    break;
                case 'create':
                case 'put':
                    $result = ['add'];
                    break;
            }
        }

        return $result;
    }
}