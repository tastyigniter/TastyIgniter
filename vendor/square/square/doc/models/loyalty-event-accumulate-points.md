
# Loyalty Event Accumulate Points

Provides metadata when the event `type` is `ACCUMULATE_POINTS`.

## Structure

`LoyaltyEventAccumulatePoints`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyProgramId` | `?string` | Optional | The ID of the [loyalty program](entity:LoyaltyProgram).<br>**Constraints**: *Maximum Length*: `36` | getLoyaltyProgramId(): ?string | setLoyaltyProgramId(?string loyaltyProgramId): void |
| `points` | `?int` | Optional | The number of points accumulated by the event.<br>**Constraints**: `>= 1` | getPoints(): ?int | setPoints(?int points): void |
| `orderId` | `?string` | Optional | The ID of the [order](entity:Order) for which the buyer accumulated the points.<br>This field is returned only if the Orders API is used to process orders. | getOrderId(): ?string | setOrderId(?string orderId): void |

## Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "points": 236,
  "order_id": "order_id6"
}
```

