
# Update Catalog Image Response

## Structure

`UpdateCatalogImageResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `image` | [`?CatalogObject`](../../doc/models/catalog-object.md) | Optional | The wrapper object for the catalog entries of a given object type.<br><br>Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to yield the corresponding type of catalog object.<br><br>For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.<br><br>In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is also a `Catalog<ObjectType>` instance.<br><br>For a more detailed discussion of the Catalog data model, please see the<br>[Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide. | getImage(): ?CatalogObject | setImage(?CatalogObject image): void |

## Example (as JSON)

```json
{
  "image": {
    "id": "L52QOQN2SW3M5QTF9JOCQKNB",
    "image_data": {
      "caption": "A picture of a cup of coffee",
      "name": "Coffee",
      "url": "https://..."
    },
    "type": "IMAGE"
  }
}
```

