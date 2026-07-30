
# Batch Retrieve Orders Response

Defines the fields that are included in the response body of
a request to the `BatchRetrieveOrders` endpoint.

## Structure

`BatchRetrieveOrdersResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `orders` | [`?(Order[])`](../../doc/models/order.md) | Optional | The requested orders. This will omit any requested orders that do not exist. | getOrders(): ?array | setOrders(?array orders): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "orders": [
    {
      "id": "CAISEM82RcpmcFBM0TfOyiHV3es",
      "line_items": [
        {
          "base_price_money": {
            "amount": 1599,
            "currency": "USD"
          },
          "name": "Awesome product",
          "quantity": "1",
          "total_money": {
            "amount": 1599,
            "currency": "USD"
          },
          "uid": "945986d1-9586-11e6-ad5a-28cfe92138cf"
        },
        {
          "base_price_money": {
            "amount": 2000,
            "currency": "USD"
          },
          "name": "Another awesome product",
          "quantity": "3",
          "total_money": {
            "amount": 6000,
            "currency": "USD"
          },
          "uid": "a8f4168c-9586-11e6-bdf0-28cfe92138cf"
        }
      ],
      "location_id": "057P5VYJ4A5X1",
      "reference_id": "my-order-001",
      "total_money": {
        "amount": 7599,
        "currency": "USD"
      }
    }
  ]
}
```

