
# Customer Custom Attribute Filter Value

A type-specific filter used in a [custom attribute filter](../../doc/models/customer-custom-attribute-filter.md) to search based on the value
of a customer-related [custom attribute](../../doc/models/custom-attribute.md).

## Structure

`CustomerCustomAttributeFilterValue`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `email` | [`?CustomerTextFilter`](../../doc/models/customer-text-filter.md) | Optional | A filter to select customers based on exact or fuzzy matching of<br>customer attributes against a specified query. Depending on the customer attributes,<br>the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both. | getEmail(): ?CustomerTextFilter | setEmail(?CustomerTextFilter email): void |
| `phone` | [`?CustomerTextFilter`](../../doc/models/customer-text-filter.md) | Optional | A filter to select customers based on exact or fuzzy matching of<br>customer attributes against a specified query. Depending on the customer attributes,<br>the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both. | getPhone(): ?CustomerTextFilter | setPhone(?CustomerTextFilter phone): void |
| `text` | [`?CustomerTextFilter`](../../doc/models/customer-text-filter.md) | Optional | A filter to select customers based on exact or fuzzy matching of<br>customer attributes against a specified query. Depending on the customer attributes,<br>the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both. | getText(): ?CustomerTextFilter | setText(?CustomerTextFilter text): void |
| `selection` | [`?FilterValue`](../../doc/models/filter-value.md) | Optional | A filter to select resources based on an exact field value. For any given<br>value, the value can only be in one property. Depending on the field, either<br>all properties can be set or only a subset will be available.<br><br>Refer to the documentation of the field. | getSelection(): ?FilterValue | setSelection(?FilterValue selection): void |
| `date` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getDate(): ?TimeRange | setDate(?TimeRange date): void |
| `number` | [`?FloatNumberRange`](../../doc/models/float-number-range.md) | Optional | Specifies a decimal number range. | getNumber(): ?FloatNumberRange | setNumber(?FloatNumberRange number): void |
| `boolean` | `?bool` | Optional | A filter for a query based on the value of a `Boolean`-type custom attribute. | getBoolean(): ?bool | setBoolean(?bool boolean): void |
| `address` | [`?CustomerAddressFilter`](../../doc/models/customer-address-filter.md) | Optional | The customer address filter. This filter is used in a [CustomerCustomAttributeFilterValue](../../doc/models/customer-custom-attribute-filter-value.md) filter when<br>searching by an `Address`-type custom attribute. | getAddress(): ?CustomerAddressFilter | setAddress(?CustomerAddressFilter address): void |

## Example (as JSON)

```json
{
  "email": {
    "exact": "exact6",
    "fuzzy": "fuzzy2"
  },
  "phone": {
    "exact": "exact0",
    "fuzzy": "fuzzy6"
  },
  "text": {
    "exact": "exact0",
    "fuzzy": "fuzzy6"
  },
  "selection": {
    "all": [
      "all1"
    ],
    "any": [
      "any8",
      "any9"
    ],
    "none": [
      "none3"
    ]
  },
  "date": {
    "start_at": "start_at6",
    "end_at": "end_at6"
  },
  "number": {
    "start_at": "start_at4",
    "end_at": "end_at8"
  },
  "boolean": false,
  "address": {
    "postal_code": {
      "exact": "exact8",
      "fuzzy": "fuzzy4"
    },
    "country": "BE"
  }
}
```

