
# Retrieve Loyalty Reward Response

A response that includes the loyalty reward.

## Structure

`RetrieveLoyaltyRewardResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `reward` | [`?LoyaltyReward`](../../doc/models/loyalty-reward.md) | Optional | Represents a contract to redeem loyalty points for a [reward tier](../../doc/models/loyalty-program-reward-tier.md) discount. Loyalty rewards can be in an ISSUED, REDEEMED, or DELETED state.<br>For more information, see [Manage loyalty rewards](https://developer.squareup.com/docs/loyalty-api/loyalty-rewards). | getReward(): ?LoyaltyReward | setReward(?LoyaltyReward reward): void |

## Example (as JSON)

```json
{
  "reward": {
    "created_at": "2020-05-08T21:55:42Z",
    "id": "9f18ac21-233a-31c3-be77-b45840f5a810",
    "loyalty_account_id": "5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd",
    "points": 10,
    "redeemed_at": "2020-05-08T21:56:00Z",
    "reward_tier_id": "e1b39225-9da5-43d1-a5db-782cdd8ad94f",
    "status": "REDEEMED",
    "updated_at": "2020-05-08T21:56:00Z"
  }
}
```

