
# Search Team Members Filter

Represents a filter used in a search for `TeamMember` objects. `AND` logic is applied
between the individual fields, and `OR` logic is applied within list-based fields.
For example, setting this filter value:

```
filter = (locations_ids = ["A", "B"], status = ACTIVE)
```

returns only active team members assigned to either location "A" or "B".

## Structure

`SearchTeamMembersFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `locationIds` | `?(string[])` | Optional | When present, filters by team members assigned to the specified locations.<br>When empty, includes team members assigned to any location. | getLocationIds(): ?array | setLocationIds(?array locationIds): void |
| `status` | [`?string (TeamMemberStatus)`](../../doc/models/team-member-status.md) | Optional | Enumerates the possible statuses the team member can have within a business. | getStatus(): ?string | setStatus(?string status): void |
| `isOwner` | `?bool` | Optional | When present and set to true, returns the team member who is the owner of the Square account. | getIsOwner(): ?bool | setIsOwner(?bool isOwner): void |

## Example (as JSON)

```json
{
  "location_ids": [
    "location_ids0"
  ],
  "status": "ACTIVE",
  "is_owner": false
}
```

