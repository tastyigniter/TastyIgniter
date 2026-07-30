
# Location

Represents one of a business' [locations](https://developer.squareup.com/docs/locations-api).

## Structure

`Location`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A short generated string of letters and numbers that uniquely identifies this location instance.<br>**Constraints**: *Maximum Length*: `32` | getId(): ?string | setId(?string id): void |
| `name` | `?string` | Optional | The name of the location.<br>This information appears in the Seller Dashboard as the nickname.<br>A location name must be unique within a seller account.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |
| `address` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getAddress(): ?Address | setAddress(?Address address): void |
| `timezone` | `?string` | Optional | The [IANA time zone](https://www.iana.org/time-zones) identifier for<br>the time zone of the location. For example, `America/Los_Angeles`.<br>**Constraints**: *Maximum Length*: `30` | getTimezone(): ?string | setTimezone(?string timezone): void |
| `capabilities` | [`?(string[]) (LocationCapability)`](../../doc/models/location-capability.md) | Optional | The Square features that are enabled for the location.<br>See [LocationCapability](entity:LocationCapability) for possible values.<br>See [LocationCapability](#type-locationcapability) for possible values | getCapabilities(): ?array | setCapabilities(?array capabilities): void |
| `status` | [`?string (LocationStatus)`](../../doc/models/location-status.md) | Optional | A location's status. | getStatus(): ?string | setStatus(?string status): void |
| `createdAt` | `?string` | Optional | The time when the location was created, in RFC 3339 format.<br>For more information, see [Working with Dates](https://developer.squareup.com/docs/build-basics/working-with-dates).<br>**Constraints**: *Minimum Length*: `20`, *Maximum Length*: `25` | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `merchantId` | `?string` | Optional | The ID of the merchant that owns the location.<br>**Constraints**: *Maximum Length*: `32` | getMerchantId(): ?string | setMerchantId(?string merchantId): void |
| `country` | [`?string (Country)`](../../doc/models/country.md) | Optional | Indicates the country associated with another entity, such as a business.<br>Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm). | getCountry(): ?string | setCountry(?string country): void |
| `languageCode` | `?string` | Optional | The language associated with the location, in<br>[BCP 47 format](https://tools.ietf.org/html/bcp47#appendix-A).<br>For more information, see [Language Preferences](https://developer.squareup.com/docs/build-basics/general-considerations/language-preferences).<br>**Constraints**: *Minimum Length*: `2`, *Maximum Length*: `5` | getLanguageCode(): ?string | setLanguageCode(?string languageCode): void |
| `currency` | [`?string (Currency)`](../../doc/models/currency.md) | Optional | Indicates the associated currency for an amount of money. Values correspond<br>to [ISO 4217](https://wikipedia.org/wiki/ISO_4217). | getCurrency(): ?string | setCurrency(?string currency): void |
| `phoneNumber` | `?string` | Optional | The phone number of the location. For example, `+1 855-700-6000`.<br>**Constraints**: *Maximum Length*: `17` | getPhoneNumber(): ?string | setPhoneNumber(?string phoneNumber): void |
| `businessName` | `?string` | Optional | The name of the location's overall business. This name is present on receipts and other customer-facing branding.<br>**Constraints**: *Maximum Length*: `255` | getBusinessName(): ?string | setBusinessName(?string businessName): void |
| `type` | [`?string (LocationType)`](../../doc/models/location-type.md) | Optional | A location's type. | getType(): ?string | setType(?string type): void |
| `websiteUrl` | `?string` | Optional | The website URL of the location.  For example, `https://squareup.com`.<br>**Constraints**: *Maximum Length*: `255` | getWebsiteUrl(): ?string | setWebsiteUrl(?string websiteUrl): void |
| `businessHours` | [`?BusinessHours`](../../doc/models/business-hours.md) | Optional | The hours of operation for a location. | getBusinessHours(): ?BusinessHours | setBusinessHours(?BusinessHours businessHours): void |
| `businessEmail` | `?string` | Optional | The email address of the location. This can be unique to the location and is not always the email address for the business owner or administrator.<br>**Constraints**: *Maximum Length*: `255` | getBusinessEmail(): ?string | setBusinessEmail(?string businessEmail): void |
| `description` | `?string` | Optional | The description of the location. For example, `Main Street location`.<br>**Constraints**: *Maximum Length*: `1024` | getDescription(): ?string | setDescription(?string description): void |
| `twitterUsername` | `?string` | Optional | The Twitter username of the location without the '@' symbol. For example, `Square`.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `15` | getTwitterUsername(): ?string | setTwitterUsername(?string twitterUsername): void |
| `instagramUsername` | `?string` | Optional | The Instagram username of the location without the '@' symbol. For example, `square`.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `30` | getInstagramUsername(): ?string | setInstagramUsername(?string instagramUsername): void |
| `facebookUrl` | `?string` | Optional | The Facebook profile URL of the location. The URL should begin with 'facebook.com/'. For example, `https://www.facebook.com/square`.<br>**Constraints**: *Maximum Length*: `255` | getFacebookUrl(): ?string | setFacebookUrl(?string facebookUrl): void |
| `coordinates` | [`?Coordinates`](../../doc/models/coordinates.md) | Optional | Latitude and longitude coordinates. | getCoordinates(): ?Coordinates | setCoordinates(?Coordinates coordinates): void |
| `logoUrl` | `?string` | Optional | The URL of the logo image for the location. When configured in the Seller<br>Dashboard (Receipts section), the logo appears on transactions (such as receipts and invoices) that Square generates on behalf of the seller.<br>This image should have a roughly square (1:1) aspect ratio and should be at least 200x200 pixels.<br>**Constraints**: *Maximum Length*: `255` | getLogoUrl(): ?string | setLogoUrl(?string logoUrl): void |
| `posBackgroundUrl` | `?string` | Optional | The URL of the Point of Sale background image for the location.<br>**Constraints**: *Maximum Length*: `255` | getPosBackgroundUrl(): ?string | setPosBackgroundUrl(?string posBackgroundUrl): void |
| `mcc` | `?string` | Optional | A four-digit number that describes the kind of goods or services sold at the location.<br>The [merchant category code (MCC)](https://developer.squareup.com/docs/locations-api#initialize-a-merchant-category-code) of the location as standardized by ISO 18245.<br>For example, `5045`, for a location that sells computer goods and software.<br>**Constraints**: *Minimum Length*: `4`, *Maximum Length*: `4` | getMcc(): ?string | setMcc(?string mcc): void |
| `fullFormatLogoUrl` | `?string` | Optional | The URL of a full-format logo image for the location. When configured in the Seller<br>Dashboard (Receipts section), the logo appears on transactions (such as receipts and invoices) that Square generates on behalf of the seller.<br>This image can be wider than it is tall and should be at least 1280x648 pixels. | getFullFormatLogoUrl(): ?string | setFullFormatLogoUrl(?string fullFormatLogoUrl): void |
| `taxIds` | [`?TaxIds`](../../doc/models/tax-ids.md) | Optional | Identifiers for the location used by various governments for tax purposes. | getTaxIds(): ?TaxIds | setTaxIds(?TaxIds taxIds): void |

## Example (as JSON)

```json
{
  "id": "id0",
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
  "timezone": "timezone0",
  "capabilities": [
    "CREDIT_CARD_PROCESSING"
  ],
  "status": "ACTIVE",
  "created_at": "created_at2",
  "merchant_id": "merchant_id0",
  "country": "FO",
  "language_code": "language_code8",
  "currency": "YER",
  "phone_number": "phone_number2",
  "business_name": "business_name4",
  "type": "PHYSICAL",
  "website_url": "website_url8",
  "business_hours": {
    "periods": [
      {
        "day_of_week": "SUN",
        "start_local_time": "start_local_time3",
        "end_local_time": "end_local_time5"
      },
      {
        "day_of_week": "SAT",
        "start_local_time": "start_local_time4",
        "end_local_time": "end_local_time6"
      },
      {
        "day_of_week": "FRI",
        "start_local_time": "start_local_time5",
        "end_local_time": "end_local_time7"
      }
    ]
  },
  "business_email": "business_email4",
  "description": "description0",
  "twitter_username": "twitter_username2",
  "instagram_username": "instagram_username4",
  "facebook_url": "facebook_url2",
  "coordinates": {
    "latitude": 39.14,
    "longitude": 36.94
  },
  "logo_url": "logo_url0",
  "pos_background_url": "pos_background_url2",
  "mcc": "mcc0",
  "full_format_logo_url": "full_format_logo_url4",
  "tax_ids": {
    "eu_vat": "eu_vat2",
    "fr_siret": "fr_siret4",
    "fr_naf": "fr_naf4",
    "es_nif": "es_nif8"
  }
}
```

