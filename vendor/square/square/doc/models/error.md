
# Error

Represents an error encountered during a request to the Connect API.

See [Handling errors](https://developer.squareup.com/docs/build-basics/handling-errors) for more information.

## Structure

`Error`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `category` | [`string (ErrorCategory)`](../../doc/models/error-category.md) | Required | Indicates which high-level category of error has occurred during a<br>request to the Connect API. | getCategory(): string | setCategory(string category): void |
| `code` | [`string (ErrorCode)`](../../doc/models/error-code.md) | Required | Indicates the specific error that occurred during a request to a<br>Square API. | getCode(): string | setCode(string code): void |
| `detail` | `?string` | Optional | A human-readable description of the error for debugging purposes. | getDetail(): ?string | setDetail(?string detail): void |
| `field` | `?string` | Optional | The name of the field provided in the original request (if any) that<br>the error pertains to. | getField(): ?string | setField(?string field): void |

## Example (as JSON)

```json
{
  "category": "RATE_LIMIT_ERROR",
  "code": "UNEXPECTED_VALUE",
  "detail": "detail6",
  "field": "field6"
}
```

