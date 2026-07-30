
# Catalog Category

A category to which a `CatalogItem` instance belongs.

## Structure

`CatalogCategory`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The category name. This is a searchable attribute for use in applicable query filters, and its value length is of Unicode code points.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |
| `imageIds` | `?(string[])` | Optional | The IDs of images associated with this `CatalogCategory` instance.<br>Currently these images are not displayed by Square, but are free to be displayed in 3rd party applications. | getImageIds(): ?array | setImageIds(?array imageIds): void |

## Example (as JSON)

```json
{
  "object": {
    "category_data": {
      "name": "Beverages"
    },
    "id": "#Beverages",
    "present_at_all_locations": true,
    "type": "CATEGORY"
  }
}
```

