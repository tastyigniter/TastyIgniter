<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RetrieveCashDrawerShiftRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $locationId;

    /**
     * @param string $locationId
     */
    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Location Id.
     * The ID of the location to retrieve cash drawer shifts from.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the location to retrieve cash drawer shifts from.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
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
        $json['location_id'] = $this->locationId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
