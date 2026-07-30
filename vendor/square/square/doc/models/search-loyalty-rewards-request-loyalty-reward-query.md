
# Search Loyalty Rewards Request Loyalty Reward Query

The set of search requirements.

## Structure

`SearchLoyaltyRewardsRequestLoyaltyRewardQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyAccountId` | `string` | Required | The ID of the [loyalty account](entity:LoyaltyAccount) to which the loyalty reward belongs.<br>**Constraints**: *Minimum Length*: `1` | getLoyaltyAccountId(): string | setLoyaltyAccountId(string loyaltyAccountId): void |
| `status` | [`?string (LoyaltyRewardStatus)`](../../doc/models/loyalty-reward-status.md) | Optional | The status of the loyalty reward. | getStatus(): ?string | setStatus(?string status): void |

## Example (as JSON)

```json
{
  "loyalty_account_id": "loyalty_account_id0",
  "status": "DELETED"
}
```

