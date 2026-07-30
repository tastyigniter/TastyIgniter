
# Gift Card Activity Redeem

Represents details about a `REDEEM` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityRedeem`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `amountMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): Money | setAmountMoney(Money amountMoney): void |
| `paymentId` | `?string` | Optional | The ID of the payment that represents the gift card redemption. Square populates this field<br>if the payment was processed by Square. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |
| `referenceId` | `?string` | Optional | A client-specified ID that associates the gift card activity with an entity in another system.<br><br>Applications that use a custom payment processing system can use this field to track information<br>related to an order or payment. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `status` | [`?string (GiftCardActivityRedeemStatus)`](../../doc/models/gift-card-activity-redeem-status.md) | Optional | Indicates the status of a [gift card](../../doc/models/gift-card.md) redemption. This status is relevant only for<br>redemptions made from Square products (such as Square Point of Sale) because Square products use a<br>two-state process. Gift cards redeemed using the Gift Card Activities API always have a `COMPLETED` status. | getStatus(): ?string | setStatus(?string status): void |

## Example (as JSON)

```json
{
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "payment_id": "payment_id0",
  "reference_id": "reference_id2",
  "status": "CANCELED"
}
```

