
# Redeem Loyalty Reward Response

A response that includes the `LoyaltyEvent` published for redeeming the reward.

## Structure

`RedeemLoyaltyRewardResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `event` | [`?LoyaltyEvent`](../../doc/models/loyalty-event.md) | Optional | Provides information about a loyalty event.<br>For more information, see [Search for Balance-Changing Loyalty Events](https://developer.squareup.com/docs/loyalty-api/loyalty-events). | getEvent(): ?LoyaltyEvent | setEvent(?LoyaltyEvent event): void |

## Example (as JSON)

```json
{
  "event": {
    "created_at": "2020-05-08T21:56:00Z",
    "id": "67377a6e-dbdc-369d-aa16-2e7ed422e71f",
    "location_id": "P034NEENMD09F",
    "loyalty_account_id": "5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd",
    "redeem_reward": {
      "loyalty_program_id": "d619f755-2d17-41f3-990d-c04ecedd64dd",
      "reward_id": "9f18ac21-233a-31c3-be77-b45840f5a810"
    },
    "source": "LOYALTY_API",
    "type": "REDEEM_REWARD"
  }
}
```

