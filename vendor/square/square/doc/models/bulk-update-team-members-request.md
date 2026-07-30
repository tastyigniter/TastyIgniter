
# Bulk Update Team Members Request

Represents a bulk update request for `TeamMember` objects.

## Structure

`BulkUpdateTeamMembersRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `teamMembers` | [`array<string,UpdateTeamMemberRequest>`](../../doc/models/update-team-member-request.md) | Required | The data used to update the `TeamMember` objects. Each key is the `team_member_id` that maps to the `UpdateTeamMemberRequest`. The maximum number of update objects is 25. | getTeamMembers(): array | setTeamMembers(array teamMembers): void |

## Example (as JSON)

```json
{
  "team_members": {
    "AFMwA08kR-MIF-3Vs0OE": {
      "team_member": {
        "assigned_locations": {
          "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
        },
        "email_address": "jane_smith@gmail.com",
        "family_name": "Smith",
        "given_name": "Jane",
        "is_owner": false,
        "phone_number": "+14159223334",
        "reference_id": "reference_id_2",
        "status": "ACTIVE"
      }
    },
    "fpgteZNMaf0qOK-a4t6P": {
      "team_member": {
        "assigned_locations": {
          "assignment_type": "EXPLICIT_LOCATIONS",
          "location_ids": [
            "YSGH2WBKG94QZ",
            "GA2Y9HSJ8KRYT"
          ]
        },
        "email_address": "joe_doe@gmail.com",
        "family_name": "Doe",
        "given_name": "Joe",
        "is_owner": false,
        "phone_number": "+14159283333",
        "reference_id": "reference_id_1",
        "status": "ACTIVE"
      }
    }
  }
}
```

