
# Invoice Payment Reminder

Describes a payment request reminder (automatic notification) that Square sends
to the customer. You configure a reminder relative to the payment request
`due_date`.

## Structure

`InvoicePaymentReminder`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A Square-assigned ID that uniquely identifies the reminder within the<br>`InvoicePaymentRequest`. | getUid(): ?string | setUid(?string uid): void |
| `relativeScheduledDays` | `?int` | Optional | The number of days before (a negative number) or after (a positive number)<br>the payment request `due_date` when the reminder is sent. For example, -3 indicates that<br>the reminder should be sent 3 days before the payment request `due_date`.<br>**Constraints**: `>= -32767`, `<= 32767` | getRelativeScheduledDays(): ?int | setRelativeScheduledDays(?int relativeScheduledDays): void |
| `message` | `?string` | Optional | The reminder message.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `1000` | getMessage(): ?string | setMessage(?string message): void |
| `status` | [`?string (InvoicePaymentReminderStatus)`](../../doc/models/invoice-payment-reminder-status.md) | Optional | The status of a payment request reminder. | getStatus(): ?string | setStatus(?string status): void |
| `sentAt` | `?string` | Optional | If sent, the timestamp when the reminder was sent, in RFC 3339 format. | getSentAt(): ?string | setSentAt(?string sentAt): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "relative_scheduled_days": 0,
  "message": "message0",
  "status": "SENT",
  "sent_at": "sent_at0"
}
```

