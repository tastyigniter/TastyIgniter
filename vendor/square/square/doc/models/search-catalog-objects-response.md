
# Search Catalog Objects Response

## Structure

`SearchCatalogObjectsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request. If unset, this is the final response.<br>See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination) for more information. | getCursor(): ?string | setCursor(?string cursor): void |
| `objects` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | The CatalogObjects returned. | getObjects(): ?array | setObjects(?array objects): void |
| `relatedObjects` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | A list of CatalogObjects referenced by the objects in the `objects` field. | getRelatedObjects(): ?array | setRelatedObjects(?array relatedObjects): void |
| `latestTime` | `?string` | Optional | When the associated product catalog was last updated. Will<br>match the value for `end_time` or `cursor` if either field is included in the `SearchCatalog` request. | getLatestTime(): ?string | setLatestTime(?string latestTime): void |

## Example (as JSON)

```json
{
  "objects": [
    {
      "id": "X5DZ5NWWAQ44CKBLKIFQGOWK",
      "is_deleted": false,
      "item_data": {
        "category_id": "E7CLE5RZZ744BHWVQQEAHI2C",
        "description": "A delicious blend of black tea.",
        "name": "Tea - Black",
        "product_type": "REGULAR",
        "tax_ids": [
          "ZXITPM6RWHZ7GZ7EIP3YKECM"
        ],
        "variations": [
          {
            "id": "5GSZPX6EU7MM75S57OONG3V5",
            "is_deleted": false,
            "item_variation_data": {
              "item_id": "X5DZ5NWWAQ44CKBLKIFQGOWK",
              "name": "Regular",
              "ordinal": 1,
              "price_money": {
                "amount": 150,
                "currency": "USD"
              },
              "pricing_type": "FIXED_PRICING"
            },
            "present_at_all_locations": true,
            "type": "ITEM_VARIATION",
            "updated_at": "2017-10-26T15:27:31.626Z",
            "version": 1509031651626
          },
          {
            "id": "XVLBN7DU6JTWHJTG5F265B43",
            "is_deleted": false,
            "item_variation_data": {
              "item_id": "X5DZ5NWWAQ44CKBLKIFQGOWK",
              "name": "Large",
              "ordinal": 2,
              "price_money": {
                "amount": 225,
                "currency": "USD"
              },
              "pricing_type": "FIXED_PRICING"
            },
            "present_at_all_locations": true,
            "type": "ITEM_VARIATION",
            "updated_at": "2017-10-26T15:27:31.626Z",
            "version": 1509031651626
          }
        ],
        "visibility": "PRIVATE"
      },
      "present_at_all_locations": true,
      "type": "ITEM",
      "updated_at": "2017-10-26T15:41:32.337Z",
      "version": 1509032492337
    },
    {
      "id": "NNNEM3LA656Q46NXLWCNI7S5",
      "is_deleted": false,
      "item_data": {
        "category_id": "E7CLE5RZZ744BHWVQQEAHI2C",
        "description": "Relaxing green herbal tea.",
        "name": "Tea - Green",
        "product_type": "REGULAR",
        "tax_ids": [
          "ZXITPM6RWHZ7GZ7EIP3YKECM"
        ],
        "variations": [
          {
            "id": "FHYBVIA6NVBCSOVETA62WEA4",
            "is_deleted": false,
            "item_variation_data": {
              "item_id": "NNNEM3LA656Q46NXLWCNI7S5",
              "name": "Regular",
              "ordinal": 1,
              "price_money": {
                "amount": 150,
                "currency": "USD"
              },
              "pricing_type": "FIXED_PRICING"
            },
            "present_at_all_locations": true,
            "type": "ITEM_VARIATION",
            "updated_at": "2017-10-26T15:29:00.524Z",
            "version": 1509031740524
          }
        ],
        "visibility": "PRIVATE"
      },
      "present_at_all_locations": true,
      "type": "ITEM",
      "updated_at": "2017-10-26T15:41:23.232Z",
      "version": 1509032483232
    }
  ]
}
```

