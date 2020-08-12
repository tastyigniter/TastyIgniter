<?php

namespace Admin\Models;

use Admin\Classes\UserState;
use Igniter\Flame\Database\Traits\Purgeable;
use Model;

/**
 * Staffs Model Class
 */
class Staffs_model extends Model
{
    use Purgeable;

    const UPDATED_AT = null;

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'staffs';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'staff_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    protected $guarded = [];

    public $casts = [
        'staff_role_id' => 'integer',
        'staff_location_id' => 'integer',
        'sale_permission' => 'integer',
        'language_id' => 'integer',
        'staff_status' => 'boolean',
    ];

    public $relation = [
        'hasOne' => [
            'user' => ['Admin\Models\Users_model', 'foreignKey' => 'staff_id', 'otherKey' => 'staff_id', 'delete' => TRUE],
        ],
        'hasMany' => [
            'assignable_logs' => ['Admin\Models\Assignable_logs_model', 'foreignKey' => 'assignee_id'],
        ],
        'belongsTo' => [
            'role' => ['Admin\Models\Staff_roles_model', 'foreignKey' => 'staff_role_id'],
            'language' => ['System\Models\Languages_model'],
        ],
        'belongsToMany' => [
            'groups' => ['Admin\Models\Staff_groups_model', 'table' => 'staffs_groups'],
            'locations' => ['Admin\Models\Locations_model', 'table' => 'staffs_locations'],
        ],
    ];

    protected $hidden = ['password'];

    protected $purgeable = ['user', 'groups', 'locations'];

    public function getFullNameAttribute($value)
    {
        return $this->staff_name;
    }

    public function getEmailAttribute()
    {
        return $this->staff_email;
    }

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('staff_name');
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
        return $query->where('staff_status', 1);
    }

    public function scopeWhereNotSuperUser($query)
    {
        $query->whereHas('user', function ($q) {
            $q->where('super_user', '!=', 1);
        });
    }

    //
    // Events
    //

    protected function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('user', $this->attributes))
            $this->addStaffUser($this->attributes['user']);

        if (array_key_exists('groups', $this->attributes))
            $this->addStaffGroups($this->attributes['groups']);

        if (array_key_exists('locations', $this->attributes))
            $this->addStaffLocations($this->attributes['locations']);
    }

    //
    // Helpers
    //

    /**
     * Return the dates of all staff
     * @return array
     */
    public function getStaffDates()
    {
        return $this->pluckDates('date_added');
    }

    public function addStaffUser($user = [])
    {
        $userModel = $this->user()->firstOrNew(['staff_id' => $this->getKey()]);

        if (isset($user['super_user']))
            $userModel->super_user = $user['super_user'];

        if (isset($user['username']))
            $userModel->username = $user['username'];

        if (isset($user['password']))
            $userModel->password = $user['password'];

        if (!$userModel->exists) {
            $userModel->is_activated = TRUE;
            $userModel->date_activated = date('Y-m-d');
        }

        $userModel->save();
    }

    /**
     * Create a new or update existing staff locations
     *
     * @param array $locations
     *
     * @return bool
     */
    public function addStaffLocations($locations = [])
    {
        return $this->locations()->sync($locations);
    }

    /**
     * Create a new or update existing staff groups
     *
     * @param array $groups
     *
     * @return bool
     */
    public function addStaffGroups($groups = [])
    {
        return $this->groups()->sync($groups);
    }

    /**
     * Send email to staff
     *
     * @param string $email
     * @param array $template
     * @param array $data
     *
     * @return bool
     */
    public function sendMail($email, $template, $data = [])
    {
        return Users_model::sendMail($email, $template, $data);
    }

    //
    //
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
}
