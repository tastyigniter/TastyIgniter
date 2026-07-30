
# Search Orders Response

Either the `order_entries` or `orders` field is set, depending on whether
`return_entries` is set on the [SearchOrdersRequest](../../doc/apis/orders.md#search-orders).

## Structure

`SearchOrdersResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `orderEntries` | [`?(OrderEntry[])`](../../doc/models/order-entry.md) | Optional | A list of [OrderEntries](entity:OrderEntry) that fit the query<br>conditions. The list is populated only if `return_entries` is set to `true` in the request. | getOrderEntries(): ?array | setOrderEntries(?array orderEntries): void |
| `orders` | [`?(Order[])`](../../doc/models/order.md) | Optional | A list of<br>[Order](entity:Order) objects that match the query conditions. The list is populated only if<br>`return_entries` is set to `false` in the request. | getOrders(): ?array | setOrders(?array orders): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request. If unset,<br>this is the final response.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | [Errors](entity:Error) encountered during the search. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "cursor": "123",
  "order_entries": [
    {
      "location_id": "057P5VYJ4A5X1",
      "order_id": "CAISEM82RcpmcFBM0TfOyiHV3es",
      "version": 1
    },
    {
      "location_id": "18YC4JDH91E1H",
      "order_id": "CAISENgvlJ6jLWAzERDzjyHVybY"
    },
    {
      "location_id": "057P5VYJ4A5X1",
      "order_id": "CAISEM52YcpmcWAzERDOyiWS3ty"
    }
  ]
}
```

