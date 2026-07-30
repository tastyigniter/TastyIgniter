
# Order Fulfillment Fulfillment Line Item Application

The `line_item_application` describes what order line items this fulfillment applies
to. It can be `ALL` or `ENTRY_LIST` with a supplied list of fulfillment entries.

## Enumeration

`OrderFulfillmentFulfillmentLineItemApplication`

## Fields

| Name | Description |
|  --- | --- |
| `ALL` | If `ALL`, `entries` must be unset. |
| `ENTRY_LIST` | If `ENTRY_LIST`, supply a list of `entries`. |

