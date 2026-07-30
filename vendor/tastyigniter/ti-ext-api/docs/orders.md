## Orders

This endpoint allows you to `list`, `retrieve`, `update` and `delete` your orders.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The order object

#### Attributes

| Key                   | Type        | Description                                                                                                  |
|-----------------------|-------------|--------------------------------------------------------------------------------------------------------------|
| `customer_id`         | `integer`   | The Unique Identifier of the customer associated with the order, if any.                                     |
| `location_id`         | `integer`   | The Unique Identifier of the location associated with the order, if any.                                     |
| `address_id`          | `integer`   | The Unique Identifier of the address associated with the order, if any.                                      |
| `first_name`          | `string`    | The first name associated with the order.                                                                    |
| `last_name`           | `string`    | The last name associated with the order.                                                                     |
| `email`               | `string`    | The email address associated with the order.                                                                 |
| `telephone`           | `string`    | The telephone associated with the order.                                                                     |
| `comment`             | `text`      | The order comment text.                                                                                      |
| `notify`              | `boolean`   | Has the value `true` if an order confirmation email was sent, or the value `false` if no email was sent.     |
| `order_type`          | `string`    | Has the value `delivery` if the order is for delivery or the value `collection` if the order is for pick-up. |
| `order_date_time`     | `dateTime`  | The datetime for when the order is available for delivery/pick-up.                                           |
| `processed`           | `boolean`   | Has the value `true` if payment for the order was successful or the value `false` if payment failed.         |
| `total_items`         | `integer`   | The total number of menu items included in the order.                                                        |
| `order_total`         | `float`     | The order's total amount.                                                                                    |
| `payment`             | `string`    | The order's payment method code.                                                                             |
| `invoice_prefix`      | `string`    | The order's invoice prefix.                                                                                  |
| `invoice_date`        | `timestamp` | The timestamp for when the invoice was generated for the order.                                              |
| `status_id`           | `integer`   | The Unique Identifier of the status associated with the order, if any.                                       |
| `status_updated_at`   | `dateTime`  | The datetime for when the order's status was last updated.                                                   |
| `assignee_id`         | `integer`   | The Unique Identifier of the staff assigned to the order, if any.                                            |
| `assignee_group_id`   | `integer`   | The Unique Identifier of the staff group assigned to the order, if any.                                      |
| `assignee_updated_at` | `timestamp` | The timestamp for when the order was last assigned.                                                          |
| `hash`                | `string`    | The order's unique hash.                                                                                     |
| `ip_address`          | `string`    | The IP address used when the order was created.                                                              |
| `user_agent`          | `string`    | The HTTP User-Agent of the browser user when the order was created.                                          |
| `created_at`          | `dateTime`  | The datetime for when the order was created.                                                                 |
| `updated_at`          | `dateTime`  | The datetime for when the order was last modified.                                                           |
| `order_totals`        | `array`     | Collection of totals associated with the order.                                                              |

#### Order object example

```json
{
    "order_id": 1,
    "customer_id": 1,
    "location_id": 1,
    "address_id": null,
    "first_name": "Tucker",
    "last_name": "Vega",
    "email": "vavur@mailinator.com",
    "telephone": "+1 (604) 376-2674",
    "notify": null,
    "order_type": "collection",
    "order_date_time": "2020-05-24 13:13:00",
    "processed": true,
    "total_items": 3,
    "order_total": "15.0449",
    "currency": "GBP",
    "comment": "",
    "payment": "cod",
    "invoice_prefix": "INV-2020-00",
    "invoice_date": "2020-05-24T11:58:43.000000Z",
    "status_id": 3,
    "status_updated_at": "2020-05-24T11:58:43.000000Z",
    "assignee_id": null,
    "assignee_group_id": null,
    "assignee_updated_at": null,
    "ip_address": "192.168.10.1",
    "hash": "7158b25ef2f10b151f87fc4d26b3b27d",
    "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
    "created_at": "2020-05-24 12:58:43",
    "updated_at": "2020-05-24 12:58:43",
    "order_totals": []
}
```

### List orders

Retrieves a list of orders.

