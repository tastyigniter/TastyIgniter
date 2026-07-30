
# Search Team Members Response

Represents a response from a search request containing a filtered list of `TeamMember` objects.

## Structure

`SearchTeamMembersResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `teamMembers` | [`?(TeamMember[])`](../../doc/models/team-member.md) | Optional | The filtered list of `TeamMember` objects. | getTeamMembers(): ?array | setTeamMembers(?array teamMembers): void |
| `cursor` | `?string` | Optional | The opaque cursor for fetching the next page. For more information, see<br>[pagination](https://developer.squareup.com/docs/working-with-apis/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | The errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "cursor": "N:9UglUjOXQ13-hMFypCft",
  "team_members": [
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2019-07-10T17:26:48Z",
      "email_address": "johnny_cash@squareup.com",
      "family_name": "Cash",
      "given_name": "Johnny",
      "id": "-3oZQKPKVk6gUXU_V5Qa",
      "is_owner": false,
      "reference_id": "12345678",
      "status": "ACTIVE",
      "updated_at": "2020-04-28T21:49:28Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T18:14:01Z",
      "family_name": "Smith",
      "given_name": "Lombard",
      "id": "1AVJj0DjkzbmbJw5r4KK",
      "is_owner": false,
      "phone_number": "+14155552671",
      "reference_id": "abcded",
      "status": "ACTIVE",
      "updated_at": "2020-06-09T17:38:05Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T01:09:25Z",
      "family_name": "Sway",
      "given_name": "Monica",
      "id": "2JCmiJol_KKFs9z2Evim",
      "is_owner": false,
      "status": "ACTIVE",
      "updated_at": "2020-03-24T01:11:25Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T01:09:23Z",
      "family_name": "Ipsum",
      "given_name": "Elton",
      "id": "4uXcJQSLtbk3F0UQHFNQ",
      "is_owner": false,
      "status": "ACTIVE",
      "updated_at": "2020-03-24T01:15:23Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T01:09:23Z",
      "family_name": "Lo",
      "given_name": "Steven",
      "id": "5CoUpyrw1YwGWcRd-eDL",
      "is_owner": false,
      "status": "ACTIVE",
      "updated_at": "2020-03-24T01:19:23Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T18:14:03Z",
      "family_name": "Steward",
      "given_name": "Patrick",
      "id": "5MRPTTp8MMBLVSmzrGha",
      "is_owner": false,
      "phone_number": "+14155552671",
      "status": "ACTIVE",
      "updated_at": "2020-03-24T18:18:03Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T01:09:25Z",
      "family_name": "Manny",
      "given_name": "Ivy",
      "id": "7F5ZxsfRnkexhu1PTbfh",
      "is_owner": false,
      "status": "ACTIVE",
      "updated_at": "2020-03-24T01:09:25Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T18:14:02Z",
      "email_address": "john_smith@example.com",
      "family_name": "Smith",
      "given_name": "John",
      "id": "808X9HR72yKvVaigQXf4",
      "is_owner": false,
      "phone_number": "+14155552671",
      "status": "ACTIVE",
      "updated_at": "2020-03-24T18:14:02Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T18:14:00Z",
      "email_address": "r_wen@example.com",
      "family_name": "Wen",
      "given_name": "Robert",
      "id": "9MVDVoY4hazkWKGo_OuZ",
      "is_owner": false,
      "phone_number": "+14155552671",
      "status": "ACTIVE",
      "updated_at": "2020-03-24T18:14:00Z"
    },
    {
      "assigned_locations": {
        "assignment_type": "ALL_CURRENT_AND_FUTURE_LOCATIONS"
      },
      "created_at": "2020-03-24T18:14:00Z",
      "email_address": "asimpson@example.com",
      "family_name": "Simpson",
      "given_name": "Ashley",
      "id": "9UglUjOXQ13-hMFypCft",
      "is_owner": false,
      "phone_number": "+14155552671",
      "status": "ACTIVE",
      "updated_at": "2020-03-24T18:18:00Z"
    }
  ]
}
```

