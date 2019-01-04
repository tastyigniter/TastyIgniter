<?php namespace Admin\Models;

use Carbon\Carbon;
use Igniter\Flame\Auth\Models\User as AuthUserModel;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Request;
use System\Classes\Controller;
use System\Models\Permissions_model;

/**
 * Users Model Class
 * @package Admin
 */
class Users_model extends AuthUserModel
{
    use Purgeable;

    /**
     * @var string The database table name
     */
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $dates = [
        'reset_time',
        'date_activated',
    ];

    public $relation = [
        'belongsTo' => [
            'staff' => ['Admin\Models\Staffs_model', 'foreignKey' => 'staff_id'],
        ],
    ];

    protected $with = ['staff'];

    protected $fillable = ['username', 'super_user'];

    protected $appends = ['staff_name'];

    protected $hidden = ['password'];

    protected $purgeable = ['password_confirm'];

    protected $availablePermissions = [];

    protected $groupPermissions = [];

    protected $filteredPermissions = [];

    protected $permissionsLoaded = FALSE;

    public function beforeLogin()
    {
        if ($language = $this->staff->language)
            app('translator.localization')->setSessionLocale($language->code);
    }

    public function getStaffNameAttribute()
    {
        if (!$staff = $this->staff)
            return null;

        return $staff->staff_name;
    }

    public function isSuperUser()
    {
        return ($this->super_user == 1);
    }

    /**
     * Reset a staff password,
     *
     */
    public function resetPassword()
    {
        $this->reset_code = $resetCode = $this->generateResetCode();
        $this->reset_time = Carbon::now();
        $this->save();

        return $resetCode;
    }

    public function getReminderEmail()
    {
        return $this->staff_email;
    }

    //
    // Permissions
    //

    public function hasPermission($permission, $displayError = FALSE)
    {
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
                    flash()->warning(sprintf(lang('admin::lang.alert_user_restricted'), $value, $permName));
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

        $groupModel = $this->staff->group;
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
        if ($requestMethod !== 'GET' AND in_array(Controller::$action, ['create', 'edit', 'manage', 'settings']))
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
        $whichAction .= 'Permissions';
        if (!isset($this->{$whichAction}[$permission]))
            return [];

        return is_array($this->{$whichAction}[$permission])
            ? $this->{$whichAction}[$permission] : [];
    }

    protected function filterPermissionName($permission)
    {
        $permArray = explode('.', $permission);

        $name = array_slice($permArray, 0, 2);
        $action = array_slice($permArray, 2, 1);

        return [implode('.', $name), strtolower(current($action))];
    }

    //
    // Location
    //

    public function hasStrictLocationAccess()
    {
        if ($this->isSuperUser())
            return FALSE;

        return (bool)$this->staff->group->location_access;
    }

    public function hasLocationAccess($location, $displayError = FALSE)
    {
        if ($location instanceof Model)
            $location = $location->getKey();

        if (!$this->hasStrictLocationAccess())
            return TRUE;

        if ($this->staff_location_id != $location) {
            if ($displayError)
                flash()->warning(lang('admin::lang.alert_location_restricted'));

            return FALSE;
        }

        return TRUE;
    }
}