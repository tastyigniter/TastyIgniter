
# Void Transaction Response

Defines the fields that are included in the response body of
a request to the [VoidTransaction](api-endpoint:Transactions-VoidTransaction) endpoint.

## Structure

`VoidTransactionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{}
```

