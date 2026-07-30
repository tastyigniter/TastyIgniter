
# Standard Unit Description Group

Group of standard measurement units.

## Structure

`StandardUnitDescriptionGroup`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `standardUnitDescriptions` | [`?(StandardUnitDescription[])`](../../doc/models/standard-unit-description.md) | Optional | List of standard (non-custom) measurement units in this description group. | getStandardUnitDescriptions(): ?array | setStandardUnitDescriptions(?array standardUnitDescriptions): void |
| `languageCode` | `?string` | Optional | IETF language tag. | getLanguageCode(): ?string | setLanguageCode(?string languageCode): void |

## Example (as JSON)

```json
{
  "standard_unit_descriptions": [
    {
      "unit": {
        "custom_unit": {
          "name": "name1",
          "abbreviation": "abbreviation3"
        },
        "area_unit": "IMPERIAL_SQUARE_INCH",
        "length_unit": "IMPERIAL_FOOT",
        "volume_unit": "GENERIC_QUART",
        "weight_unit": "IMPERIAL_POUND",
        "generic_unit": "UNIT",
        "time_unit": "GENERIC_MINUTE",
        "type": "TYPE_AREA"
      },
      "name": "name1",
      "abbreviation": "abbreviation3"
    },
    {
      "unit": {
        "custom_unit": {
          "name": "name2",
          "abbreviation": "abbreviation4"
        },
        "area_unit": "IMPERIAL_SQUARE_FOOT",
        "length_unit": "IMPERIAL_YARD",
        "volume_unit": "GENERIC_GALLON",
        "weight_unit": "IMPERIAL_STONE",
        "generic_unit": "UNIT",
        "time_unit": "GENERIC_HOUR",
        "type": "TYPE_LENGTH"
      },
      "name": "name2",
      "abbreviation": "abbreviation4"
    },
    {
      "unit": {
        "custom_unit": {
          "name": "name3",
          "abbreviation": "abbreviation5"
        },
        "area_unit": "IMPERIAL_SQUARE_YARD",
        "length_unit": "IMPERIAL_MILE",
        "volume_unit": "IMPERIAL_CUBIC_INCH",
        "weight_unit": "METRIC_MILLIGRAM",
        "generic_unit": "UNIT",
        "time_unit": "GENERIC_DAY",
        "type": "TYPE_VOLUME"
      },
      "name": "name3",
      "abbreviation": "abbreviation5"
    }
  ],
  "language_code": "language_code8"
}
```

