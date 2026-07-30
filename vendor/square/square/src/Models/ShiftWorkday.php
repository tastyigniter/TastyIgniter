<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A `Shift` search query filter parameter that sets a range of days that
 * a `Shift` must start or end in before passing the filter condition.
 */
class ShiftWorkday implements \JsonSerializable
{
    /**
     * @var DateRange|null
     */
    private $dateRange;

    /**
     * @var string|null
     */
    private $matchShiftsBy;

    /**
     * @var array
     */
    private $defaultTimezone = [];

    /**
     * Returns Date Range.
     * A range defined by two dates. Used for filtering a query for Connect v2
     * objects that have date properties.
     */
    public function getDateRange(): ?DateRange
    {
        return $this->dateRange;
    }

    /**
     * Sets Date Range.
     * A range defined by two dates. Used for filtering a query for Connect v2
     * objects that have date properties.
     *
     * @maps date_range
     */
    public function setDateRange(?DateRange $dateRange): void
    {
        $this->dateRange = $dateRange;
    }

    /**
     * Returns Match Shifts By.
     * Defines the logic used to apply a workday filter.
     */
    public function getMatchShiftsBy(): ?string
    {
        return $this->matchShiftsBy;
    }

    /**
     * Sets Match Shifts By.
     * Defines the logic used to apply a workday filter.
     *
     * @maps match_shifts_by
     */
    public function setMatchShiftsBy(?string $matchShiftsBy): void
    {
        $this->matchShiftsBy = $matchShiftsBy;
    }

    /**
     * Returns Default Timezone.
     * Location-specific timezones convert workdays to datetime filters.
     * Every location included in the query must have a timezone or this field
     * must be provided as a fallback. Format: the IANA timezone database
     * identifier for the relevant timezone.
     */
    public function getDefaultTimezone(): ?string
    {
        if (count($this->defaultTimezone) == 0) {
            return null;
        }
        return $this->defaultTimezone['value'];
    }

    /**
     * Sets Default Timezone.
     * Location-specific timezones convert workdays to datetime filters.
     * Every location included in the query must have a timezone or this field
     * must be provided as a fallback. Format: the IANA timezone database
     * identifier for the relevant timezone.
     *
     * @maps default_timezone
     */
    public function setDefaultTimezone(?string $defaultTimezone): void
    {
        $this->defaultTimezone['value'] = $defaultTimezone;
    }

    /**
     * Unsets Default Timezone.
     * Location-specific timezones convert workdays to datetime filters.
     * Every location included in the query must have a timezone or this field
     * must be provided as a fallback. Format: the IANA timezone database
     * identifier for the relevant timezone.
     */
    public function unsetDefaultTimezone(): void
    {
        $this->defaultTimezone = [];
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
        if (isset($this->dateRange)) {
            $json['date_range']       = $this->dateRange;
        }
        if (isset($this->matchShiftsBy)) {
            $json['match_shifts_by']  = $this->matchShiftsBy;
        }
        if (!empty($this->defaultTimezone)) {
            $json['default_timezone'] = $this->defaultTimezone['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
