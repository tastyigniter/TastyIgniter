
# Order Fulfillment Updated

## Structure

`OrderFulfillmentUpdated`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `orderId` | `?string` | Optional | The order's unique ID. | getOrderId(): ?string | setOrderId(?string orderId): void |
| `version` | `?int` | Optional | The version number, which is incremented each time an update is committed to the order.<br>Orders that were not created through the API do not include a version number and<br>therefore cannot be updated.<br><br>[Read more about working with versions.](https://developer.squareup.com/docs/orders-api/manage-orders/update-orders) | getVersion(): ?int | setVersion(?int version): void |
| `locationId` | `?string` | Optional | The ID of the seller location that this order is associated with. | getLocationId(): ?string | setLocationId(?string locationId): void |
| `state` | [`?string (OrderState)`](../../doc/models/order-state.md) | Optional | The state of the order. | getState(): ?string | setState(?string state): void |
| `createdAt` | `?string` | Optional | The timestamp for when the order was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp for when the order was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `fulfillmentUpdate` | [`?(OrderFulfillmentUpdatedUpdate[])`](../../doc/models/order-fulfillment-updated-update.md) | Optional | The fulfillments that were updated with this version change. | getFulfillmentUpdate(): ?array | setFulfillmentUpdate(?array fulfillmentUpdate): void |

## Example (as JSON)

```json
{
  "order_id": "order_id6",
  "version": 172,
  "location_id": "location_id4",
  "state": "OPEN",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "fulfillment_update": [
    {
      "fulfillment_uid": "fulfillment_uid6",
      "old_state": "CANCELED",
      "new_state": "PREPARED"
    },
    {
      "fulfillment_uid": "fulfillment_uid7",
      "old_state": "FAILED",
      "new_state": "COMPLETED"
    },
    {
      "fulfillment_uid": "fulfillment_uid8",
      "old_state": "PROPOSED",
      "new_state": "CANCELED"
    }
  ]
}
```

