
# V1 Update Order Request

V1UpdateOrderRequest

## Structure

`V1UpdateOrderRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `action` | [`string (V1UpdateOrderRequestAction)`](../../doc/models/v1-update-order-request-action.md) | Required | - | getAction(): string | setAction(string action): void |
| `shippedTrackingNumber` | `?string` | Optional | The tracking number of the shipment associated with the order. Only valid if action is COMPLETE. | getShippedTrackingNumber(): ?string | setShippedTrackingNumber(?string shippedTrackingNumber): void |
| `completedNote` | `?string` | Optional | A merchant-specified note about the completion of the order. Only valid if action is COMPLETE. | getCompletedNote(): ?string | setCompletedNote(?string completedNote): void |
| `refundedNote` | `?string` | Optional | A merchant-specified note about the refunding of the order. Only valid if action is REFUND. | getRefundedNote(): ?string | setRefundedNote(?string refundedNote): void |
| `canceledNote` | `?string` | Optional | A merchant-specified note about the canceling of the order. Only valid if action is CANCEL. | getCanceledNote(): ?string | setCanceledNote(?string canceledNote): void |

## Example (as JSON)

```json
{
  "action": "COMPLETE",
  "shipped_tracking_number": "shipped_tracking_number0",
  "completed_note": "completed_note0",
  "refunded_note": "refunded_note4",
  "canceled_note": "canceled_note0"
}
```

