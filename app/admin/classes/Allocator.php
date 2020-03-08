<?php

namespace Admin\Classes;

use Admin\Models\Assignable_logs_model;
use Admin\Models\Staff_groups_model as GroupModel;
use Admin\Models\Staffs_model;
use Carbon\Carbon;
use Igniter\Flame\Traits\Singleton;

class Allocator
{
    use Singleton;

    public function allocate()
    {
        $unassignedQueue = Assignable_logs_model::getUnAssignedQueue();

        $unassignedQueue->each(function (Assignable_logs_model $assignableLog) {
            if (!$assigneeGroup = $assignableLog->assignee_group)
                return TRUE;

            if ($assignee = $this->findNextAvailableAssignee($assigneeGroup)) {
                $this->allocateToAssignee($assignableLog, $assignee);
            }
        });
    }

    /**
     * @param \Admin\Models\Staff_groups_model $assigneeGroup
     * @return \Admin\Models\Staffs_model|object
     */
    protected function findNextAvailableAssignee($assigneeGroup)
    {
        $assignees = $this->listAvailableStaff($assigneeGroup);

        $query = $this->createAssignableLogQuery();
        $query->where('assignee_group_id', $assigneeGroup->getKey());
        $query->whereIn('assignee_id', $assignees->pluck('staff_id')->all());
        $query->orderBy('created_at', 'desc');

        $useDate = TRUE;
        if ($assigneeGroup->auto_assign_mode == GroupModel::AUTO_ASSIGN_LOAD_BALANCED) {
            $useDate = FALSE;
            $query->applyLoadBalancedScope($assigneeGroup->auto_assign_limit);
        }
        else {
            $query->applyRoundRobinScope();
        }

        $response = $query->pluck('assign_value', 'assignee_id');

        return $this->getAssigneeFromResponse($assignees, $response, $useDate);
    }

    /**
     * @param \Admin\Models\Assignable_logs_model $assignableLog
     * @param \Admin\Models\Staffs_model $assignee
     * @return bool
     */
    protected function allocateToAssignee($assignableLog, $assignee)
    {
        $assignableLog->reload();
        $assignableLog->reloadRelations();

        if ($assignableLog->assignee)
            return FALSE;

        $assigneeGroup = $assignableLog->assignee_group;
        $assignableLog->assignable->assignTo($assigneeGroup, $assignee);
    }

    /**
     * @param \Admin\Models\Staff_groups_model $assigneeGroup
     * @return array
     */
    protected function listAvailableStaff($assigneeGroup)
    {
        return $assigneeGroup
            ->listAssignees()
            ->sortByDesc(function (Staffs_model $staff) {
                return $staff->user->last_seen;
            })->values();
    }

    protected function createAssignableLogQuery()
    {
        return Assignable_logs_model::make()->newQuery();
    }

    protected function getAssigneeFromResponse($assignees, $response, $useDate = FALSE)
    {
        $result = [];
        foreach ($assignees as $assignee) {
            $id = $assignee->getKey();
            $value = $useDate
                ? Carbon::now()->addYear()->toDateTimeString() : 0;

            $result[$id] = $response[$id] ?? $value;
        }

        asort($result);

        $id = array_key_first($result);

        return $assignees->keyBy('staff_id')->get($id);
    }
}