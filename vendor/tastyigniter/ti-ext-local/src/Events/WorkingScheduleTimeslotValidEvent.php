<?php

declare(strict_types=1);

namespace Igniter\Local\Events;

use DateTimeInterface;
use Igniter\Flame\Traits\EventDispatchable;
use Igniter\Local\Classes\WorkingSchedule;

class WorkingScheduleTimeslotValidEvent
{
    use EventDispatchable;

    public function __construct(public WorkingSchedule $schedule, public DateTimeInterface $timeslot) {}

    public static function eventName(): string
    {
        return 'igniter.workingSchedule.timeslotValid';
    }
}
