
# Order Line Item Discount Scope

Indicates whether this is a line-item or order-level discount.

## Enumeration

`OrderLineItemDiscountScope`

## Fields

| Name | Description |
|  --- | --- |
| `OTHER_DISCOUNT_SCOPE` | Used for reporting only.<br>The original transaction discount scope is currently not supported by the API. |
| `LINE_ITEM` | The discount should be applied to only line items specified by<br>`OrderLineItemAppliedDiscount` reference records. |
| `ORDER` | The discount should be applied to the entire order. |

