<?php

declare(strict_types=1);

namespace JsonSchema;

class Rfc3339
{
    private const REGEX = '/^(\d{4}-\d{2}-\d{2}[T ](0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):((?:[0-5][0-9]|60)))(\.\d+)?(Z|([+-](0[0-9]|1[0-9]|2[0-3]))(:)?([0-5][0-9]))$/';

    /**
     * Try creating a DateTime instance
     *
     * @param string $input
     *
     * @return \DateTime|null
     */
    public static function createFromString($input): ?\DateTime
    {
        if (!preg_match(self::REGEX, strtoupper($input), $matches)) {
            return null;
        }

        $input = strtoupper($input); // Cleanup for lowercase t and z
        $inputHasTSeparator = strpos($input, 'T');

        $dateAndTime = $matches[1];
        $microseconds = $matches[5] ?: '.000000';
        $timeZone = 'Z' !== $matches[6] ? $matches[6] : '+00:00';
        $dateFormat = $inputHasTSeparator === false ? 'Y-m-d H:i:s.uP' : 'Y-m-d\TH:i:s.uP';
        $dateTime = \DateTimeImmutable::createFromFormat($dateFormat, $dateAndTime . $microseconds . $timeZone, new \DateTimeZone('UTC'));

        if ($dateTime === false) {
            return null;
        }

        $utcDateTime = $dateTime->setTimezone(new \DateTimeZone('+00:00'));
        $oneSecond = new \DateInterval('PT1S');

        // handle leap seconds
        if ($matches[4] === '60' && $utcDateTime->sub($oneSecond)->format('H:i:s') === '23:59:59') {
            $dateTime = $dateTime->sub($oneSecond);
            $matches[1] = str_replace(':60', ':59', $matches[1]);
        }

        // Ensure we still have the same year, month, day, hour, minutes and seconds to ensure no rollover took place.
        if ($dateTime->format($inputHasTSeparator ? 'Y-m-d\TH:i:s' : 'Y-m-d H:i:s') !== $matches[1]) {
            return null;
        }

        $mutable = \DateTime::createFromFormat('U.u', $dateTime->format('U.u'));
        if ($mutable === false) {
            throw new \RuntimeException('Unable to create DateTime from DateTimeImmutable');
        }

        $mutable->setTimezone($dateTime->getTimezone());

        return $mutable;
    }
}
