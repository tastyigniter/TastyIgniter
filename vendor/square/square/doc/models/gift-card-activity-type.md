
# Gift Card Activity Type

Indicates the type of [gift card activity](../../doc/models/gift-card-activity.md).

## Enumeration

`GiftCardActivityType`

## Fields

| Name | Description |
|  --- | --- |
| `ACTIVATE` | Activated a gift card with a balance. When a gift card is activated, Square changes<br>the gift card state from `PENDING` to `ACTIVE`. A gift card must be in the `ACTIVE` state<br>to be used for other balance-changing activities. |
| `LOAD` | Loaded a gift card with additional funds. |
| `REDEEM` | Redeemed a gift card for a purchase. |
| `CLEAR_BALANCE` | Set the balance of a gift card to zero. |
| `DEACTIVATE` | Permanently blocked a gift card from balance-changing activities. |
| `ADJUST_INCREMENT` | Added money to a gift card outside of a typical `ACTIVATE`, `LOAD`, or `REFUND` activity flow. |
| `ADJUST_DECREMENT` | Deducted money from a gift card outside of a typical `REDEEM` activity flow. |
| `REFUND` | Added money to a gift card from a refunded transaction. A `REFUND` activity might be linked to<br>a Square payment, depending on how the payment and refund are processed. For example:<br><br>- A gift card payment processed by Square can be refunded to the same gift card using Square Point of Sale,<br>  the Square Seller Dashboard, or the Refunds API.<br>- A cross-tender payment processed by Square can be refunded to a gift card using Square Point of Sale or the<br>  Square Seller Dashboard. The payment source might be a credit card or different gift card.<br>- A payment processed using a custom payment processing system can be refunded to the same gift card. |
| `UNLINKED_ACTIVITY_REFUND` | Added money to a gift card from a refunded transaction that was processed using a custom payment<br>processing system and not linked to the gift card. |
| `IMPORT` | Imported a third-party gift card with a balance. `IMPORT` activities are managed<br>by Square and cannot be created using the Gift Card Activities API. |
| `BLOCK` | Temporarily blocked a gift card from balance-changing activities. `BLOCK` activities<br>are managed by Square and cannot be created using the Gift Card Activities API. |
| `UNBLOCK` | Unblocked a gift card, which enables it to resume balance-changing activities. `UNBLOCK`<br>activities are managed by Square and cannot be created using the Gift Card Activities API. |
| `IMPORT_REVERSAL` | Reversed the import of a third-party gift card, which sets the gift card state to<br>`PENDING` and clears the balance. `IMPORT_REVERSAL` activities are managed by Square and<br>cannot be created using the Gift Card Activities API. |
| `TRANSFER_BALANCE_FROM` | Deducted money from a gift card as the result of a transfer to the balance of another gift card.<br>`TRANSFER_BALANCE_FROM` activities are managed by Square and cannot be created using the Gift Card Activities API. |
| `TRANSFER_BALANCE_TO` | Added money to a gift card as the result of a transfer from the balance of another gift card.<br>`TRANSFER_BALANCE_TO` activities are managed by Square and cannot be created using the Gift Card Activities API. |

