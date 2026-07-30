
# Team Member

A record representing an individual team member for a business.

## Structure

`TeamMember`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The unique ID for the team member. | getId(): ?string | setId(?string id): void |
| `referenceId` | `?string` | Optional | A second ID used to associate the team member with an entity in another system. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `isOwner` | `?bool` | Optional | Whether the team member is the owner of the Square account. | getIsOwner(): ?bool | setIsOwner(?bool isOwner): void |
| `status` | [`?string (TeamMemberStatus)`](../../doc/models/team-member-status.md) | Optional | Enumerates the possible statuses the team member can have within a business. | getStatus(): ?string | setStatus(?string status): void |
| `givenName` | `?string` | Optional | The given name (that is, the first name) associated with the team member. | getGivenName(): ?string | setGivenName(?string givenName): void |
| `familyName` | `?string` | Optional | The family name (that is, the last name) associated with the team member. | getFamilyName(): ?string | setFamilyName(?string familyName): void |
| `emailAddress` | `?string` | Optional | The email address associated with the team member. | getEmailAddress(): ?string | setEmailAddress(?string emailAddress): void |
| `phoneNumber` | `?string` | Optional | The team member's phone number, in E.164 format. For example:<br>+14155552671 - the country code is 1 for US<br>+551155256325 - the country code is 55 for BR | getPhoneNumber(): ?string | setPhoneNumber(?string phoneNumber): void |
| `createdAt` | `?string` | Optional | The timestamp, in RFC 3339 format, describing when the team member was created.<br>For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z". | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp, in RFC 3339 format, describing when the team member was last updated.<br>For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z". | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `assignedLocations` | [`?TeamMemberAssignedLocations`](../../doc/models/team-member-assigned-locations.md) | Optional | An object that represents a team member's assignment to locations. | getAssignedLocations(): ?TeamMemberAssignedLocations | setAssignedLocations(?TeamMemberAssignedLocations assignedLocations): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "reference_id": "reference_id2",
  "is_owner": false,
  "status": "ACTIVE",
  "given_name": "given_name2",
  "family_name": "family_name6",
  "email_address": "email_address2",
  "phone_number": "phone_number2",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "assigned_locations": {
    "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS",
    "location_ids": [
      "location_ids8",
      "location_ids9",
      "location_ids0"
    ]
  }
}
```

