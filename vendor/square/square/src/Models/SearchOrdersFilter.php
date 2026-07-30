<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filtering criteria to use for a `SearchOrders` request. Multiple filters
 * are ANDed together.
 */
class SearchOrdersFilter implements \JsonSerializable
{
    /**
     * @var SearchOrdersStateFilter|null
     */
    private $stateFilter;

    /**
     * @var SearchOrdersDateTimeFilter|null
     */
    private $dateTimeFilter;

    /**
     * @var SearchOrdersFulfillmentFilter|null
     */
    private $fulfillmentFilter;

    /**
     * @var SearchOrdersSourceFilter|null
     */
    private $sourceFilter;

    /**
     * @var SearchOrdersCustomerFilter|null
     */
    private $customerFilter;

    /**
     * Returns State Filter.
     * Filter by the current order `state`.
     */
    public function getStateFilter(): ?SearchOrdersStateFilter
    {
        return $this->stateFilter;
    }

    /**
     * Sets State Filter.
     * Filter by the current order `state`.
     *
     * @maps state_filter
     */
    public function setStateFilter(?SearchOrdersStateFilter $stateFilter): void
    {
        $this->stateFilter = $stateFilter;
    }

    /**
     * Returns Date Time Filter.
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
    public function getDateTimeFilter(): ?SearchOrdersDateTimeFilter
    {
        return $this->dateTimeFilter;
    }

    /**
     * Sets Date Time Filter.
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
     *
     * @maps date_time_filter
     */
    public function setDateTimeFilter(?SearchOrdersDateTimeFilter $dateTimeFilter): void
    {
        $this->dateTimeFilter = $dateTimeFilter;
    }

    /**
     * Returns Fulfillment Filter.
     * Filter based on [order fulfillment]($m/Fulfillment) information.
     */
    public function getFulfillmentFilter(): ?SearchOrdersFulfillmentFilter
    {
        return $this->fulfillmentFilter;
    }

    /**
     * Sets Fulfillment Filter.
     * Filter based on [order fulfillment]($m/Fulfillment) information.
     *
     * @maps fulfillment_filter
     */
    public function setFulfillmentFilter(?SearchOrdersFulfillmentFilter $fulfillmentFilter): void
    {
        $this->fulfillmentFilter = $fulfillmentFilter;
    }

    /**
     * Returns Source Filter.
     * A filter based on order `source` information.
     */
    public function getSourceFilter(): ?SearchOrdersSourceFilter
    {
        return $this->sourceFilter;
    }

    /**
     * Sets Source Filter.
     * A filter based on order `source` information.
     *
     * @maps source_filter
     */
    public function setSourceFilter(?SearchOrdersSourceFilter $sourceFilter): void
    {
        $this->sourceFilter = $sourceFilter;
    }

    /**
     * Returns Customer Filter.
     * A filter based on the order `customer_id` and any tender `customer_id`
     * associated with the order. It does not filter based on the
     * [FulfillmentRecipient]($m/FulfillmentRecipient) `customer_id`.
     */
    public function getCustomerFilter(): ?SearchOrdersCustomerFilter
    {
        return $this->customerFilter;
    }

    /**
     * Sets Customer Filter.
     * A filter based on the order `customer_id` and any tender `customer_id`
     * associated with the order. It does not filter based on the
     * [FulfillmentRecipient]($m/FulfillmentRecipient) `customer_id`.
     *
     * @maps customer_filter
     */
    public function setCustomerFilter(?SearchOrdersCustomerFilter $customerFilter): void
    {
        $this->customerFilter = $customerFilter;
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
        if (isset($this->stateFilter)) {
            $json['state_filter']       = $this->stateFilter;
        }
        if (isset($this->dateTimeFilter)) {
            $json['date_time_filter']   = $this->dateTimeFilter;
        }
        if (isset($this->fulfillmentFilter)) {
            $json['fulfillment_filter'] = $this->fulfillmentFilter;
        }
        if (isset($this->sourceFilter)) {
            $json['source_filter']      = $this->sourceFilter;
        }
        if (isset($this->customerFilter)) {
            $json['customer_filter']    = $this->customerFilter;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
