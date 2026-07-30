<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Contains query criteria for the search.
 */
class SearchOrdersQuery implements \JsonSerializable
{
    /**
     * @var SearchOrdersFilter|null
     */
    private $filter;

    /**
     * @var SearchOrdersSort|null
     */
    private $sort;

    /**
     * Returns Filter.
     * Filtering criteria to use for a `SearchOrders` request. Multiple filters
     * are ANDed together.
     */
    public function getFilter(): ?SearchOrdersFilter
    {
        return $this->filter;
    }

    /**
     * Sets Filter.
     * Filtering criteria to use for a `SearchOrders` request. Multiple filters
     * are ANDed together.
     *
     * @maps filter
     */
    public function setFilter(?SearchOrdersFilter $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * Returns Sort.
     * Sorting criteria for a `SearchOrders` request. Results can only be sorted
     * by a timestamp field.
     */
    public function getSort(): ?SearchOrdersSort
    {
        return $this->sort;
    }

    /**
     * Sets Sort.
     * Sorting criteria for a `SearchOrders` request. Results can only be sorted
     * by a timestamp field.
     *
     * @maps sort
     */
    public function setSort(?SearchOrdersSort $sort): void
    {
        $this->sort = $sort;
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
        if (isset($this->filter)) {
            $json['filter'] = $this->filter;
        }
        if (isset($this->sort)) {
            $json['sort']   = $this->sort;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
