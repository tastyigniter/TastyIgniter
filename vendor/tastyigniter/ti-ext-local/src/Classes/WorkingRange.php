<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use Igniter\Local\Exceptions\WorkingHourException;
use Override;
use Stringable;

class WorkingRange implements Stringable
{
    protected function __construct(protected WorkingTime $start, protected WorkingTime $end) {}

    public static function create(array $times): self
    {
        [$start, $end] = $times;

        return new static(
            WorkingTime::create($start),
            WorkingTime::create($end),
        );
    }

    public static function fromRanges(array $ranges): self
    {
        if ($ranges === []) {
            throw new WorkingHourException('The given ranges must contain at least one range.');
        }

        array_walk($ranges, function($range): void {
            if (!$range instanceof self) {
                throw new WorkingHourException('The given ranges is not a valid list of TimeRange instance containing.');
            }
        });

        $start = $ranges[0]->start();
        $end = $ranges[0]->end();

        foreach (array_slice($ranges, 1) as $range) {
            $rangeStart = $range->start();
            if ($rangeStart->format('Gi') < $start->format('Gi')) {
                $start = $rangeStart;
            }

            $rangeEnd = $range->end();
            if ($rangeEnd->format('Gi') > $end->format('Gi')) {
                $end = $rangeEnd;
            }
        }

        return new self($start, $end);
    }

    public function start(): WorkingTime
    {
        return $this->start;
    }

    public function end(): WorkingTime
    {
        return $this->end;
    }

    public function endsNextDay(): bool
    {
        return $this->end->isBefore($this->start);
    }

    public function opensAllDay(): bool
    {
        $diffInHours = $this->start()->diff($this->end());

        return ($diffInHours->h == 23 && $diffInHours->i == 59) || $diffInHours == 0;
    }

    public function containsTime(WorkingTime $time): bool
    {
        if ($this->endsNextDay()) {
            if ($time->isSameOrAfter($this->start)) {
                return $time->isAfter($this->end);
            }

            return $time->isBefore($this->end);
        }

        return $time->isSameOrAfter($this->start) && $time->isBefore($this->end);
    }

    public function overlaps(self $timeRange): bool
    {
        return $this->containsTime($timeRange->start) || $this->containsTime($timeRange->end);
    }

    public function format(string $timeFormat = 'H:i', string $rangeFormat = '%s-%s'): string
    {
        return sprintf($rangeFormat, $this->start->format($timeFormat), $this->end->format($timeFormat));
    }

    #[Override]
    public function __toString(): string
    {
        return $this->format();
    }
}