Required abilities: `orders:read`

```
GET /api/orders
```

#### Parameters

| Key         | Type       | Description                                                                                                                                                                                                                                    |
|-------------|------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer`  | The page number.                                                                                                                                                                                                                               |
| `pageLimit` | `integer`  | The number of items per page.                                                                                                                                                                                                                  |
| `customer`  | `integer`  | The customer id to return orders for                                                                                                                                                                                                           |
| `location`  | `integer ` | The location id to return orders for                                                                                                                                                                                                           |
| `sort`      | `string`   | The order to return results in. Possible values are `order_id asc`, `order_id desc`, `created_at asc`, `created_at desc`                                                                                                                       |
| `include`   | `string`   | What relations to include in the response. Options are `customer`, `location`, `address`, `payment_method`, `status`, `assignee`, `assignee_group`, `status_history`. To include multiple separate by comma (e.g. ?include= customer,location) |


#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "orders",
            "id": "1",
            "attributes": {
                "customer_id": 1,
                "location_id": 1,
                "address_id": null,
                "first_name": "Tucker",
                "last_name": "Vega",
                "email": "vavur@mailinator.com",
                "telephone": "+1 (604) 376-2674",
                "notify": null,
                "order_type": "collection",
                "order_time": "13:13:00",
                "order_date": "2020-05-24 00:00:00",
                "processed": true,
                "total_items": 3,
                "order_total": "15.0449",
                "currency": "GBP",
                "comment": "",
                "payment": "cod",
                "invoice_prefix": "INV-2020-00",
                "invoice_date": "2020-05-24T11:58:43.000000Z",
                "status_id": 3,
                "status_updated_at": "2020-05-24T11:58:43.000000Z",
                "assignee_id": null,
                "assignee_group_id": null,
                "assignee_updated_at": null,
                "ip_address": "192.168.10.1",
                "hash": "7158b25ef2f10b151f87fc4d26b3b27d",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-05-24 12:58:43",
                "updated_at": "2020-05-24 12:58:43",
                "order_totals": [],
                "customer": [],
                "location": [],
                "address": [],
                "payment_method": [],
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
                "address": {
                    "data": []
                },
                "payment_method": {
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
        "self": "https://your.url/api/orders?page=1",
        "first": "https://your.url/api/orders?page=1",
        "last": "https://your.url/api/orders?page=1"
    }
}
```


### Create an order

#### Parameters

| Key                 | Type        | Description                                                                                                                 |
|---------------------|-------------|-----------------------------------------------------------------------------------------------------------------------------|
| `customer_id`       | `integer`   | The Unique Identifier of the customer associated with the order, if any.                                                    |
| `location_id`       | `integer`   | ***required*** The Unique Identifier of the location associated with the order, if any.                                     |
| `address_id`        | `integer`   | The Unique Identifier of the address associated with the order, if any.                                                     |
| `first_name`        | `string`    | ***required*** The first name associated with the order.                                                                    |
| `last_name`         | `string`    | ***required*** The last name associated with the order.                                                                     |
| `email`             | `string`    | ***required*** The email address associated with the order.                                                                 |
| `telephone`         | `string`    | The telephone associated with the order.                                                                                    |
| `comment`           | `text`      | The order comment text.                                                                                                     |
| `order_type`        | `string`    | ***required*** Has the value `delivery` if the order is for delivery or the value `collection` if the order is for pick-up. |
| `order_date`        | `date`      | The date for when the order is requested.                                                                                   |
| `order_time`        | `time`      | The time for when the order is requested.                                                                                   |
| `total_items`       | `integer`   | ***required***  The total number of menu items included in the order.                                                       |
| `order_total`       | `float`     | ***required*** The order's total amount.                                                                                    |
| `payment`           | `string`    | The order's payment method code.                                                                                            |
| `invoice_prefix`    | `string`    | The order's invoice prefix.                                                                                                 |
| `invoice_date`      | `timestamp` | The timestamp for when the invoice was generated for the order.                                                             |
| `status_id`         | `integer`   | The Unique Identifier of the status associated with the order, if any.                                                      | 
| `status_comment`    | `string`    | A comment to associate with the assigned status                                                                             | 
| `assignee_id`       | `integer`   | The Unique Identifier of the staff assigned to the order, if any.                                                           |
| `assignee_group_id` | `integer`   | The Unique Identifier of the staff group assigned to the order, if any.                                                     |  
| `ip_address`        | `string`    | The IP address used when the order was created.                                                                             |
| `user_agent`        | `string`    | The HTTP User-Agent of the browser user when the order was created.                                                         |     |
| `order_totals`      | `array`     | ***required*** Collection of totals associated with the order.                                                              |
| `order_menus`       | `array`     | ***required*** Collection of menu items associated with the order.                                                          |


