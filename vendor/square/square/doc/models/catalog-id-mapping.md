
# Catalog Id Mapping

A mapping between a temporary client-supplied ID and a permanent server-generated ID.

When calling [UpsertCatalogObject](../../doc/apis/catalog.md#upsert-catalog-object) or
[BatchUpsertCatalogObjects](../../doc/apis/catalog.md#batch-upsert-catalog-objects) to
create a [CatalogObject](../../doc/models/catalog-object.md) instance, you can supply
a temporary ID for the to-be-created object, especially when the object is to be referenced
elsewhere in the same request body. This temporary ID can be any string unique within
the call, but must be prefixed by "#".

After the request is submitted and the object created, a permanent server-generated ID is assigned
to the new object. The permanent ID is unique across the Square catalog.

## Structure

`CatalogIdMapping`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `clientObjectId` | `?string` | Optional | The client-supplied temporary `#`-prefixed ID for a new `CatalogObject`. | getClientObjectId(): ?string | setClientObjectId(?string clientObjectId): void |
| `objectId` | `?string` | Optional | The permanent ID for the CatalogObject created by the server. | getObjectId(): ?string | setObjectId(?string objectId): void |

## Example (as JSON)

```json
{
  "client_object_id": "client_object_id0",
  "object_id": "object_id8"
}
```

