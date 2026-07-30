
# Gift Card Activity Refund

Represents details about a `REFUND` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityRefund`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `redeemActivityId` | `?string` | Optional | The ID of the refunded `REDEEM` gift card activity. Square populates this field if the<br>`payment_id` in the corresponding [RefundPayment](api-endpoint:Refunds-RefundPayment) request<br>represents a redemption made by the same gift card. Note that you must use `RefundPayment`<br>to refund a gift card payment to the same gift card if the payment was processed by Square.<br><br>For applications that use a custom payment processing system, this field is required when creating<br>a `REFUND` activity. The provided `REDEEM` activity ID must be linked to the same gift card. | getRedeemActivityId(): ?string | setRedeemActivityId(?string redeemActivityId): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `referenceId` | `?string` | Optional | A client-specified ID that associates the gift card activity with an entity in another system. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `paymentId` | `?string` | Optional | The ID of the refunded payment. Square populates this field if the refund is for a<br>payment processed by Square and one of the following conditions is true:<br><br>- The Refunds API is used to refund a gift card payment to the same gift card.<br>- A seller initiated the refund from Square Point of Sale or the Seller Dashboard. The payment source can be the<br>  same gift card or a cross-tender payment from a credit card or a different gift card. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |

## Example (as JSON)

```json
{
  "redeem_activity_id": "redeem_activity_id0",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "reference_id": "reference_id2",
  "payment_id": "payment_id0"
}
```

