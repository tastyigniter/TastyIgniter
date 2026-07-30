
# Inventory Count

Represents Square-estimated quantity of items in a particular state at a
particular seller location based on the known history of physical counts and
inventory adjustments.

## Structure

`InventoryCount`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `catalogObjectId` | `?string` | Optional | The Square-generated ID of the<br>[CatalogObject](entity:CatalogObject) being tracked.<br>**Constraints**: *Maximum Length*: `100` | getCatalogObjectId(): ?string | setCatalogObjectId(?string catalogObjectId): void |
| `catalogObjectType` | `?string` | Optional | The [type](entity:CatalogObjectType) of the [CatalogObject](entity:CatalogObject) being tracked.<br><br>The Inventory API supports setting and reading the `"catalog_object_type": "ITEM_VARIATION"` field value.<br>In addition, it can also read the `"catalog_object_type": "ITEM"` field value that is set by the Square Restaurants app.<br>**Constraints**: *Maximum Length*: `14` | getCatalogObjectType(): ?string | setCatalogObjectType(?string catalogObjectType): void |
| `state` | [`?string (InventoryState)`](../../doc/models/inventory-state.md) | Optional | Indicates the state of a tracked item quantity in the lifecycle of goods. | getState(): ?string | setState(?string state): void |
| `locationId` | `?string` | Optional | The Square-generated ID of the [Location](entity:Location) where the related<br>quantity of items is being tracked.<br>**Constraints**: *Maximum Length*: `100` | getLocationId(): ?string | setLocationId(?string locationId): void |
| `quantity` | `?string` | Optional | The number of items affected by the estimated count as a decimal string.<br>Can support up to 5 digits after the decimal point.<br>**Constraints**: *Maximum Length*: `26` | getQuantity(): ?string | setQuantity(?string quantity): void |
| `calculatedAt` | `?string` | Optional | An RFC 3339-formatted timestamp that indicates when the most recent physical count or adjustment affecting<br>the estimated count is received.<br>**Constraints**: *Maximum Length*: `34` | getCalculatedAt(): ?string | setCalculatedAt(?string calculatedAt): void |
| `isEstimated` | `?bool` | Optional | Whether the inventory count is for composed variation (TRUE) or not (FALSE). If true, the inventory count will not be present in the response of<br>any of these endpoints: [BatchChangeInventory](../../doc/apis/inventory.md#batch-change-inventory),<br>[BatchRetrieveInventoryChanges](../../doc/apis/inventory.md#batch-retrieve-inventory-changes),<br>[BatchRetrieveInventoryCounts](../../doc/apis/inventory.md#batch-retrieve-inventory-counts), and<br>[RetrieveInventoryChanges](../../doc/apis/inventory.md#retrieve-inventory-changes). | getIsEstimated(): ?bool | setIsEstimated(?bool isEstimated): void |

## Example (as JSON)

```json
{
  "catalog_object_id": "catalog_object_id6",
  "catalog_object_type": "catalog_object_type6",
  "state": "SUPPORTED_BY_NEWER_VERSION",
  "location_id": "location_id4",
  "quantity": "quantity6",
  "calculated_at": "calculated_at2",
  "is_estimated": false
}
```

