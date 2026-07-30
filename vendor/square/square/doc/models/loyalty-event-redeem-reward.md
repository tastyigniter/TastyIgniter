
# Loyalty Event Redeem Reward

Provides metadata when the event `type` is `REDEEM_REWARD`.

## Structure

`LoyaltyEventRedeemReward`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyProgramId` | `string` | Required | The ID of the [loyalty program](entity:LoyaltyProgram).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `36` | getLoyaltyProgramId(): string | setLoyaltyProgramId(string loyaltyProgramId): void |
| `rewardId` | `?string` | Optional | The ID of the redeemed [loyalty reward](entity:LoyaltyReward).<br>This field is returned only if the event source is `LOYALTY_API`.<br>**Constraints**: *Maximum Length*: `36` | getRewardId(): ?string | setRewardId(?string rewardId): void |
| `orderId` | `?string` | Optional | The ID of the [order](entity:Order) that redeemed the reward.<br>This field is returned only if the Orders API is used to process orders. | getOrderId(): ?string | setOrderId(?string orderId): void |

## Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "reward_id": "reward_id4",
  "order_id": "order_id6"
}
```

