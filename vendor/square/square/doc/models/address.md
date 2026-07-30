
# Address

Represents a postal address in a country.
For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses).

## Structure

`Address`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `addressLine1` | `?string` | Optional | The first line of the address.<br><br>Fields that start with `address_line` provide the address's most specific<br>details, like street number, street name, and building name. They do *not*<br>provide less specific details like city, state/province, or country (these<br>details are provided in other fields). | getAddressLine1(): ?string | setAddressLine1(?string addressLine1): void |
| `addressLine2` | `?string` | Optional | The second line of the address, if any. | getAddressLine2(): ?string | setAddressLine2(?string addressLine2): void |
| `addressLine3` | `?string` | Optional | The third line of the address, if any. | getAddressLine3(): ?string | setAddressLine3(?string addressLine3): void |
| `locality` | `?string` | Optional | The city or town of the address. For a full list of field meanings by country, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getLocality(): ?string | setLocality(?string locality): void |
| `sublocality` | `?string` | Optional | A civil region within the address's `locality`, if any. | getSublocality(): ?string | setSublocality(?string sublocality): void |
| `sublocality2` | `?string` | Optional | A civil region within the address's `sublocality`, if any. | getSublocality2(): ?string | setSublocality2(?string sublocality2): void |
| `sublocality3` | `?string` | Optional | A civil region within the address's `sublocality_2`, if any. | getSublocality3(): ?string | setSublocality3(?string sublocality3): void |
| `administrativeDistrictLevel1` | `?string` | Optional | A civil entity within the address's country. In the US, this<br>is the state. For a full list of field meanings by country, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getAdministrativeDistrictLevel1(): ?string | setAdministrativeDistrictLevel1(?string administrativeDistrictLevel1): void |
| `administrativeDistrictLevel2` | `?string` | Optional | A civil entity within the address's `administrative_district_level_1`.<br>In the US, this is the county. | getAdministrativeDistrictLevel2(): ?string | setAdministrativeDistrictLevel2(?string administrativeDistrictLevel2): void |
| `administrativeDistrictLevel3` | `?string` | Optional | A civil entity within the address's `administrative_district_level_2`,<br>if any. | getAdministrativeDistrictLevel3(): ?string | setAdministrativeDistrictLevel3(?string administrativeDistrictLevel3): void |
| `postalCode` | `?string` | Optional | The address's postal code. For a full list of field meanings by country, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getPostalCode(): ?string | setPostalCode(?string postalCode): void |
| `country` | [`?string (Country)`](../../doc/models/country.md) | Optional | Indicates the country associated with another entity, such as a business.<br>Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm). | getCountry(): ?string | setCountry(?string country): void |
| `firstName` | `?string` | Optional | Optional first name when it's representing recipient. | getFirstName(): ?string | setFirstName(?string firstName): void |
| `lastName` | `?string` | Optional | Optional last name when it's representing recipient. | getLastName(): ?string | setLastName(?string lastName): void |

## Example (as JSON)

```json
{
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
  "country": "FO",
  "first_name": "first_name0",
  "last_name": "last_name8"
}
```

