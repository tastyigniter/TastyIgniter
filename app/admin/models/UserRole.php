<?php

namespace Admin\Models;

use Igniter\Flame\Database\Casts\Serialize;
use Igniter\Flame\Database\Model;
use InvalidArgumentException;

class UserRole extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'user_roles';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'user_role_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $relation = [
        'hasMany' => [
            'users' => ['Admin\Models\User', 'foreignKey' => 'user_role_id', 'otherKey' => 'user_role_id'],
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
        return self::select('user_role_id', 'name', 'description')
            ->get()
            ->keyBy('user_role_id')
            ->map(function ($model) {
                return [$model->name, $model->description];
            });
    }

    public function getStaffCountAttribute($value)
    {
        return $this->users->count();
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
