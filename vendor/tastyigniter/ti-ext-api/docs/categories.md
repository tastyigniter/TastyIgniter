## Categories

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` your categories.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The category object

#### Attributes

| Key              | Type      | Description                                                                                       |
|------------------|-----------|---------------------------------------------------------------------------------------------------|
| `name`           | `string`  | **Required**. The category's name                                                                 |
| `permalink_slug` | `string`  | The category's permalink slug.                                                                    |
| `parent_id`      | `integer` | The Unique identifier of the parent category, if any.                                             |
| `locations`      | `array`   | The category's locations, if any.                                                                 |
| `priority`       | `integer` | The category's priority.                                                                          |
| `status`         | `boolean` | Has the value `true` if the category is enabled or the value `false` if the category is disabled. |
| `description`    | `string`  | An arbitrary string attached to the category.                                                     |
| `thumb`          | `string`  | The URL where the category's thumbnail can be accessed.                                           |

#### Category object example

```json
{
    "name": "Appetizer",
    "permalink_slug": "appetizer",
    "parent_id": null,
    "locations": [],
    "priority": null,
    "status": true,
    "description": "Sed consequat, sapien in scelerisque egestas",
    "thumb": null
}
```

### List categories

Returns a list of categories you’ve previously created.

Required abilities: `categories:read`

```
GET /api/categories
```

#### Parameters

| Key         | Type      | Description                                                                                                                                             |
|-------------|-----------|---------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer` | The page number.                                                                                                                                        |
| `pageLimit` | `integer` | The number of items per page.                                                                                                                           |
| `include`   | `string`  | What relations to include in the response. Options are `media`, `menus`, `locations`. To include multiple seperate by comma (e.g. ?include=media,menus) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "categories",
            "id": "1",
            "attributes": {
                "name": "Appetizer",
                "permalink_slug": "appetizer",
                "parent_id": null,
                "priority": null,
                "status": true,
                "description": "Sed consequat, sapien in scelerisque egestas",
                "thumb": null,
                "media": [],
                "menus": [],
                "locations": []
            },
            "relationships": {
                "menus": {
                    "data": []
                },
                "locations": {
                    "data": []
                }
            }
        }
    ],
    "included": [],
    "meta": {
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "links": {
        "self": "https://your.url/api/categories?page=1",
        "first": "https://your.url/api/categories?page=1",
        "last": "https://your.url/api/categories?page=1"
    }
}
```

### Create a category

Creates a new category.

Required abilities: `categories:write`

```
POST /api/categories
```

#### Parameters

| Key              | Type      | Description                                                                                       |
|------------------|-----------|---------------------------------------------------------------------------------------------------|
| `name`           | `string`  | **Required**. The category's name                                                                 |
| `permalink_slug` | `string`  | The category's permalink slug.                                                                    |
| `parent_id`      | `integer` | The Unique identifier of the parent category, if any.                                             |
| `locations`      | `array`   | The category's locations, if any.                                                                 |
| `priority`       | `integer` | The category's priority.                                                                          |
| `status`         | `boolean` | Has the value `true` if the category is enabled or the value `false` if the category is disabled. |
| `description`    | `string`  | An arbitrary string attached to the category.                                                     |
| `thumb`          | `string`  | The URL where the category's thumbnail can be accessed.                                           |

#### Payload example

```json
{
    "name": "Appetizer",
    "status": true
}
```

#### Response

```html
Status: 201 Created
```

```json
{
    "data": [
        {
            "type": "categories",
            "id": "1",
            "attributes": {
                "name": "Appetizer",
                "permalink_slug": "appetizer",
                "parent_id": null,
                "priority": null,
                "status": true,
                "description": "Sed consequat, sapien in scelerisque egestas",
                "thumb": null
            }
        }
    ]
}
```

### Retrieve a category

Retrieves a category.

Required abilities: `categories:read`

```
GET /api/categories/:category_id
```

#### Parameters

| Key       | Type     | Description                                                                                                                                             |
|-----------|----------|---------------------------------------------------------------------------------------------------------------------------------------------------------|
| `include` | `string` | What relations to include in the response. Options are `media`, `menus`, `locations`. To include multiple seperate by comma (e.g. ?include=media,menus) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "categories",
            "id": "1",
            "attributes": {
                "name": "Appetizer",
                "permalink_slug": "appetizer",
                "parent_id": null,
                "priority": null,
                "status": true,
                "description": "Sed consequat, sapien in scelerisque egestas",
                "thumb": null,
                "media": [],
                "menus": [],
                "locations": []
            },
            "relationships": {
                "menus": {
                    "data": []
                },
                "locations": {
                    "data": []
                }
            }
        }
    ],
    "included": []
}
```

### Update a category

Updates a category.

Required abilities: `categories:write`

```
PATCH /api/categories/:category_id
```

#### Parameters

| Key              | Type      | Description                                                                                       |
|------------------|-----------|---------------------------------------------------------------------------------------------------|
| `name`           | `string`  | **Required**. The category's name                                                                 |
| `permalink_slug` | `string`  | The category's permalink slug.                                                                    |
| `parent_id`      | `integer` | The Unique identifier of the parent category, if any.                                             |
| `locations`      | `array`   | The category's locations, if any.                                                                 |
| `priority`       | `integer` | The category's priority.                                                                          |
| `status`         | `boolean` | Has the value `true` if the category is enabled or the value `false` if the category is disabled. |
| `description`    | `string`  | An arbitrary string attached to the category.                                                     |
| `thumb`          | `string`  | The URL where the category's thumbnail can be accessed.                                           |

#### Payload example

```json
{
    "description": "Vivamus interdum erat ac aliquam porttitor. ",
    "parent_id": 2
}
```

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "categories",
            "id": "1",
            "attributes": {
                "name": "Appetizer",
                "permalink_slug": "appetizer",
                "parent_id": null,
                "priority": null,
                "status": true,
                "description": "Sed consequat, sapien in scelerisque egestas",
                "thumb": null
            }
        }
    ]
}
```

### Delete a category

Permanently deletes a category. It cannot be undone.

Required abilities: `categories:write`

```
DELETE /api/categories/:category_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the category ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "category",
    "deleted": true
}
```
