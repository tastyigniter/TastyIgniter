
# Create Loyalty Reward Request

A request to create a loyalty reward.

## Structure

`CreateLoyaltyRewardRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `reward` | [`LoyaltyReward`](../../doc/models/loyalty-reward.md) | Required | Represents a contract to redeem loyalty points for a [reward tier](../../doc/models/loyalty-program-reward-tier.md) discount. Loyalty rewards can be in an ISSUED, REDEEMED, or DELETED state.<br>For more information, see [Manage loyalty rewards](https://developer.squareup.com/docs/loyalty-api/loyalty-rewards). | getReward(): LoyaltyReward | setReward(LoyaltyReward reward): void |
| `idempotencyKey` | `string` | Required | A unique string that identifies this `CreateLoyaltyReward` request.<br>Keys can be any valid string, but must be unique for every request.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `128` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |

## Example (as JSON)

```json
{
  "idempotency_key": "18c2e5ea-a620-4b1f-ad60-7b167285e451",
  "reward": {
    "loyalty_account_id": "5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd",
    "order_id": "RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY",
    "reward_tier_id": "e1b39225-9da5-43d1-a5db-782cdd8ad94f"
  }
}
```

