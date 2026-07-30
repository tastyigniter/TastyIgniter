
# Batch Change Inventory Request

## Structure

`BatchChangeInventoryRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A client-supplied, universally unique identifier (UUID) for the<br>request.<br><br>See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency) in the<br>[API Development 101](https://developer.squareup.com/docs/buildbasics) section for more<br>information.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `128` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `changes` | [`?(InventoryChange[])`](../../doc/models/inventory-change.md) | Optional | The set of physical counts and inventory adjustments to be made.<br>Changes are applied based on the client-supplied timestamp and may be sent<br>out of order. | getChanges(): ?array | setChanges(?array changes): void |
| `ignoreUnchangedCounts` | `?bool` | Optional | Indicates whether the current physical count should be ignored if<br>the quantity is unchanged since the last physical count. Default: `true`. | getIgnoreUnchangedCounts(): ?bool | setIgnoreUnchangedCounts(?bool ignoreUnchangedCounts): void |

## Example (as JSON)

```json
{
  "changes": [
    {
      "physical_count": {
        "catalog_object_id": "W62UWFY35CWMYGVWK6TWJDNI",
        "location_id": "C6W5YS5QM06F5",
        "occurred_at": "2016-11-16T22:25:24.878Z",
        "quantity": "53",
        "reference_id": "1536bfbf-efed-48bf-b17d-a197141b2a92",
        "state": "IN_STOCK",
        "team_member_id": "LRK57NSQ5X7PUD05"
      },
      "type": "PHYSICAL_COUNT"
    }
  ],
  "idempotency_key": "8fc6a5b0-9fe8-4b46-b46b-2ef95793abbe",
  "ignore_unchanged_counts": true
}
```

