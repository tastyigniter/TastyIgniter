
# Customer Text Filter

A filter to select customers based on exact or fuzzy matching of
customer attributes against a specified query. Depending on the customer attributes,
the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.

## Structure

`CustomerTextFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `exact` | `?string` | Optional | Use the exact filter to select customers whose attributes match exactly the specified query. | getExact(): ?string | setExact(?string exact): void |
| `fuzzy` | `?string` | Optional | Use the fuzzy filter to select customers whose attributes match the specified query<br>in a fuzzy manner. When the fuzzy option is used, search queries are tokenized, and then<br>each query token must be matched somewhere in the searched attribute. For single token queries,<br>this is effectively the same behavior as a partial match operation. | getFuzzy(): ?string | setFuzzy(?string fuzzy): void |

## Example (as JSON)

```json
{
  "exact": "exact0",
  "fuzzy": "fuzzy4"
}
```

