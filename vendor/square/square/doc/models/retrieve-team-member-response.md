
# Retrieve Team Member Response

Represents a response from a retrieve request containing a `TeamMember` object or error messages.

## Structure

`RetrieveTeamMemberResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `teamMember` | [`?TeamMember`](../../doc/models/team-member.md) | Optional | A record representing an individual team member for a business. | getTeamMember(): ?TeamMember | setTeamMember(?TeamMember teamMember): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | The errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "team_member": {
    "assigned_locations": {
      "assignment_type": "EXPLICIT_LOCATIONS",
      "location_ids": [
        "GA2Y9HSJ8KRYT",
        "YSGH2WBKG94QZ"
      ]
    },
    "created_at": "2021-06-11T22:55:45Z",
    "email_address": "joe_doe@example.com",
    "family_name": "Doe",
    "given_name": "Joe",
    "id": "1yJlHapkseYnNPETIU1B",
    "is_owner": false,
    "phone_number": "+14159283333",
    "reference_id": "reference_id_1",
    "status": "ACTIVE",
    "updated_at": "2021-06-15T17:38:05Z"
  }
}
```

