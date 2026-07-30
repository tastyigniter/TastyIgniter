<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the request parameters for the `ListDisputes` endpoint.
 */
class ListDisputesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $states = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getCursor(): ?string
    {
        if (count($this->cursor) == 0) {
            return null;
        }
        return $this->cursor['value'];
    }

    /**
     * Sets Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns States.
     * The dispute states used to filter the result. If not specified, the endpoint returns all disputes.
     * See [DisputeState](#type-disputestate) for possible values
     *
     * @return string[]|null
     */
    public function getStates(): ?array
    {
        if (count($this->states) == 0) {
            return null;
        }
        return $this->states['value'];
    }

    /**
     * Sets States.
     * The dispute states used to filter the result. If not specified, the endpoint returns all disputes.
     * See [DisputeState](#type-disputestate) for possible values
     *
     * @maps states
     *
     * @param string[]|null $states
     */
    public function setStates(?array $states): void
    {
        $this->states['value'] = $states;
    }

    /**
     * Unsets States.
     * The dispute states used to filter the result. If not specified, the endpoint returns all disputes.
     * See [DisputeState](#type-disputestate) for possible values
     */
    public function unsetStates(): void
    {
        $this->states = [];
    }

    /**
     * Returns Location Id.
     * The ID of the location for which to return a list of disputes.
     * If not specified, the endpoint returns disputes associated with all locations.
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
     * The ID of the location for which to return a list of disputes.
     * If not specified, the endpoint returns disputes associated with all locations.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the location for which to return a list of disputes.
     * If not specified, the endpoint returns disputes associated with all locations.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
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
        if (!empty($this->cursor)) {
            $json['cursor']      = $this->cursor['value'];
        }
        if (!empty($this->states)) {
            $json['states']      = $this->states['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id'] = $this->locationId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
