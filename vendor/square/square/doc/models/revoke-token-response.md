
# Revoke Token Response

## Structure

`RevokeTokenResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `success` | `?bool` | Optional | If the request is successful, this is `true`. | getSuccess(): ?bool | setSuccess(?bool success): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "success": true
}
```

