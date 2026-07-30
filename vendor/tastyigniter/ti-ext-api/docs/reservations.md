## Reservations

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` reservations on your TastyIgniter site.

### The reservation object

#### Attributes

| Key                   | Type        | Description                                                                                                    |
|-----------------------|-------------|----------------------------------------------------------------------------------------------------------------|
| `customer_id`         | `integer`   | The Unique Identifier of the customer associated with the reservation, if any.                                 |
| `location_id`         | `integer`   | The Unique Identifier of the location associated with the reservation.                                         |
| `table_id`            | `integer`   | The Unique Identifier of the table associated with the reservation.                                            |
| `guest_num`           | `integer`   | The number of guests                                                                                           |
| `first_name`          | `string`    | The first name associated with the reservation.                                                                |
| `last_name`           | `string`    | The last name associated with the reservation.                                                                 |
| `email`               | `string`    | The email address associated with the reservation.                                                             |
| `telephone`           | `string`    | The telephone associated with the reservation.                                                                 |
| `comment`             | `text`      | The reservation comment text.                                                                                  |
| `reserve_date_time`   | `dateTime`  | The datetime for when the reservation is booked.                                                               |
| `duration`            | `integer`   | The number of minutes to keep the table reserved.                                                              |
| `notify`              | `boolean`   | Has the value `true` if an reservation confirmation email was sent, or the value `false` if no email was sent. |
| `status_id`           | `integer`   | The Unique Identifier of the status associated with the order, if any.                                         |
| `status_updated_at`   | `dateTime`  | The datetime for when the reservation's status was last updated.                                               |
| `assignee_id`         | `integer`   | The Unique Identifier of the staff assigned to the reservation, if any.                                        |
| `assignee_group_id`   | `integer`   | The Unique Identifier of the staff group assigned to the reservation, if any.                                  |
| `assignee_updated_at` | `timestamp` | The timestamp for when the reservation was last assigned.                                                      |
| `hash`                | `string`    | The reservation's unique hash.                                                                                 |
| `ip_address`          | `string`    | The IP address used when the reservation was created.                                                          |
| `user_agent`          | `string`    | The HTTP User-Agent of the browser user when the reservation was created.                                      |
| `created_at`          | `dateTime`  | The datetime for when the reservation was created.                                                             |
| `updated_at`          | `dateTime`  | The datetime for when the reservation was last modified.                                                       |

#### Reservation object example

```json
{
    "reservation_id": 1,
    "customer_id": null,
    "location_id": 1,
    "table_id": 0,
    "guest_num": 2,
    "first_name": "Ryder",
    "last_name": "Anthony",
    "email": "xigakube@mailinator.net",
    "telephone": "+1 (828) 231-8892",
    "comment": "Cillum eum cupidatat",
    "reserve_date_time": "2020-06-26 19:35:00",
    "duration": null,
    "notify": true,
    "status_id": 8,
    "status_updated_at": "2020-06-03T19:11:10.000000Z",
    "assignee_id": 2,
    "assignee_group_id": 4,
    "assignee_updated_at": "2020-06-03T19:16:58.000000Z",
    "hash": "fcf74e695a35c0db456d76b2f5180e95",
    "ip_address": "192.168.10.1",
    "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
    "created_at": "2020-06-03",
    "updated_at": "2020-06-03"
}
```

### List reservations

Retrieves a list of reservations.

Required abilities: `reservations:read`

```
GET /api/reservations
```

#### Parameters

| Key         | Type       | Description                                                                                                                                                                                                                 |
|-------------|------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer`  | The page number.                                                                                                                                                                                                            |
| `pageLimit` | `integer`  | The number of items per page.                                                                                                                                                                                               |
| `customer`  | `integer`  | The customer id to return orders for                                                                                                                                                                                        |
| `location`  | `integer ` | The location id to return orders for                                                                                                                                                                                        |
| `sort`      | `string`   | The order to return results in. Possible values are `reservation_id asc`, `reservation_id desc`, `reserve_date asc`, `reserve_date desc`                                                                                    |
| `include`   | `string`   | What relations to include in the response. Options are `customer`, `location`, `tables`, `status`, `assignee`, `assignee_group`, `status_history`. To include multiple separate by comma (e.g. ?include= customer,location) |


