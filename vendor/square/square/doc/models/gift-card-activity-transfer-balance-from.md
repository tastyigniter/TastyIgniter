
# Gift Card Activity Transfer Balance From

Represents details about a `TRANSFER_BALANCE_FROM` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityTransferBalanceFrom`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `transferToGiftCardId` | `string` | Required | The ID of the gift card to which the specified amount was transferred. | getTransferToGiftCardId(): string | setTransferToGiftCardId(string transferToGiftCardId): void |
| `amountMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): Money | setAmountMoney(Money amountMoney): void |

## Example (as JSON)

```json
{
  "transfer_to_gift_card_id": "transfer_to_gift_card_id6",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  }
}
```

