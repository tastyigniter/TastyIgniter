
# Get Terminal Checkout Response

## Structure

`GetTerminalCheckoutResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `checkout` | [`?TerminalCheckout`](../../doc/models/terminal-checkout.md) | Optional | Represents a checkout processed by the Square Terminal. | getCheckout(): ?TerminalCheckout | setCheckout(?TerminalCheckout checkout): void |

## Example (as JSON)

```json
{
  "checkout": {
    "amount_money": {
      "amount": 2610,
      "currency": "USD"
    },
    "app_id": "APP_ID",
    "created_at": "2020-04-06T16:39:32.545Z",
    "deadline_duration": "PT10M",
    "device_options": {
      "device_id": "dbb5d83a-7838-11ea-bc55-0242ac130003",
      "skip_receipt_screen": false,
      "tip_settings": {
        "allow_tipping": false
      }
    },
    "id": "08YceKh7B3ZqO",
    "note": "A brief note",
    "reference_id": "id11572",
    "status": "IN_PROGRESS",
    "updated_at": "2020-04-06T16:39:323.001Z"
  }
}
```

