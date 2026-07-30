
# Loyalty Event Filter

The filtering criteria. If the request specifies multiple filters,
the endpoint uses a logical AND to evaluate them.

## Structure

`LoyaltyEventFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyAccountFilter` | [`?LoyaltyEventLoyaltyAccountFilter`](../../doc/models/loyalty-event-loyalty-account-filter.md) | Optional | Filter events by loyalty account. | getLoyaltyAccountFilter(): ?LoyaltyEventLoyaltyAccountFilter | setLoyaltyAccountFilter(?LoyaltyEventLoyaltyAccountFilter loyaltyAccountFilter): void |
| `typeFilter` | [`?LoyaltyEventTypeFilter`](../../doc/models/loyalty-event-type-filter.md) | Optional | Filter events by event type. | getTypeFilter(): ?LoyaltyEventTypeFilter | setTypeFilter(?LoyaltyEventTypeFilter typeFilter): void |
| `dateTimeFilter` | [`?LoyaltyEventDateTimeFilter`](../../doc/models/loyalty-event-date-time-filter.md) | Optional | Filter events by date time range. | getDateTimeFilter(): ?LoyaltyEventDateTimeFilter | setDateTimeFilter(?LoyaltyEventDateTimeFilter dateTimeFilter): void |
| `locationFilter` | [`?LoyaltyEventLocationFilter`](../../doc/models/loyalty-event-location-filter.md) | Optional | Filter events by location. | getLocationFilter(): ?LoyaltyEventLocationFilter | setLocationFilter(?LoyaltyEventLocationFilter locationFilter): void |
| `orderFilter` | [`?LoyaltyEventOrderFilter`](../../doc/models/loyalty-event-order-filter.md) | Optional | Filter events by the order associated with the event. | getOrderFilter(): ?LoyaltyEventOrderFilter | setOrderFilter(?LoyaltyEventOrderFilter orderFilter): void |

## Example (as JSON)

```json
{
  "loyalty_account_filter": {
    "loyalty_account_id": "loyalty_account_id8"
  },
  "type_filter": {
    "types": [
      "ACCUMULATE_PROMOTION_POINTS",
      "ACCUMULATE_POINTS",
      "CREATE_REWARD"
    ]
  },
  "date_time_filter": {
    "created_at": {
      "start_at": "start_at0",
      "end_at": "end_at2"
    }
  },
  "location_filter": {
    "location_ids": [
      "location_ids0",
      "location_ids1",
      "location_ids2"
    ]
  },
  "order_filter": {
    "order_id": "order_id2"
  }
}
```

