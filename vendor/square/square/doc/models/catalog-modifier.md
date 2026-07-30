
# Catalog Modifier

A modifier applicable to items at the time of sale.

## Structure

`CatalogModifier`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The modifier name.  This is a searchable attribute for use in applicable query filters, and its value length is of Unicode code points.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |
| `priceMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getPriceMoney(): ?Money | setPriceMoney(?Money priceMoney): void |
| `ordinal` | `?int` | Optional | Determines where this `CatalogModifier` appears in the `CatalogModifierList`. | getOrdinal(): ?int | setOrdinal(?int ordinal): void |
| `modifierListId` | `?string` | Optional | The ID of the `CatalogModifierList` associated with this modifier. | getModifierListId(): ?string | setModifierListId(?string modifierListId): void |
| `imageId` | `?string` | Optional | The ID of the image associated with this `CatalogModifier` instance.<br>Currently this image is not displayed by Square, but is free to be displayed in 3rd party applications. | getImageId(): ?string | setImageId(?string imageId): void |

## Example (as JSON)

```json
{
  "object": {
    "modifier_data": {
      "name": "Almond Milk",
      "price_money": {
        "amount": 250,
        "currency": "USD"
      }
    },
    "present_at_all_locations": true,
    "type": "MODIFIER"
  }
}
```

