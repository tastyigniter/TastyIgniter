<?php namespace Admin\Models;

use Admin\ActivityTypes\OrderAssigned;
use Admin\ActivityTypes\ReservationAssigned;
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
     */
    public static function createLog($assignable)
    {
        $model = self::firstOrNew([
            'assignable_type' => $assignable->getMorphClass(),
            'assignable_id' => $assignable->getKey(),
            'assignee_group_id' => $assignable->assignee_group_id,
        ]);

        $model->assignee_id = $assignable->assignee_id;
        $model->status_id = $assignable->status_id;

        $exists = $model->exists;

        if ($model->save()) {
            $exists
                ? $model->fireSystemEvent('admin.assignableLog.beforeUpdateAssignee')
                : $model->fireSystemEvent('admin.assignableLog.beforeAddAssignee');

            $assignable->newQuery()->where($assignable->getKeyName(), $assignable->getKey())->update([
                'assignee_updated_at' => Carbon::now(),
            ]);
        }

        return $model;
    }

    public static function getUnAssignedQueue()
    {
        $query = self::make()->newQuery();

        return $query
            ->whereUnAssigned()
            ->whereHasAutoAssignGroup()
            ->orderBy('updated_at', 'asc')
            ->get();
    }

    //
    //
    //

    protected function beforeSave()
    {
        if ($this->assignable instanceof Orders_model) {
            OrderAssigned::log($this->assignable);
        }
        elseif ($this->assignable instanceof Reservations_model) {
            ReservationAssigned::log($this->assignable);
        }
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
    public function scopeWhereUnAssigned($query)
    {
        return $query
            ->whereNotNull('assignee_group_id')
            ->whereNull('assignee_id');
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
}