
# Loyalty Event Create Reward

Provides metadata when the event `type` is `CREATE_REWARD`.

## Structure

`LoyaltyEventCreateReward`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyProgramId` | `string` | Required | The ID of the [loyalty program](entity:LoyaltyProgram).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `36` | getLoyaltyProgramId(): string | setLoyaltyProgramId(string loyaltyProgramId): void |
| `rewardId` | `?string` | Optional | The Square-assigned ID of the created [loyalty reward](entity:LoyaltyReward).<br>This field is returned only if the event source is `LOYALTY_API`.<br>**Constraints**: *Maximum Length*: `36` | getRewardId(): ?string | setRewardId(?string rewardId): void |
| `points` | `int` | Required | The loyalty points used to create the reward. | getPoints(): int | setPoints(int points): void |

## Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "reward_id": "reward_id4",
  "points": 236
}
```