#### Payload example
```json
{
    "location_id": 1,
    "first_name": "Tucker",
    "last_name": "Vega",
    "email": "vavur@mailinator.com",
    "telephone": "+1 (604) 376-2674",
    "comment": "Give me my food",
    "order_type": "collection",
    "order_date": "2021-03-01",
    "order_time": "10:00",
    "payment": "cod",
    "processed": 1,
    "status_id": 1,
    "status_comment": "My comment",
    "order_menus": [
        {
            "rowId": 0,
            "id": 1,
            "name": "Puff-Puff",
            "qty": 3,
            "price": "4.9900",
            "subtotal": "14.9700",
            "comment": "",
            "options": []
        }
    ],
    "order_totals": [
        {
            "code": "total",
            "title": "Total",
            "value": 10,
            "priority": 1
        }
    ],
    "order_total": 10.00
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
            "type": "orders",
            "id": "1",
            "attributes": {
                "customer_id": 1,
                "location_id": 1,
                "address_id": null,
                "first_name": "Tucker",
                "last_name": "Vega",
                "email": "vavur@mailinator.com",
                "telephone": "+1 (604) 376-2674",
                "notify": null,
                "order_type": "collection",
                "order_time": "13:13:00",
                "order_date": "2020-05-24 00:00:00",
                "processed": true,
                "total_items": 3,
                "order_total": "15.0449",
                "currency": "GBP",
                "comment": "",
                "payment": "cod",
                "invoice_prefix": "INV-2020-00",
                "invoice_date": "2020-05-24T11:58:43.000000Z",
                "status_id": 3,
                "status_updated_at": "2020-05-24T11:58:43.000000Z",
                "assignee_id": null,
                "assignee_group_id": null,
                "assignee_updated_at": null,
                "ip_address": "192.168.10.1",
                "hash": "7158b25ef2f10b151f87fc4d26b3b27d",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-05-24 12:58:43",
                "updated_at": "2020-05-24 12:58:43"
            }
        }
    ]
}
```

### Retrieve an order

Retrieves an order.

Required abilities: `orders:read`

```
GET /api/orders/:order_id
```

#### Parameters

