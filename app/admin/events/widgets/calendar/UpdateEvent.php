<?php

namespace Admin\Events\Widgets\Calendar;

use System\Classes\BaseEvent;

class UpdateEvent extends BaseEvent
{
    public $eventId;
    public $startAt;
    public $endAt;

    public function __construct($eventId, $startAt, $endAt)
    {
        $this->eventId = $eventId;
        $this->startAt = $startAt;
        $this->endAt = $endAt;

        $this->fireBackwardsCompatibleEvent('calendar.updateEvent', [$eventId, $startAt, $endAt]);
    }
}
