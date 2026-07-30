
# Catalog Modifier Override

Options to control how to override the default behavior of the specified modifier.

## Structure

`CatalogModifierOverride`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `modifierId` | `string` | Required | The ID of the `CatalogModifier` whose default behavior is being overridden.<br>**Constraints**: *Minimum Length*: `1` | getModifierId(): string | setModifierId(string modifierId): void |
| `onByDefault` | `?bool` | Optional | If `true`, this `CatalogModifier` should be selected by default for this `CatalogItem`. | getOnByDefault(): ?bool | setOnByDefault(?bool onByDefault): void |

## Example (as JSON)

```json
{
  "modifier_id": "modifier_id2",
  "on_by_default": false
}
```

