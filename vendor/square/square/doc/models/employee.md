
# Employee

An employee object that is used by the external API.

## Structure

`Employee`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | UUID for this object. | getId(): ?string | setId(?string id): void |
| `firstName` | `?string` | Optional | The employee's first name. | getFirstName(): ?string | setFirstName(?string firstName): void |
| `lastName` | `?string` | Optional | The employee's last name. | getLastName(): ?string | setLastName(?string lastName): void |
| `email` | `?string` | Optional | The employee's email address | getEmail(): ?string | setEmail(?string email): void |
| `phoneNumber` | `?string` | Optional | The employee's phone number in E.164 format, i.e. "+12125554250" | getPhoneNumber(): ?string | setPhoneNumber(?string phoneNumber): void |
| `locationIds` | `?(string[])` | Optional | A list of location IDs where this employee has access to. | getLocationIds(): ?array | setLocationIds(?array locationIds): void |
| `status` | [`?string (EmployeeStatus)`](../../doc/models/employee-status.md) | Optional | The status of the Employee being retrieved. | getStatus(): ?string | setStatus(?string status): void |
| `isOwner` | `?bool` | Optional | Whether this employee is the owner of the merchant. Each merchant<br>has one owner employee, and that employee has full authority over<br>the account. | getIsOwner(): ?bool | setIsOwner(?bool isOwner): void |
| `createdAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "first_name": "first_name0",
  "last_name": "last_name8",
  "email": "email6",
  "phone_number": "phone_number2",
  "location_ids": [
    "location_ids0"
  ],
  "status": "ACTIVE",
  "is_owner": false,
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

