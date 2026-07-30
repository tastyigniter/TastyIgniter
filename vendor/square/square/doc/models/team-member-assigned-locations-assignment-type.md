
# Team Member Assigned Locations Assignment Type

Enumerates the possible assignment types that the team member can have.

## Enumeration

`TeamMemberAssignedLocationsAssignmentType`

## Fields

| Name | Description |
|  --- | --- |
| `ALL_CURRENT_AND_FUTURE_LOCATIONS` | The team member is assigned to all current and future locations. The `location_ids` field<br>is empty if the team member has this assignment type. |
| `EXPLICIT_LOCATIONS` | The team member is assigned to an explicit subset of locations. The `location_ids` field<br>is the list of locations that the team member is assigned to. |

