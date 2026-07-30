<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListCashDrawerShiftEventsRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $locationId;

    /**
     * @var array
     */
    private $limit = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @param string $locationId
     */
    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Location Id.
     * The ID of the location to list cash drawer shifts for.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the location to list cash drawer shifts for.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Limit.
     * Number of resources to be returned in a page of results (200 by
     * default, 1000 max).
     */
    public function getLimit(): ?int
    {
        if (count($this->limit) == 0) {
            return null;
        }
        return $this->limit['value'];
    }

    /**
     * Sets Limit.
     * Number of resources to be returned in a page of results (200 by
     * default, 1000 max).
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * Number of resources to be returned in a page of results (200 by
     * default, 1000 max).
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Cursor.
     * Opaque cursor for fetching the next page of results.
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
     * Opaque cursor for fetching the next page of results.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * Opaque cursor for fetching the next page of results.
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
        $json['location_id'] = $this->locationId;
        if (!empty($this->limit)) {
            $json['limit']   = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']  = $this->cursor['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
