<?php

namespace Admin\Events\Location;

class ScheduleCreated
{
    public $model;

    public $schedule;

    public function __construct($model, $schedule)
    {
        $this->model = $model;
        $this->schedule = $schedule;
    }
}
