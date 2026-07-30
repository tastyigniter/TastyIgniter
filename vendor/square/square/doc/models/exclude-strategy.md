
# Exclude Strategy

Indicates which products matched by a CatalogPricingRule
will be excluded if the pricing rule uses an exclude set.

## Enumeration

`ExcludeStrategy`

## Fields

| Name | Description |
|  --- | --- |
| `LEAST_EXPENSIVE` | The least expensive matched products are excluded from the pricing. If<br>the pricing rule is set to exclude one product and multiple products in the<br>match set qualify as least expensive, then one will be excluded at random.<br><br>Excluding the least expensive product gives the best discount value to the buyer. |
| `MOST_EXPENSIVE` | The most expensive matched product is excluded from the pricing rule.<br>If multiple products have the same price and all qualify as least expensive,<br>one will be excluded at random.<br><br>This guarantees that the most expensive product is purchased at full price. |

