<?php

namespace Admin\Events\Location;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScheduleCreated
{
    use Dispatchable, SerializesModels;

    public $model;

    public $schedule;

    public function __construct($model, $schedule)
    {
        $this->model = $model;
        $this->schedule = $schedule;
    }
}
