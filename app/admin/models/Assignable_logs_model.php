<?php namespace Admin\Models;

use Carbon\Carbon;
use Igniter\Flame\Database\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Assignable logs Model Class
 *
 * @package Admin
 */
class Assignable_logs_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'assignable_logs';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = TRUE;

    public $relation = [
        'belongsTo' => [
            'assignee' => 'Admin\Models\Staffs_model',
            'assignee_group' => 'Admin\Models\Staff_groups_model',
            'status' => 'Admin\Models\Statuses_model',
        ],
        'morphTo' => [
            'assignable' => [],
        ],
    ];

    public $casts = [
        'assignable_id' => 'integer',
        'assignee_group_id' => 'integer',
        'assignee_id' => 'integer',
        'status_id' => 'integer',
    ];

    /**
     * @param \Igniter\Flame\Database\Model|mixed $assignable
     * @return static|bool
     * @throws \Exception
     */
    public static function createLog($assignable)
    {
        $attributes = [
            'assignable_type' => $assignable->getMorphClass(),
            'assignable_id' => $assignable->getKey(),
            'assignee_group_id' => $assignable->assignee_group_id,
            'assignee_id' => null,
        ];

        self::query()->where($attributes)->delete();

        $model = self::query()->firstOrNew(array_merge($attributes, [
            'assignee_id' => $assignable->assignee_id,
        ]));

        $model->status_id = $assignable->status_id;

        $assignable->newQuery()->where($assignable->getKeyName(), $assignable->getKey())->update([
            'assignee_updated_at' => Carbon::now(),
        ]);

        $model->save();

        return $model;
    }

    /**
     * @param $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUnAssignedQueue($limit)
    {
        return self::query()
            ->whereUnAssigned()
            ->whereHasAutoAssignGroup()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function isForOrder()
    {
        return $this->assignable_type === Orders_model::make()->getMorphClass();
    }

    //
    //
    //

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @param \Igniter\Flame\Database\Model $assignable
     * @return mixed
     */
    public function scopeApplyAssignable($query, $assignable)
    {
        return $query
            ->where('assignable_type', $assignable->getMorphClass())
            ->where('assignable_id', $assignable->getKey());
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeApplyRoundRobinScope($query)
    {
        return $query
            ->select('assignee_id')
            ->selectRaw('MAX(created_at) as assign_value')
            ->whereIn('status_id', setting('processing_order_status', []))
            ->groupBy('assignee_id')
            ->orderBy('assign_value', 'asc');
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @param $limit
     * @return mixed
     */
    public function scopeApplyLoadBalancedScope($query, $limit)
    {
        return $query
            ->select('assignee_id')
            ->selectRaw('COUNT(assignee_id)/'.DB::getPdo()->quote($limit).' as assign_value')
            ->whereIn('status_id', setting('processing_order_status', []))
            ->groupBy('assignee_id')
            ->orderBy('assign_value', 'desc')
            ->havingRaw('assign_value < 1');
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeWhereUnAssigned($query)
    {
        return $query->whereNotNull('assignee_group_id')->whereNull('assignee_id');
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @param $assigneeId
     * @return mixed
     */
    public function scopeWhereAssignTo($query, $assigneeId)
    {
        return $query->where('assignee_id', $assigneeId);
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @param $assigneeGroupId
     * @return mixed
     */
    public function scopeWhereAssignToGroup($query, $assigneeGroupId)
    {
        return $query->where('assignee_group_id', $assigneeGroupId);
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @param array $assigneeGroupIds
     * @return mixed
     */
    public function scopeWhereInAssignToGroup($query, array $assigneeGroupIds)
    {
        return $query->whereIn('assignee_group_id', $assigneeGroupIds);
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeWhereHasAutoAssignGroup($query)
    {
        return $query->whereHas('assignee_group', function (Builder $query) {
            $query->where('auto_assign', 1);
        });
    }
}