<?php

namespace Admin\Traits;

use Admin\Facades\AdminAuth;
use Admin\Models\AssignableLog;
use Admin\Models\StaffGroup;
use Illuminate\Database\Eloquent\Builder;

trait Assignable
{
    public static function bootAssignable()
    {
        static::extend(function (self $model) {
            $model->relation['belongsTo']['assignee'] = ['Admin\Models\Staff'];
            $model->relation['belongsTo']['assignee_group'] = ['Admin\Models\StaffGroup'];
            $model->relation['morphMany']['assignable_logs'] = [
                'Admin\Models\AssignableLog', 'name' => 'assignable', 'delete' => TRUE,
            ];

            $model->addCasts([
                'assignee_id' => 'integer',
                'assignee_group_id' => 'integer',
                'assignee_updated_at' => 'dateTime',
            ]);
        });

        self::saved(function (self $model) {
            $model->performOnAssignableAssigned();
        });
    }

    protected function performOnAssignableAssigned()
    {
        if (
            $this->wasChanged('status_id')
            && strlen($this->assignee_group_id)
        ) AssignableLog::createLog($this);
    }

    //
    //
    //

    /**
     * @param \Admin\Models\Staff $assignee
     * @return bool
     */
    public function assignTo($assignee)
    {
        if (is_null($this->assignee_group))
            return FALSE;

        return $this->updateAssignTo($this->assignee_group, $assignee);
    }

    /**
     * @param \Admin\Models\StaffGroup $group
     * @return bool
     */
    public function assignToGroup($group)
    {
        return $this->updateAssignTo($group);
    }

    public function updateAssignTo($group = null, $assignee = null)
    {
        if (is_null($group))
            $group = $this->assignee_group;

        $this->assignee_group()->associate($group);

        $oldAssignee = $this->assignee;
        if (!is_null($assignee))
            $this->assignee()->associate($assignee);

        $this->fireSystemEvent('admin.assignable.beforeAssignTo', [$group, $assignee, $oldAssignee]);

        $this->save();

        if (!$log = AssignableLog::createLog($this))
            return FALSE;

        $this->fireSystemEvent('admin.assignable.assigned', [$log]);

        return $log;
    }

    public function isAssignedToStaffGroup($staff)
    {
        return $staff
            ->groups()
            ->whereKey($this->assignee_group_id)
            ->exists();
    }

    public function hasAssignTo()
    {
        return !is_null($this->assignee);
    }

    public function hasAssignToGroup()
    {
        return !is_null($this->assignee_group);
    }

    public function listGroupAssignees()
    {
        if (!$this->assignee_group instanceof StaffGroup)
            return [];

        return $this->assignee_group->listAssignees();
    }

    //
    // Scopes
    //

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @param null $assignedTo
     * @return mixed
     */
    public function scopeFilterAssignedTo($query, $assignedTo = null)
    {
        if ($assignedTo == 1)
            return $query->whereNull('assignee_id');

        $staffId = optional(AdminAuth::staff())->getKey();
        if ($assignedTo == 2)
            return $query->where('assignee_id', $staffId);

        return $query->where('assignee_id', '!=', $staffId);
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
