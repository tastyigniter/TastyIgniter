
# Wage Setting

An object representing a team member's wage information.

## Structure

`WageSetting`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `teamMemberId` | `?string` | Optional | The unique ID of the `TeamMember` whom this wage setting describes. | getTeamMemberId(): ?string | setTeamMemberId(?string teamMemberId): void |
| `jobAssignments` | [`?(JobAssignment[])`](../../doc/models/job-assignment.md) | Optional | Required. The ordered list of jobs that the team member is assigned to.<br>The first job assignment is considered the team member's primary job.<br><br>The minimum length is 1 and the maximum length is 12. | getJobAssignments(): ?array | setJobAssignments(?array jobAssignments): void |
| `isOvertimeExempt` | `?bool` | Optional | Whether the team member is exempt from the overtime rules of the seller's country. | getIsOvertimeExempt(): ?bool | setIsOvertimeExempt(?bool isOvertimeExempt): void |
| `version` | `?int` | Optional | Used for resolving concurrency issues. The request fails if the version<br>provided does not match the server version at the time of the request. If not provided,<br>Square executes a blind write, potentially overwriting data from another write. For more information,<br>see [optimistic concurrency](https://developer.squareup.com/docs/working-with-apis/optimistic-concurrency). | getVersion(): ?int | setVersion(?int version): void |
| `createdAt` | `?string` | Optional | The timestamp, in RFC 3339 format, describing when the wage setting object was created.<br>For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z". | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp, in RFC 3339 format, describing when the wage setting object was last updated.<br>For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z". | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "team_member_id": "team_member_id0",
  "job_assignments": [
    {
      "job_title": "job_title1",
      "pay_type": "NONE",
      "hourly_rate": {
        "amount": 79,
        "currency": "QAR"
      },
      "annual_rate": {
        "amount": 19,
        "currency": "PKR"
      },
      "weekly_hours": 187
    },
    {
      "job_title": "job_title2",
      "pay_type": "HOURLY",
      "hourly_rate": {
        "amount": 80,
        "currency": "RON"
      },
      "annual_rate": {
        "amount": 20,
        "currency": "PLN"
      },
      "weekly_hours": 188
    },
    {
      "job_title": "job_title3",
      "pay_type": "SALARY",
      "hourly_rate": {
        "amount": 81,
        "currency": "RSD"
      },
      "annual_rate": {
        "amount": 21,
        "currency": "PYG"
      },
      "weekly_hours": 189
    }
  ],
  "is_overtime_exempt": false,
  "version": 172,
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

