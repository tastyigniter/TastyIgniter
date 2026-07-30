
# Adjust Loyalty Points Response

Represents an [AdjustLoyaltyPoints](../../doc/apis/loyalty.md#adjust-loyalty-points) request.

## Structure

`AdjustLoyaltyPointsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `event` | [`?LoyaltyEvent`](../../doc/models/loyalty-event.md) | Optional | Provides information about a loyalty event.<br>For more information, see [Search for Balance-Changing Loyalty Events](https://developer.squareup.com/docs/loyalty-api/loyalty-events). | getEvent(): ?LoyaltyEvent | setEvent(?LoyaltyEvent event): void |

## Example (as JSON)

```json
{
  "event": {
    "adjust_points": {
      "loyalty_program_id": "d619f755-2d17-41f3-990d-c04ecedd64dd",
      "points": 10,
      "reason": "Complimentary points"
    },
    "created_at": "2020-05-08T21:42:32Z",
    "id": "613a6fca-8d67-39d0-bad2-3b4bc45c8637",
    "loyalty_account_id": "5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd",
    "source": "LOYALTY_API",
    "type": "ADJUST_POINTS"
  }
}
```

