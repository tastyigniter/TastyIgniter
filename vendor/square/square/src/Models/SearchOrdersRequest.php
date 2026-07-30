<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The request does not have any required fields. When given no query criteria,
 * `SearchOrders` returns all results for all of the seller's locations. When retrieving additional
 * pages using a `cursor`, the `query` must be equal to the `query` used to retrieve the first page of
 * results.
 */
class SearchOrdersRequest implements \JsonSerializable
{
    /**
     * @var string[]|null
     */
    private $locationIds;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var SearchOrdersQuery|null
     */
    private $query;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var bool|null
     */
    private $returnEntries;

    /**
     * Returns Location Ids.
     * The location IDs for the orders to query. All locations must belong to
     * the same merchant.
     *
     * Min: 1 location ID.
     *
     * Max: 10 location IDs.
     *
     * @return string[]|null
     */
    public function getLocationIds(): ?array
    {
        return $this->locationIds;
    }

    /**
     * Sets Location Ids.
     * The location IDs for the orders to query. All locations must belong to
     * the same merchant.
     *
     * Min: 1 location ID.
     *
     * Max: 10 location IDs.
     *
     * @maps location_ids
     *
     * @param string[]|null $locationIds
     */
    public function setLocationIds(?array $locationIds): void
    {
        $this->locationIds = $locationIds;
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this cursor to retrieve the next set of results for your original query.
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
     * Provide this cursor to retrieve the next set of results for your original query.
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
     * Returns Query.
     * Contains query criteria for the search.
     */
    public function getQuery(): ?SearchOrdersQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * Contains query criteria for the search.
     *
     * @maps query
     */
    public function setQuery(?SearchOrdersQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     * The maximum number of results to be returned in a single page. It is
     * possible to receive fewer results than the specified limit on a given page.
     *
     * Default: `500`
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The maximum number of results to be returned in a single page. It is
     * possible to receive fewer results than the specified limit on a given page.
     *
     * Default: `500`
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Return Entries.
     * A Boolean that controls the format of the search results. If `true`,
     * `SearchOrders` returns [OrderEntry](entity:OrderEntry) objects. If `false`, `SearchOrders`
     * returns complete order objects.
     *
     * Default: `false`.
     */
    public function getReturnEntries(): ?bool
    {
        return $this->returnEntries;
    }

    /**
     * Sets Return Entries.
     * A Boolean that controls the format of the search results. If `true`,
     * `SearchOrders` returns [OrderEntry](entity:OrderEntry) objects. If `false`, `SearchOrders`
     * returns complete order objects.
     *
     * Default: `false`.
     *
     * @maps return_entries
     */
    public function setReturnEntries(?bool $returnEntries): void
    {
        $this->returnEntries = $returnEntries;
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
        if (isset($this->locationIds)) {
            $json['location_ids']   = $this->locationIds;
        }
        if (isset($this->cursor)) {
            $json['cursor']         = $this->cursor;
        }
        if (isset($this->query)) {
            $json['query']          = $this->query;
        }
        if (isset($this->limit)) {
            $json['limit']          = $this->limit;
        }
        if (isset($this->returnEntries)) {
            $json['return_entries'] = $this->returnEntries;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
