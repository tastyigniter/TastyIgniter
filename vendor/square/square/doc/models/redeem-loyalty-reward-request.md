
# Redeem Loyalty Reward Request

A request to redeem a loyalty reward.

## Structure

`RedeemLoyaltyRewardRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A unique string that identifies this `RedeemLoyaltyReward` request.<br>Keys can be any valid string, but must be unique for every request.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `128` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `locationId` | `string` | Required | The ID of the [location](entity:Location) where the reward is redeemed.<br>**Constraints**: *Minimum Length*: `1` | getLocationId(): string | setLocationId(string locationId): void |

## Example (as JSON)

```json
{
  "idempotency_key": "98adc7f7-6963-473b-b29c-f3c9cdd7d994",
  "location_id": "P034NEENMD09F"
}
```

