
# Quick Pay

Describes an ad hoc item and price to generate a quick pay checkout link.
For more information,
see [Quick Pay Checkout](https://developer.squareup.com/docs/checkout-api/quick-pay-checkout).

## Structure

`QuickPay`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `string` | Required | The ad hoc item name. In the resulting `Order`, this name appears as the line item name.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getName(): string | setName(string name): void |
| `priceMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getPriceMoney(): Money | setPriceMoney(Money priceMoney): void |
| `locationId` | `string` | Required | The ID of the business location the checkout is associated with. | getLocationId(): string | setLocationId(string locationId): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "price_money": {
    "amount": 202,
    "currency": "BBD"
  },
  "location_id": "location_id4"
}
```

