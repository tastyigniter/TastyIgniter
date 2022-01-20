<?php

namespace Admin\Events\StatusHistory;

use System\Classes\BaseEvent;

class HistoryAdded extends BaseEvent
{
    public $model;
    public $log;

    public function __construct($model, $log)
    {
        $this->model = $model;
        $this->log = $log;

        $this->fireBackwardsCompatibleEvent('admin.statusHistory.added', [$model, $log]);
    }
}
