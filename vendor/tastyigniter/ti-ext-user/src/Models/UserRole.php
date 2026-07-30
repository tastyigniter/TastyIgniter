<?php

declare(strict_types=1);

namespace Igniter\User\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Casts\Serialize;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

/**
 * UserRole Model Class
 *
 * @property int $user_role_id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property mixed|null $permissions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $staff_count
 * @property-read Collection<int, User> $users
 * @method static Builder<static>|User query()
 * @method static UserRole first()
 * @method static Builder<static>|CustomerGroup dropdown(string $column, string $key = null)
 * @mixin Model
 */
class UserRole extends Model
{
    use HasFactory;

    /**
     * @var string The database table name
     */
    protected $table = 'admin_user_roles';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'user_role_id';

    public $timestamps = true;

    public $relation = [
        'hasMany' => [
            'users' => [User::class, 'foreignKey' => 'user_role_id', 'otherKey' => 'user_role_id'],
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
        return self::query()
            ->select('user_role_id', 'name', 'description')
            ->get()
            ->keyBy('user_role_id')
            ->map(fn($model): array => [$model->name, $model->description]);
    }

    public function getStaffCountAttribute($value): int
    {
        return $this->users->count();
    }

    public function setPermissionsAttribute($permissions): void
    {
        foreach ($permissions ?? [] as $permission => $value) {
            if (!in_array((int)$value, [-1, 0, 1], true)) {
                throw new InvalidArgumentException(sprintf(
                    'Invalid value "%s" for permission "%s" given.', $value, $permission,
                ));
            }

            if ($value === 0) {
                unset($permissions[$permission]);
            }
        }

        $this->attributes['permissions'] = empty($permissions) ? '' : serialize($permissions);
    }
}
