<?php

namespace Admin\Traits;

use Admin\Facades\AdminAuth;
use Admin\Models\Assignable_logs_model;
use Admin\Models\Staff_groups_model;

trait Assignable
{
    public static function bootAssignable()
    {
        static::extend(function (self $model) {
            $model->relation['belongsTo']['assignee'] = ['Admin\Models\Staffs_model'];
            $model->relation['belongsTo']['assignee_group'] = ['Admin\Models\Staff_groups_model'];
            $model->relation['morphMany']['assignable_logs'] = [
                'Admin\Models\Assignable_logs_model', 'name' => 'assignable',
            ];

            $model->casts = array_merge($model->casts, [
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
        if (strlen($this->assignee_group_id))
            Assignable_logs_model::createLog($this);
    }

    //
    //
    //

    /**
     * @param \Admin\Models\Staff_groups_model $group
     * @param \Admin\Models\Staffs_model $assignee
     * @return bool
     */
    public function assignTo($group, $assignee = null)
    {
        $this->fireSystemEvent('admin.assignable.beforeAssignTo', [$group, $assignee]);

        $saved = $this->updateAssignTo($group, $assignee);

        if ($this->wasChanged(['assignee_id', 'assignee_group_id']))
            $this->fireSystemEvent('admin.assignable.assigned');

        return $saved;
    }

    public function updateAssignTo($group = null, $assignee = null)
    {
        if (is_null($group))
            $group = $this->assignee_group;

        $this->assignee_group()->associate($group);

        if (!is_null($assignee))
            $this->assignee()->associate($assignee);

        return $this->save();
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
        if (!$this->assign_group instanceof Staff_groups_model)
            return [];

        return $this->assign_group->listAssignees();
    }

    //
    // Scopes
    //

    public function scopeFilterAssignedTo($query, $assignedTo = null)
    {
        $staffId = AdminAuth::staff()->getKey();

        if ($assignedTo == 1)
            return $query->whereNull('assignee_id');

        if ($assignedTo == 2)
            return $query->where('assignee_id', $staffId);

        return $query->where('assignee_id', '!=', $staffId);
    }

    public function scopeWhereAssignTo($query, $assigneeId)
    {
        return $query->where('assignee_id', $assigneeId);
    }

    public function scopeWhereAssignToGroup($query, $assigneeGroupId)
    {
        return $query->where('assignee_group_id', $assigneeGroupId);
    }

    public function scopeWhereInAssignToGroup($query, array $assigneeGroupIds)
    {
        return $query->whereIn('assignee_group_id', $assigneeGroupIds);
    }
}