<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use ArrayAccess;
use ArrayIterator;
use Countable;
use DateInterval;
use DateTimeInterface;
use Igniter\Local\Exceptions\WorkingHourException;
use IteratorAggregate;
use Override;
use Stringable;
use Traversable;

class WorkingPeriod implements ArrayAccess, Countable, IteratorAggregate, Stringable
{
    public const string CLOSED = 'closed';

    public const string OPEN = 'open';

    public const string OPENING = 'opening';

    /**
     * @var WorkingRange[]
     */
    protected array $ranges = [];

    public static function create(array $times): static
    {
        $period = new static;

        $timeRanges = array_map(WorkingRange::create(...), $times);

        $period->checkWorkingRangesOverlaps($timeRanges);

        $period->ranges = $timeRanges;

        return $period;
    }

    public function isOpenAt(WorkingTime $time): bool
    {
        return !is_null($this->findTimeInRange($time));
    }

    public function openTimeAt(WorkingTime $time): ?WorkingTime
    {
        if (($range = $this->findTimeInRange($time)) instanceof WorkingRange) {
            return $range->start();
        }

        return optional(current($this->ranges))->start();
    }

    public function closeTimeAt(WorkingTime $time): ?WorkingTime
    {
        if (($range = $this->findTimeInRange($time)) instanceof WorkingRange) {
            return $range->end();
        }

        return optional(end($this->ranges))->end();
    }

    public function nextOpenAt(WorkingTime $time): bool|WorkingTime
    {
        foreach ($this->ranges as $range) {
            if ($range->containsTime($time)) {
                if (count($this->ranges) === 1) {
                    return $range->start();
                }

                if (($nextOpenTime = $this->getNextStartTime($range)) instanceof WorkingTime) {
                    return $nextOpenTime;
                }
            }

            if (($nextOpenTime = $this->findNextTimeInFreeTime('start', $time, $range)) instanceof WorkingTime) {
                return $nextOpenTime;
            }
        }

        return false;
    }

    public function nextCloseAt(WorkingTime $time): bool|WorkingTime
    {
        foreach ($this->ranges as $range) {
            if ($range->containsTime($time)) {
                return $range->end();
            }

            if (($nextCloseTime = $this->findNextTimeInFreeTime('end', $time, $range)) instanceof WorkingTime) {
                return $nextCloseTime;
            }
        }

        return false;
    }

    public function opensAllDay(): bool
    {
        $diffInHours = 0;
        foreach ($this->ranges as $range) {
            $interval = $range->start()->diff($range->end());
            $diffInHours += (int)$interval->format('%H');
        }

        return $diffInHours >= 23 || $diffInHours === 0;
    }

    public function closesLate(): bool
    {
        return array_any($this->ranges, fn(WorkingRange $range): bool => $range->endsNextDay());
    }

    public function opensLateAt(WorkingTime $time): bool
    {
        return array_any($this->ranges, fn(WorkingRange $range): bool => $range->endsNextDay() && $range->containsTime($time));
    }

    public function timeslot(DateTimeInterface $dateTime, DateInterval $interval, ?DateInterval $leadTime = null): WorkingTimeslot
    {
        return WorkingTimeslot::make($this->ranges)->generate(
            $dateTime, $interval, $leadTime,
        );
    }

    protected function findTimeInRange(WorkingTime $time): ?WorkingRange
    {
        foreach ($this->ranges as $range) {
            if ($range->containsTime($time)) {
                return $range;
            }
        }

        return null;
    }

    protected function findNextTimeInFreeTime($type, WorkingTime $time, WorkingRange $timeRange): ?WorkingTime
    {
        $timeOffRange = WorkingRange::create(['00:00', (string)$timeRange->start()]);

        return ($timeOffRange->containsTime($time) || $timeOffRange->start()->isSame($time))
            ? $timeRange->{$type}()
            : null;
    }

    /**
     * @param WorkingRange[] $ranges
     * @throws WorkingHourException
     */
    protected function checkWorkingRangesOverlaps(array $ranges): void
    {
        foreach ($ranges as $index => $range) {
            $nextRange = $ranges[$index + 1] ?? null;
            if ($nextRange && $range->overlaps($nextRange)) {
                throw new WorkingHourException(sprintf('Time ranges %s and %s overlap.', $range, $nextRange));
            }
        }
    }

    protected function getNextStartTime(WorkingRange $range): ?WorkingTime
    {
        $currentRangeFound = false;

        return collect($this->ranges)->first(function($currentRange) use ($range, &$currentRangeFound) {
            if ($currentRange === $range) {
                $currentRangeFound = true;

                return false; // Skip the current range
            }

            if ($currentRangeFound) {
                return true; // Return the next range start
            }
        })?->start();
    }

    public function isEmpty(): bool
    {
        return $this->ranges === [];
    }

    /**
     * Retrieve an external iterator
     */
    #[Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->ranges);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function count(): int
    {
        return count($this->ranges);
    }

    /**
     * Whether a offset exists
     *
     * @return bool true on success or false on failure.
     */
    #[Override]
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->ranges[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @return mixed Can return all value types.
     */
    #[Override]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->ranges[$offset];
    }

    /**
     * Offset to set
     */
    #[Override]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new WorkingHourException('Can not set ranges');
    }

    /**
     * Offset to unset
     */
    #[Override]
    public function offsetUnset(mixed $offset): void
    {
        unset($this->ranges[$offset]);
    }

    #[Override]
    public function __toString(): string
    {
        $values = array_map(fn(WorkingRange $range): string => (string)$range, $this->ranges);

        return implode(',', $values);
    }
}
