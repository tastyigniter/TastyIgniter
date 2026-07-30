<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The custom attribute filters in a set of [customer filters]($m/CustomerFilter) used in a search
 * query. Use this filter
 * to search based on [custom attributes]($m/CustomAttribute) that are assigned to customer profiles.
 * For more information, see
 * [Search by custom attribute](https://developer.squareup.com/docs/customers-api/use-the-api/search-
 * customers#search-by-custom-attribute).
 */
class CustomerCustomAttributeFilters implements \JsonSerializable
{
    /**
     * @var array
     */
    private $filters = [];

    /**
     * Returns Filters.
     * The custom attribute filters. Each filter must specify `key` and include the `filter` field with a
     * type-specific filter,
     * the `updated_at` field, or both. The provided keys must be unique within the list of custom
     * attribute filters.
     *
     * @return CustomerCustomAttributeFilter[]|null
     */
    public function getFilters(): ?array
    {
        if (count($this->filters) == 0) {
            return null;
        }
        return $this->filters['value'];
    }

    /**
     * Sets Filters.
     * The custom attribute filters. Each filter must specify `key` and include the `filter` field with a
     * type-specific filter,
     * the `updated_at` field, or both. The provided keys must be unique within the list of custom
     * attribute filters.
     *
     * @maps filters
     *
     * @param CustomerCustomAttributeFilter[]|null $filters
     */
    public function setFilters(?array $filters): void
    {
        $this->filters['value'] = $filters;
    }

    /**
     * Unsets Filters.
     * The custom attribute filters. Each filter must specify `key` and include the `filter` field with a
     * type-specific filter,
     * the `updated_at` field, or both. The provided keys must be unique within the list of custom
     * attribute filters.
     */
    public function unsetFilters(): void
    {
        $this->filters = [];
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
        if (!empty($this->filters)) {
            $json['filters'] = $this->filters['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
