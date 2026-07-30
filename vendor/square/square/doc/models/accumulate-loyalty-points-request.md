
# Accumulate Loyalty Points Request

Represents an [AccumulateLoyaltyPoints](../../doc/apis/loyalty.md#accumulate-loyalty-points) request.

## Structure

`AccumulateLoyaltyPointsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `accumulatePoints` | [`LoyaltyEventAccumulatePoints`](../../doc/models/loyalty-event-accumulate-points.md) | Required | Provides metadata when the event `type` is `ACCUMULATE_POINTS`. | getAccumulatePoints(): LoyaltyEventAccumulatePoints | setAccumulatePoints(LoyaltyEventAccumulatePoints accumulatePoints): void |
| `idempotencyKey` | `string` | Required | A unique string that identifies the `AccumulateLoyaltyPoints` request.<br>Keys can be any valid string but must be unique for every request.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `128` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `locationId` | `string` | Required | The [location](entity:Location) where the purchase was made. | getLocationId(): string | setLocationId(string locationId): void |

## Example (as JSON)

```json
{
  "accumulate_points": {
    "order_id": "RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY"
  },
  "idempotency_key": "58b90739-c3e8-4b11-85f7-e636d48d72cb",
  "location_id": "P034NEENMD09F"
}
```

