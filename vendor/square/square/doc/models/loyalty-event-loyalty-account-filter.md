
# Loyalty Event Loyalty Account Filter

Filter events by loyalty account.

## Structure

`LoyaltyEventLoyaltyAccountFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyAccountId` | `string` | Required | The ID of the [loyalty account](entity:LoyaltyAccount) associated with loyalty events.<br>**Constraints**: *Minimum Length*: `1` | getLoyaltyAccountId(): string | setLoyaltyAccountId(string loyaltyAccountId): void |

## Example (as JSON)

```json
{
  "loyalty_account_id": "loyalty_account_id0"
}
```

