
# List Customer Custom Attribute Definitions Response

Represents a [ListCustomerCustomAttributeDefinitions](../../doc/apis/customer-custom-attributes.md#list-customer-custom-attribute-definitions) response.
Either `custom_attribute_definitions`, an empty object, or `errors` is present in the response.
If additional results are available, the `cursor` field is also present along with `custom_attribute_definitions`.

## Structure

`ListCustomerCustomAttributeDefinitionsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttributeDefinitions` | [`?(CustomAttributeDefinition[])`](../../doc/models/custom-attribute-definition.md) | Optional | The retrieved custom attribute definitions. If no custom attribute definitions are found,<br>Square returns an empty object (`{}`). | getCustomAttributeDefinitions(): ?array | setCustomAttributeDefinitions(?array customAttributeDefinitions): void |
| `cursor` | `?string` | Optional | The cursor to provide in your next call to this endpoint to retrieve the next page of<br>results for your original request. This field is present only if the request succeeded and<br>additional results are available. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "cursor": "YEk4UPbUEsu8MUV0xouO5hCiFcD9T5ztB6UWEJq5vZnqBFmoBEi0j1j6HWYTFGMRre4p7T5wAQBj3Th1NX3XgBFcQVEVsIxUQ2NsbwjRitfoEZDml9uxxQXepowyRvCuSThHPbJSn7M7wInl3x8XypQF9ahVVQXegJ0CxEKc0SBH",
  "custom_attribute_definitions": [
    {
      "created_at": "2022-04-26T15:27:30Z",
      "description": "Update the description as desired.",
      "key": "favoritemovie",
      "name": "Favorite Movie",
      "schema": null,
      "updated_at": "2022-04-26T15:39:38Z",
      "version": 3,
      "visibility": "VISIBILITY_READ_ONLY"
    },
    {
      "created_at": "2022-04-26T15:49:05Z",
      "description": "Customer owns movie.",
      "key": "ownsmovie",
      "name": "Owns Movie",
      "schema": null,
      "updated_at": "2022-04-26T15:49:05Z",
      "version": 1,
      "visibility": "VISIBILITY_HIDDEN"
    }
  ]
}
```

