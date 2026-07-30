<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request for a filtered and sorted set of `Shift` objects.
 */
class SearchShiftsRequest implements \JsonSerializable
{
    /**
     * @var ShiftQuery|null
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
     * The parameters of a `Shift` search query, which includes filter and sort options.
     */
    public function getQuery(): ?ShiftQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     * The parameters of a `Shift` search query, which includes filter and sort options.
     *
     * @maps query
     */
    public function setQuery(?ShiftQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     * The number of resources in a page (200 by default).
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     * The number of resources in a page (200 by default).
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Cursor.
     * An opaque cursor for fetching the next page.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * An opaque cursor for fetching the next page.
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
