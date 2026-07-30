
# Upsert Catalog Object Response

## Structure

`UpsertCatalogObjectResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `catalogObject` | [`?CatalogObject`](../../doc/models/catalog-object.md) | Optional | The wrapper object for the catalog entries of a given object type.<br><br>Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to yield the corresponding type of catalog object.<br><br>For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.<br><br>In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is also a `Catalog<ObjectType>` instance.<br><br>For a more detailed discussion of the Catalog data model, please see the<br>[Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide. | getCatalogObject(): ?CatalogObject | setCatalogObject(?CatalogObject catalogObject): void |
| `idMappings` | [`?(CatalogIdMapping[])`](../../doc/models/catalog-id-mapping.md) | Optional | The mapping between client and server IDs for this upsert. | getIdMappings(): ?array | setIdMappings(?array idMappings): void |

## Example (as JSON)

```json
{
  "catalog_object": {
    "id": "R2TA2FOBUGCJZNIWJSOSNAI4",
    "is_deleted": false,
    "item_data": {
      "abbreviation": "Ch",
      "description": "Hot Chocolate",
      "description_html": "<p><strong>Hot</strong> Chocolate</p>",
      "description_plaintext": "Hot Chocolate",
      "name": "Cocoa",
      "product_type": "REGULAR",
      "variations": [
        {
          "id": "QRT53UP4LITLWGOGBZCUWP63",
          "is_deleted": false,
          "item_variation_data": {
            "item_id": "R2TA2FOBUGCJZNIWJSOSNAI4",
            "name": "Small",
            "ordinal": 0,
            "pricing_type": "VARIABLE_PRICING",
            "stockable": true
          },
          "present_at_all_locations": true,
          "type": "ITEM_VARIATION",
          "updated_at": "2021-06-14T15:51:39.021Z",
          "version": 1623685899021
        },
        {
          "id": "NS77DKEIQ3AEQTCP727DSA7U",
          "is_deleted": false,
          "item_variation_data": {
            "item_id": "R2TA2FOBUGCJZNIWJSOSNAI4",
            "name": "Large",
            "ordinal": 1,
            "price_money": {
              "amount": 400,
              "currency": "USD"
            },
            "pricing_type": "FIXED_PRICING",
            "stockable": true
          },
          "present_at_all_locations": true,
          "type": "ITEM_VARIATION",
          "updated_at": "2021-06-14T15:51:39.021Z",
          "version": 1623685899021
        }
      ]
    },
    "present_at_all_locations": true,
    "type": "ITEM",
    "updated_at": "2021-06-14T15:51:39.021Z",
    "version": 1623685899021
  },
  "id_mappings": [
    {
      "client_object_id": "#Cocoa",
      "object_id": "R2TA2FOBUGCJZNIWJSOSNAI4"
    },
    {
      "client_object_id": "#Small",
      "object_id": "QRT53UP4LITLWGOGBZCUWP63"
    },
    {
      "client_object_id": "#Large",
      "object_id": "NS77DKEIQ3AEQTCP727DSA7U"
    }
  ]
}
```

