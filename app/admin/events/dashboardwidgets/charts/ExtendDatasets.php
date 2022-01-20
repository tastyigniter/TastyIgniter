<?php

namespace Admin\Events\DashboardWidgets\Charts;

use System\Classes\BaseEvent;

class ExtendDatasets extends BaseEvent
{
    public $chart;

    public function __construct($chart)
    {
        $this->chart = $chart;

        $this->fireBackwardsCompatibleEvent('admin.charts.extendDatasets', [$chart]);
    }
}
