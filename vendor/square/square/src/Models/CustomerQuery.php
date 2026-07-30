<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents filtering and sorting criteria for a [SearchCustomers]($e/Customers/SearchCustomers)
 * request.
 */
class CustomerQuery implements \JsonSerializable
{
    /**
     * @var CustomerFilter|null
     */
    private $filter;

    /**
     * @var CustomerSort|null
     */
    private $sort;

    /**
     * Returns Filter.
     * Represents the filtering criteria in a [search query]($m/CustomerQuery) that defines how to filter
     * customer profiles returned in [SearchCustomers]($e/Customers/SearchCustomers) results.
     */
    public function getFilter(): ?CustomerFilter
    {
        return $this->filter;
    }

    /**
     * Sets Filter.
     * Represents the filtering criteria in a [search query]($m/CustomerQuery) that defines how to filter
     * customer profiles returned in [SearchCustomers]($e/Customers/SearchCustomers) results.
     *
     * @maps filter
     */
    public function setFilter(?CustomerFilter $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * Returns Sort.
     * Represents the sorting criteria in a [search query]($m/CustomerQuery) that defines how to sort
     * customer profiles returned in [SearchCustomers]($e/Customers/SearchCustomers) results.
     */
    public function getSort(): ?CustomerSort
    {
        return $this->sort;
    }

    /**
     * Sets Sort.
     * Represents the sorting criteria in a [search query]($m/CustomerQuery) that defines how to sort
     * customer profiles returned in [SearchCustomers]($e/Customers/SearchCustomers) results.
     *
     * @maps sort
     */
    public function setSort(?CustomerSort $sort): void
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
