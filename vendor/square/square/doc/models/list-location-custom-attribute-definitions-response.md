
# List Location Custom Attribute Definitions Response

Represents a [ListLocationCustomAttributeDefinitions](../../doc/apis/location-custom-attributes.md#list-location-custom-attribute-definitions) response.
Either `custom_attribute_definitions`, an empty object, or `errors` is present in the response.
If additional results are available, the `cursor` field is also present along with `custom_attribute_definitions`.

## Structure

`ListLocationCustomAttributeDefinitionsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttributeDefinitions` | [`?(CustomAttributeDefinition[])`](../../doc/models/custom-attribute-definition.md) | Optional | The retrieved custom attribute definitions. If no custom attribute definitions are found,<br>Square returns an empty object (`{}`). | getCustomAttributeDefinitions(): ?array | setCustomAttributeDefinitions(?array customAttributeDefinitions): void |
| `cursor` | `?string` | Optional | The cursor to provide in your next call to this endpoint to retrieve the next page of<br>results for your original request. This field is present only if the request succeeded and<br>additional results are available. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "cursor": "ImfNzWVSiAYyiAR4gEcxDJ75KZAOSjX8H2BVHUTR0ofCtp4SdYvrUKbwYY2aCH2WqZ2FsfAuylEVUlTfaINg3ecIlFpP9Y5Ie66w9NSg9nqdI5fCJ6qdH2s0za5m2plFonsjIuFaoN89j78ROUwuSOzD6mFZPcJHhJ0CxEKc0SBH",
  "custom_attribute_definitions": [
    {
      "created_at": "2022-12-02T19:50:21.832Z",
      "description": "Location's phone number",
      "key": "phone-number",
      "name": "phone number",
      "schema": null,
      "updated_at": "2022-12-02T19:50:21.832Z",
      "version": 1,
      "visibility": "VISIBILITY_READ_ONLY"
    },
    {
      "created_at": "2022-12-02T19:06:36.559Z",
      "description": "Bestselling item at location",
      "key": "bestseller",
      "name": "Bestseller",
      "schema": null,
      "updated_at": "2022-12-03T10:17:52.341Z",
      "version": 4,
      "visibility": "VISIBILITY_READ_WRITE_VALUES"
    }
  ]
}
```

