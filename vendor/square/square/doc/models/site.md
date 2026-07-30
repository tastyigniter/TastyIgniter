
# Site

Represents a Square Online site, which is an online store for a Square seller.

## Structure

`Site`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the site.<br>**Constraints**: *Maximum Length*: `32` | getId(): ?string | setId(?string id): void |
| `siteTitle` | `?string` | Optional | The title of the site. | getSiteTitle(): ?string | setSiteTitle(?string siteTitle): void |
| `domain` | `?string` | Optional | The domain of the site (without the protocol). For example, `mysite1.square.site`. | getDomain(): ?string | setDomain(?string domain): void |
| `isPublished` | `?bool` | Optional | Indicates whether the site is published. | getIsPublished(): ?bool | setIsPublished(?bool isPublished): void |
| `createdAt` | `?string` | Optional | The timestamp of when the site was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp of when the site was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "site_title": "site_title6",
  "domain": "domain6",
  "is_published": false,
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

