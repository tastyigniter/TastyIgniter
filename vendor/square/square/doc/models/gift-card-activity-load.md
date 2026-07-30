
# Gift Card Activity Load

Represents details about a `LOAD` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityLoad`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `orderId` | `?string` | Optional | The ID of the [order](entity:Order) that contains the `GIFT_CARD` line item.<br><br>Applications that use the Square Orders API to process orders must specify the order ID in the<br>[CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request. | getOrderId(): ?string | setOrderId(?string orderId): void |
| `lineItemUid` | `?string` | Optional | The UID of the `GIFT_CARD` line item in the order that represents the additional funds for the gift card.<br><br>Applications that use the Square Orders API to process orders must specify the line item UID<br>in the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request. | getLineItemUid(): ?string | setLineItemUid(?string lineItemUid): void |
| `referenceId` | `?string` | Optional | A client-specified ID that associates the gift card activity with an entity in another system.<br><br>Applications that use a custom order processing system can use this field to track information related to<br>an order or payment. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `buyerPaymentInstrumentIds` | `?(string[])` | Optional | The payment instrument IDs used to process the order for the additional funds, such as a credit card ID<br>or bank account ID.<br><br>Applications that use a custom order processing system must specify payment instrument IDs in<br>the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.<br>Square uses this information to perform compliance checks.<br><br>For applications that use the Square Orders API to process payments, Square has the necessary<br>instrument IDs to perform compliance checks. | getBuyerPaymentInstrumentIds(): ?array | setBuyerPaymentInstrumentIds(?array buyerPaymentInstrumentIds): void |

## Example (as JSON)

```json
{
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "order_id": "order_id6",
  "line_item_uid": "line_item_uid0",
  "reference_id": "reference_id2",
  "buyer_payment_instrument_ids": [
    "buyer_payment_instrument_ids6"
  ]
}
```

