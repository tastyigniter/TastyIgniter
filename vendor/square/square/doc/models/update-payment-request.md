
# Update Payment Request

Describes a request to update a payment using
[UpdatePayment](../../doc/apis/payments.md#update-payment).

## Structure

`UpdatePaymentRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `payment` | [`?Payment`](../../doc/models/payment.md) | Optional | Represents a payment processed by the Square API. | getPayment(): ?Payment | setPayment(?Payment payment): void |
| `idempotencyKey` | `string` | Required | A unique string that identifies this `UpdatePayment` request. Keys can be any valid string<br>but must be unique for every `UpdatePayment` request.<br><br>For more information, see [Idempotency](https://developer.squareup.com/docs/basics/api101/idempotency).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `45` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |

## Example (as JSON)

```json
{
  "idempotency_key": "956f8b13-e4ec-45d6-85e8-d1d95ef0c5de",
  "payment": {
    "amount_money": {
      "amount": 1000,
      "currency": "USD"
    },
    "tip_money": {
      "amount": 100,
      "currency": "USD"
    },
    "version_token": "ODhwVQ35xwlzRuoZEwKXucfu7583sPTzK48c5zoGd0g6o"
  }
}
```

