
# Accumulate Loyalty Points Response

Represents an [AccumulateLoyaltyPoints](../../doc/apis/loyalty.md#accumulate-loyalty-points) response.

## Structure

`AccumulateLoyaltyPointsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `event` | [`?LoyaltyEvent`](../../doc/models/loyalty-event.md) | Optional | Provides information about a loyalty event.<br>For more information, see [Search for Balance-Changing Loyalty Events](https://developer.squareup.com/docs/loyalty-api/loyalty-events). | getEvent(): ?LoyaltyEvent | setEvent(?LoyaltyEvent event): void |
| `events` | [`?(LoyaltyEvent[])`](../../doc/models/loyalty-event.md) | Optional | The resulting loyalty events. If the purchase qualifies for points, the `ACCUMULATE_POINTS` event<br>is always included. When using the Orders API, the `ACCUMULATE_PROMOTION_POINTS` event is included<br>if the purchase also qualifies for a loyalty promotion. | getEvents(): ?array | setEvents(?array events): void |

## Example (as JSON)

```json
{
  "events": [
    {
      "accumulate_points": {
        "loyalty_program_id": "d619f755-2d17-41f3-990d-c04ecedd64dd",
        "order_id": "RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY",
        "points": 6
      },
      "created_at": "2020-05-08T21:41:12Z",
      "id": "ee46aafd-1af6-3695-a385-276e2ef0be26",
      "location_id": "P034NEENMD09F",
      "loyalty_account_id": "5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd",
      "source": "LOYALTY_API",
      "type": "ACCUMULATE_POINTS"
    }
  ]
}
```

