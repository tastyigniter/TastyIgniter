<?php

namespace Admin\Events\Widgets\Calendar;

use System\Classes\BaseEvent;

class GenerateEvents extends BaseEvent
{
    public $calendar;
    public $startAt;
    public $endAt;
    public $events;

    public function __construct($widget, $startAt, $endAt, $events)
    {
        $this->calendar = $widget;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->events = $events;

        $this->fireBackwardsCompatibleEvent('calendar.generateEvents', [$startAt, $endAt, $events]);
    }
}
