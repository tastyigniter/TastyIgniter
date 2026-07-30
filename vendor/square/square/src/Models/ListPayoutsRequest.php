<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to retrieve payout records.
 */
class ListPayoutsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var array
     */
    private $beginTime = [];

    /**
     * @var array
     */
    private $endTime = [];

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * Returns Location Id.
     * The ID of the location for which to list the payouts.
     * By default, payouts are returned for the default (main) location associated with the seller.
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
     * The ID of the location for which to list the payouts.
     * By default, payouts are returned for the default (main) location associated with the seller.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the location for which to list the payouts.
     * By default, payouts are returned for the default (main) location associated with the seller.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Status.
     * Payout status types
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Payout status types
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Begin Time.
     * The timestamp for the beginning of the payout creation time, in RFC 3339 format.
     * Inclusive. Default: The current time minus one year.
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
     * The timestamp for the beginning of the payout creation time, in RFC 3339 format.
     * Inclusive. Default: The current time minus one year.
     *
     * @maps begin_time
     */
    public function setBeginTime(?string $beginTime): void
    {
        $this->beginTime['value'] = $beginTime;
    }

    /**
     * Unsets Begin Time.
     * The timestamp for the beginning of the payout creation time, in RFC 3339 format.
     * Inclusive. Default: The current time minus one year.
     */
    public function unsetBeginTime(): void
    {
        $this->beginTime = [];
    }

    /**
     * Returns End Time.
     * The timestamp for the end of the payout creation time, in RFC 3339 format.
     * Default: The current time.
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
     * The timestamp for the end of the payout creation time, in RFC 3339 format.
     * Default: The current time.
     *
     * @maps end_time
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime['value'] = $endTime;
    }

    /**
     * Unsets End Time.
     * The timestamp for the end of the payout creation time, in RFC 3339 format.
     * Default: The current time.
     */
    public function unsetEndTime(): void
    {
        $this->endTime = [];
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
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     * If request parameters change between requests, subsequent results may contain duplicates or missing
     * records.
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
     * If request parameters change between requests, subsequent results may contain duplicates or missing
     * records.
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
     * If request parameters change between requests, subsequent results may contain duplicates or missing
     * records.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Limit.
     * The maximum number of results to be returned in a single page.
     * It is possible to receive fewer results than the specified limit on a given page.
     * The default value of 100 is also the maximum allowed value. If the provided value is
     * greater than 100, it is ignored and the default value is used instead.
     * Default: `100`
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
     * The maximum number of results to be returned in a single page.
     * It is possible to receive fewer results than the specified limit on a given page.
     * The default value of 100 is also the maximum allowed value. If the provided value is
     * greater than 100, it is ignored and the default value is used instead.
     * Default: `100`
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of results to be returned in a single page.
     * It is possible to receive fewer results than the specified limit on a given page.
     * The default value of 100 is also the maximum allowed value. If the provided value is
     * greater than 100, it is ignored and the default value is used instead.
     * Default: `100`
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
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
        if (!empty($this->locationId)) {
            $json['location_id'] = $this->locationId['value'];
        }
        if (isset($this->status)) {
            $json['status']      = $this->status;
        }
        if (!empty($this->beginTime)) {
            $json['begin_time']  = $this->beginTime['value'];
        }
        if (!empty($this->endTime)) {
            $json['end_time']    = $this->endTime['value'];
        }
        if (isset($this->sortOrder)) {
            $json['sort_order']  = $this->sortOrder;
        }
        if (!empty($this->cursor)) {
            $json['cursor']      = $this->cursor['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']       = $this->limit['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
