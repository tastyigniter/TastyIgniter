
# Batch Delete Catalog Objects Response

## Structure

`BatchDeleteCatalogObjectsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `deletedObjectIds` | `?(string[])` | Optional | The IDs of all CatalogObjects deleted by this request. | getDeletedObjectIds(): ?array | setDeletedObjectIds(?array deletedObjectIds): void |
| `deletedAt` | `?string` | Optional | The database [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates) of this deletion in RFC 3339 format, e.g., "2016-09-04T23:59:33.123Z". | getDeletedAt(): ?string | setDeletedAt(?string deletedAt): void |

## Example (as JSON)

```json
{
  "deleted_at": "2016-11-16T22:25:24.878Z",
  "deleted_object_ids": [
    "W62UWFY35CWMYGVWK6TWJDNI",
    "AA27W3M2GGTF3H6AVPNB77CK"
  ]
}
```

