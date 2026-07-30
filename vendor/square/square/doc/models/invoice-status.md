
# Invoice Status

Indicates the status of an invoice.

## Enumeration

`InvoiceStatus`

## Fields

| Name | Description |
|  --- | --- |
| `DRAFT` | The invoice is a draft. You must publish a draft invoice before Square can process it.<br>A draft invoice has no `public_url`, so it is not available to customers. |
| `UNPAID` | The invoice is published but not yet paid. |
| `SCHEDULED` | The invoice is scheduled to be processed. On the scheduled date,<br>Square sends the invoice, initiates an automatic payment, or takes no action, depending on<br>the delivery method and payment request settings. Square also sets the invoice status to the<br>appropriate state: `UNPAID`, `PAID`, `PARTIALLY_PAID`, or `PAYMENT_PENDING`. |
| `PARTIALLY_PAID` | A partial payment is received for the invoice. |
| `PAID` | The customer paid the invoice in full. |
| `PARTIALLY_REFUNDED` | The invoice is paid (or partially paid) and some but not all the amount paid is<br>refunded. |
| `REFUNDED` | The full amount that the customer paid for the invoice is refunded. |
| `CANCELED` | The invoice is canceled. Square no longer requests payments from the customer.<br>The `public_url` page remains and is accessible, but it displays the invoice<br>as canceled and does not accept payment. |
| `FAILED` | Square canceled the invoice due to suspicious activity. |
| `PAYMENT_PENDING` | A payment on the invoice was initiated but has not yet been processed.<br><br>When in this state, invoices cannot be updated and other payments cannot be initiated. |

