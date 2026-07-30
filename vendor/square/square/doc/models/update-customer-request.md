
# Update Customer Request

Defines the body parameters that can be included in a request to the
`UpdateCustomer` endpoint.

## Structure

`UpdateCustomerRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `givenName` | `?string` | Optional | The given name (that is, the first name) associated with the customer profile.<br><br>The maximum length for this value is 300 characters. | getGivenName(): ?string | setGivenName(?string givenName): void |
| `familyName` | `?string` | Optional | The family name (that is, the last name) associated with the customer profile.<br><br>The maximum length for this value is 300 characters. | getFamilyName(): ?string | setFamilyName(?string familyName): void |
| `companyName` | `?string` | Optional | A business name associated with the customer profile.<br><br>The maximum length for this value is 500 characters. | getCompanyName(): ?string | setCompanyName(?string companyName): void |
| `nickname` | `?string` | Optional | A nickname for the customer profile.<br><br>The maximum length for this value is 100 characters. | getNickname(): ?string | setNickname(?string nickname): void |
| `emailAddress` | `?string` | Optional | The email address associated with the customer profile.<br><br>The maximum length for this value is 254 characters. | getEmailAddress(): ?string | setEmailAddress(?string emailAddress): void |
| `address` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getAddress(): ?Address | setAddress(?Address address): void |
| `phoneNumber` | `?string` | Optional | The phone number associated with the customer profile. The phone number must be valid and can contain<br>9–16 digits, with an optional `+` prefix and country code. For more information, see<br>[Customer phone numbers](https://developer.squareup.com/docs/customers-api/use-the-api/keep-records#phone-number). | getPhoneNumber(): ?string | setPhoneNumber(?string phoneNumber): void |
| `referenceId` | `?string` | Optional | An optional second ID used to associate the customer profile with an<br>entity in another system.<br><br>The maximum length for this value is 100 characters. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `note` | `?string` | Optional | A custom note associated with the customer profile. | getNote(): ?string | setNote(?string note): void |
| `birthday` | `?string` | Optional | The birthday associated with the customer profile, in `YYYY-MM-DD` or `MM-DD` format. For example,<br>specify `1998-09-21` for September 21, 1998, or `09-21` for September 21. Birthdays are returned in `YYYY-MM-DD`<br>format, where `YYYY` is the specified birth year or `0000` if a birth year is not specified. | getBirthday(): ?string | setBirthday(?string birthday): void |
| `version` | `?int` | Optional | The current version of the customer profile.<br><br>As a best practice, you should include this field to enable [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency) control. For more information, see [Update a customer profile](https://developer.squareup.com/docs/customers-api/use-the-api/keep-records#update-a-customer-profile). | getVersion(): ?int | setVersion(?int version): void |
| `taxIds` | [`?CustomerTaxIds`](../../doc/models/customer-tax-ids.md) | Optional | Represents the tax ID associated with a [customer profile](../../doc/models/customer.md). The corresponding `tax_ids` field is available only for customers of sellers in EU countries or the United Kingdom.<br>For more information, see [Customer tax IDs](https://developer.squareup.com/docs/customers-api/what-it-does#customer-tax-ids). | getTaxIds(): ?CustomerTaxIds | setTaxIds(?CustomerTaxIds taxIds): void |

## Example (as JSON)

```json
{
  "email_address": "New.Amelia.Earhart@example.com",
  "note": "updated customer note",
  "phone_number": "",
  "version": 2
}
```

