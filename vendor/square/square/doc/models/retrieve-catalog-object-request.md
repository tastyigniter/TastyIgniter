
# Retrieve Catalog Object Request

## Structure

`RetrieveCatalogObjectRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `includeRelatedObjects` | `?bool` | Optional | If `true`, the response will include additional objects that are related to the<br>requested objects. Related objects are defined as any objects referenced by ID by the results in the `objects` field<br>of the response. These objects are put in the `related_objects` field. Setting this to `true` is<br>helpful when the objects are needed for immediate display to a user.<br>This process only goes one level deep. Objects referenced by the related objects will not be included. For example,<br><br>if the `objects` field of the response contains a CatalogItem, its associated<br>CatalogCategory objects, CatalogTax objects, CatalogImage objects and<br>CatalogModifierLists will be returned in the `related_objects` field of the<br>response. If the `objects` field of the response contains a CatalogItemVariation,<br>its parent CatalogItem will be returned in the `related_objects` field of<br>the response.<br><br>Default value: `false` | getIncludeRelatedObjects(): ?bool | setIncludeRelatedObjects(?bool includeRelatedObjects): void |
| `catalogVersion` | `?int` | Optional | Requests objects as of a specific version of the catalog. This allows you to retrieve historical<br>versions of objects. The value to retrieve a specific version of an object can be found<br>in the version field of [CatalogObject](../../doc/models/catalog-object.md)s. If not included, results will<br>be from the current version of the catalog. | getCatalogVersion(): ?int | setCatalogVersion(?int catalogVersion): void |

## Example (as JSON)

```json
{
  "include_related_objects": false,
  "catalog_version": 126
}
```

