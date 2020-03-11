<?php

namespace Admin\Classes;

use Admin\Models\Orders_model;
use Admin\Models\Reservations_model;
use Admin\Models\Staff_groups_model;
use Igniter\Flame\Traits\Singleton;

class Allocator
{
    use Singleton;

    protected static $running = FALSE;

    public function allocate()
    {
        if (self::$running)
            return;

        self::$running = TRUE;

        $this->getUnAssignedQueue()->each(function ($assignable) {
            $assigneeGroup = $assignable->assignee_group;
            if (!$assigneeGroup instanceof Staff_groups_model)
                return TRUE;

            if ($assignee = $assigneeGroup->findAvailableAssignee()) {
                $this->allocateToAssignee($assignable, $assignee);
            }
        });

        self::$running = FALSE;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $assignable
     * @param \Admin\Models\Staffs_model $assignee
     * @return bool
     */
    protected function allocateToAssignee($assignable, $assignee)
    {
        $assignable->reload();
        $assignable->reloadRelations();

        if ($assignable->assignee)
            return FALSE;

        $assigneeGroup = $assignable->assignee_group;
        if (!method_exists($assignable, 'assignTo'))
            throw new \BadMethodCallException('Method assignTo() not found in '.get_class($assignable));

        $assignable->assignTo($assigneeGroup, $assignee);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getUnAssignedQueue()
    {
        return collect()->merge(
            Orders_model::getUnAssignedQueue(),
            Reservations_model::getUnAssignedQueue()
        );
    }
}