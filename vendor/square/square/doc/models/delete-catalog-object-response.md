
# Delete Catalog Object Response

## Structure

`DeleteCatalogObjectResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `deletedObjectIds` | `?(string[])` | Optional | The IDs of all catalog objects deleted by this request.<br>Multiple IDs may be returned when associated objects are also deleted, for example<br>a catalog item variation will be deleted (and its ID included in this field)<br>when its parent catalog item is deleted. | getDeletedObjectIds(): ?array | setDeletedObjectIds(?array deletedObjectIds): void |
| `deletedAt` | `?string` | Optional | The database [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>of this deletion in RFC 3339 format, e.g., `2016-09-04T23:59:33.123Z`. | getDeletedAt(): ?string | setDeletedAt(?string deletedAt): void |

## Example (as JSON)

```json
{
  "deleted_at": "2016-11-16T22:25:24.878Z",
  "deleted_object_ids": [
    "7SB3ZQYJ5GDMVFL7JK46JCHT",
    "KQLFFHA6K6J3YQAQAWDQAL57"
  ]
}
```

