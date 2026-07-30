
# Batch Retrieve Inventory Counts Request

## Structure

`BatchRetrieveInventoryCountsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `catalogObjectIds` | `?(string[])` | Optional | The filter to return results by `CatalogObject` ID.<br>The filter is applicable only when set.  The default is null. | getCatalogObjectIds(): ?array | setCatalogObjectIds(?array catalogObjectIds): void |
| `locationIds` | `?(string[])` | Optional | The filter to return results by `Location` ID.<br>This filter is applicable only when set. The default is null. | getLocationIds(): ?array | setLocationIds(?array locationIds): void |
| `updatedAfter` | `?string` | Optional | The filter to return results with their `calculated_at` value<br>after the given time as specified in an RFC 3339 timestamp.<br>The default value is the UNIX epoch of (`1970-01-01T00:00:00Z`). | getUpdatedAfter(): ?string | setUpdatedAfter(?string updatedAfter): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for the original query.<br><br>See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for more information. | getCursor(): ?string | setCursor(?string cursor): void |
| `states` | [`?(string[]) (InventoryState)`](../../doc/models/inventory-state.md) | Optional | The filter to return results by `InventoryState`. The filter is only applicable when set.<br>Ignored are untracked states of `NONE`, `SOLD`, and `UNLINKED_RETURN`.<br>The default is null. | getStates(): ?array | setStates(?array states): void |
| `limit` | `?int` | Optional | The number of [records](entity:InventoryCount) to return.<br>**Constraints**: `>= 1`, `<= 1000` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "catalog_object_ids": [
    "W62UWFY35CWMYGVWK6TWJDNI"
  ],
  "location_ids": [
    "59TNP9SA8VGDA"
  ],
  "updated_after": "2016-11-16T00:00:00.000Z"
}
```

