
# Gift Card Activity Clear Balance

Represents details about a `CLEAR_BALANCE` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityClearBalance`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `reason` | [`string (GiftCardActivityClearBalanceReason)`](../../doc/models/gift-card-activity-clear-balance-reason.md) | Required | Indicates the reason for clearing the balance of a [gift card](../../doc/models/gift-card.md). | getReason(): string | setReason(string reason): void |

## Example (as JSON)

```json
{
  "reason": "REUSE_GIFTCARD"
}
```

