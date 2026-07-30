
# List Order Custom Attribute Definitions Response

Represents a response from listing order custom attribute definitions.

## Structure

`ListOrderCustomAttributeDefinitionsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttributeDefinitions` | [`CustomAttributeDefinition[]`](../../doc/models/custom-attribute-definition.md) | Required | The retrieved custom attribute definitions. If no custom attribute definitions are found, Square returns an empty object (`{}`). | getCustomAttributeDefinitions(): array | setCustomAttributeDefinitions(array customAttributeDefinitions): void |
| `cursor` | `?string` | Optional | The cursor to provide in your next call to this endpoint to retrieve the next page of results for your original request.<br>This field is present only if the request succeeded and additional results are available.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination).<br>**Constraints**: *Minimum Length*: `1` | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "custom_attribute_definitions": [
    {
      "created_at": "2022-11-16T18:03:44.051Z",
      "description": "The number of people seated at a table",
      "key": "cover-count",
      "name": "Cover count",
      "schema": null,
      "updated_at": "2022-11-16T18:03:44.051Z",
      "version": 1,
      "visibility": "VISIBILITY_READ_WRITE_VALUES"
    },
    {
      "created_at": "2022-11-16T18:04:32.059Z",
      "description": "The identifier for a particular seat",
      "key": "seat-number",
      "name": "Seat number",
      "schema": null,
      "updated_at": "2022-11-16T18:04:32.059Z",
      "version": 1,
      "visibility": "VISIBILITY_READ_WRITE_VALUES"
    },
    {
      "created_at": "2022-11-16T18:04:21.912Z",
      "description": "The identifier for a particular table",
      "key": "table-number",
      "name": "Table number",
      "schema": null,
      "updated_at": "2022-11-16T18:04:21.912Z",
      "version": 1,
      "visibility": "VISIBILITY_READ_WRITE_VALUES"
    }
  ]
}
```

