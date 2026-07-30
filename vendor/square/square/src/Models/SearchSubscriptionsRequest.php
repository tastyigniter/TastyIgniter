<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a request to the
 * [SearchSubscriptions]($e/Subscriptions/SearchSubscriptions) endpoint.
 */
class SearchSubscriptionsRequest implements \JsonSerializable
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
     * @var SearchSubscriptionsQuery|null
     */
    private $query;

    /**
     * @var string[]|null
     */
    private $include;

    /**
     * Returns Cursor.
     * When the total number of resulting subscriptions exceeds the limit of a paged response,
     * specify the cursor returned from a preceding response here to fetch the next set of results.
     * If the cursor is unset, the response contains the last page of the results.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * When the total number of resulting subscriptions exceeds the limit of a paged response,
     * specify the cursor returned from a preceding response here to fetch the next set of results.
     * If the cursor is unset, the response contains the last page of the results.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Limit.
     * The upper limit on the number of subscriptions to return
     * in a paged response.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The upper limit on the number of subscriptions to return
     * in a paged response.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Query.
     * Represents a query, consisting of specified query expressions, used to search for subscriptions.
     */
    public function getQuery(): ?SearchSubscriptionsQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * Represents a query, consisting of specified query expressions, used to search for subscriptions.
     *
     * @maps query
     */
    public function setQuery(?SearchSubscriptionsQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Include.
     * An option to include related information in the response.
     *
     * The supported values are:
     *
     * - `actions`: to include scheduled actions on the targeted subscriptions.
     *
     * @return string[]|null
     */
    public function getInclude(): ?array
    {
        return $this->include;
    }

    /**
     * Sets Include.
     * An option to include related information in the response.
     *
     * The supported values are:
     *
     * - `actions`: to include scheduled actions on the targeted subscriptions.
     *
     * @maps include
     *
     * @param string[]|null $include
     */
    public function setInclude(?array $include): void
    {
        $this->include = $include;
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
            $json['cursor']  = $this->cursor;
        }
        if (isset($this->limit)) {
            $json['limit']   = $this->limit;
        }
        if (isset($this->query)) {
            $json['query']   = $this->query;
        }
        if (isset($this->include)) {
            $json['include'] = $this->include;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
