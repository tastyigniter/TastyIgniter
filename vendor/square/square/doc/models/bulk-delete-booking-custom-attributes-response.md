
# Bulk Delete Booking Custom Attributes Response

Represents a [BulkDeleteBookingCustomAttributes](../../doc/apis/booking-custom-attributes.md#bulk-delete-booking-custom-attributes) response,
which contains a map of responses that each corresponds to an individual delete request.

## Structure

`BulkDeleteBookingCustomAttributesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `values` | [`?array<string,BookingCustomAttributeDeleteResponse>`](../../doc/models/booking-custom-attribute-delete-response.md) | Optional | A map of responses that correspond to individual delete requests. Each response has the<br>same ID as the corresponding request and contains `booking_id` and  `errors` field. | getValues(): ?array | setValues(?array values): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "errors": [],
  "values": {
    "id1": {
      "booking_id": "N3NCVYY3WS27HF0HKANA3R9FP8",
      "errors": []
    },
    "id2": {
      "booking_id": "SY8EMWRNDN3TQDP2H4KS1QWMMM",
      "errors": []
    },
    "id3": {
      "booking_id": "SY8EMWRNDN3TQDP2H4KS1QWMMM",
      "errors": []
    }
  }
}
```

