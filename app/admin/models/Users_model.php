<?php namespace Admin\Models;

use Admin\Classes\PermissionManager;
use Carbon\Carbon;
use Igniter\Flame\Auth\Models\User as AuthUserModel;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;

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

    protected $fillable = ['username', 'super_user'];

    protected $appends = ['staff_name'];

    protected $hidden = ['password'];

    public $casts = [
        'staff_id' => 'integer',
        'super_user' => 'boolean',
        'is_activated' => 'boolean',
        'reset_time' => 'datetime',
        'date_activated' => 'datetime',
        'last_login' => 'datetime',
    ];

    public $relation = [
        'belongsTo' => [
            'staff' => ['Admin\Models\Staffs_model', 'foreignKey' => 'staff_id'],
        ],
    ];

    protected $with = ['staff'];

    protected $purgeable = ['password_confirm'];

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

    public function hasAnyPermission($permissions)
    {
        return $this->hasPermission($permissions, FALSE);
    }

    public function hasPermission($permissions, $checkAll = TRUE)
    {
        // Bail out if the staff is a super user
        if ($this->isSuperUser())
            return TRUE;

        $groupPermissions = $this->getPermissions();

        if (!is_array($permissions))
            $permissions = [$permissions];

        if (PermissionManager::instance()->checkGroupPermission(
            $groupPermissions, $permissions, $checkAll)
        ) return TRUE;

        return FALSE;
    }

    public function getPermissions()
    {
        $group = $this->staff->group;

        $permissions = [];
        if ($group AND is_array($group->permissions)) {
            $permissions = $group->permissions;
        }

        return $permissions;
    }

    //
    // Location
    //

    public function hasStrictLocationAccess()
    {
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