| Key       | Type     | Description                                                                                                                                                                                                                                    |
|-----------|----------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `include` | `string` | What relations to include in the response. Options are `customer`, `location`, `address`, `payment_method`, `status`, `assignee`, `assignee_group`, `status_history`. To include multiple separate by comma (e.g. ?include= customer,location) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "orders",
            "id": "1",
            "attributes": {
                "customer_id": 1,
                "location_id": 1,
                "address_id": null,
                "first_name": "Tucker",
                "last_name": "Vega",
                "email": "vavur@mailinator.com",
                "telephone": "+1 (604) 376-2674",
                "notify": null,
                "order_type": "collection",
                "order_time": "13:13:00",
                "order_date": "2020-05-24 00:00:00",
                "processed": true,
                "total_items": 3,
                "order_total": "15.0449",
                "currency": "GBP",
                "comment": "",
                "payment": "cod",
                "invoice_prefix": "INV-2020-00",
                "invoice_date": "2020-05-24T11:58:43.000000Z",
                "status_id": 3,
                "status_updated_at": "2020-05-24T11:58:43.000000Z",
                "assignee_id": null,
                "assignee_group_id": null,
                "assignee_updated_at": null,
                "ip_address": "192.168.10.1",
                "hash": "7158b25ef2f10b151f87fc4d26b3b27d",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-05-24 12:58:43",
                "updated_at": "2020-05-24 12:58:43",
                "order_totals": [],
                "customer": [],
                "location": [],
                "address": [],
                "payment_method": [],
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
                "address": {
                    "data": []
                },
                "payment_method": {
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

### Update an order

Updates an order.

Required abilities: `orders:write`

```
PATCH /api/orders/:order_id
```

#### Parameters

| Key                   | Type        | Description                                                                                                  |
|-----------------------|-------------|--------------------------------------------------------------------------------------------------------------|
| `first_name`          | `string`    | The first name associated with the order.                                                                    |
| `last_name`           | `string`    | The last name associated with the order.                                                                     |
| `email`               | `string`    | The email address associated with the order.                                                                 |
| `telephone`           | `string`    | The telephone associated with the order.                                                                     |
| `notify`              | `boolean`   | Has the value `true` if an order confirmation email was sent, or the value `false` if no email was sent.     |
| `order_type`          | `string`    | Has the value `delivery` if the order is for delivery or the value `collection` if the order is for pick-up. |
| `order_date_time`     | `dateTime`  | The datetime for when the order is available for delivery/pick-up.                                           |
| `status_id`           | `integer`   | The Unique Identifier of the status associated with the order, if any.                                       |
| `status_updated_at`   | `dateTime`  | The datetime for when the order's status was last updated.                                                   |
| `assignee_id`         | `integer`   | The Unique Identifier of the staff assigned to the order, if any.                                            |
| `assignee_group_id`   | `integer`   | The Unique Identifier of the staff group assigned to the order, if any.                                      |
| `assignee_updated_at` | `timestamp` | The timestamp for when the order was last assigned.                                                          |

#### Payload example

```json
{
    "order_type": "delivery",
    "status_id": 4
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
            "type": "orders",
            "id": "1",
            "attributes": {
                "customer_id": 1,
                "location_id": 1,
                "address_id": null,
                "first_name": "Tucker",
                "last_name": "Vega",
                "email": "vavur@mailinator.com",
                "telephone": "+1 (604) 376-2674",
                "notify": null,
                "order_type": "collection",
                "order_time": "13:13:00",
                "order_date": "2020-05-24 00:00:00",
                "processed": true,
                "total_items": 3,
                "order_total": "15.0449",
                "currency": "GBP",
                "comment": "",
                "payment": "cod",
                "invoice_prefix": "INV-2020-00",
                "invoice_date": "2020-05-24T11:58:43.000000Z",
                "status_id": 4,
                "status_updated_at": "2020-05-24T11:58:43.000000Z",
                "assignee_id": null,
                "assignee_group_id": null,
                "assignee_updated_at": null,
                "ip_address": "192.168.10.1",
                "hash": "7158b25ef2f10b151f87fc4d26b3b27d",
                "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:76.0) Gecko/20100101 Firefox/76.0",
                "created_at": "2020-05-24 12:58:43",
                "updated_at": "2020-05-24 12:58:43"
            }
        }
    ]
}
```

### Update order status

Updates only the order status. Use this when you only need to change the status (e.g. from pending to completed) without sending other order fields.

Required abilities: `orders:write`

```
PATCH /api/orders/:order_id/status
```

#### Parameters

| Key               | Type     | Description                                                                 |
|-------------------|----------|-----------------------------------------------------------------------------|
| `status_id`       | `integer`| **Required**. The Unique Identifier of the status to assign to the order.  |
| `comment`  | `string` | Optional comment to attach to the status change (max 500 characters).     |
| `notify`         | `boolean`| Optional. Whether to notify the customer of the status change (default: false). |

#### Payload example

```json
{
    "status_id": 4,
    "status_comment": "Order ready for collection"
}
```

#### Response

```html
Status: 200 OK
```

Returns the updated order object in the same shape as the retrieve/update response (including the new `status_id` and `status_updated_at`).

### Delete an order

Permanently deletes an order. It cannot be undone.

Required abilities: `orders:write`

```
DELETE /api/orders/:order_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the order ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "order",
    "deleted": true
}
```
