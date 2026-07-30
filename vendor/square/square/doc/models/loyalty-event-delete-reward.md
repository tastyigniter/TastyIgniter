
# Loyalty Event Delete Reward

Provides metadata when the event `type` is `DELETE_REWARD`.

## Structure

`LoyaltyEventDeleteReward`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyProgramId` | `string` | Required | The ID of the [loyalty program](entity:LoyaltyProgram).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `36` | getLoyaltyProgramId(): string | setLoyaltyProgramId(string loyaltyProgramId): void |
| `rewardId` | `?string` | Optional | The ID of the deleted [loyalty reward](entity:LoyaltyReward).<br>This field is returned only if the event source is `LOYALTY_API`.<br>**Constraints**: *Maximum Length*: `36` | getRewardId(): ?string | setRewardId(?string rewardId): void |
| `points` | `int` | Required | The number of points returned to the loyalty account. | getPoints(): int | setPoints(int points): void |

## Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "reward_id": "reward_id4",
  "points": 236
}
```

