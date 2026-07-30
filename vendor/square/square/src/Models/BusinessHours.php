<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The hours of operation for a location.
 */
class BusinessHours implements \JsonSerializable
{
    /**
     * @var array
     */
    private $periods = [];

    /**
     * Returns Periods.
     * The list of time periods during which the business is open. There can be at most 10 periods per day.
     *
     * @return BusinessHoursPeriod[]|null
     */
    public function getPeriods(): ?array
    {
        if (count($this->periods) == 0) {
            return null;
        }
        return $this->periods['value'];
    }

    /**
     * Sets Periods.
     * The list of time periods during which the business is open. There can be at most 10 periods per day.
     *
     * @maps periods
     *
     * @param BusinessHoursPeriod[]|null $periods
     */
    public function setPeriods(?array $periods): void
    {
        $this->periods['value'] = $periods;
    }

    /**
     * Unsets Periods.
     * The list of time periods during which the business is open. There can be at most 10 periods per day.
     */
    public function unsetPeriods(): void
    {
        $this->periods = [];
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
        if (!empty($this->periods)) {
            $json['periods'] = $this->periods['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
