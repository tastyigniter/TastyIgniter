
# Gift Card Activity Import

Represents details about an `IMPORT` [gift card activity type](../../doc/models/gift-card-activity-type.md).
This activity type is used when Square imports a third-party gift card, in which case the
`gan_source` of the gift card is set to `OTHER`.

## Structure

`GiftCardActivityImport`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `amountMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): Money | setAmountMoney(Money amountMoney): void |

## Example (as JSON)

```json
{
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  }
}
```

