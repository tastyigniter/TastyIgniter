
# Vendor

Represents a supplier to a seller.

## Structure

`Vendor`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A unique Square-generated ID for the [Vendor](entity:Vendor).<br>This field is required when attempting to update a [Vendor](entity:Vendor).<br>**Constraints**: *Maximum Length*: `100` | getId(): ?string | setId(?string id): void |
| `createdAt` | `?string` | Optional | An RFC 3339-formatted timestamp that indicates when the<br>[Vendor](entity:Vendor) was created.<br>**Constraints**: *Maximum Length*: `34` | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | An RFC 3339-formatted timestamp that indicates when the<br>[Vendor](entity:Vendor) was last updated.<br>**Constraints**: *Maximum Length*: `34` | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `name` | `?string` | Optional | The name of the [Vendor](entity:Vendor).<br>This field is required when attempting to create or update a [Vendor](entity:Vendor).<br>**Constraints**: *Maximum Length*: `100` | getName(): ?string | setName(?string name): void |
| `address` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getAddress(): ?Address | setAddress(?Address address): void |
| `contacts` | [`?(VendorContact[])`](../../doc/models/vendor-contact.md) | Optional | The contacts of the [Vendor](entity:Vendor). | getContacts(): ?array | setContacts(?array contacts): void |
| `accountNumber` | `?string` | Optional | The account number of the [Vendor](entity:Vendor).<br>**Constraints**: *Maximum Length*: `100` | getAccountNumber(): ?string | setAccountNumber(?string accountNumber): void |
| `note` | `?string` | Optional | A note detailing information about the [Vendor](entity:Vendor).<br>**Constraints**: *Maximum Length*: `4096` | getNote(): ?string | setNote(?string note): void |
| `version` | `?int` | Optional | The version of the [Vendor](entity:Vendor). | getVersion(): ?int | setVersion(?int version): void |
| `status` | [`?string (VendorStatus)`](../../doc/models/vendor-status.md) | Optional | The status of the [Vendor](../../doc/models/vendor.md),<br>whether a [Vendor](../../doc/models/vendor.md) is active or inactive. | getStatus(): ?string | setStatus(?string status): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "name": "name0",
  "address": {
    "address_line_1": "address_line_16",
    "address_line_2": "address_line_26",
    "address_line_3": "address_line_32",
    "locality": "locality6",
    "sublocality": "sublocality6",
    "sublocality_2": "sublocality_24",
    "sublocality_3": "sublocality_36",
    "administrative_district_level_1": "administrative_district_level_10",
    "administrative_district_level_2": "administrative_district_level_28",
    "administrative_district_level_3": "administrative_district_level_34",
    "postal_code": "postal_code8",
    "country": "BE",
    "first_name": "first_name6",
    "last_name": "last_name4"
  },
  "contacts": [
    {
      "id": "id7",
      "name": "name7",
      "email_address": "email_address5",
      "phone_number": "phone_number5",
      "removed": true,
      "ordinal": 19
    },
    {
      "id": "id8",
      "name": "name8",
      "email_address": "email_address6",
      "phone_number": "phone_number6",
      "removed": false,
      "ordinal": 20
    }
  ],
  "account_number": "account_number0",
  "note": "note4",
  "version": 172,
  "status": "ACTIVE"
}
```

