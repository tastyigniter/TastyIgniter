
# Retrieve Employee Response

## Structure

`RetrieveEmployeeResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `employee` | [`?Employee`](../../doc/models/employee.md) | Optional | An employee object that is used by the external API. | getEmployee(): ?Employee | setEmployee(?Employee employee): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "employee": {
    "id": "id8",
    "first_name": "first_name8",
    "last_name": "last_name6",
    "email": "email8",
    "phone_number": "phone_number6",
    "location_ids": [
      "location_ids8",
      "location_ids9",
      "location_ids0"
    ],
    "status": "ACTIVE",
    "is_owner": false,
    "created_at": "created_at6",
    "updated_at": "updated_at4"
  },
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

