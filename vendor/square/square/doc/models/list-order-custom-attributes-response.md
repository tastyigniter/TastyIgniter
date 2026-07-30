
# List Order Custom Attributes Response

Represents a response from listing order custom attributes.

## Structure

`ListOrderCustomAttributesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttributes` | [`?(CustomAttribute[])`](../../doc/models/custom-attribute.md) | Optional | The retrieved custom attributes. If no custom attribute are found, Square returns an empty object (`{}`). | getCustomAttributes(): ?array | setCustomAttributes(?array customAttributes): void |
| `cursor` | `?string` | Optional | The cursor to provide in your next call to this endpoint to retrieve the next page of results for your original request.<br>This field is present only if the request succeeded and additional results are available.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination).<br>**Constraints**: *Minimum Length*: `1` | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "custom_attributes": [
    {
      "key": "key2",
      "value": {
        "key1": "val1",
        "key2": "val2"
      },
      "version": 228,
      "visibility": "VISIBILITY_READ_WRITE_VALUES",
      "definition": {
        "key": "key2",
        "schema": {
          "key1": "val1",
          "key2": "val2"
        },
        "name": "name2",
        "description": "description2",
        "visibility": "VISIBILITY_HIDDEN",
        "version": 68,
        "updated_at": "updated_at8",
        "created_at": "created_at0"
      },
      "updated_at": "updated_at8",
      "created_at": "created_at0"
    },
    {
      "key": "key3",
      "value": {
        "key1": "val1",
        "key2": "val2"
      },
      "version": 229,
      "visibility": "VISIBILITY_READ_ONLY",
      "definition": {
        "key": "key3",
        "schema": {
          "key1": "val1",
          "key2": "val2"
        },
        "name": "name3",
        "description": "description3",
        "visibility": "VISIBILITY_READ_ONLY",
        "version": 69,
        "updated_at": "updated_at9",
        "created_at": "created_at1"
      },
      "updated_at": "updated_at9",
      "created_at": "created_at1"
    },
    {
      "key": "key4",
      "value": {
        "key1": "val1",
        "key2": "val2"
      },
      "version": 230,
      "visibility": "VISIBILITY_HIDDEN",
      "definition": {
        "key": "key4",
        "schema": {
          "key1": "val1",
          "key2": "val2"
        },
        "name": "name4",
        "description": "description4",
        "visibility": "VISIBILITY_READ_WRITE_VALUES",
        "version": 70,
        "updated_at": "updated_at0",
        "created_at": "created_at2"
      },
      "updated_at": "updated_at0",
      "created_at": "created_at2"
    }
  ],
  "cursor": "cursor6",
  "errors": [
    {
      "category": "AUTHENTICATION_ERROR",
      "code": "REFUND_ALREADY_PENDING",
      "detail": "detail1",
      "field": "field9"
    },
    {
      "category": "INVALID_REQUEST_ERROR",
      "code": "PAYMENT_NOT_REFUNDABLE",
      "detail": "detail2",
      "field": "field0"
    },
    {
      "category": "RATE_LIMIT_ERROR",
      "code": "REFUND_DECLINED",
      "detail": "detail3",
      "field": "field1"
    }
  ]
}
```

