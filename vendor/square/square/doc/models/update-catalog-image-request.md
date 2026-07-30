
# Update Catalog Image Request

## Structure

`UpdateCatalogImageRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A unique string that identifies this UpdateCatalogImage request.<br>Keys can be any valid string but must be unique for every UpdateCatalogImage request.<br><br>See [Idempotency keys](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency) for more information.<br>**Constraints**: *Minimum Length*: `1` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |

## Example (as JSON)

```json
{
  "idempotency_key": "528dea59-7bfb-43c1-bd48-4a6bba7dd61f86",
  "image": {
    "image_data": {
      "caption": "A picture of a cup of coffee",
      "name": "Coffee"
    },
    "type": "IMAGE"
  },
  "object_id": "ND6EA5AAJEO5WL3JNNIAQA32"
}
```

