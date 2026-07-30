
# Custom Attribute Definition

Represents a definition for custom attribute values. A custom attribute definition
specifies the key, visibility, schema, and other properties for a custom attribute.

## Structure

`CustomAttributeDefinition`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `key` | `?string` | Optional | The identifier<br>of the custom attribute definition and its corresponding custom attributes. This value<br>can be a simple key, which is the key that is provided when the custom attribute definition<br>is created, or a qualified key, if the requesting<br>application is not the definition owner. The qualified key consists of the application ID<br>of the custom attribute definition owner<br>followed by the simple key that was provided when the definition was created. It has the<br>format application_id:simple key.<br><br>The value for a simple key can contain up to 60 alphanumeric characters, periods (.),<br>underscores (_), and hyphens (-).<br><br>This field can not be changed<br>after the custom attribute definition is created. This field is required when creating<br>a definition and must be unique per application, seller, and resource type.<br>**Constraints**: *Minimum Length*: `1`, *Pattern*: `^([a-zA-Z0-9\._-]+:)?[a-zA-Z0-9\._-]{1,60}$` | getKey(): ?string | setKey(?string key): void |
| `schema` | `mixed` | Optional | The JSON schema for the custom attribute definition, which determines the data type of the corresponding custom attributes. For more information,<br>see [Custom Attributes Overview](https://developer.squareup.com/docs/devtools/customattributes/overview). This field is required when creating a definition. | getSchema(): | setSchema( schema): void |
| `name` | `?string` | Optional | The name of the custom attribute definition for API and seller-facing UI purposes. The name must<br>be unique within the seller and application pair. This field is required if the<br>`visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |
| `description` | `?string` | Optional | Seller-oriented description of the custom attribute definition, including any constraints<br>that the seller should observe. May be displayed as a tooltip in Square UIs. This field is<br>required if the `visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.<br>**Constraints**: *Maximum Length*: `255` | getDescription(): ?string | setDescription(?string description): void |
| `visibility` | [`?string (CustomAttributeDefinitionVisibility)`](../../doc/models/custom-attribute-definition-visibility.md) | Optional | The level of permission that a seller or other applications requires to<br>view this custom attribute definition.<br>The `Visibility` field controls who can read and write the custom attribute values<br>and custom attribute definition. | getVisibility(): ?string | setVisibility(?string visibility): void |
| `version` | `?int` | Optional | Read only. The current version of the custom attribute definition.<br>The value is incremented each time the custom attribute definition is updated.<br>When updating a custom attribute definition, you can provide this field<br>and specify the current version of the custom attribute definition to enable<br>[optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency).<br><br>On writes, this field must be set to the latest version. Stale writes are rejected.<br><br>This field can also be used to enforce strong consistency for reads. For more information about strong consistency for reads,<br>see [Custom Attributes Overview](https://developer.squareup.com/docs/devtools/customattributes/overview). | getVersion(): ?int | setVersion(?int version): void |
| `updatedAt` | `?string` | Optional | The timestamp that indicates when the custom attribute definition was created or most recently updated,<br>in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `createdAt` | `?string` | Optional | The timestamp that indicates when the custom attribute definition was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |

## Example (as JSON)

```json
{
  "key": "key0",
  "schema": {
    "key1": "val1",
    "key2": "val2"
  },
  "name": "name0",
  "description": "description0",
  "visibility": "VISIBILITY_READ_WRITE_VALUES",
  "version": 172,
  "updated_at": "updated_at4",
  "created_at": "created_at2"
}
```

