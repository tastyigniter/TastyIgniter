
# Loyalty Event Type Filter

Filter events by event type.

## Structure

`LoyaltyEventTypeFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `types` | [`string[] (LoyaltyEventType)`](../../doc/models/loyalty-event-type.md) | Required | The loyalty event types used to filter the result.<br>If multiple values are specified, the endpoint uses a<br>logical OR to combine them.<br>See [LoyaltyEventType](#type-loyaltyeventtype) for possible values | getTypes(): array | setTypes(array types): void |

## Example (as JSON)

```json
{
  "types": [
    "DELETE_REWARD",
    "ADJUST_POINTS",
    "EXPIRE_POINTS"
  ]
}
```

