
# Retrieve Order Custom Attribute Definition Request

Represents a get request for an order custom attribute definition.

## Structure

`RetrieveOrderCustomAttributeDefinitionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `version` | `?int` | Optional | To enable [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency)<br>control, include this optional field and specify the current version of the custom attribute. | getVersion(): ?int | setVersion(?int version): void |

## Example (as JSON)

```json
{
  "version": 172
}
```

