
# Terminal Refund

Represents a payment refund processed by the Square Terminal. Only supports Interac (Canadian debit network) payment refunds.

## Structure

`TerminalRefund`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A unique ID for this `TerminalRefund`.<br>**Constraints**: *Minimum Length*: `10`, *Maximum Length*: `255` | getId(): ?string | setId(?string id): void |
| `refundId` | `?string` | Optional | The reference to the payment refund created by completing this `TerminalRefund`. | getRefundId(): ?string | setRefundId(?string refundId): void |
| `paymentId` | `string` | Required | The unique ID of the payment being refunded.<br>**Constraints**: *Minimum Length*: `1` | getPaymentId(): string | setPaymentId(string paymentId): void |
| `orderId` | `?string` | Optional | The reference to the Square order ID for the payment identified by the `payment_id`. | getOrderId(): ?string | setOrderId(?string orderId): void |
| `amountMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): Money | setAmountMoney(Money amountMoney): void |
| `reason` | `string` | Required | A description of the reason for the refund.<br>**Constraints**: *Maximum Length*: `192` | getReason(): string | setReason(string reason): void |
| `deviceId` | `string` | Required | The unique ID of the device intended for this `TerminalRefund`.<br>The Id can be retrieved from /v2/devices api. | getDeviceId(): string | setDeviceId(string deviceId): void |
| `deadlineDuration` | `?string` | Optional | The RFC 3339 duration, after which the refund is automatically canceled.<br>A `TerminalRefund` that is `PENDING` is automatically `CANCELED` and has a cancellation reason<br>of `TIMED_OUT`.<br><br>Default: 5 minutes from creation.<br><br>Maximum: 5 minutes | getDeadlineDuration(): ?string | setDeadlineDuration(?string deadlineDuration): void |
| `status` | `?string` | Optional | The status of the `TerminalRefund`.<br>Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, or `COMPLETED`. | getStatus(): ?string | setStatus(?string status): void |
| `cancelReason` | [`?string (ActionCancelReason)`](../../doc/models/action-cancel-reason.md) | Optional | - | getCancelReason(): ?string | setCancelReason(?string cancelReason): void |
| `createdAt` | `?string` | Optional | The time when the `TerminalRefund` was created, as an RFC 3339 timestamp. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The time when the `TerminalRefund` was last updated, as an RFC 3339 timestamp. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `appId` | `?string` | Optional | The ID of the application that created the refund. | getAppId(): ?string | setAppId(?string appId): void |
| `locationId` | `?string` | Optional | The location of the device where the `TerminalRefund` was directed. | getLocationId(): ?string | setLocationId(?string locationId): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "refund_id": "refund_id4",
  "payment_id": "payment_id0",
  "order_id": "order_id6",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "reason": "reason4",
  "device_id": "device_id6",
  "deadline_duration": "deadline_duration8",
  "status": "status8",
  "cancel_reason": "SELLER_CANCELED",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "app_id": "app_id6",
  "location_id": "location_id4"
}
```

