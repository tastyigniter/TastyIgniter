
# Update Payment Link Response

## Structure

`UpdatePaymentLinkResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred when updating the payment link. | getErrors(): ?array | setErrors(?array errors): void |
| `paymentLink` | [`?PaymentLink`](../../doc/models/payment-link.md) | Optional | - | getPaymentLink(): ?PaymentLink | setPaymentLink(?PaymentLink paymentLink): void |

## Example (as JSON)

```json
{
  "payment_link": {
    "checkout_options": {
      "ask_for_shipping_address": true
    },
    "created_at": "2022-04-26T00:15:15Z",
    "id": "TY4BWEDJ6AI5MBIV",
    "long_url": "https://checkout.square.site/EXAMPLE",
    "order_id": "Qqc8ypQGvxVwc46Cch4zHTaJqc4F",
    "payment_note": "test",
    "updated_at": "2022-04-26T00:18:24Z",
    "url": "https://square.link/u/EXAMPLE",
    "version": 2
  }
}
```

