
# Fulfillment Recipient

Information about the fulfillment recipient.

## Structure

`FulfillmentRecipient`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customerId` | `?string` | Optional | The ID of the customer associated with the fulfillment.<br><br>If `customer_id` is provided, the fulfillment recipient's `display_name`,<br>`email_address`, and `phone_number` are automatically populated from the<br>targeted customer profile. If these fields are set in the request, the request<br>values override the information from the customer profile. If the<br>targeted customer profile does not contain the necessary information and<br>these fields are left unset, the request results in an error.<br>**Constraints**: *Maximum Length*: `191` | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `displayName` | `?string` | Optional | The display name of the fulfillment recipient. This field is required.<br><br>If provided, the display name overrides the corresponding customer profile value<br>indicated by `customer_id`.<br>**Constraints**: *Maximum Length*: `255` | getDisplayName(): ?string | setDisplayName(?string displayName): void |
| `emailAddress` | `?string` | Optional | The email address of the fulfillment recipient.<br><br>If provided, the email address overrides the corresponding customer profile value<br>indicated by `customer_id`.<br>**Constraints**: *Maximum Length*: `255` | getEmailAddress(): ?string | setEmailAddress(?string emailAddress): void |
| `phoneNumber` | `?string` | Optional | The phone number of the fulfillment recipient. This field is required.<br><br>If provided, the phone number overrides the corresponding customer profile value<br>indicated by `customer_id`.<br>**Constraints**: *Maximum Length*: `17` | getPhoneNumber(): ?string | setPhoneNumber(?string phoneNumber): void |
| `address` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getAddress(): ?Address | setAddress(?Address address): void |

## Example (as JSON)

```json
{
  "customer_id": "customer_id8",
  "display_name": "display_name0",
  "email_address": "email_address2",
  "phone_number": "phone_number2",
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
  }
}
```

