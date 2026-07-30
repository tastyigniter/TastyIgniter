
# Order Fulfillment Updated Object

## Structure

`OrderFulfillmentUpdatedObject`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `orderFulfillmentUpdated` | [`?OrderFulfillmentUpdated`](../../doc/models/order-fulfillment-updated.md) | Optional | - | getOrderFulfillmentUpdated(): ?OrderFulfillmentUpdated | setOrderFulfillmentUpdated(?OrderFulfillmentUpdated orderFulfillmentUpdated): void |

## Example (as JSON)

```json
{
  "order_fulfillment_updated": {
    "order_id": "order_id8",
    "version": 174,
    "location_id": "location_id8",
    "state": "CANCELED",
    "created_at": "created_at2",
    "updated_at": "updated_at0",
    "fulfillment_update": [
      {
        "fulfillment_uid": "fulfillment_uid0",
        "old_state": "PREPARED",
        "new_state": "PROPOSED"
      }
    ]
  }
}
```

