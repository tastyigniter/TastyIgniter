<?php namespace Admin\Models;

use InvalidArgumentException;
use Model;

/**
 * StaffGroups Model Class
 *
 * @package Admin
 */
class Staff_groups_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'staff_groups';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'staff_group_id';

    public $casts = [
        'customer_account_access' => 'boolean',
        'permissions' => 'serialize',
    ];

    public $relation = [
        'hasMany' => [
            'staffs' => ['Admin\Models\Staffs_model', 'foreignKey' => 'staff_group_id', 'otherKey' => 'staff_group_id'],
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::dropdown('staff_group_name');
    }

    public function getStaffCountAttribute($value)
    {
        return Staffs_model::where('staff_group_id', $this->staff_group_id)->count();
    }

    public function getPermissionsAttribute($value)
    {
        $value = !empty($value) ? @unserialize($value) : [];

        // Backward compatibility to convert permission values
        // to 1 or 0 from array of [access, add, manage]
        foreach ($value as $permission => &$permissionValue) {
            if (is_array($permissionValue))
                $permissionValue = count($permissionValue) ? 1 : 0;
        }

        return $value;
    }

    public function setPermissionsAttribute($permissions)
    {
        foreach ($permissions as $permission => $value) {
            if (!in_array($value = (int)$value, [-1, 0, 1])) {
                throw new InvalidArgumentException(sprintf(
                    'Invalid value "%s" for permission "%s" given.', $value, $permission
                ));
            }

            if ($value === 0) {
                unset($permissions[$permission]);
            }
        }

        $this->attributes['permissions'] = !empty($permissions) ? serialize($permissions) : '';
    }
}