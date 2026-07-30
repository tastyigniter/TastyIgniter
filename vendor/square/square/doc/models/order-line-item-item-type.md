
# Order Line Item Item Type

Represents the line item type.

## Enumeration

`OrderLineItemItemType`

## Fields

| Name | Description |
|  --- | --- |
| `ITEM` | Indicates that the line item is an itemized sale. |
| `CUSTOM_AMOUNT` | Indicates that the line item is a non-itemized sale. |
| `GIFT_CARD` | Indicates that the line item is a gift card sale. Gift cards sold through<br>the Orders API are sold in an unactivated state and can be activated through the<br>Gift Cards API using the line item `uid`. |

