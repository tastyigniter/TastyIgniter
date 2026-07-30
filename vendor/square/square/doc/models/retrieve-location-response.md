
# Retrieve Location Response

Defines the fields that the [RetrieveLocation](../../doc/apis/locations.md#retrieve-location)
endpoint returns in a response.

## Structure

`RetrieveLocationResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `location` | [`?Location`](../../doc/models/location.md) | Optional | Represents one of a business' [locations](https://developer.squareup.com/docs/locations-api). | getLocation(): ?Location | setLocation(?Location location): void |

## Example (as JSON)

```json
{
  "location": {
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
  }
}
```

