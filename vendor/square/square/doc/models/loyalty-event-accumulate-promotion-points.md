
# Loyalty Event Accumulate Promotion Points

Provides metadata when the event `type` is `ACCUMULATE_PROMOTION_POINTS`.

## Structure

`LoyaltyEventAccumulatePromotionPoints`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyProgramId` | `?string` | Optional | The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).<br>**Constraints**: *Maximum Length*: `36` | getLoyaltyProgramId(): ?string | setLoyaltyProgramId(?string loyaltyProgramId): void |
| `loyaltyPromotionId` | `?string` | Optional | The Square-assigned ID of the [loyalty promotion](entity:LoyaltyPromotion).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getLoyaltyPromotionId(): ?string | setLoyaltyPromotionId(?string loyaltyPromotionId): void |
| `points` | `int` | Required | The number of points earned by the event. | getPoints(): int | setPoints(int points): void |
| `orderId` | `string` | Required | The ID of the [order](entity:Order) for which the buyer earned the promotion points.<br>Only applications that use the Orders API to process orders can trigger this event.<br>**Constraints**: *Minimum Length*: `1` | getOrderId(): string | setOrderId(string orderId): void |

## Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "loyalty_promotion_id": "loyalty_promotion_id8",
  "points": 236,
  "order_id": "order_id6"
}
```

