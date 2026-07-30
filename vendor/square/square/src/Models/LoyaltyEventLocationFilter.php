<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter events by location.
 */
class LoyaltyEventLocationFilter implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $locationIds;

    /**
     * @param string[] $locationIds
     */
    public function __construct(array $locationIds)
    {
        $this->locationIds = $locationIds;
    }

    /**
     * Returns Location Ids.
     * The [location](entity:Location) IDs for loyalty events to query.
     * If multiple values are specified, the endpoint uses
     * a logical OR to combine them.
     *
     * @return string[]
     */
    public function getLocationIds(): array
    {
        return $this->locationIds;
    }

    /**
     * Sets Location Ids.
     * The [location](entity:Location) IDs for loyalty events to query.
     * If multiple values are specified, the endpoint uses
     * a logical OR to combine them.
     *
     * @required
     * @maps location_ids
     *
     * @param string[] $locationIds
     */
    public function setLocationIds(array $locationIds): void
    {
        $this->locationIds = $locationIds;
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
        $json['location_ids'] = $this->locationIds;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
