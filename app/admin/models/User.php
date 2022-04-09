<?php

namespace Admin\Models;

use Admin\Classes\PermissionManager;
use Admin\Classes\UserState;
use Admin\Traits\Locationable;
use Carbon\Carbon;
use Igniter\Flame\Auth\Models\User as AuthUserModel;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Traits\Purgeable;
use System\Traits\SendsMailTemplate;

/**
 * Users Model Class
 */
class User extends AuthUserModel
{
    use HasFactory;
    use Purgeable;
    use SendsMailTemplate;
    use Locationable;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public $timestamps = TRUE;

    protected $fillable = ['username', 'super_user'];

    protected $appends = ['staff_name'];

    protected $hidden = ['password'];

    protected $casts = [
        'user_role_id' => 'integer',
        'sale_permission' => 'integer',
        'language_id' => 'integer',
        'status' => 'boolean',
        'super_user' => 'boolean',
        'is_activated' => 'boolean',
        'reset_time' => 'datetime',
        'date_invited' => 'datetime',
        'date_activated' => 'datetime',
        'last_login' => 'datetime',
    ];

    public $relation = [
        'hasMany' => [
            'assignable_logs' => [\Admin\Models\AssignableLog::class, 'foreignKey' => 'assignee_id'],
        ],
        'belongsTo' => [
            'role' => [\Admin\Models\UserRole::class, 'foreignKey' => 'user_role_id'],
            'language' => [\System\Models\Language::class],
        ],
        'belongsToMany' => [
            'groups' => [\Admin\Models\UserGroup::class, 'table' => 'users_groups'],
        ],
        'morphToMany' => [
            'locations' => [\Admin\Models\Location::class, 'name' => 'locationable'],
        ],
    ];

    protected $purgeable = ['password_confirm', 'send_invite'];

    public function getStaffNameAttribute()
    {
        return $this->name;
    }

    public function getStaffEmailAttribute()
    {
        return $this->email;
    }

    public function getFullNameAttribute($value)
    {
        return $this->name;
    }

    public function getAvatarUrlAttribute()
    {
        return '//www.gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'.png?d=mm';
    }

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('name');
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled staff
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    public function scopeWhereNotSuperUser($query)
    {
        $query->where('super_user', '!=', 1);
    }

    public function scopeWhereIsSuperUser($query)
    {
        $query->where('super_user', 1);
    }

    //
    // Events
    //

    protected function afterCreate()
    {
        $this->restorePurgedValues();

        if ($this->send_invite) {
            $this->sendInvite();
        }
    }

    protected function beforeDelete()
    {
        $this->groups()->detach();
        $this->locations()->detach();
    }

    protected function sendInvite()
    {
        $this->bindEventOnce('model.mailGetData', function ($view, $recipientType) {
            if ($view === 'admin::_mail.invite') {
                $this->reset_code = $inviteCode = $this->generateResetCode();
                $this->reset_time = now();
                $this->save();

                return ['invite_code' => $inviteCode];
            }
        });

        $this->mailSend('admin::_mail.invite');
    }

    public function beforeLogin()
    {
        app('translator.localization')->setSessionLocale(
            optional($this->language)->code ?? setting('default_language')
        );
    }

    public function afterLogin()
    {
        $this->last_login = Carbon::now();
        $this->save();
    }

    public function isSuperUser()
    {
        return $this->super_user == 1;
    }

    /**
     * Reset a user password,
     */
    public function resetPassword()
    {
        $this->reset_code = $resetCode = $this->generateResetCode();
        $this->reset_time = Carbon::now();
        $this->save();

        return $resetCode;
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
        // Bail out if the user is a super user
        if ($this->isSuperUser())
            return TRUE;

        $staffPermissions = $this->getPermissions();

        if (!is_array($permissions))
            $permissions = [$permissions];

        if (PermissionManager::instance()->checkPermission(
            $staffPermissions, $permissions, $checkAll)
        ) return TRUE;

        return FALSE;
    }

    public function getPermissions()
    {
        $role = $this->role;

        $permissions = [];
        if ($role && is_array($role->permissions)) {
            $permissions = $role->permissions;
        }

        return $permissions;
    }

    //
    // Location
    //

    public function hasLocationAccess($location)
    {
        return $this->locations->contains(function ($model) use ($location) {
            return $model->location_id === $location->location_id;
        });
    }

    public function mailGetRecipients($type)
    {
        return [
            [$this->email, $this->name],
        ];
    }

    public function mailGetData()
    {
        $model = $this->fresh();

        return array_merge($model->toArray(), [
            'staff' => $model,
            'staff_name' => $model->name,
            'staff_email' => $model->email,
            'username' => $model->username,
        ]);
    }

    //
    // Assignment
    //

    public function canAssignTo()
    {
        return !UserState::forUser($this->user)->isAway();
    }

    public function hasGlobalAssignableScope()
    {
        return $this->sale_permission === 1;
    }

    public function hasGroupAssignableScope()
    {
        return $this->sale_permission === 2;
    }

    public function hasRestrictedAssignableScope()
    {
        return $this->sale_permission === 3;
    }

    //
    // Helpers
    //

    /**
     * Return the dates of all staff
     * @return array
     */
    public function getUserDates()
    {
        return $this->pluckDates('created_at');
    }

    public function getLocale()
    {
        return optional($this->language)->code;
    }

    /**
     * Create a new or update existing user locations
     *
     * @param array $locations
     *
     * @return bool
     */
    public function addLocations($locations = [])
    {
        return $this->locations()->sync($locations);
    }

    /**
     * Create a new or update existing user groups
     *
     * @param array $groups
     *
     * @return bool
     */
    public function addGroups($groups = [])
    {
        return $this->groups()->sync($groups);
    }
}
