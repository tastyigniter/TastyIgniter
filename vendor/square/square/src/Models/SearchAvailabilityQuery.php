<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query used to search for buyer-accessible availabilities of bookings.
 */
class SearchAvailabilityQuery implements \JsonSerializable
{
    /**
     * @var SearchAvailabilityFilter
     */
    private $filter;

    /**
     * @param SearchAvailabilityFilter $filter
     */
    public function __construct(SearchAvailabilityFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Returns Filter.
     * A query filter to search for buyer-accessible availabilities by.
     */
    public function getFilter(): SearchAvailabilityFilter
    {
        return $this->filter;
    }

    /**
     * Sets Filter.
     * A query filter to search for buyer-accessible availabilities by.
     *
     * @required
     * @maps filter
     */
    public function setFilter(SearchAvailabilityFilter $filter): void
    {
        $this->filter = $filter;
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
        $json['filter'] = $this->filter;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
