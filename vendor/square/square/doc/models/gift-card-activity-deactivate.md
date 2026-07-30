
# Gift Card Activity Deactivate

Represents details about a `DEACTIVATE` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityDeactivate`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `reason` | [`string (GiftCardActivityDeactivateReason)`](../../doc/models/gift-card-activity-deactivate-reason.md) | Required | Indicates the reason for deactivating a [gift card](../../doc/models/gift-card.md). | getReason(): string | setReason(string reason): void |

## Example (as JSON)

```json
{
  "reason": "UNKNOWN_REASON"
}
```

