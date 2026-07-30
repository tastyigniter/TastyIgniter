
# Invoice Delivery Method

Indicates how Square delivers the [invoice](../../doc/models/invoice.md) to the customer.

## Enumeration

`InvoiceDeliveryMethod`

## Fields

| Name | Description |
|  --- | --- |
| `EMAIL` | Directs Square to send invoices, reminders, and receipts to the customer using email. |
| `SHARE_MANUALLY` | Directs Square to take no action on the invoice. In this case, the seller<br>or application developer follows up with the customer for payment. For example,<br>a seller might collect a payment in the Seller Dashboard or Point of Sale (POS) application.<br>The seller might also share the URL of the Square-hosted invoice page (`public_url`) with the customer to request payment. |
| `SMS` | Directs Square to send invoices and receipts to the customer using SMS (text message).<br><br>You cannot set `SMS` as a delivery method using the Invoices API, but you can change an `SMS` delivery method to `EMAIL` or `SHARE_MANUALLY`. |

