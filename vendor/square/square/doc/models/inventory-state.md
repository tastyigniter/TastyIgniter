
# Inventory State

Indicates the state of a tracked item quantity in the lifecycle of goods.

## Enumeration

`InventoryState`

## Fields

| Name | Description |
|  --- | --- |
| `CUSTOM` | The related quantity of items are in a custom state. **READ-ONLY**:<br>the Inventory API cannot move quantities to or from this state. |
| `IN_STOCK` | The related quantity of items are on hand and available for sale. |
| `SOLD` | The related quantity of items were sold as part of an itemized<br>transaction. Quantities in the `SOLD` state are no longer tracked. |
| `RETURNED_BY_CUSTOMER` | The related quantity of items were returned through the Square Point<br>of Sale application, but are not yet available for sale. **READ-ONLY**:<br>the Inventory API cannot move quantities to or from this state. |
| `RESERVED_FOR_SALE` | The related quantity of items are on hand, but not currently<br>available for sale. **READ-ONLY**: the Inventory API cannot move<br>quantities to or from this state. |
| `SOLD_ONLINE` | The related quantity of items were sold online. **READ-ONLY**: the<br>Inventory API cannot move quantities to or from this state. |
| `ORDERED_FROM_VENDOR` | The related quantity of items were ordered from a vendor but not yet<br>received. **READ-ONLY**: the Inventory API cannot move quantities to or<br>from this state. |
| `RECEIVED_FROM_VENDOR` | The related quantity of items were received from a vendor but are<br>not yet available for sale. **READ-ONLY**: the Inventory API cannot move<br>quantities to or from this state. |
| `IN_TRANSIT_TO` | The related quantity of items are in transit between locations.<br>*READ-ONLY**: the Inventory API cannot move quantities to or from this<br>state. |
| `NONE` | A placeholder indicating that the related quantity of items are not<br>currently tracked in Square. Transferring quantities from the `NONE` state<br>to a tracked state (e.g., `IN_STOCK`) introduces stock into the system. |
| `WASTE` | The related quantity of items are lost or damaged and cannot be<br>sold. |
| `UNLINKED_RETURN` | The related quantity of items were returned but not linked to a<br>previous transaction. Unlinked returns are not tracked in Square.<br>Transferring a quantity from `UNLINKED_RETURN` to a tracked state (e.g.,<br>`IN_STOCK`) introduces new stock into the system. |
| `COMPOSED` | The related quantity of items that are part of a composition consisting one or more components. |
| `DECOMPOSED` | The related quantity of items that are part of a component. |
| `SUPPORTED_BY_NEWER_VERSION` | This state is not supported by this version of the Square API. We recommend that you upgrade the client to use the appropriate version of the Square API supporting this state. |

