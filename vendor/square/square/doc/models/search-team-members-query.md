
# Search Team Members Query

Represents the parameters in a search for `TeamMember` objects.

## Structure

`SearchTeamMembersQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`?SearchTeamMembersFilter`](../../doc/models/search-team-members-filter.md) | Optional | Represents a filter used in a search for `TeamMember` objects. `AND` logic is applied<br>between the individual fields, and `OR` logic is applied within list-based fields.<br>For example, setting this filter value:<br><br>```<br>filter = (locations_ids = ["A", "B"], status = ACTIVE)<br>```<br><br>returns only active team members assigned to either location "A" or "B". | getFilter(): ?SearchTeamMembersFilter | setFilter(?SearchTeamMembersFilter filter): void |

## Example (as JSON)

```json
{
  "filter": {
    "location_ids": [
      "location_ids4"
    ],
    "status": "ACTIVE",
    "is_owner": false
  }
}
```

