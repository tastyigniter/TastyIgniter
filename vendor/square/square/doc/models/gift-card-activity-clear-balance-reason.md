
# Gift Card Activity Clear Balance Reason

Indicates the reason for clearing the balance of a [gift card](../../doc/models/gift-card.md).

## Enumeration

`GiftCardActivityClearBalanceReason`

## Fields

| Name | Description |
|  --- | --- |
| `SUSPICIOUS_ACTIVITY` | The seller suspects suspicious activity. |
| `REUSE_GIFTCARD` | The seller cleared the balance to reuse the gift card. |
| `UNKNOWN_REASON` | The gift card balance was cleared for an unknown reason.<br><br>This reason is read-only and cannot be used to create a `CLEAR_BALANCE` activity using the Gift Card Activities API. |

