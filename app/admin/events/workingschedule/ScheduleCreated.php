<?php

namespace Admin\Events\WorkingSchedule;

use System\Classes\BaseEvent;

class ScheduleCreated extends BaseEvent
{
    public $model;
    public $schedule;

    public function __construct($model, $schedule)
    {
        $this->model = $model;
        $this->schedule = $schedule;

        $this->fireBackwardsCompatibleEvent('admin.workingSchedule.created', [$this->model, $this->schedule]);
    }
}
