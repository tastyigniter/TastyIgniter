
# Search Catalog Items Request

Defines the request body for the [SearchCatalogItems](../../doc/apis/catalog.md#search-catalog-items) endpoint.

## Structure

`SearchCatalogItemsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `textFilter` | `?string` | Optional | The text filter expression to return items or item variations containing specified text in<br>the `name`, `description`, or `abbreviation` attribute value of an item, or in<br>the `name`, `sku`, or `upc` attribute value of an item variation. | getTextFilter(): ?string | setTextFilter(?string textFilter): void |
| `categoryIds` | `?(string[])` | Optional | The category id query expression to return items containing the specified category IDs. | getCategoryIds(): ?array | setCategoryIds(?array categoryIds): void |
| `stockLevels` | [`?(string[]) (SearchCatalogItemsRequestStockLevel)`](../../doc/models/search-catalog-items-request-stock-level.md) | Optional | The stock-level query expression to return item variations with the specified stock levels.<br>See [SearchCatalogItemsRequestStockLevel](#type-searchcatalogitemsrequeststocklevel) for possible values | getStockLevels(): ?array | setStockLevels(?array stockLevels): void |
| `enabledLocationIds` | `?(string[])` | Optional | The enabled-location query expression to return items and item variations having specified enabled locations. | getEnabledLocationIds(): ?array | setEnabledLocationIds(?array enabledLocationIds): void |
| `cursor` | `?string` | Optional | The pagination token, returned in the previous response, used to fetch the next batch of pending results. | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | The maximum number of results to return per page. The default value is 100.<br>**Constraints**: `<= 100` | getLimit(): ?int | setLimit(?int limit): void |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getSortOrder(): ?string | setSortOrder(?string sortOrder): void |
| `productTypes` | [`?(string[]) (CatalogItemProductType)`](../../doc/models/catalog-item-product-type.md) | Optional | The product types query expression to return items or item variations having the specified product types. | getProductTypes(): ?array | setProductTypes(?array productTypes): void |
| `customAttributeFilters` | [`?(CustomAttributeFilter[])`](../../doc/models/custom-attribute-filter.md) | Optional | The customer-attribute filter to return items or item variations matching the specified<br>custom attribute expressions. A maximum number of 10 custom attribute expressions are supported in<br>a single call to the [SearchCatalogItems](api-endpoint:Catalog-SearchCatalogItems) endpoint. | getCustomAttributeFilters(): ?array | setCustomAttributeFilters(?array customAttributeFilters): void |

## Example (as JSON)

```json
{
  "category_ids": [
    "WINE_CATEGORY_ID"
  ],
  "custom_attribute_filters": [
    {
      "bool_filter": true,
      "custom_attribute_definition_id": "VEGAN_DEFINITION_ID"
    },
    {
      "custom_attribute_definition_id": "BRAND_DEFINITION_ID",
      "string_filter": "Dark Horse"
    },
    {
      "key": "VINTAGE",
      "number_filter": {
        "max": "2018",
        "min": "2017"
      }
    },
    {
      "custom_attribute_definition_id": "VARIETAL_DEFINITION_ID",
      "selection_ids_filter": "MERLOT_SELECTION_ID"
    }
  ],
  "enabled_location_ids": [
    "ATL_LOCATION_ID"
  ],
  "limit": 100,
  "product_types": [
    "REGULAR"
  ],
  "sort_order": "ASC",
  "stock_levels": [
    "OUT",
    "LOW"
  ],
  "text_filter": "red"
}
```

