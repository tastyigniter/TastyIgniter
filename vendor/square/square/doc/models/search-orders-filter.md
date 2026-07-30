
# Search Orders Filter

Filtering criteria to use for a `SearchOrders` request. Multiple filters
are ANDed together.

## Structure

`SearchOrdersFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `stateFilter` | [`?SearchOrdersStateFilter`](../../doc/models/search-orders-state-filter.md) | Optional | Filter by the current order `state`. | getStateFilter(): ?SearchOrdersStateFilter | setStateFilter(?SearchOrdersStateFilter stateFilter): void |
| `dateTimeFilter` | [`?SearchOrdersDateTimeFilter`](../../doc/models/search-orders-date-time-filter.md) | Optional | Filter for `Order` objects based on whether their `CREATED_AT`,<br>`CLOSED_AT`, or `UPDATED_AT` timestamps fall within a specified time range.<br>You can specify the time range and which timestamp to filter for. You can filter<br>for only one time range at a time.<br><br>For each time range, the start time and end time are inclusive. If the end time<br>is absent, it defaults to the time of the first request for the cursor.<br><br>__Important:__ If you use the `DateTimeFilter` in a `SearchOrders` query,<br>you must set the `sort_field` in [OrdersSort](../../doc/models/search-orders-sort.md)<br>to the same field you filter for. For example, if you set the `CLOSED_AT` field<br>in `DateTimeFilter`, you must set the `sort_field` in `SearchOrdersSort` to<br>`CLOSED_AT`. Otherwise, `SearchOrders` throws an error.<br>[Learn more about filtering orders by time range.](https://developer.squareup.com/docs/orders-api/manage-orders/search-orders#important-note-about-filtering-orders-by-time-range) | getDateTimeFilter(): ?SearchOrdersDateTimeFilter | setDateTimeFilter(?SearchOrdersDateTimeFilter dateTimeFilter): void |
| `fulfillmentFilter` | [`?SearchOrdersFulfillmentFilter`](../../doc/models/search-orders-fulfillment-filter.md) | Optional | Filter based on [order fulfillment](../../doc/models/fulfillment.md) information. | getFulfillmentFilter(): ?SearchOrdersFulfillmentFilter | setFulfillmentFilter(?SearchOrdersFulfillmentFilter fulfillmentFilter): void |
| `sourceFilter` | [`?SearchOrdersSourceFilter`](../../doc/models/search-orders-source-filter.md) | Optional | A filter based on order `source` information. | getSourceFilter(): ?SearchOrdersSourceFilter | setSourceFilter(?SearchOrdersSourceFilter sourceFilter): void |
| `customerFilter` | [`?SearchOrdersCustomerFilter`](../../doc/models/search-orders-customer-filter.md) | Optional | A filter based on the order `customer_id` and any tender `customer_id`<br>associated with the order. It does not filter based on the<br>[FulfillmentRecipient](../../doc/models/fulfillment-recipient.md) `customer_id`. | getCustomerFilter(): ?SearchOrdersCustomerFilter | setCustomerFilter(?SearchOrdersCustomerFilter customerFilter): void |

## Example (as JSON)

```json
{
  "state_filter": {
    "states": [
      "CANCELED",
      "DRAFT"
    ]
  },
  "date_time_filter": {
    "created_at": {
      "start_at": "start_at0",
      "end_at": "end_at2"
    },
    "updated_at": {
      "start_at": "start_at8",
      "end_at": "end_at4"
    },
    "closed_at": {}
  },
  "fulfillment_filter": {
    "fulfillment_types": [
      "DELIVERY"
    ],
    "fulfillment_states": [
      "CANCELED",
      "FAILED"
    ]
  },
  "source_filter": {
    "source_names": [
      "source_names6"
    ]
  },
  "customer_filter": {
    "customer_ids": [
      "customer_ids3",
      "customer_ids4"
    ]
  }
}
```

