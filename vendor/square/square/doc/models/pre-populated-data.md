
# Pre Populated Data

Describes buyer data to prepopulate in the payment form.
For more information,
see [Optional Checkout Configurations](https://developer.squareup.com/docs/checkout-api/optional-checkout-configurations).

## Structure

`PrePopulatedData`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `buyerEmail` | `?string` | Optional | The buyer email to prepopulate in the payment form.<br>**Constraints**: *Maximum Length*: `256` | getBuyerEmail(): ?string | setBuyerEmail(?string buyerEmail): void |
| `buyerPhoneNumber` | `?string` | Optional | The buyer phone number to prepopulate in the payment form.<br>**Constraints**: *Maximum Length*: `17` | getBuyerPhoneNumber(): ?string | setBuyerPhoneNumber(?string buyerPhoneNumber): void |
| `buyerAddress` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getBuyerAddress(): ?Address | setBuyerAddress(?Address buyerAddress): void |

## Example (as JSON)

```json
{
  "buyer_email": "buyer_email8",
  "buyer_phone_number": "buyer_phone_number0",
  "buyer_address": {
    "address_line_1": "address_line_12",
    "address_line_2": "address_line_22",
    "address_line_3": "address_line_38",
    "locality": "locality2",
    "sublocality": "sublocality2",
    "sublocality_2": "sublocality_20",
    "sublocality_3": "sublocality_32",
    "administrative_district_level_1": "administrative_district_level_16",
    "administrative_district_level_2": "administrative_district_level_28",
    "administrative_district_level_3": "administrative_district_level_30",
    "postal_code": "postal_code4",
    "country": "IO",
    "first_name": "first_name2",
    "last_name": "last_name0"
  }
}
```

