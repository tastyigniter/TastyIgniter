
# Customer

Represents a Square customer profile in the Customer Directory of a Square seller.

## Structure

`Customer`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A unique Square-assigned ID for the customer profile.<br><br>If you need this ID for an API request, use the ID returned when you created the customer profile or call the [SearchCustomers](api-endpoint:Customers-SearchCustomers)<br>or [ListCustomers](api-endpoint:Customers-ListCustomers) endpoint. | getId(): ?string | setId(?string id): void |
| `createdAt` | `?string` | Optional | The timestamp when the customer profile was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp when the customer profile was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `cards` | [`?(Card[])`](../../doc/models/card.md) | Optional | Payment details of the credit, debit, and gift cards stored on file for the customer profile.<br><br>DEPRECATED at version 2021-06-16. Replaced by calling [ListCards](api-endpoint:Cards-ListCards) (for credit and debit cards on file)<br>or [ListGiftCards](api-endpoint:GiftCards-ListGiftCards) (for gift cards on file) and including the `customer_id` query parameter.<br>For more information, see [Migration notes](https://developer.squareup.com/docs/customers-api/what-it-does#migrate-customer-cards). | getCards(): ?array | setCards(?array cards): void |
| `givenName` | `?string` | Optional | The given name (that is, the first name) associated with the customer profile. | getGivenName(): ?string | setGivenName(?string givenName): void |
| `familyName` | `?string` | Optional | The family name (that is, the last name) associated with the customer profile. | getFamilyName(): ?string | setFamilyName(?string familyName): void |
| `nickname` | `?string` | Optional | A nickname for the customer profile. | getNickname(): ?string | setNickname(?string nickname): void |
| `companyName` | `?string` | Optional | A business name associated with the customer profile. | getCompanyName(): ?string | setCompanyName(?string companyName): void |
| `emailAddress` | `?string` | Optional | The email address associated with the customer profile. | getEmailAddress(): ?string | setEmailAddress(?string emailAddress): void |
| `address` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getAddress(): ?Address | setAddress(?Address address): void |
| `phoneNumber` | `?string` | Optional | The phone number associated with the customer profile. | getPhoneNumber(): ?string | setPhoneNumber(?string phoneNumber): void |
| `birthday` | `?string` | Optional | The birthday associated with the customer profile, in `YYYY-MM-DD` format. For example, `1998-09-21`<br>represents September 21, 1998, and `0000-09-21` represents September 21 (without a birth year). | getBirthday(): ?string | setBirthday(?string birthday): void |
| `referenceId` | `?string` | Optional | An optional second ID used to associate the customer profile with an<br>entity in another system. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `note` | `?string` | Optional | A custom note associated with the customer profile. | getNote(): ?string | setNote(?string note): void |
| `preferences` | [`?CustomerPreferences`](../../doc/models/customer-preferences.md) | Optional | Represents communication preferences for the customer profile. | getPreferences(): ?CustomerPreferences | setPreferences(?CustomerPreferences preferences): void |
| `creationSource` | [`?string (CustomerCreationSource)`](../../doc/models/customer-creation-source.md) | Optional | Indicates the method used to create the customer profile. | getCreationSource(): ?string | setCreationSource(?string creationSource): void |
| `groupIds` | `?(string[])` | Optional | The IDs of [customer groups](entity:CustomerGroup) the customer belongs to. | getGroupIds(): ?array | setGroupIds(?array groupIds): void |
| `segmentIds` | `?(string[])` | Optional | The IDs of [customer segments](entity:CustomerSegment) the customer belongs to. | getSegmentIds(): ?array | setSegmentIds(?array segmentIds): void |
| `version` | `?int` | Optional | The Square-assigned version number of the customer profile. The version number is incremented each time an update is committed to the customer profile, except for changes to customer segment membership and cards on file. | getVersion(): ?int | setVersion(?int version): void |
| `taxIds` | [`?CustomerTaxIds`](../../doc/models/customer-tax-ids.md) | Optional | Represents the tax ID associated with a [customer profile](../../doc/models/customer.md). The corresponding `tax_ids` field is available only for customers of sellers in EU countries or the United Kingdom.<br>For more information, see [Customer tax IDs](https://developer.squareup.com/docs/customers-api/what-it-does#customer-tax-ids). | getTaxIds(): ?CustomerTaxIds | setTaxIds(?CustomerTaxIds taxIds): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "cards": [
    {
      "id": "id7",
      "card_brand": "EBT",
      "last_4": "last_49",
      "exp_month": 79,
      "exp_year": 217,
      "cardholder_name": "cardholder_name7",
      "billing_address": {
        "address_line_1": "address_line_11",
        "address_line_2": "address_line_29",
        "address_line_3": "address_line_35",
        "locality": "locality9",
        "sublocality": "sublocality9",
        "sublocality_2": "sublocality_27",
        "sublocality_3": "sublocality_39",
        "administrative_district_level_1": "administrative_district_level_13",
        "administrative_district_level_2": "administrative_district_level_25",
        "administrative_district_level_3": "administrative_district_level_37",
        "postal_code": "postal_code1",
        "country": "CW",
        "first_name": "first_name9",
        "last_name": "last_name7"
      },
      "fingerprint": "fingerprint3",
      "customer_id": "customer_id5",
      "merchant_id": "merchant_id7",
      "reference_id": "reference_id5",
      "enabled": true,
      "card_type": "DEBIT",
      "prepaid_type": "UNKNOWN_PREPAID_TYPE",
      "bin": "bin7",
      "version": 47,
      "card_co_brand": "UNKNOWN"
    },
    {
      "id": "id8",
      "card_brand": "FELICA",
      "last_4": "last_40",
      "exp_month": 78,
      "exp_year": 218,
      "cardholder_name": "cardholder_name6",
      "billing_address": {
        "address_line_1": "address_line_10",
        "address_line_2": "address_line_20",
        "address_line_3": "address_line_36",
        "locality": "locality0",
        "sublocality": "sublocality0",
        "sublocality_2": "sublocality_28",
        "sublocality_3": "sublocality_30",
        "administrative_district_level_1": "administrative_district_level_14",
        "administrative_district_level_2": "administrative_district_level_24",
        "administrative_district_level_3": "administrative_district_level_38",
        "postal_code": "postal_code2",
        "country": "CX",
        "first_name": "first_name0",
        "last_name": "last_name8"
      },
      "fingerprint": "fingerprint4",
      "customer_id": "customer_id6",
      "merchant_id": "merchant_id8",
      "reference_id": "reference_id6",
      "enabled": false,
      "card_type": "CREDIT",
      "prepaid_type": "NOT_PREPAID",
      "bin": "bin8",
      "version": 48,
      "card_co_brand": "CLEARPAY"
    }
  ],
  "given_name": "given_name2",
  "family_name": "family_name6",
  "nickname": "nickname6",
  "company_name": "company_name6",
  "email_address": "email_address2",
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
  "phone_number": "phone_number2",
  "birthday": "birthday0",
  "reference_id": "reference_id2",
  "note": "note4",
  "preferences": {
    "email_unsubscribed": false
  },
  "creation_source": "MERGE",
  "group_ids": [
    "group_ids3",
    "group_ids4",
    "group_ids5"
  ],
  "segment_ids": [
    "segment_ids0",
    "segment_ids1",
    "segment_ids2"
  ],
  "version": 172,
  "tax_ids": {
    "eu_vat": "eu_vat2"
  }
}
```

