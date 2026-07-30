<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a search request for a filtered list of `TeamMember` objects.
 */
class SearchTeamMembersRequest implements \JsonSerializable
{
    /**
     * @var SearchTeamMembersQuery|null
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
     * Represents the parameters in a search for `TeamMember` objects.
     */
    public function getQuery(): ?SearchTeamMembersQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * Represents the parameters in a search for `TeamMember` objects.
     *
     * @maps query
     */
    public function setQuery(?SearchTeamMembersQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     * The maximum number of `TeamMember` objects in a page (100 by default).
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The maximum number of `TeamMember` objects in a page (100 by default).
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Cursor.
     * The opaque cursor for fetching the next page. For more information, see
     * [pagination](https://developer.squareup.com/docs/working-with-apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The opaque cursor for fetching the next page. For more information, see
     * [pagination](https://developer.squareup.com/docs/working-with-apis/pagination).
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
