
# List Locations Response

Defines the fields that are included in the response body of a request
to the [ListLocations](../../doc/apis/locations.md#list-locations) endpoint.

Either `errors` or `locations` is present in a given response (never both).

## Structure

`ListLocationsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `locations` | [`?(Location[])`](../../doc/models/location.md) | Optional | The business locations. | getLocations(): ?array | setLocations(?array locations): void |

## Example (as JSON)

```json
{
  "locations": [
    {
      "address": {
        "address_line_1": "123 Main St",
        "administrative_district_level_1": "CA",
        "country": "US",
        "locality": "San Francisco",
        "postal_code": "94114"
      },
      "business_name": "Jet Fuel Coffee",
      "capabilities": [
        "CREDIT_CARD_PROCESSING"
      ],
      "country": "US",
      "created_at": "2016-09-19T17:33:12Z",
      "currency": "USD",
      "id": "18YC4JDH91E1H",
      "language_code": "en-US",
      "merchant_id": "3MYCJG5GVYQ8Q",
      "name": "Grant Park",
      "phone_number": "+1 650-354-7217",
      "status": "ACTIVE",
      "timezone": "America/Los_Angeles"
    },
    {
      "address": {
        "address_line_1": "1234 Peachtree St. NE",
        "administrative_district_level_1": "GA",
        "locality": "Atlanta",
        "postal_code": "30309"
      },
      "business_name": "Jet Fuel Coffee",
      "capabilities": [
        "CREDIT_CARD_PROCESSING"
      ],
      "coordinates": {
        "latitude": 33.7889,
        "longitude": -84.3841
      },
      "country": "US",
      "created_at": "2022-02-19T17:58:25Z",
      "currency": "USD",
      "description": "Midtown Atlanta store",
      "id": "3Z4V4WHQK64X9",
      "language_code": "en-US",
      "mcc": "7299",
      "merchant_id": "3MYCJG5GVYQ8Q",
      "name": "Midtown",
      "status": "ACTIVE",
      "timezone": "America/New_York",
      "type": "PHYSICAL"
    }
  ]
}
```

