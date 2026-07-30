
# Shipping Fee

## Structure

`ShippingFee`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The name for the shipping fee. | getName(): ?string | setName(?string name): void |
| `charge` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getCharge(): Money | setCharge(Money charge): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "charge": {
    "amount": 80,
    "currency": "CUC"
  }
}
```

