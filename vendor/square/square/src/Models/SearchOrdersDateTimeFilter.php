<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter for `Order` objects based on whether their `CREATED_AT`,
 * `CLOSED_AT`, or `UPDATED_AT` timestamps fall within a specified time range.
 * You can specify the time range and which timestamp to filter for. You can filter
 * for only one time range at a time.
 *
 * For each time range, the start time and end time are inclusive. If the end time
 * is absent, it defaults to the time of the first request for the cursor.
 *
 * __Important:__ If you use the `DateTimeFilter` in a `SearchOrders` query,
 * you must set the `sort_field` in [OrdersSort]($m/SearchOrdersSort)
 * to the same field you filter for. For example, if you set the `CLOSED_AT` field
 * in `DateTimeFilter`, you must set the `sort_field` in `SearchOrdersSort` to
 * `CLOSED_AT`. Otherwise, `SearchOrders` throws an error.
 * [Learn more about filtering orders by time range.](https://developer.squareup.com/docs/orders-
 * api/manage-orders/search-orders#important-note-about-filtering-orders-by-time-range)
 */
class SearchOrdersDateTimeFilter implements \JsonSerializable
{
    /**
     * @var TimeRange|null
     */
    private $createdAt;

    /**
     * @var TimeRange|null
     */
    private $updatedAt;

    /**
     * @var TimeRange|null
     */
    private $closedAt;

    /**
     * Returns Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getCreatedAt(): ?TimeRange
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps created_at
     */
    public function setCreatedAt(?TimeRange $createdAt): void
    {
        $this->createdAt = $createdAt;
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
     * Returns Closed At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getClosedAt(): ?TimeRange
    {
        return $this->closedAt;
    }

    /**
     * Sets Closed At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps closed_at
     */
    public function setClosedAt(?TimeRange $closedAt): void
    {
        $this->closedAt = $closedAt;
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
        if (isset($this->createdAt)) {
            $json['created_at'] = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at'] = $this->updatedAt;
        }
        if (isset($this->closedAt)) {
            $json['closed_at']  = $this->closedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
