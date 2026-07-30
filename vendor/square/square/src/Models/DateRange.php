<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A range defined by two dates. Used for filtering a query for Connect v2
 * objects that have date properties.
 */
class DateRange implements \JsonSerializable
{
    /**
     * @var array
     */
    private $startDate = [];

    /**
     * @var array
     */
    private $endDate = [];

    /**
     * Returns Start Date.
     * A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601
     * extended format for calendar dates.
     * The beginning of a date range (inclusive).
     */
    public function getStartDate(): ?string
    {
        if (count($this->startDate) == 0) {
            return null;
        }
        return $this->startDate['value'];
    }

    /**
     * Sets Start Date.
     * A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601
     * extended format for calendar dates.
     * The beginning of a date range (inclusive).
     *
     * @maps start_date
     */
    public function setStartDate(?string $startDate): void
    {
        $this->startDate['value'] = $startDate;
    }

    /**
     * Unsets Start Date.
     * A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601
     * extended format for calendar dates.
     * The beginning of a date range (inclusive).
     */
    public function unsetStartDate(): void
    {
        $this->startDate = [];
    }

    /**
     * Returns End Date.
     * A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601
     * extended format for calendar dates.
     * The end of a date range (inclusive).
     */
    public function getEndDate(): ?string
    {
        if (count($this->endDate) == 0) {
            return null;
        }
        return $this->endDate['value'];
    }

    /**
     * Sets End Date.
     * A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601
     * extended format for calendar dates.
     * The end of a date range (inclusive).
     *
     * @maps end_date
     */
    public function setEndDate(?string $endDate): void
    {
        $this->endDate['value'] = $endDate;
    }

    /**
     * Unsets End Date.
     * A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601
     * extended format for calendar dates.
     * The end of a date range (inclusive).
     */
    public function unsetEndDate(): void
    {
        $this->endDate = [];
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
        if (!empty($this->startDate)) {
            $json['start_date'] = $this->startDate['value'];
        }
        if (!empty($this->endDate)) {
            $json['end_date']   = $this->endDate['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
