<?php

namespace Admin\Events\Assignable;

use System\Classes\BaseEvent;

class AssignedTo extends BaseEvent
{
    public $model;
    public $log;

    public function __construct($model, $log)
    {
        $this->model = $model;
        $this->log = $log;

        $this->fireBackwardsCompatibleEvent('admin.assignable.assigned', [$model, $log]);
    }
}
