
# Team Member Assigned Locations

An object that represents a team member's assignment to locations.

## Structure

`TeamMemberAssignedLocations`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `assignmentType` | [`?string (TeamMemberAssignedLocationsAssignmentType)`](../../doc/models/team-member-assigned-locations-assignment-type.md) | Optional | Enumerates the possible assignment types that the team member can have. | getAssignmentType(): ?string | setAssignmentType(?string assignmentType): void |
| `locationIds` | `?(string[])` | Optional | The explicit locations that the team member is assigned to. | getLocationIds(): ?array | setLocationIds(?array locationIds): void |

## Example (as JSON)

```json
{
  "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS",
  "location_ids": [
    "location_ids0"
  ]
}
```

