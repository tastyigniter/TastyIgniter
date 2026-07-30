
# Upsert Catalog Object Request

## Structure

`UpsertCatalogObjectRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A value you specify that uniquely identifies this<br>request among all your requests. A common way to create<br>a valid idempotency key is to use a Universally unique<br>identifier (UUID).<br><br>If you're unsure whether a particular request was successful,<br>you can reattempt it with the same idempotency key without<br>worrying about creating duplicate objects.<br><br>See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency) for more information.<br>**Constraints**: *Minimum Length*: `1` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `object` | [`CatalogObject`](../../doc/models/catalog-object.md) | Required | The wrapper object for the catalog entries of a given object type.<br><br>Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to yield the corresponding type of catalog object.<br><br>For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.<br><br>In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is also a `Catalog<ObjectType>` instance.<br><br>For a more detailed discussion of the Catalog data model, please see the<br>[Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide. | getObject(): CatalogObject | setObject(CatalogObject object): void |

## Example (as JSON)

```json
{
  "idempotency_key": "af3d1afc-7212-4300-b463-0bfc5314a5ae",
  "object": {
    "id": "#Cocoa",
    "item_data": {
      "abbreviation": "Ch",
      "description_html": "<p><strong>Hot</strong> Chocolate</p>",
      "name": "Cocoa",
      "variations": [
        {
          "id": "#Small",
          "item_variation_data": {
            "item_id": "#Cocoa",
            "name": "Small",
            "pricing_type": "VARIABLE_PRICING"
          },
          "type": "ITEM_VARIATION"
        },
        {
          "id": "#Large",
          "item_variation_data": {
            "item_id": "#Cocoa",
            "name": "Large",
            "price_money": {
              "amount": 400,
              "currency": "USD"
            },
            "pricing_type": "FIXED_PRICING"
          },
          "type": "ITEM_VARIATION"
        }
      ]
    },
    "type": "ITEM"
  }
}
```