#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "reservations",
            "id": "1",
            "attributes": {
                "customer_id": null,
                "location_id": 1,
                "table_id": 0,
                "guest_num": 2,
                "first_name": "Ryder",
                "last_name": "Anthony",
                "email": "xigakube@mailinator.net",
                "telephone": "+1 (828) 231-8892",
                "comment": "Cillum eum cupidatat",
                "reserve_date_time": "2020-06-26 19:35:00",
                "duration": null,
                "notify": true,
                "status_id": 8,
                "status_updated_at": "2020-06-03T19:11:10.000000Z",
                "assignee_id": 2,
                "assignee_group_id": 4,
                "assignee_updated_at": "2020-06-03T19:16:58.000000Z",
                "hash": "fcf74e695a35c0db456d76b2f5180e95",
                "ip_address": "192.168.10.1",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-06-03",
                "updated_at": "2020-06-03",
                "order_totals": [],
                "customer": [],
                "location": [],
                "tables": [],
                "status": [],
                "assignee": [],
                "assignee_group": [],
                "status_history": []
            },
            "relationships": {
                "customer": {
                    "data": []
                },
                "location": {
                    "data": []
                },
                "tables": {
                    "data": []
                },
                "status": {
                    "data": []
                },
                "assignee": {
                    "data": []
                },
                "assignee_group": {
                    "data": []
                },
                "status_history": {
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
        "self": "https://your.url/api/reservations?page=1",
        "first": "https://your.url/api/reservations?page=1",
        "last": "https://your.url/api/reservations?page=1"
    }
}
```

### Create a reservation

Creates a new reservation.

Required abilities: `reservations:write`

```
POST /api/reservations
```

#### Parameters

| Key                                                                              | Type      | Description                                                              |
|----------------------------------------------------------------------------------|-----------|--------------------------------------------------------------------------|
| `location_id`                                                                    | `integer` | The Unique Identifier of the location to associate with the reservation. |
| `table_id`                                                                       | `integer` | The Unique Identifier of the table to associate with the reservation.    |
| `guest_num`                                                                      | `integer` | The number of guests                                                     |
| `first_name`                                                                     | `string`  | **                                                                       |
| Required**. The reservation's first name (between 2 and 32 characters in length) |           |                                                                          |
| `last_name`                                                                      | `string`  | **                                                                       |
| Required**. The reservation's last name (between 2 and 32 characters in length)  |           |                                                                          |
| `email`                                                                          | `string`  | **Required**. The reservation's email address                            |
| `telephone`                                                                      | `string`  | The reservation's telephone number                                       |
| `reserve_date`                                                                   | `string`  | The reservation's date in format Y-m-d                                   |
| `reserve_time`                                                                   | `string`  | The reservation's hour in format H:i                                     |

#### Payload example

```json
{
    "reservation_id": 1,
    "location_id": 1,
    "table_id": 1,
    "guest_num": 2,
    "first_name": "Ryder",
    "last_name": "Anthony",
    "email": "xigakube@mailinator.net",
    "telephone": "+1 (828) 231-8892",
    "comment": "Cillum eum cupidatat",
    "reserve_date": "2022-06-26",
    "reserve_time": "19:35"
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
            "type": "reservations",
            "id": "1",
            "attributes": {
                "reservation_id": 1,
                "customer_id": null,
                "location_id": 1,
                "table_id": 0,
                "guest_num": 2,
                "first_name": "Ryder",
                "last_name": "Anthony",
                "email": "xigakube@mailinator.net",
                "telephone": "+1 (828) 231-8892",
                "comment": "Cillum eum cupidatat",
                "reserve_date_time": "2020-06-26 19:35:00",
                "duration": null,
                "notify": true,
                "status_id": 8,
                "status_updated_at": "2020-06-03T19:11:10.000000Z",
                "assignee_id": 2,
                "assignee_group_id": 4,
                "assignee_updated_at": "2020-06-03T19:16:58.000000Z",
                "hash": "fcf74e695a35c0db456d76b2f5180e95",
                "ip_address": "192.168.10.1",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-06-03",
                "updated_at": "2020-06-03"
            }
        }
    ]
}
```

### Retrieve a reservation

Retrieves a reservation.

Required abilities: `reservations:read`

```
GET /api/reservations/:reservation_id
```

#### Parameters

| Key       | Type     | Description                                                                                                                                                                                                                 |
|-----------|----------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `include` | `string` | What relations to include in the response. Options are `customer`, `location`, `tables`, `status`, `assignee`, `assignee_group`, `status_history`. To include multiple separate by comma (e.g. ?include= customer,location) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "reservations",
            "id": "1",
            "attributes": {
                "customer_id": null,
                "location_id": 1,
                "table_id": 0,
                "guest_num": 2,
                "first_name": "Ryder",
                "last_name": "Anthony",
                "email": "xigakube@mailinator.net",
                "telephone": "+1 (828) 231-8892",
                "comment": "Cillum eum cupidatat",
                "reserve_date_time": "2020-06-26 19:35:00",
                "duration": null,
                "notify": true,
                "status_id": 8,
                "status_updated_at": "2020-06-03T19:11:10.000000Z",
                "assignee_id": 2,
                "assignee_group_id": 4,
                "assignee_updated_at": "2020-06-03T19:16:58.000000Z",
                "hash": "fcf74e695a35c0db456d76b2f5180e95",
                "ip_address": "192.168.10.1",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-06-03",
                "updated_at": "2020-06-03",
                "order_totals": [],
                "customer": [],
                "location": [],
                "tables": [],
                "status": [],
                "assignee": [],
                "assignee_group": [],
                "status_history": []
            },
            "relationships": {
                "customer": {
                    "data": []
                },
                "location": {
                    "data": []
                },
                "tables": {
                    "data": []
                },
                "status": {
                    "data": []
                },
                "assignee": {
                    "data": []
                },
                "assignee_group": {
                    "data": []
                },
                "status_history": {
                    "data": []
                }
            }
        }
    ],
    "included": []
}
```

