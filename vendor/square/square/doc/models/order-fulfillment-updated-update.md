
# Order Fulfillment Updated Update

Information about fulfillment updates.

## Structure

`OrderFulfillmentUpdatedUpdate`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `fulfillmentUid` | `?string` | Optional | A unique ID that identifies the fulfillment only within this order. | getFulfillmentUid(): ?string | setFulfillmentUid(?string fulfillmentUid): void |
| `oldState` | [`?string (FulfillmentState)`](../../doc/models/fulfillment-state.md) | Optional | The current state of this fulfillment. | getOldState(): ?string | setOldState(?string oldState): void |
| `newState` | [`?string (FulfillmentState)`](../../doc/models/fulfillment-state.md) | Optional | The current state of this fulfillment. | getNewState(): ?string | setNewState(?string newState): void |

## Example (as JSON)

```json
{
  "fulfillment_uid": "fulfillment_uid4",
  "old_state": "PREPARED",
  "new_state": "PREPARED"
}
```

