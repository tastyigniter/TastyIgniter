
# Search Catalog Objects Request

## Structure

`SearchCatalogObjectsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cursor` | `?string` | Optional | The pagination cursor returned in the previous response. Leave unset for an initial request.<br>See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination) for more information. | getCursor(): ?string | setCursor(?string cursor): void |
| `objectTypes` | [`?(string[]) (CatalogObjectType)`](../../doc/models/catalog-object-type.md) | Optional | The desired set of object types to appear in the search results.<br><br>If this is unspecified, the operation returns objects of all the top level types at the version<br>of the Square API used to make the request. Object types that are nested onto other object types<br>are not included in the defaults.<br><br>At the current API version the default object types are:<br>ITEM, CATEGORY, TAX, DISCOUNT, MODIFIER_LIST,<br>PRICING_RULE, PRODUCT_SET, TIME_PERIOD, MEASUREMENT_UNIT,<br>SUBSCRIPTION_PLAN, ITEM_OPTION, CUSTOM_ATTRIBUTE_DEFINITION, QUICK_AMOUNT_SETTINGS.<br><br>Note that if you wish for the query to return objects belonging to nested types (i.e., COMPONENT, IMAGE,<br>ITEM_OPTION_VAL, ITEM_VARIATION, or MODIFIER), you must explicitly include all the types of interest<br>in this field. | getObjectTypes(): ?array | setObjectTypes(?array objectTypes): void |
| `includeDeletedObjects` | `?bool` | Optional | If `true`, deleted objects will be included in the results. Deleted objects will have their<br>`is_deleted` field set to `true`. | getIncludeDeletedObjects(): ?bool | setIncludeDeletedObjects(?bool includeDeletedObjects): void |
| `includeRelatedObjects` | `?bool` | Optional | If `true`, the response will include additional objects that are related to the<br>requested objects. Related objects are objects that are referenced by object ID by the objects<br>in the response. This is helpful if the objects are being fetched for immediate display to a user.<br>This process only goes one level deep. Objects referenced by the related objects will not be included.<br>For example:<br><br>If the `objects` field of the response contains a CatalogItem, its associated<br>CatalogCategory objects, CatalogTax objects, CatalogImage objects and<br>CatalogModifierLists will be returned in the `related_objects` field of the<br>response. If the `objects` field of the response contains a CatalogItemVariation,<br>its parent CatalogItem will be returned in the `related_objects` field of<br>the response.<br><br>Default value: `false` | getIncludeRelatedObjects(): ?bool | setIncludeRelatedObjects(?bool includeRelatedObjects): void |
| `beginTime` | `?string` | Optional | Return objects modified after this [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates), in RFC 3339<br>format, e.g., `2016-09-04T23:59:33.123Z`. The timestamp is exclusive - objects with a<br>timestamp equal to `begin_time` will not be included in the response. | getBeginTime(): ?string | setBeginTime(?string beginTime): void |
| `query` | [`?CatalogQuery`](../../doc/models/catalog-query.md) | Optional | A query composed of one or more different types of filters to narrow the scope of targeted objects when calling the `SearchCatalogObjects` endpoint.<br><br>Although a query can have multiple filters, only certain query types can be combined per call to [SearchCatalogObjects](../../doc/apis/catalog.md#search-catalog-objects).<br>Any combination of the following types may be used together:<br><br>- [exact_query](../../doc/models/catalog-query-exact.md)<br>- [prefix_query](../../doc/models/catalog-query-prefix.md)<br>- [range_query](../../doc/models/catalog-query-range.md)<br>- [sorted_attribute_query](../../doc/models/catalog-query-sorted-attribute.md)<br>- [text_query](../../doc/models/catalog-query-text.md)<br>  All other query types cannot be combined with any others.<br><br>When a query filter is based on an attribute, the attribute must be searchable.<br>Searchable attributes are listed as follows, along their parent types that can be searched for with applicable query filters.<br><br>* Searchable attribute and objects queryable by searchable attributes **<br><br>- `name`:  `CatalogItem`, `CatalogItemVariation`, `CatalogCategory`, `CatalogTax`, `CatalogDiscount`, `CatalogModifier`, 'CatalogModifierList`,`CatalogItemOption`,`CatalogItemOptionValue`<br>- `description`: `CatalogItem`, `CatalogItemOptionValue`<br>- `abbreviation`: `CatalogItem`<br>- `upc`: `CatalogItemVariation`<br>- `sku`: `CatalogItemVariation`<br>- `caption`: `CatalogImage`<br>- `display_name`: `CatalogItemOption`<br><br>For example, to search for [CatalogItem](../../doc/models/catalog-item.md) objects by searchable attributes, you can use<br>the `"name"`, `"description"`, or `"abbreviation"` attribute in an applicable query filter. | getQuery(): ?CatalogQuery | setQuery(?CatalogQuery query): void |
| `limit` | `?int` | Optional | A limit on the number of results to be returned in a single page. The limit is advisory -<br>the implementation may return more or fewer results. If the supplied limit is negative, zero, or<br>is higher than the maximum limit of 1,000, it will be ignored. | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "limit": 100,
  "object_types": [
    "ITEM"
  ],
  "query": {
    "prefix_query": {
      "attribute_name": "name",
      "attribute_prefix": "tea"
    }
  }
}
```

