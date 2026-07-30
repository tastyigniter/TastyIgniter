
# Order Line Item Applied Discount

Represents an applied portion of a discount to a line item in an order.

Order scoped discounts have automatically applied discounts present for each line item.
Line-item scoped discounts must have applied discounts added manually for any applicable line
items. The corresponding applied money is automatically computed based on participating
line items.

## Structure

`OrderLineItemAppliedDiscount`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID that identifies the applied discount only within this order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `discountUid` | `string` | Required | The `uid` of the discount that the applied discount represents. It must<br>reference a discount present in the `order.discounts` field.<br><br>This field is immutable. To change which discounts apply to a line item,<br>you must delete the discount and re-add it as a new `OrderLineItemAppliedDiscount`.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `60` | getDiscountUid(): string | setDiscountUid(string discountUid): void |
| `appliedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAppliedMoney(): ?Money | setAppliedMoney(?Money appliedMoney): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "discount_uid": "discount_uid4",
  "applied_money": {
    "amount": 196,
    "currency": "PLN"
  }
}
```

