
# List Payment Refunds Response

Defines the response returned by [ListPaymentRefunds](../../doc/apis/refunds.md#list-payment-refunds).

Either `errors` or `refunds` is present in a given response (never both).

## Structure

`ListPaymentRefundsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `refunds` | [`?(PaymentRefund[])`](../../doc/models/payment-refund.md) | Optional | The list of requested refunds. | getRefunds(): ?array | setRefunds(?array refunds): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request. If empty,<br>this is the final response.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "cursor": "5evquW1YswHoT4EoyUhzMmTsCnsSXBU9U0WJ4FU4623nrMQcocH0RGU6Up1YkwfiMcF59ood58EBTEGgzMTGHQJpocic7ExOL0NtrTXCeWcv0UJIJNk8eXb",
  "refunds": [
    {
      "amount_money": {
        "amount": 555,
        "currency": "USD"
      },
      "created_at": "2021-10-13T19:59:05.342Z",
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
      "updated_at": "2021-10-13T20:00:03.497Z"
    }
  ]
}
```

