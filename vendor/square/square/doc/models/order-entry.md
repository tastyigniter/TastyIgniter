
# Order Entry

A lightweight description of an [order](../../doc/models/order.md) that is returned when
`returned_entries` is `true` on a [SearchOrdersRequest](../../doc/apis/orders.md#search-orders).

## Structure

`OrderEntry`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `orderId` | `?string` | Optional | The ID of the order. | getOrderId(): ?string | setOrderId(?string orderId): void |
| `version` | `?int` | Optional | The version number, which is incremented each time an update is committed to the order.<br>Orders that were not created through the API do not include a version number and<br>therefore cannot be updated.<br><br>[Read more about working with versions.](https://developer.squareup.com/docs/orders-api/manage-orders/update-orders) | getVersion(): ?int | setVersion(?int version): void |
| `locationId` | `?string` | Optional | The location ID the order belongs to. | getLocationId(): ?string | setLocationId(?string locationId): void |

## Example (as JSON)

```json
{
  "order_id": "order_id6",
  "version": 172,
  "location_id": "location_id4"
}
```

