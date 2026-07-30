
# Cancel Terminal Checkout Response

## Structure

`CancelTerminalCheckoutResponse`

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
      "amount": 123,
      "currency": "USD"
    },
    "app_id": "APP_ID",
    "cancel_reason": "SELLER_CANCELED",
    "created_at": "2020-03-16T15:31:19.934Z",
    "deadline_duration": "PT10M",
    "device_options": {
      "device_id": "dbb5d83a-7838-11ea-bc55-0242ac130003",
      "skip_receipt_screen": true,
      "tip_settings": {
        "allow_tipping": true
      }
    },
    "id": "S1yDlPQx7slqO",
    "reference_id": "id36815",
    "status": "CANCELED",
    "updated_at": "2020-03-16T15:31:45.787Z"
  }
}
```

