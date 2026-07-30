## Tables

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` your tables.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The table object

#### Attributes

| Key            | Type      | Description                       |
|----------------|-----------|-----------------------------------|
| `table_name`   | `string`  | **Required**. The table name      |
| `min_capacity` | `integer` | The minimum capacity of the table | 
| `max_capacity` | `integer` | The maximum capacity of the table | 

| `priority`           | `integer`  | The table's priority.         |
| `table_status`           | `boolean`  | Has the value `true` if the table is enabled or the value `false` if the table is disabled.         |
| `extra_capacity`           | `integer `  | Any extra capacity the table may have (only used internally)
| `is_joinable`           | `boolean `  | Whether the table can be joined with others     |

#### Table object example

```json
{
    "table_name": "Table 1",
    "min_capacity": 3,
    "max_capacity": 12,
    "table_status": true,
    "extra_capacity": 0,
    "is_joinable": false,
    "priority": 0
}
```

### List tables

Returns a list of tables you’ve previously created.

Required abilities: `tables:read`

```
GET /api/tables
```

#### Parameters

| Key         | Type      | Description                   |
|-------------|-----------|-------------------------------|
| `page`      | `integer` | The page number.              |
| `pageLimit` | `integer` | The number of items per page. |

#### Response

```html
Status: 201 Created
```

```json
{
    "data": [
        {
            "type": "menus",
            "id": "1",
            "attributes": {
                "table_name": "Table 1",
                "min_capacity": 3,
                "max_capacity": 12,
                "table_status": true,
                "extra_capacity": 0,
                "is_joinable": false,
                "priority": 0
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
        "self": "https://your.url/api/tables?page=1",
        "first": "https://your.url/api/tables?page=1",
        "last": "https://your.url/api/tables?page=1"
    }
}
```

### Create a table

Creates a new table.

Required abilities: `tables:write`

```
POST /api/tables
```

#### Parameters

| Key            | Type      | Description                       |
|----------------|-----------|-----------------------------------|
| `table_name`   | `string`  | **Required**. The table name      |
| `min_capacity` | `integer` | The minimum capacity of the table | 
| `max_capacity` | `integer` | The maximum capacity of the table | 

| `priority`           | `integer`  | The table's priority.         |
| `table_status`           | `boolean`  | Has the value `true` if the table is enabled or the value `false` if the table is disabled.         |
| `extra_capacity`           | `integer `  | Any extra capacity the table may have (only used internally)
| `is_joinable`           | `boolean `  | Whether the table can be joined with others     |

#### Payload example

```json
{
    "table_name": "New table",
    "table_status": true
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
            "type": "tables",
            "id": "2",
            "attributes": {
                "table_name": "New table",
                "min_capacity": 0,
                "max_capacity": 12,
                "table_status": true,
                "extra_capacity": 0,
                "is_joinable": false,
                "priority": 0
            }
        }
    ]
}
```

### Retrieve a table

Retrieves a table.

Required abilities: `tables:read`

```
GET /api/tables/:table_id
```

#### Parameters

No parameters.

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "menus",
            "id": "1",
            "attributes": {
                "table_name": "Table 1",
                "min_capacity": 3,
                "max_capacity": 12,
                "table_status": true,
                "extra_capacity": 0,
                "is_joinable": false,
                "priority": 0
            }
        }
    ]
}
```

### Update a table

Updates a table.

Required abilities: `tables:write`

```
PATCH /api/tables/:table_id
```

#### Parameters

| Key            | Type      | Description                       |
|----------------|-----------|-----------------------------------|
| `table_name`   | `string`  | **Required**. The table name      |
| `min_capacity` | `integer` | The minimum capacity of the table | 
| `max_capacity` | `integer` | The maximum capacity of the table | 

| `priority`           | `integer`  | The table's priority.         |
| `table_status`           | `boolean`  | Has the value `true` if the table is enabled or the value `false` if the table is disabled.         |
| `extra_capacity`           | `integer `  | Any extra capacity the table may have (only used internally)
| `is_joinable`           | `boolean `  | Whether the table can be joined with others     |       |

#### Payload example

```json
{
    "table_name": "Table 2"
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
      "type": "tables",
      "id": "2",
      "attributes": {
        "table_name": "Table 2",
        "min_capacity": 3,
        "max_capacity": 12,
        "table_status": true,
        "extra_capacity": 0,
        "is_joinable": false,
        "priority": 0
      }
    }
  ]
}
```

### Delete a table

Permanently deletes a table. It cannot be undone.

Required abilities: `tables:write`

```
DELETE /api/tables/:table_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the table ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
  "id": 1,
  "object": "table",
  "deleted": true
}
```
