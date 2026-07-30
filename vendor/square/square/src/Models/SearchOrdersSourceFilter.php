<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A filter based on order `source` information.
 */
class SearchOrdersSourceFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $sourceNames = [];

    /**
     * Returns Source Names.
     * Filters by the [Source](entity:OrderSource) `name`. The filter returns any orders
     * with a `source.name` that matches any of the listed source names.
     *
     * Max: 10 source names.
     *
     * @return string[]|null
     */
    public function getSourceNames(): ?array
    {
        if (count($this->sourceNames) == 0) {
            return null;
        }
        return $this->sourceNames['value'];
    }

    /**
     * Sets Source Names.
     * Filters by the [Source](entity:OrderSource) `name`. The filter returns any orders
     * with a `source.name` that matches any of the listed source names.
     *
     * Max: 10 source names.
     *
     * @maps source_names
     *
     * @param string[]|null $sourceNames
     */
    public function setSourceNames(?array $sourceNames): void
    {
        $this->sourceNames['value'] = $sourceNames;
    }

    /**
     * Unsets Source Names.
     * Filters by the [Source](entity:OrderSource) `name`. The filter returns any orders
     * with a `source.name` that matches any of the listed source names.
     *
     * Max: 10 source names.
     */
    public function unsetSourceNames(): void
    {
        $this->sourceNames = [];
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
        if (!empty($this->sourceNames)) {
            $json['source_names'] = $this->sourceNames['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
