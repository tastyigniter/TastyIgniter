
# Bulk Create Team Members Response

Represents a response from a bulk create request containing the created `TeamMember` objects or error messages.

## Structure

`BulkCreateTeamMembersResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `teamMembers` | [`?array<string,CreateTeamMemberResponse>`](../../doc/models/create-team-member-response.md) | Optional | The successfully created `TeamMember` objects. Each key is the `idempotency_key` that maps to the `CreateTeamMemberRequest`. | getTeamMembers(): ?array | setTeamMembers(?array teamMembers): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | The errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "team_members": {
    "idempotency-key-1": {
      "team_member": {
        "assigned_locations": {
          "assignment_type": "EXPLICIT_LOCATIONS",
          "location_ids": [
            "GA2Y9HSJ8KRYT",
            "YSGH2WBKG94QZ"
          ]
        },
        "email_address": "joe_doe@gmail.com",
        "family_name": "Doe",
        "given_name": "Joe",
        "id": "ywhG1qfIOoqsHfVRubFV",
        "is_owner": false,
        "phone_number": "+14159283333",
        "reference_id": "reference_id_1",
        "status": "ACTIVE"
      }
    },
    "idempotency-key-2": {
      "team_member": {
        "assigned_locations": {
          "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
        },
        "email_address": "jane_smith@gmail.com",
        "family_name": "Smith",
        "given_name": "Jane",
        "id": "IF_Ncrg7fHhCqxVI9T6R",
        "is_owner": false,
        "phone_number": "+14159223334",
        "reference_id": "reference_id_2",
        "status": "ACTIVE"
      }
    }
  }
}
```

