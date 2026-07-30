<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListPaymentLinksRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for the original query.
     * If a cursor is not provided, the endpoint returns the first page of the results.
     * For more  information, see [Pagination](https://developer.squareup.
     * com/docs/basics/api101/pagination).
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
     * If a cursor is not provided, the endpoint returns the first page of the results.
     * For more  information, see [Pagination](https://developer.squareup.
     * com/docs/basics/api101/pagination).
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
     * If a cursor is not provided, the endpoint returns the first page of the results.
     * For more  information, see [Pagination](https://developer.squareup.
     * com/docs/basics/api101/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Limit.
     * A limit on the number of results to return per page. The limit is advisory and
     * the implementation might return more or less results. If the supplied limit is negative, zero, or
     * greater than the maximum limit of 1000, it is ignored.
     *
     * Default value: `100`
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
     * A limit on the number of results to return per page. The limit is advisory and
     * the implementation might return more or less results. If the supplied limit is negative, zero, or
     * greater than the maximum limit of 1000, it is ignored.
     *
     * Default value: `100`
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * A limit on the number of results to return per page. The limit is advisory and
     * the implementation might return more or less results. If the supplied limit is negative, zero, or
     * greater than the maximum limit of 1000, it is ignored.
     *
     * Default value: `100`
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
        if (!empty($this->cursor)) {
            $json['cursor'] = $this->cursor['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']  = $this->limit['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
