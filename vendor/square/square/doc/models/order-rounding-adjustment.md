
# Order Rounding Adjustment

A rounding adjustment of the money being returned. Commonly used to apply cash rounding
when the minimum unit of the account is smaller than the lowest physical denomination of the currency.

## Structure

`OrderRoundingAdjustment`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID that identifies the rounding adjustment only within this order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `name` | `?string` | Optional | The name of the rounding adjustment from the original sale order. | getName(): ?string | setName(?string name): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "name": "name0",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  }
}
```

