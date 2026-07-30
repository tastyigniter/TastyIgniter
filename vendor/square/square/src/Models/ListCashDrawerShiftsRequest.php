<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListCashDrawerShiftsRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $locationId;

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * @var array
     */
    private $beginTime = [];

    /**
     * @var array
     */
    private $endTime = [];

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
     * The ID of the location to query for a list of cash drawer shifts.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the location to query for a list of cash drawer shifts.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Sort Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     */
    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    /**
     * Sets Sort Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     *
     * @maps sort_order
     */
    public function setSortOrder(?string $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * Returns Begin Time.
     * The inclusive start time of the query on opened_at, in ISO 8601 format.
     */
    public function getBeginTime(): ?string
    {
        if (count($this->beginTime) == 0) {
            return null;
        }
        return $this->beginTime['value'];
    }

    /**
     * Sets Begin Time.
     * The inclusive start time of the query on opened_at, in ISO 8601 format.
     *
     * @maps begin_time
     */
    public function setBeginTime(?string $beginTime): void
    {
        $this->beginTime['value'] = $beginTime;
    }

    /**
     * Unsets Begin Time.
     * The inclusive start time of the query on opened_at, in ISO 8601 format.
     */
    public function unsetBeginTime(): void
    {
        $this->beginTime = [];
    }

    /**
     * Returns End Time.
     * The exclusive end date of the query on opened_at, in ISO 8601 format.
     */
    public function getEndTime(): ?string
    {
        if (count($this->endTime) == 0) {
            return null;
        }
        return $this->endTime['value'];
    }

    /**
     * Sets End Time.
     * The exclusive end date of the query on opened_at, in ISO 8601 format.
     *
     * @maps end_time
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime['value'] = $endTime;
    }

    /**
     * Unsets End Time.
     * The exclusive end date of the query on opened_at, in ISO 8601 format.
     */
    public function unsetEndTime(): void
    {
        $this->endTime = [];
    }

    /**
     * Returns Limit.
     * Number of cash drawer shift events in a page of results (200 by
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
     * Number of cash drawer shift events in a page of results (200 by
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
     * Number of cash drawer shift events in a page of results (200 by
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
        $json['location_id']    = $this->locationId;
        if (isset($this->sortOrder)) {
            $json['sort_order'] = $this->sortOrder;
        }
        if (!empty($this->beginTime)) {
            $json['begin_time'] = $this->beginTime['value'];
        }
        if (!empty($this->endTime)) {
            $json['end_time']   = $this->endTime['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']      = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']     = $this->cursor['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
