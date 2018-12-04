<?php namespace Admin\Models;

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
        'permissions' => 'serialize',
    ];

    public $relation = [
        'hasMany' => [
            'staffs' => ['Admin\Models\Staffs_model', 'foreignKey' => 'staff_group_id', 'otherKey' => 'staff_group_id']
        ]
    ];

    public static function getDropdownOptions()
    {
        return static::dropdown('staff_group_name');
    }

    public function getStaffCountAttribute($value)
    {
        return Staffs_model::where('staff_group_id', $this->staff_group_id)->count();
    }
}