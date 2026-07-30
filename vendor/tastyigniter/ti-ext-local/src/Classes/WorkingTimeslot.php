<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use DateInterval;
use DatePeriod;
use DateTimeInterface;
use Illuminate\Support\Collection;

class WorkingTimeslot extends Collection
{
    public function generate(DateTimeInterface $date, DateInterval $interval, ?DateInterval $leadTime = null): static
    {
        $items = [];

        foreach ($this->items as $range) {
            $start = $range->start()->toDateTime($date);
            $end = $range->end()->toDateTime($date);

            if ($range->endsNextDay()) {
                $end->add(new DateInterval('P1D'));
            }

            if (!is_null($leadTime)) {
                $start = $start->add($leadTime);
            }

            if ($interval->format('%i') < 5) {
                $interval->i = 5;
            }

            $datePeriod = new DatePeriod($start, $interval, $end);
            foreach ($datePeriod as $dateTime) {
                $items[] = $dateTime;
            }
        }

        return new static($items);
    }
}
