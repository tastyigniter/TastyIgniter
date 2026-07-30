
# Order Reward

Represents a reward that can be applied to an order if the necessary
reward tier criteria are met. Rewards are created through the Loyalty API.

## Structure

`OrderReward`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `string` | Required | The identifier of the reward.<br>**Constraints**: *Minimum Length*: `1` | getId(): string | setId(string id): void |
| `rewardTierId` | `string` | Required | The identifier of the reward tier corresponding to this reward.<br>**Constraints**: *Minimum Length*: `1` | getRewardTierId(): string | setRewardTierId(string rewardTierId): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "reward_tier_id": "reward_tier_id6"
}
```

