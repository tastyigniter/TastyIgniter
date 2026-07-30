
# Update Booking Custom Attribute Definition Response

Represents an [UpdateBookingCustomAttributeDefinition](../../doc/apis/booking-custom-attributes.md#update-booking-custom-attribute-definition) response.
Either `custom_attribute_definition` or `errors` is present in the response.

## Structure

`UpdateBookingCustomAttributeDefinitionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttributeDefinition` | [`?CustomAttributeDefinition`](../../doc/models/custom-attribute-definition.md) | Optional | Represents a definition for custom attribute values. A custom attribute definition<br>specifies the key, visibility, schema, and other properties for a custom attribute. | getCustomAttributeDefinition(): ?CustomAttributeDefinition | setCustomAttributeDefinition(?CustomAttributeDefinition customAttributeDefinition): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "custom_attribute_definition": {
    "created_at": "2022-11-16T15:27:30Z",
    "description": "Update the description as desired.",
    "key": "favoriteShampoo",
    "name": "Favorite shampoo",
    "schema": null,
    "updated_at": "2022-11-16T15:39:38Z",
    "version": 2,
    "visibility": "VISIBILITY_READ_ONLY"
  },
  "errors": []
}
```

