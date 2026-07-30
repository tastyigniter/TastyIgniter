
# Payment Balance Activity App Fee Refund Detail

## Structure

`PaymentBalanceActivityAppFeeRefundDetail`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `paymentId` | `?string` | Optional | The ID of the payment associated with this activity. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |
| `refundId` | `?string` | Optional | The ID of the refund associated with this activity. | getRefundId(): ?string | setRefundId(?string refundId): void |
| `locationId` | `?string` | Optional | The ID of the location of the merchant associated with the payment refund activity | getLocationId(): ?string | setLocationId(?string locationId): void |

## Example (as JSON)

```json
{
  "payment_id": "payment_id0",
  "refund_id": "refund_id4",
  "location_id": "location_id4"
}
```

