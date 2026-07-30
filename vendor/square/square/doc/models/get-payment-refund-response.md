
# Get Payment Refund Response

Defines the response returned by [GetRefund](../../doc/apis/refunds.md#get-payment-refund).

Note: If there are errors processing the request, the refund field might not be
present or it might be present in a FAILED state.

## Structure

`GetPaymentRefundResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `refund` | [`?PaymentRefund`](../../doc/models/payment-refund.md) | Optional | Represents a refund of a payment made using Square. Contains information about<br>the original payment and the amount of money refunded. | getRefund(): ?PaymentRefund | setRefund(?PaymentRefund refund): void |

## Example (as JSON)

```json
{
  "refund": {
    "amount_money": {
      "amount": 555,
      "currency": "USD"
    },
    "created_at": "2021-10-13T19:59:05.073Z",
    "id": "bP9mAsEMYPUGjjGNaNO5ZDVyLhSZY_69MmgHubkLqx9wGhnmenRUHOaKitE6llfZuxcWYjGxd",
    "location_id": "L88917AVBK2S5",
    "order_id": "9ltv0bx5PuvGXUYHYHxYSKEqC3IZY",
    "payment_id": "bP9mAsEMYPUGjjGNaNO5ZDVyLhSZY",
    "processing_fee": [
      {
        "amount_money": {
          "amount": -34,
          "currency": "USD"
        },
        "effective_at": "2021-10-13T21:34:35.000Z",
        "type": "INITIAL"
      }
    ],
    "reason": "Example Refund",
    "status": "COMPLETED",
    "updated_at": "2021-10-13T20:00:02.442Z"
  }
}
```

