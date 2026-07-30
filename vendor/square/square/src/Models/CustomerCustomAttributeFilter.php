<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The custom attribute filter. Use this filter in a set of [custom attribute
 * filters]($m/CustomerCustomAttributeFilters) to search
 * based on the value or last updated date of a customer-related [custom attribute]($m/CustomAttribute).
 */
class CustomerCustomAttributeFilter implements \JsonSerializable
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var CustomerCustomAttributeFilterValue|null
     */
    private $filter;

    /**
     * @var TimeRange|null
     */
    private $updatedAt;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Returns Key.
     * The `key` of the [custom attribute](entity:CustomAttribute) to filter by. The key is the identifier
     * of the custom attribute
     * (and the corresponding custom attribute definition) and can be retrieved using the [Customer Custom
     * Attributes API](api:CustomerCustomAttributes).
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Sets Key.
     * The `key` of the [custom attribute](entity:CustomAttribute) to filter by. The key is the identifier
     * of the custom attribute
     * (and the corresponding custom attribute definition) and can be retrieved using the [Customer Custom
     * Attributes API](api:CustomerCustomAttributes).
     *
     * @required
     * @maps key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * Returns Filter.
     * A type-specific filter used in a [custom attribute filter]($m/CustomerCustomAttributeFilter) to
     * search based on the value
     * of a customer-related [custom attribute]($m/CustomAttribute).
     */
    public function getFilter(): ?CustomerCustomAttributeFilterValue
    {
        return $this->filter;
    }

    /**
     * Sets Filter.
     * A type-specific filter used in a [custom attribute filter]($m/CustomerCustomAttributeFilter) to
     * search based on the value
     * of a customer-related [custom attribute]($m/CustomAttribute).
     *
     * @maps filter
     */
    public function setFilter(?CustomerCustomAttributeFilterValue $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * Returns Updated At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getUpdatedAt(): ?TimeRange
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?TimeRange $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
        $json['key']            = $this->key;
        if (isset($this->filter)) {
            $json['filter']     = $this->filter;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at'] = $this->updatedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
