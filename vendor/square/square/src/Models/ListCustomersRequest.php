<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the query parameters that can be included in a request to the
 * `ListCustomers` endpoint.
 */
class ListCustomersRequest implements \JsonSerializable
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
     * @var string|null
     */
    private $sortField;

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for your original query.
     *
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
     * Provide this cursor to retrieve the next set of results for your original query.
     *
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
     * Provide this cursor to retrieve the next set of results for your original query.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Limit.
     * The maximum number of results to return in a single page. This limit is advisory. The response might
     * contain more or fewer results.
     * If the specified limit is less than 1 or greater than 100, Square returns a `400 VALUE_TOO_LOW` or
     * `400 VALUE_TOO_HIGH` error. The default value is 100.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
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
     * The maximum number of results to return in a single page. This limit is advisory. The response might
     * contain more or fewer results.
     * If the specified limit is less than 1 or greater than 100, Square returns a `400 VALUE_TOO_LOW` or
     * `400 VALUE_TOO_HIGH` error. The default value is 100.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of results to return in a single page. This limit is advisory. The response might
     * contain more or fewer results.
     * If the specified limit is less than 1 or greater than 100, Square returns a `400 VALUE_TOO_LOW` or
     * `400 VALUE_TOO_HIGH` error. The default value is 100.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Sort Field.
     * Specifies customer attributes as the sort key to customer profiles returned from a search.
     */
    public function getSortField(): ?string
    {
        return $this->sortField;
    }

    /**
     * Sets Sort Field.
     * Specifies customer attributes as the sort key to customer profiles returned from a search.
     *
     * @maps sort_field
     */
    public function setSortField(?string $sortField): void
    {
        $this->sortField = $sortField;
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
            $json['cursor']     = $this->cursor['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']      = $this->limit['value'];
        }
        if (isset($this->sortField)) {
            $json['sort_field'] = $this->sortField;
        }
        if (isset($this->sortOrder)) {
            $json['sort_order'] = $this->sortOrder;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
