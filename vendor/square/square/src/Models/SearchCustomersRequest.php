<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the request body of a request to the
 * `SearchCustomers` endpoint.
 */
class SearchCustomersRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var CustomerQuery|null
     */
    private $query;

    /**
     * Returns Cursor.
     * Include the pagination cursor in subsequent calls to this endpoint to retrieve
     * the next set of results associated with the original query.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * Include the pagination cursor in subsequent calls to this endpoint to retrieve
     * the next set of results associated with the original query.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Limit.
     * The maximum number of results to return in a single page. This limit is advisory. The response might
     * contain more or fewer results.
     * If the specified limit is invalid, Square returns a `400 VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH`
     * error. The default value is 100.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The maximum number of results to return in a single page. This limit is advisory. The response might
     * contain more or fewer results.
     * If the specified limit is invalid, Square returns a `400 VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH`
     * error. The default value is 100.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Query.
     * Represents filtering and sorting criteria for a [SearchCustomers]($e/Customers/SearchCustomers)
     * request.
     */
    public function getQuery(): ?CustomerQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * Represents filtering and sorting criteria for a [SearchCustomers]($e/Customers/SearchCustomers)
     * request.
     *
     * @maps query
     */
    public function setQuery(?CustomerQuery $query): void
    {
        $this->query = $query;
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
        if (isset($this->cursor)) {
            $json['cursor'] = $this->cursor;
        }
        if (isset($this->limit)) {
            $json['limit']  = $this->limit;
        }
        if (isset($this->query)) {
            $json['query']  = $this->query;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
