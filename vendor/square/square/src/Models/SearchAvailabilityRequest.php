<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class SearchAvailabilityRequest implements \JsonSerializable
{
    /**
     * @var SearchAvailabilityQuery
     */
    private $query;

    /**
     * @param SearchAvailabilityQuery $query
     */
    public function __construct(SearchAvailabilityQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Returns Query.
     * The query used to search for buyer-accessible availabilities of bookings.
     */
    public function getQuery(): SearchAvailabilityQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * The query used to search for buyer-accessible availabilities of bookings.
     *
     * @required
     * @maps query
     */
    public function setQuery(SearchAvailabilityQuery $query): void
    {
        $this->query = $query;
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
        $json['query'] = $this->query;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
