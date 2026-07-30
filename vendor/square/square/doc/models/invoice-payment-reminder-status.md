
# Invoice Payment Reminder Status

The status of a payment request reminder.

## Enumeration

`InvoicePaymentReminderStatus`

## Fields

| Name | Description |
|  --- | --- |
| `PENDING` | The reminder will be sent on the `relative_scheduled_date` (if the invoice is published). |
| `NOT_APPLICABLE` | The reminder is not applicable and is not sent. The following are examples<br>of when reminders are not applicable and are not sent:<br><br>- You schedule a reminder to be sent before the invoice is published.<br>- The invoice is configured with multiple payment requests and a payment request reminder<br>  is configured to be sent after the next payment request `due_date`.<br>- Two reminders (for different payment requests) are configured to be sent on the<br>  same date. Therefore, only one reminder is sent.<br>- You configure a reminder to be sent on the date that the invoice is scheduled to be sent.<br>- The payment request is already paid.<br>- The invoice status is `CANCELED` or `FAILED`. |
| `SENT` | The reminder is sent. |

