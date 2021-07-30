<?php

namespace Admin\Events\Widgets\Calendar;

use Event;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventId;
    public $startAt;
    public $endAt;

    public function __construct($eventId, $startAt, $endAt)
    {
        $this->eventId = $eventId;
        $this->startAt = $startAt;
        $this->endAt = $endAt;

        // deprecate on next major release
        Event::fire('calendar.updateEvent', [$eventId, $startAt, $endAt]);

    }
}
