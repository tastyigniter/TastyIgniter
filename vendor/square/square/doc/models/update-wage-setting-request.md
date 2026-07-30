
# Update Wage Setting Request

Represents an update request for the `WageSetting` object describing a `TeamMember`.

## Structure

`UpdateWageSettingRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `wageSetting` | [`WageSetting`](../../doc/models/wage-setting.md) | Required | An object representing a team member's wage information. | getWageSetting(): WageSetting | setWageSetting(WageSetting wageSetting): void |

## Example (as JSON)

```json
{
  "wage_setting": {
    "is_overtime_exempt": true,
    "job_assignments": [
      {
        "annual_rate": {
          "amount": 3000000,
          "currency": "USD"
        },
        "job_title": "Manager",
        "pay_type": "SALARY",
        "weekly_hours": 40
      },
      {
        "hourly_rate": {
          "amount": 1200,
          "currency": "USD"
        },
        "job_title": "Cashier",
        "pay_type": "HOURLY"
      }
    ]
  }
}
```

