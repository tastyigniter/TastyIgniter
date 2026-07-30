
# Invoice Automatic Payment Source

Indicates the automatic payment method for an [invoice payment request](../../doc/models/invoice-payment-request.md).

## Enumeration

`InvoiceAutomaticPaymentSource`

## Fields

| Name | Description |
|  --- | --- |
| `NONE` | An automatic payment is not configured for the payment request. |
| `CARD_ON_FILE` | Use a card on file as the automatic payment method. On the due date, Square charges the card<br>for the amount of the payment request.<br><br>For `CARD_ON_FILE` payments, the invoice delivery method must be `EMAIL` and `card_id` must be<br>specified for the payment request before the invoice can be published. |
| `BANK_ON_FILE` | Use a bank account on file as the automatic payment method. On the due date, Square charges the bank<br>account for the amount of the payment request.<br><br>This payment method applies only to recurring invoices that sellers create in the Seller Dashboard or other<br>Square first-party applications. The bank account is provided by the customer during the payment flow.<br><br>You cannot set `BANK_ON_FILE` as a payment method using the Invoices API, but you can change a `BANK_ON_FILE`<br>payment method to `NONE` or `CARD_ON_FILE`. For `BANK_ON_FILE` payments, the invoice delivery method must be `EMAIL`. |

