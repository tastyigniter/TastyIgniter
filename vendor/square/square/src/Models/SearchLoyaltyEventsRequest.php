<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to search for loyalty events.
 */
class SearchLoyaltyEventsRequest implements \JsonSerializable
{
    /**
     * @var LoyaltyEventQuery|null
     */
    private $query;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Query.
     * Represents a query used to search for loyalty events.
     */
    public function getQuery(): ?LoyaltyEventQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * Represents a query used to search for loyalty events.
     *
     * @maps query
     */
    public function setQuery(?LoyaltyEventQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     * The maximum number of results to include in the response.
     * The last page might contain fewer events.
     * The default is 30 events.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The maximum number of results to include in the response.
     * The last page might contain fewer events.
     * The default is 30 events.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
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
        if (isset($this->query)) {
            $json['query']  = $this->query;
        }
        if (isset($this->limit)) {
            $json['limit']  = $this->limit;
        }
        if (isset($this->cursor)) {
            $json['cursor'] = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
