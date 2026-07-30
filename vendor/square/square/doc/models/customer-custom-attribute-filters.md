
# Customer Custom Attribute Filters

The custom attribute filters in a set of [customer filters](../../doc/models/customer-filter.md) used in a search query. Use this filter
to search based on [custom attributes](../../doc/models/custom-attribute.md) that are assigned to customer profiles. For more information, see
[Search by custom attribute](https://developer.squareup.com/docs/customers-api/use-the-api/search-customers#search-by-custom-attribute).

## Structure

`CustomerCustomAttributeFilters`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filters` | [`?(CustomerCustomAttributeFilter[])`](../../doc/models/customer-custom-attribute-filter.md) | Optional | The custom attribute filters. Each filter must specify `key` and include the `filter` field with a type-specific filter,<br>the `updated_at` field, or both. The provided keys must be unique within the list of custom attribute filters. | getFilters(): ?array | setFilters(?array filters): void |

## Example (as JSON)

```json
{
  "filters": [
    {
      "key": "key0",
      "filter": {
        "email": {
          "exact": "exact2",
          "fuzzy": "fuzzy8"
        },
        "phone": {
          "exact": "exact6",
          "fuzzy": "fuzzy2"
        },
        "text": {},
        "selection": {
          "all": [
            "all5"
          ],
          "any": [
            "any2",
            "any3"
          ],
          "none": [
            "none7"
          ]
        },
        "date": {
          "start_at": "start_at2",
          "end_at": "end_at0"
        },
        "number": {
          "start_at": "start_at0",
          "end_at": "end_at2"
        },
        "boolean": false,
        "address": {
          "postal_code": {},
          "country": "WS"
        }
      },
      "updated_at": {
        "start_at": "start_at8",
        "end_at": "end_at4"
      }
    }
  ]
}
```

