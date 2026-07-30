<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListPayoutEntriesRequest implements \JsonSerializable
{
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
        if (isset($this->sortOrder)) {
            $json['sort_order'] = $this->sortOrder;
        }
        if (!empty($this->cursor)) {
            $json['cursor']     = $this->cursor['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']      = $this->limit['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
