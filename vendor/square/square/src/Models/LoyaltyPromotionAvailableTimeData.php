<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents scheduling information that determines when purchases can qualify to earn points
 * from a [loyalty promotion]($m/LoyaltyPromotion).
 */
class LoyaltyPromotionAvailableTimeData implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $startDate;

    /**
     * @var string|null
     */
    private $endDate;

    /**
     * @var string[]
     */
    private $timePeriods;

    /**
     * @param string[] $timePeriods
     */
    public function __construct(array $timePeriods)
    {
        $this->timePeriods = $timePeriods;
    }

    /**
     * Returns Start Date.
     * The date that the promotion starts, in `YYYY-MM-DD` format. Square populates this field
     * based on the provided `time_periods`.
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * Sets Start Date.
     * The date that the promotion starts, in `YYYY-MM-DD` format. Square populates this field
     * based on the provided `time_periods`.
     *
     * @maps start_date
     */
    public function setStartDate(?string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * Returns End Date.
     * The date that the promotion ends, in `YYYY-MM-DD` format. Square populates this field
     * based on the provided `time_periods`. If an end date is not specified, an `ACTIVE` promotion
     * remains available until it is canceled.
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * Sets End Date.
     * The date that the promotion ends, in `YYYY-MM-DD` format. Square populates this field
     * based on the provided `time_periods`. If an end date is not specified, an `ACTIVE` promotion
     * remains available until it is canceled.
     *
     * @maps end_date
     */
    public function setEndDate(?string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * Returns Time Periods.
     * A list of [iCalendar (RFC 5545) events](https://tools.ietf.org/html/rfc5545#section-3.6.1)
     * (`VEVENT`). Each event represents an available time period per day or days of the week.
     * A day can have a maximum of one available time period.
     *
     * Only `DTSTART`, `DURATION`, and `RRULE` are supported. `DTSTART` and `DURATION` are required and
     * timestamps must be in local (unzoned) time format. Include `RRULE` to specify recurring promotions,
     * an end date (using the `UNTIL` keyword), or both. For more information, see
     * [Available time](https://developer.squareup.com/docs/loyalty-api/loyalty-promotions#available-time).
     *
     * Note that `BEGIN:VEVENT` and `END:VEVENT` are optional in a `CreateLoyaltyPromotion` request
     * but are always included in the response.
     *
     * @return string[]
     */
    public function getTimePeriods(): array
    {
        return $this->timePeriods;
    }

    /**
     * Sets Time Periods.
     * A list of [iCalendar (RFC 5545) events](https://tools.ietf.org/html/rfc5545#section-3.6.1)
     * (`VEVENT`). Each event represents an available time period per day or days of the week.
     * A day can have a maximum of one available time period.
     *
     * Only `DTSTART`, `DURATION`, and `RRULE` are supported. `DTSTART` and `DURATION` are required and
     * timestamps must be in local (unzoned) time format. Include `RRULE` to specify recurring promotions,
     * an end date (using the `UNTIL` keyword), or both. For more information, see
     * [Available time](https://developer.squareup.com/docs/loyalty-api/loyalty-promotions#available-time).
     *
     * Note that `BEGIN:VEVENT` and `END:VEVENT` are optional in a `CreateLoyaltyPromotion` request
     * but are always included in the response.
     *
     * @required
     * @maps time_periods
     *
     * @param string[] $timePeriods
     */
    public function setTimePeriods(array $timePeriods): void
    {
        $this->timePeriods = $timePeriods;
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
        if (isset($this->startDate)) {
            $json['start_date'] = $this->startDate;
        }
        if (isset($this->endDate)) {
            $json['end_date']   = $this->endDate;
        }
        $json['time_periods']   = $this->timePeriods;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
