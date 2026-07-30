<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the body parameters that can be provided in a request to the
 * `CreateMobileAuthorizationCode` endpoint.
 */
class CreateMobileAuthorizationCodeRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $locationId;

    /**
     * Returns Location Id.
     * The Square location ID that the authorization code should be tied to.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The Square location ID that the authorization code should be tied to.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
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
        if (isset($this->locationId)) {
            $json['location_id'] = $this->locationId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
