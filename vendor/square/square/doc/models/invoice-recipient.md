
# Invoice Recipient

Represents a snapshot of customer data. This object stores customer data that is displayed on the invoice
and that Square uses to deliver the invoice.

When you provide a customer ID for a draft invoice, Square retrieves the associated customer profile and populates
the remaining `InvoiceRecipient` fields. You cannot update these fields after the invoice is published.
Square updates the customer ID in response to a merge operation, but does not update other fields.

## Structure

`InvoiceRecipient`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customerId` | `?string` | Optional | The ID of the customer. This is the customer profile ID that<br>you provide when creating a draft invoice.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `givenName` | `?string` | Optional | The recipient's given (that is, first) name. | getGivenName(): ?string | setGivenName(?string givenName): void |
| `familyName` | `?string` | Optional | The recipient's family (that is, last) name. | getFamilyName(): ?string | setFamilyName(?string familyName): void |
| `emailAddress` | `?string` | Optional | The recipient's email address. | getEmailAddress(): ?string | setEmailAddress(?string emailAddress): void |
| `address` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getAddress(): ?Address | setAddress(?Address address): void |
| `phoneNumber` | `?string` | Optional | The recipient's phone number. | getPhoneNumber(): ?string | setPhoneNumber(?string phoneNumber): void |
| `companyName` | `?string` | Optional | The name of the recipient's company. | getCompanyName(): ?string | setCompanyName(?string companyName): void |
| `taxIds` | [`?InvoiceRecipientTaxIds`](../../doc/models/invoice-recipient-tax-ids.md) | Optional | Represents the tax IDs for an invoice recipient. The country of the seller account determines<br>whether the corresponding `tax_ids` field is available for the customer. For more information,<br>see [Invoice recipient tax IDs](https://developer.squareup.com/docs/invoices-api/overview#recipient-tax-ids). | getTaxIds(): ?InvoiceRecipientTaxIds | setTaxIds(?InvoiceRecipientTaxIds taxIds): void |

## Example (as JSON)

```json
{
  "customer_id": "customer_id8",
  "given_name": "given_name2",
  "family_name": "family_name6",
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
  "company_name": "company_name6",
  "tax_ids": {
    "eu_vat": "eu_vat2"
  }
}
```

