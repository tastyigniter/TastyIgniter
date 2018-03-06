<?php namespace Admin\Classes;

use Igniter\Flame\Auth\Manager;
use Request;
use System\Classes\Controller;
use System\Models\Permissions_model;

/**
 * Admin User authentication manager
 * @package Admin
 */
class User extends Manager
{
    protected $sessionKey = 'admin_info';

    protected $model = 'Admin\Models\Users_model';

    protected $groupModel = 'Admin\Models\Staff_groups_model';

    protected $identifier = 'username';

    protected $isSuperUser = FALSE;

    protected $availablePermissions = [];

    protected $groupPermissions = [];

    protected $filteredPermissions = [];

    protected $permissionsLoaded = FALSE;

    public function login($userModel, $remember = FALSE)
    {
        parent::login($userModel, $remember);
    }

    public function restrictLocation($location_id, $permission, $redirect = FALSE)
    {
        if ($this->isSuperUser()) return FALSE;

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
        return $this->user()->isSuperUser();
    }

    public function getId()
    {
        return $this->fromModel('user_id', 'user');
    }

    public function getUserName()
    {
        return $this->fromModel('username', 'user');
    }

    public function getStaffId()
    {
        return $this->fromModel('staff_id', 'user');
    }

    public function getStaffName()
    {
        return $this->fromModel('staff_name', 'staff');
    }

    public function getStaffEmail()
    {
        return $this->fromModel('staff_email', 'staff');
    }

    public function getLocationId()
    {
        return $this->fromModel('staff_email', 'staff', params('default_location_id'));
    }

    public function getLocationName()
    {
        return $this->fromModel('location_name', 'location');
    }

    public function staffGroup()
    {
        return $this->fromModel('staff_group_name', 'group');
    }

    public function getStaffGroupId()
    {
        return $this->fromModel('staff_group_id', 'staff');
    }

    public function isStrictLocation()
    {
        return ($this->fromModel('location_access', 'group') AND setting('site_location_mode') == 'single');
    }

    public function canAccessCustomerAccount()
    {
        return $this->fromModel('customer_account_access', 'group');
    }

    public function extendUserQuery($query)
    {
        $query->with(['staff.group', 'staff.location']);
    }

    protected function fromModel($key, $related = null, $default = null)
    {
        $user = $this->user();

        switch ($related) {
            case 'staff':
                return isset($user->staff[$key]) ? $user->staff[$key] : $default;
            case 'group':
                return isset($user->staff->group[$key]) ? $user->staff->group[$key] : $default;
            case 'location':
                return isset($user->staff->location[$key]) ? $user->staff->location[$key] : $default;
            default:
                return isset($user[$key]) ? $user[$key] : $default;
        }

        return $default;
    }


    //
    // Permissions
    //

    public function hasPermission($permission, $displayError = FALSE)
    {
        if (!$this->check())
            return FALSE;

        if (!is_array($permission))
            $permission = [$permission];

        foreach ($permission as $name) {
            if ($this->checkPermittedActions($name, $displayError))
                return TRUE;
        }

        return FALSE;
    }

    protected function checkPermittedActions($perm, $displayError = FALSE)
    {
        $this->loadPermissions();

        // Bail out if the staff is a super user
        if ($this->isSuperUser()) return TRUE;

        list($permName, $action) = $this->filterPermissionName($perm);

        $actionsToCheck = $action
            ? [$action]
            : $this->getRequestedAction();

        $availableActions = $this->getPermissionActions($permName, 'available');
        $permittedActions = $this->getPermissionActions($permName, 'filtered');

        foreach ($actionsToCheck as $value) {
            // Fail if action is available and not permitted.
            if (in_array($value, $availableActions) AND !in_array($value, $permittedActions)) {
                if ($displayError) {
                    flash()->warning(sprintf(lang('admin::default.alert_user_restricted'), $value, $permName));
                }

                return FALSE;
            }
        }

        return TRUE;
    }

    protected function loadPermissions()
    {
        if ($this->permissionsLoaded)
            return FALSE;

        $groupModel = $this->createGroupModel()->find($this->getStaffGroupId());
        if (!$groupModel)
            return FALSE;

        $this->groupPermissions = is_array($groupModel->permissions) ? $groupModel->permissions : [];
        $this->availablePermissions = Permissions_model::listPermissionActions();

        $this->filteredPermissions = [];
        foreach ($this->groupPermissions as $permission => $actions) {
            if (!$availableActions = array_get($this->availablePermissions, $permission, FALSE))
                continue;

            if (!array_filter(array_intersect($actions, $availableActions)))
                continue;

            $this->filteredPermissions[$permission] = $actions;
        }

        $this->permissionsLoaded = TRUE;
    }

    protected function getRequestedAction()
    {
        $result = [];

        // Specify the requested action if not present, based on the $_SERVER REQUEST_METHOD
        $requestMethod = Request::server('REQUEST_METHOD');
        if (in_array(Controller::$action, ['create', 'edit', 'manage', 'settings']))
            $requestMethod = Controller::$action;

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

        return $result;
    }

    protected function getPermissionActions($permission, $whichAction)
    {
        $whichAction = $whichAction.'Permissions';
        if (!isset($this->{$whichAction}[$permission]))
            return [];

        return (is_array($this->{$whichAction}[$permission]))
            ? $this->{$whichAction}[$permission] : [];
    }

    protected function filterPermissionName($permission)
    {
        $permArray = explode('.', $permission);

        $name = array_slice($permArray, 0, 2);
        $action = array_slice($permArray, 2, 1);

        return [implode('.', $name), strtolower(current($action))];
    }
}