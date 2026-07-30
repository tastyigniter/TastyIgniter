<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use DateInterval;
use DateTime;
use DateTimeInterface;
use Igniter\Local\Exceptions\WorkingHourException;
use Override;
use Stringable;

class WorkingTime implements Stringable
{
    public function __construct(protected int $hours, protected int $minutes) {}

    public static function create(string $string): self
    {
        if (!preg_match('/^([0-1]\d)|(2[0-4]):[0-5]\d$/', $string)) {
            throw new WorkingHourException(sprintf("The string `%s` isn't a valid time string. A time string must be a formatted as `18:00`.", $string));
        }

        [$hours, $minutes] = explode(':', $string);

        return new self((int)$hours, (int)$minutes);
    }

    public static function fromDateTime(DateTimeInterface $dateTime): self
    {
        return self::create($dateTime->format('H:i'));
    }

    public function hours(): int
    {
        return $this->hours;
    }

    public function minutes(): int
    {
        return $this->minutes;
    }

    public function isSame(self $time): bool
    {
        return (string)$this === (string)$time;
    }

    public function isAfter(self $time): bool
    {
        if ($this->isSame($time)) {
            return false;
        }

        if ($this->hours > $time->hours) {
            return true;
        }

        return $this->hours === $time->hours && $this->minutes >= $time->minutes;
    }

    public function isBefore(self $time): bool
    {
        if ($this->isSame($time)) {
            return false;
        }

        return !$this->isAfter($time);
    }

    public function isSameOrAfter(self $time): bool
    {
        return $this->isSame($time) || $this->isAfter($time);
    }

    public function isSameOrBefore(self $time): bool
    {
        return $this->isSame($time) || $this->isBefore($time);
    }

    public function diff(self $time): DateInterval
    {
        return $this->toDateTime()->diff($time->toDateTime());
    }

    /**
     * Convert to DateTime object.
     */
    public function toDateTime(?DateTime $date = null): DateTime
    {
        $date = $date instanceof DateTime ? clone $date : new DateTime('1970-01-01 00:00:00');

        return $date->setTime($this->hours, $this->minutes);
    }

    public function format(string $format = 'H:i'): string
    {
        return $this->toDateTime()->format($format);
    }

    #[Override]
    public function __toString(): string
    {
        return $this->format();
    }
}
