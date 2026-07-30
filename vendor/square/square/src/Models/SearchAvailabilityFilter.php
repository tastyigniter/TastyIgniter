<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A query filter to search for buyer-accessible availabilities by.
 */
class SearchAvailabilityFilter implements \JsonSerializable
{
    /**
     * @var TimeRange
     */
    private $startAtRange;

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $segmentFilters = [];

    /**
     * @var array
     */
    private $bookingId = [];

    /**
     * @param TimeRange $startAtRange
     */
    public function __construct(TimeRange $startAtRange)
    {
        $this->startAtRange = $startAtRange;
    }

    /**
     * Returns Start at Range.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getStartAtRange(): TimeRange
    {
        return $this->startAtRange;
    }

    /**
     * Sets Start at Range.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @required
     * @maps start_at_range
     */
    public function setStartAtRange(TimeRange $startAtRange): void
    {
        $this->startAtRange = $startAtRange;
    }

    /**
     * Returns Location Id.
     * The query expression to search for buyer-accessible availabilities with their location IDs matching
     * the specified location ID.
     * This query expression cannot be set if `booking_id` is set.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The query expression to search for buyer-accessible availabilities with their location IDs matching
     * the specified location ID.
     * This query expression cannot be set if `booking_id` is set.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The query expression to search for buyer-accessible availabilities with their location IDs matching
     * the specified location ID.
     * This query expression cannot be set if `booking_id` is set.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Segment Filters.
     * The query expression to search for buyer-accessible availabilities matching the specified list of
     * segment filters.
     * If the size of the `segment_filters` list is `n`, the search returns availabilities with `n`
     * segments per availability.
     *
     * This query expression cannot be set if `booking_id` is set.
     *
     * @return SegmentFilter[]|null
     */
    public function getSegmentFilters(): ?array
    {
        if (count($this->segmentFilters) == 0) {
            return null;
        }
        return $this->segmentFilters['value'];
    }

    /**
     * Sets Segment Filters.
     * The query expression to search for buyer-accessible availabilities matching the specified list of
     * segment filters.
     * If the size of the `segment_filters` list is `n`, the search returns availabilities with `n`
     * segments per availability.
     *
     * This query expression cannot be set if `booking_id` is set.
     *
     * @maps segment_filters
     *
     * @param SegmentFilter[]|null $segmentFilters
     */
    public function setSegmentFilters(?array $segmentFilters): void
    {
        $this->segmentFilters['value'] = $segmentFilters;
    }

    /**
     * Unsets Segment Filters.
     * The query expression to search for buyer-accessible availabilities matching the specified list of
     * segment filters.
     * If the size of the `segment_filters` list is `n`, the search returns availabilities with `n`
     * segments per availability.
     *
     * This query expression cannot be set if `booking_id` is set.
     */
    public function unsetSegmentFilters(): void
    {
        $this->segmentFilters = [];
    }

    /**
     * Returns Booking Id.
     * The query expression to search for buyer-accessible availabilities for an existing booking by
     * matching the specified `booking_id` value.
     * This is commonly used to reschedule an appointment.
     * If this expression is set, the `location_id` and `segment_filters` expressions cannot be set.
     */
    public function getBookingId(): ?string
    {
        if (count($this->bookingId) == 0) {
            return null;
        }
        return $this->bookingId['value'];
    }

    /**
     * Sets Booking Id.
     * The query expression to search for buyer-accessible availabilities for an existing booking by
     * matching the specified `booking_id` value.
     * This is commonly used to reschedule an appointment.
     * If this expression is set, the `location_id` and `segment_filters` expressions cannot be set.
     *
     * @maps booking_id
     */
    public function setBookingId(?string $bookingId): void
    {
        $this->bookingId['value'] = $bookingId;
    }

    /**
     * Unsets Booking Id.
     * The query expression to search for buyer-accessible availabilities for an existing booking by
     * matching the specified `booking_id` value.
     * This is commonly used to reschedule an appointment.
     * If this expression is set, the `location_id` and `segment_filters` expressions cannot be set.
     */
    public function unsetBookingId(): void
    {
        $this->bookingId = [];
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
        $json['start_at_range']      = $this->startAtRange;
        if (!empty($this->locationId)) {
            $json['location_id']     = $this->locationId['value'];
        }
        if (!empty($this->segmentFilters)) {
            $json['segment_filters'] = $this->segmentFilters['value'];
        }
        if (!empty($this->bookingId)) {
            $json['booking_id']      = $this->bookingId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
