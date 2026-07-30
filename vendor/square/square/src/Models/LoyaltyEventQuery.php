<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a query used to search for loyalty events.
 */
class LoyaltyEventQuery implements \JsonSerializable
{
    /**
     * @var LoyaltyEventFilter|null
     */
    private $filter;

    /**
     * Returns Filter.
     * The filtering criteria. If the request specifies multiple filters,
     * the endpoint uses a logical AND to evaluate them.
     */
    public function getFilter(): ?LoyaltyEventFilter
    {
        return $this->filter;
    }

    /**
     * Sets Filter.
     * The filtering criteria. If the request specifies multiple filters,
     * the endpoint uses a logical AND to evaluate them.
     *
     * @maps filter
     */
    public function setFilter(?LoyaltyEventFilter $filter): void
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
