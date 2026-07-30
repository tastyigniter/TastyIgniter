
# Gift Card Activity Unlinked Activity Refund

Represents details about an `UNLINKED_ACTIVITY_REFUND` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityUnlinkedActivityRefund`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `amountMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): Money | setAmountMoney(Money amountMoney): void |
| `referenceId` | `?string` | Optional | A client-specified ID that associates the gift card activity with an entity in another system. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `paymentId` | `?string` | Optional | The ID of the refunded payment. This field is not used starting in Square version 2022-06-16. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |

## Example (as JSON)

```json
{
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "reference_id": "reference_id2",
  "payment_id": "payment_id0"
}
```

