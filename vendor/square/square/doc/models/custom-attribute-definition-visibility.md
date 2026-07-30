
# Custom Attribute Definition Visibility

The level of permission that a seller or other applications requires to
view this custom attribute definition.
The `Visibility` field controls who can read and write the custom attribute values
and custom attribute definition.

## Enumeration

`CustomAttributeDefinitionVisibility`

## Fields

| Name | Description |
|  --- | --- |
| `VISIBILITY_HIDDEN` | The custom attribute definition and values are hidden from the seller (except on export<br>of all seller data) and other developers. |
| `VISIBILITY_READ_ONLY` | The seller and other developers can read the custom attribute definition and values<br>on resources. |
| `VISIBILITY_READ_WRITE_VALUES` | The seller and other developers can read the custom attribute definition,<br>and can read and write values on resources. A custom attribute definition<br>can only be edited or deleted by the application that created it. |

