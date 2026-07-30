
# Cash Drawer Event Type

The types of events on a CashDrawerShift.
Each event type represents an employee action on the actual cash drawer
represented by a CashDrawerShift.

## Enumeration

`CashDrawerEventType`

## Fields

| Name | Description |
|  --- | --- |
| `NO_SALE` | Triggered when a no sale occurs on a cash drawer.<br>A CashDrawerEvent of this type must have a zero money amount. |
| `CASH_TENDER_PAYMENT` | Triggered when a cash tender payment occurs on a cash drawer.<br>A CashDrawerEvent of this type can must not have a negative amount. |
| `OTHER_TENDER_PAYMENT` | Triggered when a check, gift card, or other non-cash payment occurs<br>on a cash drawer.<br>A CashDrawerEvent of this type must have a zero money amount. |
| `CASH_TENDER_CANCELLED_PAYMENT` | Triggered when a split tender bill is cancelled after cash has been<br>tendered.<br>A CASH_TENDER_CANCELLED_PAYMENT should have a corresponding CASH_TENDER_PAYMENT.<br>A CashDrawerEvent of this type must not have a negative amount. |
| `OTHER_TENDER_CANCELLED_PAYMENT` | Triggered when a split tender bill is cancelled after a non-cash tender<br>has been tendered. An OTHER_TENDER_CANCELLED_PAYMENT should have a corresponding<br>OTHER_TENDER_PAYMENT. A CashDrawerEvent of this type must have a zero money<br>amount. |
| `CASH_TENDER_REFUND` | Triggered when a cash tender refund occurs.<br>A CashDrawerEvent of this type must not have a negative amount. |
| `OTHER_TENDER_REFUND` | Triggered when an other tender refund occurs.<br>A CashDrawerEvent of this type must have a zero money amount. |
| `PAID_IN` | Triggered when money unrelated to a payment is added to the cash drawer.<br>For example, an employee adds coins to the drawer.<br>A CashDrawerEvent of this type must not have a negative amount. |
| `PAID_OUT` | Triggered when money is removed from the drawer for other reasons<br>than making change.<br>For example, an employee pays a delivery person with cash from the cash drawer.<br>A CashDrawerEvent of this type must not have a negative amount. |

