
# Gift Card Activity Deactivate Reason

Indicates the reason for deactivating a [gift card](../../doc/models/gift-card.md).

## Enumeration

`GiftCardActivityDeactivateReason`

## Fields

| Name | Description |
|  --- | --- |
| `SUSPICIOUS_ACTIVITY` | The seller suspects suspicious activity. |
| `UNKNOWN_REASON` | The gift card was deactivated for an unknown reason.<br><br>This reason is read-only and cannot be used to create a `DEACTIVATE` activity using the Gift Card Activities API. |
| `CHARGEBACK_DEACTIVATE` | A chargeback on the gift card purchase (or the gift card load) was ruled in favor of the buyer.<br><br>This reason is read-only and cannot be used to create a `DEACTIVATE` activity using the Gift Card Activities API. |

