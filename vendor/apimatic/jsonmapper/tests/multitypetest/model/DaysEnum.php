<?php

namespace multitypetest\model;

use Exception;
use stdClass;

/**
 * A string enum representing days of the week
 */
class DaysEnum
{
    const SUNDAY = 'Sunday';

    const MONDAY = 'Monday';

    const TUESDAY = 'Tuesday';

    const WEDNESDAY_ = 'Wednesday';

    const THURSDAY = 'Thursday';

    const FRI_DAY = 'Friday';

    const SATURDAY = 'Saturday';

    const DECEMBER = 'December';

    const _ALL_VALUES = [
        self::SUNDAY,
        self::MONDAY,
        self::TUESDAY,
        self::WEDNESDAY_,
        self::THURSDAY,
        self::FRI_DAY,
        self::SATURDAY,
        self::DECEMBER,
    ];

    /**
     * Ensures that all the given values are present in this Enum.
     *
     * @param array|stdClass|null|string $value Value or a list/map of values
     *
     * @return array|null|string Input value(s), if all are a part of this Enum
     *
     * @throws Exception Throws exception if any given value is not in this Enum
     */
    public static function checkValue($value)
    {
        $value = json_decode(json_encode($value), true);
        if (is_null($value)) {
            return null;
        }
        if (is_array($value)) {
            foreach ($value as $v) {
                self::checkValue($v);
            }
            return $value;
        }
        if (!in_array($value, self::_ALL_VALUES, true)) {
            throw new Exception("$value is invalid for " . self::class);
        }
        return $value;
    }
}
