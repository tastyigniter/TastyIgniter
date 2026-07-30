
# Catalog V1 Id

A Square API V1 identifier of an item, including the object ID and its associated location ID.

## Structure

`CatalogV1Id`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `catalogV1Id` | `?string` | Optional | The ID for an object used in the Square API V1, if the object ID differs from the Square API V2 object ID. | getCatalogV1Id(): ?string | setCatalogV1Id(?string catalogV1Id): void |
| `locationId` | `?string` | Optional | The ID of the `Location` this Connect V1 ID is associated with. | getLocationId(): ?string | setLocationId(?string locationId): void |

## Example (as JSON)

```json
{
  "catalog_v1_id": "catalog_v1_id4",
  "location_id": "location_id4"
}
```

