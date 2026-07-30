
# Tax Inclusion Type

Whether to the tax amount should be additional to or included in the CatalogItem price.

## Enumeration

`TaxInclusionType`

## Fields

| Name | Description |
|  --- | --- |
| `ADDITIVE` | The tax is an additive tax. The tax amount is added on top of the<br>CatalogItemVariation price. For example, a $1.00 item with a 10% additive<br>tax would have a total cost to the buyer of $1.10. |
| `INCLUSIVE` | The tax is an inclusive tax. The tax amount is included in the<br>CatalogItemVariation price. For example, a $1.00 item with a 10% inclusive<br>tax would have a total cost to the buyer of $1.00, with $0.91 (91 cents) of<br>that total being the cost of the item and $0.09 (9 cents) being tax. |

