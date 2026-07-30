
# Retrieve Booking Custom Attribute Request

Represents a [RetrieveBookingCustomAttribute](../../doc/apis/booking-custom-attributes.md#retrieve-booking-custom-attribute) request.

## Structure

`RetrieveBookingCustomAttributeRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `withDefinition` | `?bool` | Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of<br>the custom attribute. Set this parameter to `true` to get the name and description of the custom<br>attribute, information about the data type, or other definition details. The default value is `false`. | getWithDefinition(): ?bool | setWithDefinition(?bool withDefinition): void |
| `version` | `?int` | Optional | The current version of the custom attribute, which is used for strongly consistent reads to<br>guarantee that you receive the most up-to-date data. When included in the request, Square<br>returns the specified version or a higher version if one exists. If the specified version is<br>higher than the current version, Square returns a `BAD_REQUEST` error. | getVersion(): ?int | setVersion(?int version): void |

## Example (as JSON)

```json
{
  "with_definition": false,
  "version": 172
}
```

