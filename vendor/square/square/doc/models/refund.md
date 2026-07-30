
# Refund

Represents a refund processed for a Square transaction.

## Structure

`Refund`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `string` | Required | The refund's unique ID.<br>**Constraints**: *Maximum Length*: `255` | getId(): string | setId(string id): void |
| `locationId` | `string` | Required | The ID of the refund's associated location.<br>**Constraints**: *Maximum Length*: `50` | getLocationId(): string | setLocationId(string locationId): void |
| `transactionId` | `?string` | Optional | The ID of the transaction that the refunded tender is part of.<br>**Constraints**: *Maximum Length*: `192` | getTransactionId(): ?string | setTransactionId(?string transactionId): void |
| `tenderId` | `string` | Required | The ID of the refunded tender.<br>**Constraints**: *Maximum Length*: `192` | getTenderId(): string | setTenderId(string tenderId): void |
| `createdAt` | `?string` | Optional | The timestamp for when the refund was created, in RFC 3339 format.<br>**Constraints**: *Maximum Length*: `32` | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `reason` | `string` | Required | The reason for the refund being issued.<br>**Constraints**: *Maximum Length*: `192` | getReason(): string | setReason(string reason): void |
| `amountMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): Money | setAmountMoney(Money amountMoney): void |
| `status` | [`string (RefundStatus)`](../../doc/models/refund-status.md) | Required | Indicates a refund's current status. | getStatus(): string | setStatus(string status): void |
| `processingFeeMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getProcessingFeeMoney(): ?Money | setProcessingFeeMoney(?Money processingFeeMoney): void |
| `additionalRecipients` | [`?(AdditionalRecipient[])`](../../doc/models/additional-recipient.md) | Optional | Additional recipients (other than the merchant) receiving a portion of this refund.<br>For example, fees assessed on a refund of a purchase by a third party integration. | getAdditionalRecipients(): ?array | setAdditionalRecipients(?array additionalRecipients): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "location_id": "location_id4",
  "transaction_id": "transaction_id8",
  "tender_id": "tender_id8",
  "created_at": "created_at2",
  "reason": "reason4",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "status": "PENDING",
  "processing_fee_money": {
    "amount": 112,
    "currency": "XBB"
  },
  "additional_recipients": [
    {
      "location_id": "location_id3",
      "description": "description9",
      "amount_money": {
        "amount": 83,
        "currency": "ALL"
      },
      "receivable_id": "receivable_id9"
    },
    {
      "location_id": "location_id4",
      "description": "description0",
      "amount_money": {
        "amount": 84,
        "currency": "AMD"
      },
      "receivable_id": "receivable_id0"
    },
    {
      "location_id": "location_id5",
      "description": "description1",
      "amount_money": {
        "amount": 85,
        "currency": "ANG"
      },
      "receivable_id": "receivable_id1"
    }
  ]
}
```

