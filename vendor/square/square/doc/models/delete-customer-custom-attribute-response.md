
# Delete Customer Custom Attribute Response

Represents a [DeleteCustomerCustomAttribute](../../doc/apis/customer-custom-attributes.md#delete-customer-custom-attribute) response.
Either an empty object `{}` (for a successful deletion) or `errors` is present in the response.

## Structure

`DeleteCustomerCustomAttributeResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{}
```

