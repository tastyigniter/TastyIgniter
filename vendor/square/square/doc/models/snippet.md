
# Snippet

Represents the snippet that is added to a Square Online site. The snippet code is injected into the `head` element of all pages on the site, except for checkout pages.

## Structure

`Snippet`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID for the snippet.<br>**Constraints**: *Maximum Length*: `48` | getId(): ?string | setId(?string id): void |
| `siteId` | `?string` | Optional | The ID of the site that contains the snippet. | getSiteId(): ?string | setSiteId(?string siteId): void |
| `content` | `string` | Required | The snippet code, which can contain valid HTML, JavaScript, or both.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `65535` | getContent(): string | setContent(string content): void |
| `createdAt` | `?string` | Optional | The timestamp of when the snippet was initially added to the site, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp of when the snippet was last updated on the site, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "site_id": "site_id6",
  "content": "content4",
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

