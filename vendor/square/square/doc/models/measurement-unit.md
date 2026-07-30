
# Measurement Unit

Represents a unit of measurement to use with a quantity, such as ounces
or inches. Exactly one of the following fields are required: `custom_unit`,
`area_unit`, `length_unit`, `volume_unit`, and `weight_unit`.

## Structure

`MeasurementUnit`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customUnit` | [`?MeasurementUnitCustom`](../../doc/models/measurement-unit-custom.md) | Optional | The information needed to define a custom unit, provided by the seller. | getCustomUnit(): ?MeasurementUnitCustom | setCustomUnit(?MeasurementUnitCustom customUnit): void |
| `areaUnit` | [`?string (MeasurementUnitArea)`](../../doc/models/measurement-unit-area.md) | Optional | Unit of area used to measure a quantity. | getAreaUnit(): ?string | setAreaUnit(?string areaUnit): void |
| `lengthUnit` | [`?string (MeasurementUnitLength)`](../../doc/models/measurement-unit-length.md) | Optional | The unit of length used to measure a quantity. | getLengthUnit(): ?string | setLengthUnit(?string lengthUnit): void |
| `volumeUnit` | [`?string (MeasurementUnitVolume)`](../../doc/models/measurement-unit-volume.md) | Optional | The unit of volume used to measure a quantity. | getVolumeUnit(): ?string | setVolumeUnit(?string volumeUnit): void |
| `weightUnit` | [`?string (MeasurementUnitWeight)`](../../doc/models/measurement-unit-weight.md) | Optional | Unit of weight used to measure a quantity. | getWeightUnit(): ?string | setWeightUnit(?string weightUnit): void |
| `genericUnit` | [`?string (MeasurementUnitGeneric)`](../../doc/models/measurement-unit-generic.md) | Optional | - | getGenericUnit(): ?string | setGenericUnit(?string genericUnit): void |
| `timeUnit` | [`?string (MeasurementUnitTime)`](../../doc/models/measurement-unit-time.md) | Optional | Unit of time used to measure a quantity (a duration). | getTimeUnit(): ?string | setTimeUnit(?string timeUnit): void |
| `type` | [`?string (MeasurementUnitUnitType)`](../../doc/models/measurement-unit-unit-type.md) | Optional | Describes the type of this unit and indicates which field contains the unit information. This is an ‘open’ enum. | getType(): ?string | setType(?string type): void |

## Example (as JSON)

```json
{
  "custom_unit": {
    "name": "name2",
    "abbreviation": "abbreviation4"
  },
  "area_unit": "IMPERIAL_SQUARE_MILE",
  "length_unit": "METRIC_MILLIMETER",
  "volume_unit": "GENERIC_CUP",
  "weight_unit": "IMPERIAL_STONE",
  "generic_unit": "UNIT",
  "time_unit": "GENERIC_MINUTE",
  "type": "TYPE_LENGTH"
}
```

