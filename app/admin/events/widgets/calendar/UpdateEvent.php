<?php

namespace Admin\Events\Widgets\Calendar;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use System\Traits\DispatchesLegacyEvent;

class UpdateEvent
{
    use Dispatchable, DispatchesLegacyEvent, InteractsWithSockets, SerializesModels;

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
