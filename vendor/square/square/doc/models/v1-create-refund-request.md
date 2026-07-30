
# V1 Create Refund Request

V1CreateRefundRequest

## Structure

`V1CreateRefundRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `paymentId` | `string` | Required | The ID of the payment to refund. If you are creating a `PARTIAL`<br>refund for a split tender payment, instead provide the id of the<br>particular tender you want to refund. | getPaymentId(): string | setPaymentId(string paymentId): void |
| `type` | [`string (V1CreateRefundRequestType)`](../../doc/models/v1-create-refund-request-type.md) | Required | - | getType(): string | setType(string type): void |
| `reason` | `string` | Required | The reason for the refund. | getReason(): string | setReason(string reason): void |
| `refundedMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedMoney(): ?V1Money | setRefundedMoney(?V1Money refundedMoney): void |
| `requestIdempotenceKey` | `?string` | Optional | An optional key to ensure idempotence if you issue the same PARTIAL refund request more than once. | getRequestIdempotenceKey(): ?string | setRequestIdempotenceKey(?string requestIdempotenceKey): void |

## Example (as JSON)

```json
{
  "payment_id": "payment_id0",
  "type": "FULL",
  "reason": "reason4",
  "refunded_money": {
    "amount": 214,
    "currency_code": "CHW"
  },
  "request_idempotence_key": "request_idempotence_key8"
}
```

