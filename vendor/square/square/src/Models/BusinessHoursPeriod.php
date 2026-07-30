<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a period of time during which a business location is open.
 */
class BusinessHoursPeriod implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $dayOfWeek;

    /**
     * @var array
     */
    private $startLocalTime = [];

    /**
     * @var array
     */
    private $endLocalTime = [];

    /**
     * Returns Day of Week.
     * Indicates the specific day  of the week.
     */
    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    /**
     * Sets Day of Week.
     * Indicates the specific day  of the week.
     *
     * @maps day_of_week
     */
    public function setDayOfWeek(?string $dayOfWeek): void
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    /**
     * Returns Start Local Time.
     * The start time of a business hours period, specified in local time using partial-time
     * RFC 3339 format. For example, `8:30:00` for a period starting at 8:30 in the morning.
     * Note that the seconds value is always :00, but it is appended for conformance to the RFC.
     */
    public function getStartLocalTime(): ?string
    {
        if (count($this->startLocalTime) == 0) {
            return null;
        }
        return $this->startLocalTime['value'];
    }

    /**
     * Sets Start Local Time.
     * The start time of a business hours period, specified in local time using partial-time
     * RFC 3339 format. For example, `8:30:00` for a period starting at 8:30 in the morning.
     * Note that the seconds value is always :00, but it is appended for conformance to the RFC.
     *
     * @maps start_local_time
     */
    public function setStartLocalTime(?string $startLocalTime): void
    {
        $this->startLocalTime['value'] = $startLocalTime;
    }

    /**
     * Unsets Start Local Time.
     * The start time of a business hours period, specified in local time using partial-time
     * RFC 3339 format. For example, `8:30:00` for a period starting at 8:30 in the morning.
     * Note that the seconds value is always :00, but it is appended for conformance to the RFC.
     */
    public function unsetStartLocalTime(): void
    {
        $this->startLocalTime = [];
    }

    /**
     * Returns End Local Time.
     * The end time of a business hours period, specified in local time using partial-time
     * RFC 3339 format. For example, `21:00:00` for a period ending at 9:00 in the evening.
     * Note that the seconds value is always :00, but it is appended for conformance to the RFC.
     */
    public function getEndLocalTime(): ?string
    {
        if (count($this->endLocalTime) == 0) {
            return null;
        }
        return $this->endLocalTime['value'];
    }

    /**
     * Sets End Local Time.
     * The end time of a business hours period, specified in local time using partial-time
     * RFC 3339 format. For example, `21:00:00` for a period ending at 9:00 in the evening.
     * Note that the seconds value is always :00, but it is appended for conformance to the RFC.
     *
     * @maps end_local_time
     */
    public function setEndLocalTime(?string $endLocalTime): void
    {
        $this->endLocalTime['value'] = $endLocalTime;
    }

    /**
     * Unsets End Local Time.
     * The end time of a business hours period, specified in local time using partial-time
     * RFC 3339 format. For example, `21:00:00` for a period ending at 9:00 in the evening.
     * Note that the seconds value is always :00, but it is appended for conformance to the RFC.
     */
    public function unsetEndLocalTime(): void
    {
        $this->endLocalTime = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->dayOfWeek)) {
            $json['day_of_week']      = $this->dayOfWeek;
        }
        if (!empty($this->startLocalTime)) {
            $json['start_local_time'] = $this->startLocalTime['value'];
        }
        if (!empty($this->endLocalTime)) {
            $json['end_local_time']   = $this->endLocalTime['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
