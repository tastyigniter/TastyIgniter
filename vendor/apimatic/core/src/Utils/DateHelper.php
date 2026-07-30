<?php

declare(strict_types=1);

namespace Core\Utils;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use stdClass;

class DateHelper
{
    /**
     * Match the pattern for a datetime string in simple date format
     */
    public const SIMPLE_DATE = 'Y-m-d';

    /**
     * Match the pattern for a datetime string in Rfc1123 format
     */
    public const RFC1123 = 'D, d M Y H:i:s T';

    /**
     * Match the pattern for a datetime string in RFC3339 format
     */
    public const RFC3339 = 'Y-m-d\TH:i:sP';

    /**
     * Convert a DateTime object to a string in simple date format
     *
     * @param DateTime|null $date The DateTime object to convert
     *
     * @return string|null The datetime as a string in simple date format
     * @throws InvalidArgumentException
     */
    public static function toSimpleDate(?DateTime $date): ?string
    {
        if (is_null($date)) {
            return null;
        }
        return $date->format(static::SIMPLE_DATE);
    }

    /**
     * Convert an array of DateTime objects to an array of strings in simple date format
     *
     * @param array|null $dates The array of DateTime objects to convert
     *
     * @return array|null The array of datetime strings in simple date format
     */
    public static function toSimpleDateArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toSimpleDate'], $dates);
    }

    /**
     * Convert a 2D array of DateTime objects to a 2D array of strings in simple date format
     *
     * @param array|null $dates The 2D array of DateTime objects to convert
     *
     * @return array|null The 2D array of datetime strings in simple date format
     */
    public static function toSimpleDate2DArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toSimpleDateArray'], $dates);
    }

    /**
     * Parse a datetime string in simple date format to a DateTime object
     *
     * @param string|null $date A datetime string in simple date format
     *
     * @return DateTime|null The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromSimpleDate(?string $date): ?DateTime
    {
        if (is_null($date)) {
            return null;
        }
        $x = DateTime::createFromFormat(static::SIMPLE_DATE, $date);
        if ($x instanceof DateTime) {
            return $x;
        }
        throw new InvalidArgumentException('Incorrect format.');
    }

    /**
     * Parse a datetime string in simple date format to a DateTime object
     *
     * @param string|null $date A datetime string in simple date format
     *
     * @return DateTime The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromSimpleDateRequired(?string $date): DateTime
    {
        $result = DateHelper::fromSimpleDate($date);

        if (isset($result)) {
            return $result;
        }

        throw new \InvalidArgumentException('Date is null, empty or not in required format.');
    }

    /**
     * Parse an array of datetime strings in simple date format to an array of DateTime objects
     *
     * @param array|null $dates An array of datetime strings in simple date format
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromSimpleDateArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromSimpleDate'], $dates);
    }

    /**
     * Parse an array of map of datetime strings in simple date format to a 2D array of DateTime objects
     *
     * @param array|null $dates An array of map of datetime strings in simple date format
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromSimpleDateArrayOfMap(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromSimpleDateMap'], $dates);
    }

    /**
     * Parse a class of datetime strings in simple date format to an array of DateTime objects
     *
     * @param stdClass|null $dates A class of datetime strings in simple date format
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromSimpleDateMap(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromSimpleDate'], $array);
    }

    /**
     * Parse a map of array of datetime strings in simple date format to a 2D array of DateTime objects
     *
     * @param stdClass|null $dates A map of array of datetime strings in simple date format
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromSimpleDateMapOfArray(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromSimpleDateArray'], $array);
    }

    /**
     * Convert a DateTime object to a string in Rfc1123 format
     *
     * @param DateTime|null $date The DateTime object to convert
     *
     * @return string|null The datetime as a string in Rfc1123 format
     * @throws InvalidArgumentException
     */
    public static function toRfc1123DateTime(?DateTime $date): ?string
    {
        if (is_null($date)) {
            return null;
        }
        return $date->setTimeZone(new DateTimeZone('GMT'))->format(static::RFC1123);
    }

    /**
     * Convert an array of DateTime objects to an array of strings in Rfc1123 format
     *
     * @param array|null $dates The array of DateTime objects to convert
     *
     * @return array|null The array of datetime strings in Rfc1123 format
     */
    public static function toRfc1123DateTimeArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toRfc1123DateTime'], $dates);
    }

    /**
     * Convert a 2D array of DateTime objects to a 2D array of strings in Rfc1123 format
     *
     * @param array|null $dates The 2D array of DateTime objects to convert
     *
     * @return array|null The 2D array of datetime strings in Rfc1123 format
     */
    public static function toRfc1123DateTime2DArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toRfc1123DateTimeArray'], $dates);
    }

    /**
     * Parse a datetime string in Rfc1123 format to a DateTime object
     *
     * @param string|null $date A datetime string in Rfc1123 format
     *
     * @return DateTime|null The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromRfc1123DateTime(?string $date): ?DateTime
    {
        if (is_null($date)) {
            return null;
        }
        $x = DateTime::createFromFormat(static::RFC1123, $date);
        if ($x instanceof DateTime) {
            return $x->setTimeZone(new DateTimeZone('GMT'));
        }
        throw new InvalidArgumentException('Incorrect format.');
    }

    /**
     * Parse a datetime string in Rfc1123 format to a DateTime object
     *
     * @param string|null $datetime A datetime string in Rfc1123 format
     *
     * @return DateTime The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromRfc1123DateTimeRequired(?string $datetime): DateTime
    {
        $result = DateHelper::fromRfc1123DateTime($datetime);

        if (isset($result)) {
            return $result;
        }

        throw new \InvalidArgumentException('DateTime is null, empty or not in required format.');
    }

    /**
     * Parse an array of datetime strings in Rfc1123 format to an array of DateTime objects
     *
     * @param array|null $dates An array of datetime strings in Rfc1123 format
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromRfc1123DateTimeArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromRfc1123DateTime'], $dates);
    }

    /**
     * Parse an array of map of datetime strings in Rfc1123 format to a 2D array of DateTime objects
     *
     * @param array|null $dates An array of map of datetime strings in Rfc1123 format
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromRfc1123DateTimeArrayOfMap(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromRfc1123DateTimeMap'], $dates);
    }

    /**
     * Parse a class of datetime strings in Rfc1123 format to an array of DateTime objects
     *
     * @param stdClass|null $dates A class of datetime strings in Rfc1123 format
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromRfc1123DateTimeMap(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromRfc1123DateTime'], $array);
    }

    /**
     * Parse a map of array of datetime strings in Rfc1123 format to a 2D array of DateTime objects
     *
     * @param stdClass|null $dates A map of array of datetime strings in Rfc1123 format
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromRfc1123DateTimeMapOfArray(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromRfc1123DateTimeArray'], $array);
    }

    /**
     * Convert a DateTime object to a string in Rfc3339 format
     *
     * @param DateTime|null $date The DateTime object to convert
     *
     * @return string|null The datetime as a string in Rfc3339 format
     * @throws InvalidArgumentException
     */
    public static function toRfc3339DateTime(?DateTime $date): ?string
    {
        if (is_null($date)) {
            return null;
        }
        return $date->setTimeZone(new DateTimeZone('UTC'))->format(static::RFC3339);
    }

    /**
     * Convert an array of DateTime objects to an array of strings in Rfc3339 format
     *
     * @param array|null $dates The array of DateTime objects to convert
     *
     * @return array|null The array of datetime strings in Rfc3339 format
     */
    public static function toRfc3339DateTimeArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toRfc3339DateTime'], $dates);
    }

    /**
     * Convert a 2D array of DateTime objects to a 2D array of strings in Rfc3339 format
     *
     * @param array|null $dates The 2D array of DateTime objects to convert
     *
     * @return array|null The 2D array of datetime strings in Rfc3339 format
     */
    public static function toRfc3339DateTime2DArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toRfc3339DateTimeArray'], $dates);
    }

    /**
     * Parse a datetime string in Rfc3339 format to a DateTime object
     *
     * @param string|null $date A datetime string in Rfc3339 format
     *
     * @return DateTime|null The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromRfc3339DateTime(?string $date): ?DateTime
    {
        if (is_null($date)) {
            return null;
        }
        // Check for timezone information and append it if missing
        if (substr($date, strlen($date) - 1) !== 'Z' && strpos($date, '+') === false) {
            $date .= 'Z';
        }

        $x = DateTime::createFromFormat(static::RFC3339, $date);
        if ($x instanceof DateTime) {
            return $x->setTimeZone(new DateTimeZone('UTC'));
        }
        $x = DateTime::createFromFormat("Y-m-d\TH:i:s.uP", $date); // parse with up to 6 microseconds
        if ($x instanceof DateTime) {
            return $x->setTimeZone(new DateTimeZone('UTC'));
        }
        $x = DateTime::createFromFormat("Y-m-d\TH:i:s.uuP", $date); // parse with up to 12 microseconds
        if ($x instanceof DateTime) {
            return $x->setTimeZone(new DateTimeZone('UTC'));
        }
        throw new InvalidArgumentException('Incorrect format.');
    }

    /**
     * Parse a datetime string in Rfc3339 format to a DateTime object
     *
     * @param string|null $datetime A datetime string in Rfc3339 format
     *
     * @return DateTime The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromRfc3339DateTimeRequired(?string $datetime): DateTime
    {
        $result = DateHelper::fromRfc3339DateTime($datetime);

        if (isset($result)) {
            return $result;
        }

        throw new \InvalidArgumentException('DateTime is null, empty or not in required format.');
    }

    /**
     * Parse an array of datetime strings in Rfc3339 format to an array of DateTime objects
     *
     * @param array|null $dates An array of datetime strings in Rfc3339 format
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromRfc3339DateTimeArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromRfc3339DateTime'], $dates);
    }

    /**
     * Parse an array of map of datetime strings in Rfc3339 format to a 2D array DateTime objects
     *
     * @param array|null $dates An array of map of datetime strings in Rfc3339 format
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromRfc3339DateTimeArrayOfMap(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromRfc3339DateTimeMap'], $dates);
    }

    /**
     * Parse a class of datetime strings in Rfc3339 format to an array of DateTime objects
     *
     * @param stdClass|null $dates A class of datetime strings in Rfc3339 format
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromRfc3339DateTimeMap(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromRfc3339DateTime'], $array);
    }

    /**
     * Parse a map of array of datetime strings in Rfc3339 format to a 2D array of DateTime objects
     *
     * @param stdClass|null $dates A map of array of datetime strings in Rfc3339 format
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromRfc3339DateTimeMapOfArray(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromRfc3339DateTimeArray'], $array);
    }

    /**
     * Convert a DateTime object to a Unix Timestamp
     *
     * @param DateTime|null $date The DateTime object to convert
     *
     * @return int|null The converted Unix Timestamp
     * @throws InvalidArgumentException
     */
    public static function toUnixTimestamp(?DateTime $date): ?int
    {
        if (is_null($date)) {
            return null;
        }
        return $date->getTimestamp();
    }

    /**
     * Convert an array of DateTime objects to an array of Unix timestamps
     *
     * @param array|null $dates The array of DateTime objects to convert
     *
     * @return array|null The array of integers representing date-time in Unix timestamp
     */
    public static function toUnixTimestampArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toUnixTimestamp'], $dates);
    }

    /**
     * Convert a 2D array of DateTime objects to a 2D array of Unix timestamps
     *
     * @param array|null $dates The 2D array of DateTime objects to convert
     *
     * @return array|null The 2D array of integers representing date-time in Unix timestamp
     */
    public static function toUnixTimestamp2DArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'toUnixTimestampArray'], $dates);
    }

    /**
     * Parse a Unix Timestamp to a DateTime object
     *
     * @param string|null $date The Unix Timestamp
     *
     * @return DateTime|null The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromUnixTimestamp(?string $date): ?DateTime
    {
        if (empty($date)) {
            return null;
        }
        $x = DateTime::createFromFormat("U", $date);
        if ($x instanceof DateTime) {
            return $x;
        }
        throw new InvalidArgumentException('Incorrect format.');
    }

    /**
     * Parse a Unix Timestamp to a DateTime object
     *
     * @param string|null $datetime The Unix Timestamp
     *
     * @return DateTime The parsed DateTime object
     * @throws InvalidArgumentException
     */
    public static function fromUnixTimestampRequired(?string $datetime): DateTime
    {
        $result = DateHelper::fromUnixTimestamp($datetime);

        if (isset($result)) {
            return $result;
        }

        throw new \InvalidArgumentException('DateTime is null, empty or not in required format.');
    }

    /**
     * Parse an array of Unix Timestamps to an array of DateTime objects
     *
     * @param array|null $dates An array of Unix Timestamps
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromUnixTimestampArray(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromUnixTimestamp'], array_map('strval', $dates));
    }

    /**
     * Parse an array of map of Unix Timestamps to a 2D array of DateTime objects
     *
     * @param array|null $dates An array of map of Unix Timestamps
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromUnixTimestampArrayOfMap(?array $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        return array_map([self::class, 'fromUnixTimestampMap'], $dates);
    }

    /**
     * Parse a class of Unix Timestamps to an array of DateTime objects
     *
     * @param stdClass|null $dates A class of Unix Timestamps
     *
     * @return array|null An array of parsed DateTime objects
     */
    public static function fromUnixTimestampMap(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromUnixTimestamp'], array_map('strval', $array));
    }

    /**
     * Parse a map of array of Unix Timestamps to a 2D array of DateTime objects
     *
     * @param stdClass|null $dates A map of array of Unix Timestamps
     *
     * @return array|null A 2D array of parsed DateTime objects
     */
    public static function fromUnixTimestampMapOfArray(?stdClass $dates): ?array
    {
        if (is_null($dates)) {
            return null;
        }
        $array = json_decode(json_encode($dates), true);
        return array_map([self::class, 'fromUnixTimestampArray'], $array);
    }
}
