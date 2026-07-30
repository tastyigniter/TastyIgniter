<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to search for loyalty rewards.
 */
class SearchLoyaltyRewardsRequest implements \JsonSerializable
{
    /**
     * @var SearchLoyaltyRewardsRequestLoyaltyRewardQuery|null
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
     * The set of search requirements.
     */
    public function getQuery(): ?SearchLoyaltyRewardsRequestLoyaltyRewardQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * The set of search requirements.
     *
     * @maps query
     */
    public function setQuery(?SearchLoyaltyRewardsRequestLoyaltyRewardQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     * The maximum number of results to return in the response. The default value is 30.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The maximum number of results to return in the response. The default value is 30.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to
     * this endpoint. Provide this to retrieve the next set of
     * results for the original query.
     * For more information,
     * see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * A pagination cursor returned by a previous call to
     * this endpoint. Provide this to retrieve the next set of
     * results for the original query.
     * For more information,
     * see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).
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
