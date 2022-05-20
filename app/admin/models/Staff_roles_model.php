<?php

namespace Admin\Models;

use Igniter\Flame\Database\Casts\Serialize;
use Igniter\Flame\Database\Model;
use InvalidArgumentException;

class Staff_roles_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'staff_roles';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'staff_role_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = true;

    public $relation = [
        'hasMany' => [
            'staffs' => ['Admin\Models\Staffs_model', 'foreignKey' => 'staff_role_id', 'otherKey' => 'staff_role_id'],
        ],
    ];

    protected $casts = [
        'permissions' => Serialize::class,
    ];

    public static function getDropdownOptions()
    {
        return static::dropdown('name');
    }

    public static function listDropdownOptions()
    {
        return self::select('staff_role_id', 'name', 'description')
            ->get()
            ->keyBy('staff_role_id')
            ->map(function ($model) {
                return [$model->name, $model->description];
            });
    }

    public function getStaffCountAttribute($value)
    {
        return $this->staffs->count();
    }

    public function setPermissionsAttribute($permissions)
    {
        foreach ($permissions ?? [] as $permission => $value) {
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
