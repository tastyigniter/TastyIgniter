<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RetrieveInventoryChangesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $locationIds = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * Returns Location Ids.
     * The [Location](entity:Location) IDs to look up as a comma-separated
     * list. An empty list queries all locations.
     */
    public function getLocationIds(): ?string
    {
        if (count($this->locationIds) == 0) {
            return null;
        }
        return $this->locationIds['value'];
    }

    /**
     * Sets Location Ids.
     * The [Location](entity:Location) IDs to look up as a comma-separated
     * list. An empty list queries all locations.
     *
     * @maps location_ids
     */
    public function setLocationIds(?string $locationIds): void
    {
        $this->locationIds['value'] = $locationIds;
    }

    /**
     * Unsets Location Ids.
     * The [Location](entity:Location) IDs to look up as a comma-separated
     * list. An empty list queries all locations.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for the original query.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
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
     * Provide this to retrieve the next set of results for the original query.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
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
     * Provide this to retrieve the next set of results for the original query.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
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
        if (!empty($this->locationIds)) {
            $json['location_ids'] = $this->locationIds['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']       = $this->cursor['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
