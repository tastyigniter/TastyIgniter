<?php

namespace Admin\Events\Assignable;

use System\Classes\BaseEvent;

class BeforeAssignTo extends BaseEvent
{
    public $model;
    public $group;
    public $assignee;
    public $oldAssignee;

    public function __construct($model, $group, $assignee, $oldAssignee)
    {
        $this->model = $model;
        $this->group = $group;
        $this->assignee = $assignee;
        $this->oldAssignee = $oldAssignee;

        $this->fireBackwardsCompatibleEvent('admin.assignable.beforeAssignTo', [$model, $group, $assignee, $oldAssignee]);
    }
}
