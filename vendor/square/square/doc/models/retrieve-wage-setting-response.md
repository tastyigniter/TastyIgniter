
# Retrieve Wage Setting Response

Represents a response from a retrieve request containing the specified `WageSetting` object or error messages.

## Structure

`RetrieveWageSettingResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `wageSetting` | [`?WageSetting`](../../doc/models/wage-setting.md) | Optional | An object representing a team member's wage information. | getWageSetting(): ?WageSetting | setWageSetting(?WageSetting wageSetting): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | The errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "wage_setting": {
    "created_at": "2020-06-11T23:01:21+00:00",
    "is_overtime_exempt": false,
    "job_assignments": [
      {
        "annual_rate": {
          "amount": 4500000,
          "currency": "USD"
        },
        "hourly_rate": {
          "amount": 2164,
          "currency": "USD"
        },
        "job_title": "Manager",
        "pay_type": "SALARY",
        "weekly_hours": 40
      }
    ],
    "team_member_id": "1yJlHapkseYnNPETIU1B",
    "updated_at": "2020-06-11T23:01:21+00:00",
    "version": 1
  }
}
```

