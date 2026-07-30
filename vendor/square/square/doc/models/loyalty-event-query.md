
# Loyalty Event Query

Represents a query used to search for loyalty events.

## Structure

`LoyaltyEventQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`?LoyaltyEventFilter`](../../doc/models/loyalty-event-filter.md) | Optional | The filtering criteria. If the request specifies multiple filters,<br>the endpoint uses a logical AND to evaluate them. | getFilter(): ?LoyaltyEventFilter | setFilter(?LoyaltyEventFilter filter): void |

## Example (as JSON)

```json
{
  "filter": {
    "loyalty_account_filter": {
      "loyalty_account_id": "loyalty_account_id4"
    },
    "type_filter": {
      "types": [
        "DELETE_REWARD",
        "ADJUST_POINTS",
        "EXPIRE_POINTS"
      ]
    },
    "date_time_filter": {
      "created_at": {
        "start_at": "start_at6",
        "end_at": "end_at6"
      }
    },
    "location_filter": {
      "location_ids": [
        "location_ids4",
        "location_ids5",
        "location_ids6"
      ]
    },
    "order_filter": {
      "order_id": "order_id6"
    }
  }
}
```

