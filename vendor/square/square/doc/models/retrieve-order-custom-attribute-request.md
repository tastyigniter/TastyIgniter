
# Retrieve Order Custom Attribute Request

Represents a get request for an order custom attribute.

## Structure

`RetrieveOrderCustomAttributeRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `version` | `?int` | Optional | To enable [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency)<br>control, include this optional field and specify the current version of the custom attribute. | getVersion(): ?int | setVersion(?int version): void |
| `withDefinition` | `?bool` | Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of each<br>custom attribute. Set this parameter to `true` to get the name and description of each custom attribute,<br>information about the data type, or other definition details. The default value is `false`. | getWithDefinition(): ?bool | setWithDefinition(?bool withDefinition): void |

## Example (as JSON)

```json
{
  "version": 172,
  "with_definition": false
}
```

