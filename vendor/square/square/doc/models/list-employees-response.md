
# List Employees Response

## Structure

`ListEmployeesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `employees` | [`?(Employee[])`](../../doc/models/employee.md) | Optional | - | getEmployees(): ?array | setEmployees(?array employees): void |
| `cursor` | `?string` | Optional | The token to be used to retrieve the next page of results. | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "employees": [
    {
      "id": "id6",
      "first_name": "first_name6",
      "last_name": "last_name4",
      "email": "email0",
      "phone_number": "phone_number4",
      "location_ids": [
        "location_ids6"
      ],
      "status": "ACTIVE",
      "is_owner": false,
      "created_at": "created_at4",
      "updated_at": "updated_at2"
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

