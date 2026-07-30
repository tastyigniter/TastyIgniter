
# Bulk Delete Order Custom Attributes Response

Represents a response from deleting one or more order custom attributes.

## Structure

`BulkDeleteOrderCustomAttributesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `values` | [`array<string,DeleteOrderCustomAttributeResponse>`](../../doc/models/delete-order-custom-attribute-response.md) | Required | A map of responses that correspond to individual delete requests. Each response has the same ID<br>as the corresponding request and contains either a `custom_attribute` or an `errors` field. | getValues(): array | setValues(array values): void |

## Example (as JSON)

```json
{
  "values": {
    "cover-count": {},
    "table-number": {}
  }
}
```

