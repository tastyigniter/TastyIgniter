
# List Invoices Response

Describes a `ListInvoice` response.

## Structure

`ListInvoicesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `invoices` | [`?(Invoice[])`](../../doc/models/invoice.md) | Optional | The invoices retrieved. | getInvoices(): ?array | setInvoices(?array invoices): void |
| `cursor` | `?string` | Optional | When a response is truncated, it includes a cursor that you can use in a<br>subsequent request to retrieve the next set of invoices. If empty, this is the final<br>response.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "cursor": "ChoIDhIWVm54ZVRhLXhySFBOejBBM2xJb2daUQoFCI4IGAE",
  "invoices": [
    {
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
    },
    {
      "accepted_payment_methods": {
        "bank_account": false,
        "buy_now_pay_later": false,
        "card": true,
        "square_gift_card": true
      },
      "created_at": "2021-01-23T15:29:12Z",
      "delivery_method": "EMAIL",
      "id": "inv:0-ChC366qAfskpGrBI_1bozs9mEA3",
      "invoice_number": "inv-455",
      "location_id": "ES0RJRZYEC39A",
      "next_payment_amount_money": {
        "amount": 3000,
        "currency": "USD"
      },
      "order_id": "a65jnS8NXbfprvGJzY9F4fQTuaB",
      "payment_requests": [
        {
          "automatic_payment_source": "CARD_ON_FILE",
          "card_id": "ccof:IkWfpLj4tNHMyFii3GB",
          "computed_amount_money": {
            "amount": 1000,
            "currency": "USD"
          },
          "due_date": "2021-01-23",
          "percentage_requested": "25",
          "request_type": "DEPOSIT",
          "tipping_enabled": false,
          "total_completed_amount_money": {
            "amount": 1000,
            "currency": "USD"
          },
          "uid": "66c3bdfd-5090-4ff9-a8a0-c1e1a2ffa176"
        },
        {
          "automatic_payment_source": "CARD_ON_FILE",
          "card_id": "ccof:IkWfpLj4tNHMyFii3GB",
          "computed_amount_money": {
            "amount": 3000,
            "currency": "USD"
          },
          "due_date": "2021-06-15",
          "request_type": "BALANCE",
          "tipping_enabled": false,
          "total_completed_amount_money": {
            "amount": 0,
            "currency": "USD"
          },
          "uid": "120c5e18-4f80-4f6b-b159-774cb9bf8f99"
        }
      ],
      "primary_recipient": {
        "customer_id": "JDKYHBWT1D4F8MFH63DBMEN8Y4",
        "email_address": "Amelia.Earhart@example.com",
        "family_name": "Earhart",
        "given_name": "Amelia",
        "phone_number": "1-212-555-4240"
      },
      "public_url": "https://squareup.com/pay-invoice/h9sfsfTGTSnYEhISUDBhEQ",
      "sale_or_service_date": "2030-01-24",
      "status": "PARTIALLY_PAID",
      "store_payment_method_enabled": false,
      "timezone": "America/Los_Angeles",
      "updated_at": "2021-01-23T15:29:56Z",
      "version": 3
    }
  ]
}
```

