<?php

namespace multitypetest\model;

use Exception;
use stdClass;

/**
 * A string enum representing days of the week
 */
class MonthNameEnum
{
    const JANUARY = 'January';

    const FEBRUARY = 'February';

    const MARCH = 'March';

    const APRIL = 'April';

    const MAY = 'May';

    const JUNE = 'June';

    const JULY = 'July';

    const AUGUST = 'August';

    const SEPTEMBER = 'September';

    const OCTOBER = 'October';

    const NOVEMBER = 'November';

    const DECEMBER = 'December';

    const _ALL_VALUES = [
        self::JANUARY,
        self::FEBRUARY,
        self::MARCH,
        self::APRIL,
        self::MAY,
        self::JUNE,
        self::JULY,
        self::AUGUST,
        self::SEPTEMBER,
        self::OCTOBER,
        self::NOVEMBER,
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