### Update a reservation

Updates a reservation.

Required abilities: `reservations:write`

```
PATCH /api/reservations/:reservation_id
```

#### Parameters

| Key                    | Type      | Description                                                                                             |
|------------------------|-----------|---------------------------------------------------------------------------------------------------------|
| `first_name`           | `string`  | The reservation's first name (between 2 and 32 characters in length)                                    |
| `last_name`            | `string`  | The reservation's last name (between 2 and 32 characters in length)                                     |
| `email`                | `string`  | The reservation's email address                                                                         |
| `telephone`            | `string`  | The reservation's telephone number                                                                      |
| `newsletter`           | `boolean` | Whether the reservation opts into newsletter marketing                                                  |
| `status`               | `boolean` | Has the value `true` if the reservation is enabled or the value `false` if the reservation is disabled. |
| `addresses`            | `array`   | The reservation's addresses, if any                                                                     |

#### Payload example

```json
{
    "first_name": "Joseph",
    "email": "joseph@bloggs.com"
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
            "type": "reservations",
            "id": "1",
            "attributes": {
                "customer_id": null,
                "location_id": 1,
                "table_id": 0,
                "guest_num": 2,
                "first_name": "Joseph",
                "last_name": "Student",
                "email": "xigakube@mailinator.net",
                "telephone": "+1 (828) 231-8892",
                "comment": "Cillum eum cupidatat",
                "reserve_date_time": "2020-06-26 19:35:00",
                "duration": null,
                "notify": true,
                "status_id": 8,
                "status_updated_at": "2020-06-03T19:11:10.000000Z",
                "assignee_id": 2,
                "assignee_group_id": 4,
                "assignee_updated_at": "2020-06-03T19:16:58.000000Z",
                "hash": "fcf74e695a35c0db456d76b2f5180e95",
                "ip_address": "192.168.10.1",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-06-03",
                "updated_at": "2020-06-03"
            }
        }
    ]
}
```

### Update reservation status

Updates only the reservation status. Use this when you only need to change the status (e.g. from pending to confirmed) without sending other reservation fields. Only staff tokens may update reservation status; customer tokens receive 403.

Required abilities: `reservations:write`

```
PATCH /api/reservations/:reservation_id/status
```

#### Parameters

| Key          | Type     | Description                                                                 |
|--------------|----------|-----------------------------------------------------------------------------|
| `status_id`  | `integer`| **Required**. The Unique Identifier of the status to assign (must exist in `statuses`). |
| `comment`    | `string` | Optional comment to attach to the status change (max 500 characters).     |
| `notify`     | `boolean`| Whether to notify the customer of the status change.                        |

#### Payload example

```json
{
    "status_id": 8,
    "comment": "Table confirmed",
    "notify": true
}
```

#### Response

```html
Status: 200 OK
```

Returns the updated reservation object in the same shape as the retrieve/update response (including the new `status_id` and `status_updated_at`).

### Delete a reservation

Permanently deletes a reservation. It cannot be undone.

Required abilities: `reservations:write`

```
DELETE /api/reservations/:reservation_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the reservation ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "reservation",
    "deleted": true
}
```
