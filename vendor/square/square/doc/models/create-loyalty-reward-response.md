
# Create Loyalty Reward Response

A response that includes the loyalty reward created.

## Structure

`CreateLoyaltyRewardResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `reward` | [`?LoyaltyReward`](../../doc/models/loyalty-reward.md) | Optional | Represents a contract to redeem loyalty points for a [reward tier](../../doc/models/loyalty-program-reward-tier.md) discount. Loyalty rewards can be in an ISSUED, REDEEMED, or DELETED state.<br>For more information, see [Manage loyalty rewards](https://developer.squareup.com/docs/loyalty-api/loyalty-rewards). | getReward(): ?LoyaltyReward | setReward(?LoyaltyReward reward): void |

## Example (as JSON)

```json
{
  "reward": {
    "created_at": "2020-05-01T21:49:54Z",
    "id": "a8f43ebe-2ad6-3001-bdd5-7d7c2da08943",
    "loyalty_account_id": "5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd",
    "order_id": "RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY",
    "points": 10,
    "reward_tier_id": "e1b39225-9da5-43d1-a5db-782cdd8ad94f",
    "status": "ISSUED",
    "updated_at": "2020-05-01T21:49:54Z"
  }
}
```

