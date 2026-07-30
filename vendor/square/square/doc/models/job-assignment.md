
# Job Assignment

An object describing a job that a team member is assigned to.

## Structure

`JobAssignment`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `jobTitle` | `string` | Required | The title of the job.<br>**Constraints**: *Minimum Length*: `1` | getJobTitle(): string | setJobTitle(string jobTitle): void |
| `payType` | [`string (JobAssignmentPayType)`](../../doc/models/job-assignment-pay-type.md) | Required | Enumerates the possible pay types that a job can be assigned. | getPayType(): string | setPayType(string payType): void |
| `hourlyRate` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getHourlyRate(): ?Money | setHourlyRate(?Money hourlyRate): void |
| `annualRate` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAnnualRate(): ?Money | setAnnualRate(?Money annualRate): void |
| `weeklyHours` | `?int` | Optional | The planned hours per week for the job. Set if the job `PayType` is `SALARY`. | getWeeklyHours(): ?int | setWeeklyHours(?int weeklyHours): void |

## Example (as JSON)

```json
{
  "job_title": "job_title4",
  "pay_type": "NONE",
  "hourly_rate": {
    "amount": 172,
    "currency": "TJS"
  },
  "annual_rate": {
    "amount": 232,
    "currency": "TOP"
  },
  "weekly_hours": 156
}
```

