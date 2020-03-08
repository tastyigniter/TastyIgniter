<?php namespace Admin\Models;

use Illuminate\Support\Facades\DB;
use Model;

/**
 * StaffGroups Model Class
 *
 * @package Admin
 */
class Staff_groups_model extends Model
{
    public const AUTO_ASSIGN_ROUND_ROBIN = 1;

    public const AUTO_ASSIGN_LOAD_BALANCED = 2;

    /**
     * @var string The database table name
     */
    protected $table = 'staff_groups';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'staff_group_id';

    public $relation = [
        'belongsToMany' => [
            'staffs' => ['Admin\Models\Staffs_model', 'table' => 'staffs_groups'],
        ],
    ];

    public $casts = [
        'auto_assign' => 'boolean',
        'auto_assign_mode' => 'integer',
        'auto_assign_limit' => 'integer',
        'auto_assign_availability' => 'boolean',
    ];

    public static function getDropdownOptions()
    {
        return static::dropdown('staff_group_name');
    }

    public static function listDropdownOptions()
    {
        return self::select('staff_group_id', 'staff_group_name', 'description')
                   ->get()
                   ->keyBy('staff_group_id')
                   ->map(function ($model) {
                       return [$model->staff_group_name, $model->description];
                   });
    }

    public function getStaffCountAttribute($value)
    {
        return $this->staffs->count();
    }

    //
    // Assignment
    //

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

    public function listAssignees()
    {
        return $this->staffs->filter(function (Staffs_model $staff) {
            return $staff->isEnabled() AND $staff->canAssignTo();
        })->values();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newRoundRobinAssignModeQuery()
    {
        $query = $this->staffs()->newQuery();

        return $query
            ->select('staffs.*')
            ->selectRaw('MAX(created_at) as assign_value')
            ->leftJoin('assignable_logs', 'assignable_logs.assignee_id', '=', 'staffs.staff_id')
            ->groupBy('assignable_logs.assignee_id')
            ->orderBy('assign_value', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newLoadBalancedAssignModeQuery()
    {
        $query = $this->staffs()->newQuery();
        $limit = DB::getPdo()->quote($this->auto_assign_limit);

        return $query
            ->select('staffs.*')
            ->selectRaw('COUNT(assignee_id)/'.$limit.' as assign_value')
            ->leftJoin('assignable_logs', 'assignable_logs.assignee_id', '=', 'staffs.staff_id')
            ->whereIn('status_id', setting('processing_order_status', []))
            ->groupBy('assignable_logs.assignee_id')
            ->orderBy('assign_value', 'desc')
            ->havingRaw('assign_value < 1');
    }
}