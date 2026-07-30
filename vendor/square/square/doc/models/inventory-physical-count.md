
# Inventory Physical Count

Represents the quantity of an item variation that is physically present
at a specific location, verified by a seller or a seller's employee. For example,
a physical count might come from an employee counting the item variations on
hand or from syncing with an external system.

## Structure

`InventoryPhysicalCount`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A unique Square-generated ID for the<br>[InventoryPhysicalCount](entity:InventoryPhysicalCount).<br>**Constraints**: *Maximum Length*: `100` | getId(): ?string | setId(?string id): void |
| `referenceId` | `?string` | Optional | An optional ID provided by the application to tie the<br>[InventoryPhysicalCount](entity:InventoryPhysicalCount) to an external<br>system.<br>**Constraints**: *Maximum Length*: `255` | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `catalogObjectId` | `?string` | Optional | The Square-generated ID of the<br>[CatalogObject](entity:CatalogObject) being tracked.<br>**Constraints**: *Maximum Length*: `100` | getCatalogObjectId(): ?string | setCatalogObjectId(?string catalogObjectId): void |
| `catalogObjectType` | `?string` | Optional | The [type](entity:CatalogObjectType) of the [CatalogObject](entity:CatalogObject) being tracked.<br><br>The Inventory API supports setting and reading the `"catalog_object_type": "ITEM_VARIATION"` field value.<br>In addition, it can also read the `"catalog_object_type": "ITEM"` field value that is set by the Square Restaurants app.<br>**Constraints**: *Maximum Length*: `14` | getCatalogObjectType(): ?string | setCatalogObjectType(?string catalogObjectType): void |
| `state` | [`?string (InventoryState)`](../../doc/models/inventory-state.md) | Optional | Indicates the state of a tracked item quantity in the lifecycle of goods. | getState(): ?string | setState(?string state): void |
| `locationId` | `?string` | Optional | The Square-generated ID of the [Location](entity:Location) where the related<br>quantity of items is being tracked.<br>**Constraints**: *Maximum Length*: `100` | getLocationId(): ?string | setLocationId(?string locationId): void |
| `quantity` | `?string` | Optional | The number of items affected by the physical count as a decimal string.<br>The number can support up to 5 digits after the decimal point.<br>**Constraints**: *Maximum Length*: `26` | getQuantity(): ?string | setQuantity(?string quantity): void |
| `source` | [`?SourceApplication`](../../doc/models/source-application.md) | Optional | Represents information about the application used to generate a change. | getSource(): ?SourceApplication | setSource(?SourceApplication source): void |
| `employeeId` | `?string` | Optional | The Square-generated ID of the [Employee](entity:Employee) responsible for the<br>physical count.<br>**Constraints**: *Maximum Length*: `100` | getEmployeeId(): ?string | setEmployeeId(?string employeeId): void |
| `teamMemberId` | `?string` | Optional | The Square-generated ID of the [Team Member](entity:TeamMember) responsible for the<br>physical count.<br>**Constraints**: *Maximum Length*: `100` | getTeamMemberId(): ?string | setTeamMemberId(?string teamMemberId): void |
| `occurredAt` | `?string` | Optional | A client-generated RFC 3339-formatted timestamp that indicates when<br>the physical count was examined. For physical count updates, the `occurred_at`<br>timestamp cannot be older than 24 hours or in the future relative to the<br>time of the request.<br>**Constraints**: *Maximum Length*: `34` | getOccurredAt(): ?string | setOccurredAt(?string occurredAt): void |
| `createdAt` | `?string` | Optional | An RFC 3339-formatted timestamp that indicates when the physical count is received.<br>**Constraints**: *Maximum Length*: `34` | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "reference_id": "reference_id2",
  "catalog_object_id": "catalog_object_id6",
  "catalog_object_type": "catalog_object_type6",
  "state": "SUPPORTED_BY_NEWER_VERSION",
  "location_id": "location_id4",
  "quantity": "quantity6",
  "source": {
    "product": "PAYROLL",
    "application_id": "application_id0",
    "name": "name4"
  },
  "employee_id": "employee_id0",
  "team_member_id": "team_member_id0",
  "occurred_at": "occurred_at4",
  "created_at": "created_at2"
}
```

