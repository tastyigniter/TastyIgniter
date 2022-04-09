<?php

namespace Admin\Models;

use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;

/**
 * UserGroup Model Class
 */
class UserGroup extends Model
{
    use HasFactory;

    public const AUTO_ASSIGN_ROUND_ROBIN = 1;

    public const AUTO_ASSIGN_LOAD_BALANCED = 2;

    /**
     * @var string The database table name
     */
    protected $table = 'user_groups';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'user_group_id';

    public $relation = [
        'hasMany' => [
            'assignable_logs' => [\Admin\Models\AssignableLog::class, 'foreignKey' => 'assignee_group_id'],
        ],
        'belongsToMany' => [
            'users' => [\Admin\Models\User::class, 'table' => 'users_groups'],
        ],
    ];

    protected $casts = [
        'auto_assign' => 'boolean',
        'auto_assign_mode' => 'integer',
        'auto_assign_limit' => 'integer',
        'auto_assign_availability' => 'boolean',
    ];

    public $timestamps = TRUE;

    public static function getDropdownOptions()
    {
        return static::dropdown('user_group_name');
    }

    public static function listDropdownOptions()
    {
        return self::select('user_group_id', 'user_group_name', 'description')
            ->get()
            ->keyBy('user_group_id')
            ->map(function ($model) {
                return [$model->user_group_name, $model->description];
            });
    }

    public function getStaffCountAttribute($value)
    {
        return $this->users->count();
    }

    //
    // Assignment
    //

    public static function syncAutoAssignStatus()
    {
        params()->set('allocator_is_enabled',
            self::query()->where('auto_assign', 1)->exists()
        );
    }

    public function getAutoAssignLimitAttribute($value)
    {
        return $this->attributes['auto_assign_limit'] ?? 20;
    }

    /**
     * @return bool
     */
    public function autoAssignEnabled()
    {
        return $this->auto_assign;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function listAssignees()
    {
        return $this->users->filter(function (User $user) {
            return $user->isEnabled() && $user->canAssignTo();
        })->values();
    }

    /**
     * @return \Admin\Models\User|object
     */
    public function findAvailableAssignee()
    {
        $query = $this->assignable_logs()->newQuery();

        $useLoadBalance = $this->auto_assign_mode == self::AUTO_ASSIGN_LOAD_BALANCED;

        $useLoadBalance
            ? $query->applyLoadBalancedScope($this->auto_assign_limit)
            : $query->applyRoundRobinScope();

        $logs = $query->pluck('assign_value', 'assignee_id');

        $assignees = $this->listAssignees()->map(function (User $model) use ($logs) {
            $model->assign_value = $logs[$model->getKey()] ?? 0;

            return $model;
        });

        return $assignees->sortBy('assign_value')->first();
    }
}
