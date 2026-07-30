
# Batch Retrieve Catalog Objects Request

## Structure

`BatchRetrieveCatalogObjectsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `objectIds` | `string[]` | Required | The IDs of the CatalogObjects to be retrieved. | getObjectIds(): array | setObjectIds(array objectIds): void |
| `includeRelatedObjects` | `?bool` | Optional | If `true`, the response will include additional objects that are related to the<br>requested objects. Related objects are defined as any objects referenced by ID by the results in the `objects` field<br>of the response. These objects are put in the `related_objects` field. Setting this to `true` is<br>helpful when the objects are needed for immediate display to a user.<br>This process only goes one level deep. Objects referenced by the related objects will not be included. For example,<br><br>if the `objects` field of the response contains a CatalogItem, its associated<br>CatalogCategory objects, CatalogTax objects, CatalogImage objects and<br>CatalogModifierLists will be returned in the `related_objects` field of the<br>response. If the `objects` field of the response contains a CatalogItemVariation,<br>its parent CatalogItem will be returned in the `related_objects` field of<br>the response.<br><br>Default value: `false` | getIncludeRelatedObjects(): ?bool | setIncludeRelatedObjects(?bool includeRelatedObjects): void |
| `catalogVersion` | `?int` | Optional | The specific version of the catalog objects to be included in the response.<br>This allows you to retrieve historical versions of objects. The specified version value is matched against<br>the [CatalogObject](../../doc/models/catalog-object.md)s' `version` attribute. If not included, results will<br>be from the current version of the catalog. | getCatalogVersion(): ?int | setCatalogVersion(?int catalogVersion): void |
| `includeDeletedObjects` | `?bool` | Optional | Indicates whether to include (`true`) or not (`false`) in the response deleted objects, namely, those with the `is_deleted` attribute set to `true`. | getIncludeDeletedObjects(): ?bool | setIncludeDeletedObjects(?bool includeDeletedObjects): void |

## Example (as JSON)

```json
{
  "include_related_objects": true,
  "object_ids": [
    "W62UWFY35CWMYGVWK6TWJDNI",
    "AA27W3M2GGTF3H6AVPNB77CK"
  ]
}
```

