
# Order Return Line Item Modifier

A line item modifier being returned.

## Structure

`OrderReturnLineItemModifier`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID that identifies the return modifier only within this order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `sourceModifierUid` | `?string` | Optional | The modifier `uid` from the order's line item that contains the<br>original sale of this line item modifier.<br>**Constraints**: *Maximum Length*: `60` | getSourceModifierUid(): ?string | setSourceModifierUid(?string sourceModifierUid): void |
| `catalogObjectId` | `?string` | Optional | The catalog object ID referencing [CatalogModifier](entity:CatalogModifier).<br>**Constraints**: *Maximum Length*: `192` | getCatalogObjectId(): ?string | setCatalogObjectId(?string catalogObjectId): void |
| `catalogVersion` | `?int` | Optional | The version of the catalog object that this line item modifier references. | getCatalogVersion(): ?int | setCatalogVersion(?int catalogVersion): void |
| `name` | `?string` | Optional | The name of the item modifier.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |
| `basePriceMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getBasePriceMoney(): ?Money | setBasePriceMoney(?Money basePriceMoney): void |
| `totalPriceMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalPriceMoney(): ?Money | setTotalPriceMoney(?Money totalPriceMoney): void |
| `quantity` | `?string` | Optional | The quantity of the line item modifier. The modifier quantity can be 0 or more.<br>For example, suppose a restaurant offers a cheeseburger on the menu. When a buyer orders<br>this item, the restaurant records the purchase by creating an `Order` object with a line item<br>for a burger. The line item includes a line item modifier: the name is cheese and the quantity<br>is 1. The buyer has the option to order extra cheese (or no cheese). If the buyer chooses<br>the extra cheese option, the modifier quantity increases to 2. If the buyer does not want<br>any cheese, the modifier quantity is set to 0. | getQuantity(): ?string | setQuantity(?string quantity): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "source_modifier_uid": "source_modifier_uid6",
  "catalog_object_id": "catalog_object_id6",
  "catalog_version": 126,
  "name": "name0",
  "base_price_money": {
    "amount": 114,
    "currency": "ALL"
  },
  "total_price_money": {
    "amount": 52,
    "currency": "MYR"
  },
  "quantity": "quantity6"
}
```

