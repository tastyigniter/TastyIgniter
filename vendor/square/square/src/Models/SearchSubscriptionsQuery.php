<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a query, consisting of specified query expressions, used to search for subscriptions.
 */
class SearchSubscriptionsQuery implements \JsonSerializable
{
    /**
     * @var SearchSubscriptionsFilter|null
     */
    private $filter;

    /**
     * Returns Filter.
     * Represents a set of query expressions (filters) to narrow the scope of targeted subscriptions
     * returned by
     * the [SearchSubscriptions]($e/Subscriptions/SearchSubscriptions) endpoint.
     */
    public function getFilter(): ?SearchSubscriptionsFilter
    {
        return $this->filter;
    }

    /**
     * Sets Filter.
     * Represents a set of query expressions (filters) to narrow the scope of targeted subscriptions
     * returned by
     * the [SearchSubscriptions]($e/Subscriptions/SearchSubscriptions) endpoint.
     *
     * @maps filter
     */
    public function setFilter(?SearchSubscriptionsFilter $filter): void
    {
        $this->filter = $filter;
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
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
