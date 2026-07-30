<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use DateTimeInterface;
use Igniter\Local\Exceptions\WorkingHourException;

class WorkingDay
{
    const MONDAY = 'monday';

    const TUESDAY = 'tuesday';

    const WEDNESDAY = 'wednesday';

    const THURSDAY = 'thursday';

    const FRIDAY = 'friday';

    const SATURDAY = 'saturday';

    const SUNDAY = 'sunday';

    public static function days(): array
    {
        return [
            static::MONDAY,
            static::TUESDAY,
            static::WEDNESDAY,
            static::THURSDAY,
            static::FRIDAY,
            static::SATURDAY,
            static::SUNDAY,
        ];
    }

    public static function mapDays(callable $callback): array
    {
        return array_map($callback, array_combine(static::days(), static::days()));
    }

    public static function isValid(string $day): bool
    {
        return in_array($day, static::days());
    }

    public static function onDateTime(DateTimeInterface $dateTime): string
    {
        return static::days()[$dateTime->format('N') - 1];
    }

    public static function toISO(string $day): int
    {
        return array_search($day, static::days(), true) + 1;
    }

    public static function normalizeName($day): string
    {
        $day = strtolower((string)$day);

        if (!static::isValid($day)) {
            throw new WorkingHourException(sprintf("Day `%s` isn't a valid day name. Valid day names are lowercase english words, e.g. `monday`, `thursday`.", $day));
        }

        return $day;
    }
}
