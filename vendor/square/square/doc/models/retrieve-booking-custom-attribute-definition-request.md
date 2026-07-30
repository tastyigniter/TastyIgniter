
# Retrieve Booking Custom Attribute Definition Request

Represents a [RetrieveBookingCustomAttributeDefinition](../../doc/apis/booking-custom-attributes.md#retrieve-booking-custom-attribute-definition) request.

## Structure

`RetrieveBookingCustomAttributeDefinitionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `version` | `?int` | Optional | The current version of the custom attribute definition, which is used for strongly consistent<br>reads to guarantee that you receive the most up-to-date data. When included in the request,<br>Square returns the specified version or a higher version if one exists. If the specified version<br>is higher than the current version, Square returns a `BAD_REQUEST` error. | getVersion(): ?int | setVersion(?int version): void |

## Example (as JSON)

```json
{
  "version": 172
}
```

