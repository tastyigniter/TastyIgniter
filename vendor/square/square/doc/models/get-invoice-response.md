
# Get Invoice Response

Describes a `GetInvoice` response.

## Structure

`GetInvoiceResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `invoice` | [`?Invoice`](../../doc/models/invoice.md) | Optional | Stores information about an invoice. You use the Invoices API to create and manage<br>invoices. For more information, see [Invoices API Overview](https://developer.squareup.com/docs/invoices-api/overview). | getInvoice(): ?Invoice | setInvoice(?Invoice invoice): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "invoice": {
    "accepted_payment_methods": {
      "bank_account": false,
      "buy_now_pay_later": false,
      "card": true,
      "square_gift_card": false
    },
    "created_at": "2020-06-18T17:45:13Z",
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
    "id": "inv:0-ChCHu2mZEabLeeHahQnXDjZQECY",
    "invoice_number": "inv-100",
    "location_id": "ES0RJRZYEC39A",
    "order_id": "CAISENgvlJ6jLWAzERDzjyHVybY",
    "payment_requests": [
      {
        "automatic_payment_source": "NONE",
        "computed_amount_money": {
          "amount": 10000,
          "currency": "USD"
        },
        "due_date": "2030-01-24",
        "reminders": [
          {
            "message": "Your invoice is due tomorrow",
            "relative_scheduled_days": -1,
            "status": "PENDING",
            "uid": "beebd363-e47f-4075-8785-c235aaa7df11"
          }
        ],
        "request_type": "BALANCE",
        "tipping_enabled": true,
        "total_completed_amount_money": {
          "amount": 0,
          "currency": "USD"
        },
        "uid": "2da7964f-f3d2-4f43-81e8-5aa220bf3355"
      }
    ],
    "primary_recipient": {
      "customer_id": "JDKYHBWT1D4F8MFH63DBMEN8Y4",
      "email_address": "Amelia.Earhart@example.com",
      "family_name": "Earhart",
      "given_name": "Amelia",
      "phone_number": "1-212-555-4240"
    },
    "sale_or_service_date": "2030-01-24",
    "scheduled_at": "2030-01-13T10:00:00Z",
    "status": "DRAFT",
    "store_payment_method_enabled": false,
    "timezone": "America/Los_Angeles",
    "title": "Event Planning Services",
    "updated_at": "2020-06-18T17:45:13Z",
    "version": 0
  }
}
```

