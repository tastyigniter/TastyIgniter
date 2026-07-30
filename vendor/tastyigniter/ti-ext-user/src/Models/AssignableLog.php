<?php

declare(strict_types=1);

namespace Igniter\User\Models;

use Carbon\Carbon;
use Igniter\Admin\Models\Status;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Reservation\Models\Reservation;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\DB;

/**
 * AssignableLog Model Class
 *
 * @property int $id
 * @property string $assignable_type
 * @property int $assignable_id
 * @property int|null $assignee_id
 * @property int|null $assignee_group_id
 * @property int|null $user_id
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model $assignable
 * @property-read null|Model $assignee_group
 * @method static Builder<static>|AssignableLog query()
 * @method static Builder<static>|AssignableLog applyAssignable(Model $assignable)
 * @method static Builder<static>|AssignableLog whereAssignTo(int|string $assigneeId)
 * @method static Builder<static>|AssignableLog whereAssignToGroup(int|string $assigneeGroupId)
 * @method static Builder<static>|AssignableLog whereInAssignToGroup(array $assigneeGroupIds)
 * @method static Builder<static>|AssignableLog whereUnAssigned()
 * @method static Builder<static>|AssignableLog whereHasAutoAssignGroup()
 * @method static Builder<static>|AssignableLog applyLoadBalancedScope(int|string $limit)
 * @method static Builder<static>|AssignableLog applyRoundRobinScope()
 * @mixin Model
 */
class AssignableLog extends Model
{
    use Prunable;

    /**
     * @var string The database table name
     */
    protected $table = 'assignable_logs';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = true;

    public $relation = [
        'belongsTo' => [
            'user' => User::class,
            'assignee' => User::class,
            'assignee_group' => UserGroup::class,
            'status' => Status::class,
        ],
        'morphTo' => [
            'assignable' => [],
        ],
    ];

    protected $casts = [
        'assignable_id' => 'integer',
        'assignee_group_id' => 'integer',
        'assignee_id' => 'integer',
        'user_id' => 'integer',
        'status_id' => 'integer',
    ];

    public static function createLog(Order|Reservation $assignable, ?Model $user = null): self
    {
        $attributes = [
            'assignable_type' => $assignable->getMorphClass(),
            'assignable_id' => $assignable->getKey(),
            'assignee_group_id' => $assignable->assignee_group_id,
            'assignee_id' => null,
        ];

        self::query()->where($attributes)->delete();

        /** @var AssignableLog $model */
        $model = self::query()->firstOrNew(array_merge($attributes, [
            'assignee_id' => $assignable->assignee_id,
        ]));

        $model->user_id = $user?->getKey();
        $model->status_id = $assignable->status_id;

        $assignable->newQuery()->where($assignable->getKeyName(), $assignable->getKey())->update([
            'assignee_updated_at' => Carbon::now(),
        ]);

        $model->save();

        return $model;
    }

    public static function getUnAssignedQueue($limit): Builder
    {
        return self::query()
            ->whereUnAssigned()
            ->whereHasAutoAssignGroup()
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }

    public function isForOrder(): bool
    {
        return $this->assignable_type === Order::make()->getMorphClass();
    }

    //
    //
    //

    public function scopeApplyAssignable(Builder $query, Model $assignable): void
    {
        $query
            ->where('assignable_type', $assignable->getMorphClass())
            ->where('assignable_id', $assignable->getKey());
    }

    public function scopeApplyRoundRobinScope(Builder $query): void
    {
        $query
            ->select('assignee_id')
            ->selectRaw('MAX(created_at) as assign_value')
            ->whereIn('status_id', setting('processing_order_status', []))
            ->whereNotNull('assignee_id')
            ->groupBy('assignee_id')
            ->orderBy('assign_value', 'asc');
    }

    public function scopeApplyLoadBalancedScope(Builder $query, string $limit): void
    {
        $query
            ->select('assignee_id')
            ->selectRaw('COUNT(assignee_id)/'.DB::getPdo()->quote($limit).' as assign_value')
            ->whereIn('status_id', setting('processing_order_status', []))
            ->whereNotNull('assignee_id')
            ->groupBy('assignee_id')
            ->orderBy('assign_value', 'desc')
            ->havingRaw('assign_value < 1');
    }

    public function scopeWhereUnAssigned(Builder $query): void
    {
        $query->whereNotNull('assignee_group_id')->whereNull('assignee_id');
    }

    public function scopeWhereAssignTo(Builder $query, int|string $assigneeId): void
    {
        $query->where('assignee_id', $assigneeId);
    }

    public function scopeWhereAssignToGroup(Builder $query, int|string $assigneeGroupId): void
    {
        $query->where('assignee_group_id', $assigneeGroupId);
    }

    public function scopeWhereInAssignToGroup(Builder $query, array $assigneeGroupIds): void
    {
        $query->whereIn('assignee_group_id', $assigneeGroupIds);
    }

    public function scopeWhereHasAutoAssignGroup(Builder $query): void
    {
        $query->whereHas('assignee_group', function(Builder $query): void {
            $query->where('auto_assign', 1);
        });
    }

    //
    // Concerns
    //

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subDays(setting('activity_log_timeout', 60)));
    }
}
