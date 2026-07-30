
# Catalog Query Text

The query filter to return the search result whose searchable attribute values contain all of the specified keywords or tokens, independent of the token order or case.

## Structure

`CatalogQueryText`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `keywords` | `string[]` | Required | A list of 1, 2, or 3 search keywords. Keywords with fewer than 3 characters are ignored. | getKeywords(): array | setKeywords(array keywords): void |

## Example (as JSON)

```json
{
  "keywords": [
    "keywords3",
    "keywords4"
  ]
}
```

