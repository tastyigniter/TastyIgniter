
# Catalog Discount

A discount applicable to items.

## Structure

`CatalogDiscount`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The discount name. This is a searchable attribute for use in applicable query filters, and its value length is of Unicode code points.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |
| `discountType` | [`?string (CatalogDiscountType)`](../../doc/models/catalog-discount-type.md) | Optional | How to apply a CatalogDiscount to a CatalogItem. | getDiscountType(): ?string | setDiscountType(?string discountType): void |
| `percentage` | `?string` | Optional | The percentage of the discount as a string representation of a decimal number, using a `.` as the decimal<br>separator and without a `%` sign. A value of `7.5` corresponds to `7.5%`. Specify a percentage of `0` if `discount_type`<br>is `VARIABLE_PERCENTAGE`.<br><br>Do not use this field for amount-based or variable discounts. | getPercentage(): ?string | setPercentage(?string percentage): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `pinRequired` | `?bool` | Optional | Indicates whether a mobile staff member needs to enter their PIN to apply the<br>discount to a payment in the Square Point of Sale app. | getPinRequired(): ?bool | setPinRequired(?bool pinRequired): void |
| `labelColor` | `?string` | Optional | The color of the discount display label in the Square Point of Sale app. This must be a valid hex color code. | getLabelColor(): ?string | setLabelColor(?string labelColor): void |
| `modifyTaxBasis` | [`?string (CatalogDiscountModifyTaxBasis)`](../../doc/models/catalog-discount-modify-tax-basis.md) | Optional | - | getModifyTaxBasis(): ?string | setModifyTaxBasis(?string modifyTaxBasis): void |
| `maximumAmountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getMaximumAmountMoney(): ?Money | setMaximumAmountMoney(?Money maximumAmountMoney): void |

## Example (as JSON)

```json
{
  "object": {
    "discount_data": {
      "discount_type": "FIXED_PERCENTAGE",
      "label_color": "red",
      "name": "Welcome to the Dark(Roast) Side!",
      "percentage": "5.4",
      "pin_required": false
    },
    "id": "#Maythe4th",
    "present_at_all_locations": true,
    "type": "DISCOUNT"
  }
}
```

