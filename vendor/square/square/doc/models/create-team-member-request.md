
# Create Team Member Request

Represents a create request for a `TeamMember` object.

## Structure

`CreateTeamMemberRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique string that identifies this `CreateTeamMember` request.<br>Keys can be any valid string, but must be unique for every request.<br>For more information, see [Idempotency](https://developer.squareup.com/docs/basics/api101/idempotency).<br><br>The minimum length is 1 and the maximum length is 45. | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `teamMember` | [`?TeamMember`](../../doc/models/team-member.md) | Optional | A record representing an individual team member for a business. | getTeamMember(): ?TeamMember | setTeamMember(?TeamMember teamMember): void |

## Example (as JSON)

```json
{
  "idempotency_key": "idempotency-key-0",
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
    "phone_number": "+14159283333",
    "reference_id": "reference_id_1",
    "status": "ACTIVE"
  }
}
```

