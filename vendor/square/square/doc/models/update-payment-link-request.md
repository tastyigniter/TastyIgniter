
# Update Payment Link Request

## Structure

`UpdatePaymentLinkRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `paymentLink` | [`PaymentLink`](../../doc/models/payment-link.md) | Required | - | getPaymentLink(): PaymentLink | setPaymentLink(PaymentLink paymentLink): void |

## Example (as JSON)

```json
{
  "payment_link": {
    "checkout_options": {
      "ask_for_shipping_address": true
    },
    "version": 1
  }
}
```

