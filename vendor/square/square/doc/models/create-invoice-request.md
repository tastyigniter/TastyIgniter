
# Create Invoice Request

Describes a `CreateInvoice` request.

## Structure

`CreateInvoiceRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `invoice` | [`Invoice`](../../doc/models/invoice.md) | Required | Stores information about an invoice. You use the Invoices API to create and manage<br>invoices. For more information, see [Invoices API Overview](https://developer.squareup.com/docs/invoices-api/overview). | getInvoice(): Invoice | setInvoice(Invoice invoice): void |
| `idempotencyKey` | `?string` | Optional | A unique string that identifies the `CreateInvoice` request. If you do not<br>provide `idempotency_key` (or provide an empty string as the value), the endpoint<br>treats each request as independent.<br><br>For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-apis/idempotency).<br>**Constraints**: *Maximum Length*: `128` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |

## Example (as JSON)

```json
{
  "idempotency_key": "ce3748f9-5fc1-4762-aa12-aae5e843f1f4",
  "invoice": {
    "accepted_payment_methods": {
      "bank_account": false,
      "buy_now_pay_later": false,
      "card": true,
      "square_gift_card": false
    },
    "custom_fields": [
      {
        "label": "Event Reference Number",
        "placement": "ABOVE_LINE_ITEMS",
        "value": "Ref. #1234"
      },
      {
        "label": "Terms of Service",
        "placement": "BELOW_LINE_ITEMS",
        "value": "The terms of service are..."
      }
    ],
    "delivery_method": "EMAIL",
    "description": "We appreciate your business!",
    "invoice_number": "inv-100",
    "location_id": "ES0RJRZYEC39A",
    "order_id": "CAISENgvlJ6jLWAzERDzjyHVybY",
    "payment_requests": [
      {
        "automatic_payment_source": "NONE",
        "due_date": "2030-01-24",
        "reminders": [
          {
            "message": "Your invoice is due tomorrow",
            "relative_scheduled_days": -1
          }
        ],
        "request_type": "BALANCE",
        "tipping_enabled": true
      }
    ],
    "primary_recipient": {
      "customer_id": "JDKYHBWT1D4F8MFH63DBMEN8Y4"
    },
    "sale_or_service_date": "2030-01-24",
    "scheduled_at": "2030-01-13T10:00:00Z",
    "store_payment_method_enabled": false,
    "title": "Event Planning Services"
  }
}
```

