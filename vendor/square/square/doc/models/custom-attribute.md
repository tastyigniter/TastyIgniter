
# Custom Attribute

A custom attribute value. Each custom attribute value has a corresponding
`CustomAttributeDefinition` object.

## Structure

`CustomAttribute`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `key` | `?string` | Optional | The identifier<br>of the custom attribute definition and its corresponding custom attributes. This value<br>can be a simple key, which is the key that is provided when the custom attribute definition<br>is created, or a qualified key, if the requesting<br>application is not the definition owner. The qualified key consists of the application ID<br>of the custom attribute definition owner<br>followed by the simple key that was provided when the definition was created. It has the<br>format application_id:simple key.<br><br>The value for a simple key can contain up to 60 alphanumeric characters, periods (.),<br>underscores (_), and hyphens (-).<br>**Constraints**: *Minimum Length*: `1`, *Pattern*: `^([a-zA-Z0-9\._-]+:)?[a-zA-Z0-9\._-]{1,60}$` | getKey(): ?string | setKey(?string key): void |
| `value` | `mixed` | Optional | The value assigned to the custom attribute. It is validated against the custom<br>attribute definition's schema on write operations. For more information about custom<br>attribute values,<br>see [Custom Attributes Overview](https://developer.squareup.com/docs/devtools/customattributes/overview). | getValue(): | setValue( value): void |
| `version` | `?int` | Optional | Read only. The current version of the custom attribute. This field is incremented when the custom attribute is changed.<br>When updating an existing custom attribute value, you can provide this field<br>and specify the current version of the custom attribute to enable<br>[optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency).<br>This field can also be used to enforce strong consistency for reads. For more information about strong consistency for reads,<br>see [Custom Attributes Overview](https://developer.squareup.com/docs/devtools/customattributes/overview). | getVersion(): ?int | setVersion(?int version): void |
| `visibility` | [`?string (CustomAttributeDefinitionVisibility)`](../../doc/models/custom-attribute-definition-visibility.md) | Optional | The level of permission that a seller or other applications requires to<br>view this custom attribute definition.<br>The `Visibility` field controls who can read and write the custom attribute values<br>and custom attribute definition. | getVisibility(): ?string | setVisibility(?string visibility): void |
| `definition` | [`?CustomAttributeDefinition`](../../doc/models/custom-attribute-definition.md) | Optional | Represents a definition for custom attribute values. A custom attribute definition<br>specifies the key, visibility, schema, and other properties for a custom attribute. | getDefinition(): ?CustomAttributeDefinition | setDefinition(?CustomAttributeDefinition definition): void |
| `updatedAt` | `?string` | Optional | The timestamp that indicates when the custom attribute was created or was most recently<br>updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `createdAt` | `?string` | Optional | The timestamp that indicates when the custom attribute was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |

## Example (as JSON)

```json
{
  "key": "key0",
  "value": {
    "key1": "val1",
    "key2": "val2"
  },
  "version": 172,
  "visibility": "VISIBILITY_READ_WRITE_VALUES",
  "definition": {
    "key": "key0",
    "schema": {
      "key1": "val1",
      "key2": "val2"
    },
    "name": "name0",
    "description": "description0",
    "visibility": "VISIBILITY_HIDDEN",
    "version": 180,
    "updated_at": "updated_at6",
    "created_at": "created_at8"
  },
  "updated_at": "updated_at4",
  "created_at": "created_at2"
}
```

