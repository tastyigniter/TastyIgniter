
# List Payment Links Response

## Structure

`ListPaymentLinksResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `paymentLinks` | [`?(PaymentLink[])`](../../doc/models/payment-link.md) | Optional | The list of payment links. | getPaymentLinks(): ?array | setPaymentLinks(?array paymentLinks): void |
| `cursor` | `?string` | Optional | When a response is truncated, it includes a cursor that you can use in a subsequent request<br>to retrieve the next set of gift cards. If a cursor is not present, this is the final response.<br>For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "cursor": "MTY1NQ==",
  "payment_links": [
    {
      "checkout_options": {
        "ask_for_shipping_address": true
      },
      "created_at": "2022-04-26T00:15:15Z",
      "id": "TN4BWEDJ9AI5MBIV",
      "order_id": "Qqc6yppGvxVwc46Cch4zHTaJqc4F",
      "payment_note": "test",
      "updated_at": "2022-04-26T00:18:24Z",
      "url": "https://square.link/u/EXAMPLE",
      "version": 2
    },
    {
      "created_at": "2022-04-11T23:14:59Z",
      "description": "",
      "id": "RY5UNCUMPJN5XKCT",
      "order_id": "EmBmGt3zJD15QeO1dxzBTxMxtwfZY",
      "url": "https://square.link/u/EXAMPLE",
      "version": 1
    }
  ]
}
```

