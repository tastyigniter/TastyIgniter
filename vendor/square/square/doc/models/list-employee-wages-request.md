
# List Employee Wages Request

A request for a set of `EmployeeWage` objects.

## Structure

`ListEmployeeWagesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `employeeId` | `?string` | Optional | Filter the returned wages to only those that are associated with the specified employee. | getEmployeeId(): ?string | setEmployeeId(?string employeeId): void |
| `limit` | `?int` | Optional | The maximum number of `EmployeeWage` results to return per page. The number can range between<br>1 and 200. The default is 200.<br>**Constraints**: `>= 1`, `<= 200` | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | A pointer to the next page of `EmployeeWage` results to fetch. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "employee_id": "employee_id0",
  "limit": 172,
  "cursor": "cursor6"
}
```

