
# Catalog Info Response

## Structure

`CatalogInfoResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `limits` | [`?CatalogInfoResponseLimits`](../../doc/models/catalog-info-response-limits.md) | Optional | - | getLimits(): ?CatalogInfoResponseLimits | setLimits(?CatalogInfoResponseLimits limits): void |
| `standardUnitDescriptionGroup` | [`?StandardUnitDescriptionGroup`](../../doc/models/standard-unit-description-group.md) | Optional | Group of standard measurement units. | getStandardUnitDescriptionGroup(): ?StandardUnitDescriptionGroup | setStandardUnitDescriptionGroup(?StandardUnitDescriptionGroup standardUnitDescriptionGroup): void |

## Example (as JSON)

```json
{
  "limits": {
    "batch_delete_max_object_ids": 200,
    "batch_retrieve_max_object_ids": 1000,
    "batch_upsert_max_objects_per_batch": 1000,
    "batch_upsert_max_total_objects": 10000,
    "search_max_page_limit": 1000,
    "update_item_modifier_lists_max_item_ids": 1000,
    "update_item_modifier_lists_max_modifier_lists_to_disable": 1000,
    "update_item_modifier_lists_max_modifier_lists_to_enable": 1000,
    "update_item_taxes_max_item_ids": 1000,
    "update_item_taxes_max_taxes_to_disable": 1000,
    "update_item_taxes_max_taxes_to_enable": 1000
  }
}
```

