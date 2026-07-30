
# List Team Member Wages Request

A request for a set of `TeamMemberWage` objects.

## Structure

`ListTeamMemberWagesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `teamMemberId` | `?string` | Optional | Filter the returned wages to only those that are associated with the<br>specified team member. | getTeamMemberId(): ?string | setTeamMemberId(?string teamMemberId): void |
| `limit` | `?int` | Optional | The maximum number of `TeamMemberWage` results to return per page. The number can range between<br>1 and 200. The default is 200.<br>**Constraints**: `>= 1`, `<= 200` | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | A pointer to the next page of `EmployeeWage` results to fetch. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "team_member_id": "team_member_id0",
  "limit": 172,
  "cursor": "cursor6"
}
```

