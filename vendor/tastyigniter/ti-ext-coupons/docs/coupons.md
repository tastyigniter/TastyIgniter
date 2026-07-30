## Coupons

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` your coupons.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The Coupon object

#### Attributes

| Key                  | Type      | Description                                                  |
| -------------------- | --------- | ------------------------------------------------------------ |
| `name`           | `string`  | **Required**. The coupon's name         |
| `code`           | `string`  | **Required**. The coupon's code.         |
| `type`           | `character`  | **Required**. F for fixed value, P for percentage         |
| `discount`           | `float`  | **Required**. The discount value or percentage         |
| `min_total`           | `float`  | The minimum basket total for the coupon to be valid        |
| `redemptions`           | `integer`  | *Required**. The total number of times this coupon can be redeemed       |
| `customer_redemptions`           | `integer`  | *Required**. The number of times a specific customer can redeem this coupon      |
| `description`           | `string`  | A description of the coupon         |
| `validity`           | `string`  | One of: `forever`, `fixed`, `period` or `recurring`        |
| `fixed_date`           | `date`  | Date coupon is valid on. Required when validity is `fixed` |
| `fixed_from_time`           | `time`  | Time coupon is valid from. Required when validity is `fixed` |
| `fixed_to_time`           | `time`  | Time coupon is valid to. Required when validity is `fixed` |
| `period_start_date`           | `date`  | Date coupon is valid from. Required when validity is `period` |
| `period_end_date`           | `date`  | Date coupon is valid to. Required when validity is `period` |
| `recurring_every`           | `array`  | Array of days of the week the coupon is valid from (Sunday is 0, Saturday is 6). Required when validity is `recurring` |
| `recurring_from_time`           | `time`  | Time coupon is valid from. Required when validity is `recurring ` |
| `recurring_to_time`           | `time`  | Time coupon is valid to. Required when validity is `recurring` |
| `order_restriction`           | `string`  | `null` for any delivery type, `delivery` for delivery only, `collection` for pick-up only |
| `status`           | `boolean`  | Has the value `true` if the coupon is enabled or the value `false` if the coupon is disabled.         |
| `locations`           | `array`  | An array of location ids this coupon is valid for         |
| `auto_apply`           | `boolean`  | Has the value `true` if the coupon is to be auto applied or the value `false` if not.         |
| `is_limited_to_cart_item`           | `boolean`  | Has the value `true` if the coupon is limited to specific cart items or the value `false` if not.         |

#### Coupon object example

```json
{
  "type": "coupons",
  "id": "1",
    "attributes": {
        "name": "Half Sundays",
        "code": "2222",
        "type": "F",
        "discount": 100,
        "min_total": 500,
        "redemptions": 0,
        "customer_redemptions": 0,
        "description": null,
        "status": true,
        "updated_at": "-0001-11-30 00:00:00",
        "created_at": "-0001-11-30 00:00:00",
        "validity": "forever",
        "fixed_date": null,
        "fixed_from_time": null,
        "fixed_to_time": null,
        "period_start_date": null,
        "period_end_date": null,
        "recurring_every": [
            0,
            1,
            2,
        3,
        4,
        5,
        6
    ],
    "recurring_from_time": null,
    "recurring_to_time": null,
    "order_restriction": null,
    "is_limited_to_cart_item": 0,
    "auto_apply": false
  }
}
```

### The history object

The history object contains key information about the coupon transaction.

#### Attributes

| Key                  | Type      | Description                                                  |
| -------------------- | --------- | ------------------------------------------------------------ |
| `coupon_id`           | `integer`  | The coupon id associated with the history log
| `order_id`           | `integer`  | The order id associated with the history log        |
| `customer_id`           | `integer `  | The customer id associated with the history log         |
| `code`           | `string `  | The code used in the transaction        |
| `amount`           | `float `  | The total value of the order        |
| `min_total`           | `float`  | The minimum total required for the order   |
| `created_at`           | `datetime`  | Timestamp of transaction
| `status`           | `boolean`  | Defaults to true, might change in future   |

### List coupons

Returns a list of coupons you’ve previously created.

Required abilities: `coupons:read`

```
GET /api/coupons
```

#### Parameters

| Key                  | Type      | Description          |
| -------------------- | --------- | ------------------------- |
| `page`           | `integer`  | The page number.         |
| `pageLimit`           | `integer`  | The number of items per page.         |
| `include`           | `string`  | What relations to include in the response. Options are `menus`, `categories`. To include multiple seperate by comma (e.g. ?include=categories,menus) |

#### Response

```html
Status: 200 OK
```

```json
{
  "data": [
      {
        "type": "coupons",
        "id": "1",
          "attributes": {
              "name": "Half Sundays",
              "code": "2222",
              "type": "F",
              "discount": 100,
              "min_total": 500,
              "redemptions": 0,
              "customer_redemptions": 0,
              "description": null,
              "status": true,
              "created_at": "-0001-11-30 00:00:00",
              "updated_at": "-0001-11-30 00:00:00",
              "validity": "forever",
              "fixed_date": null,
              "fixed_from_time": null,
              "fixed_to_time": null,
              "period_start_date": null,
              "period_end_date": null,
              "recurring_every": [
                  6
              ],
              "recurring_from_time": null,
          "recurring_to_time": null,
          "order_restriction": null,
          "is_limited_to_cart_item": 0,
          "auto_apply": false
	    }
      },
      "relationships": {
        "menus": {
          "data": [...]
        },
        "categories": {
          "data": [...]
        }
      }
    }
  ],
  "included": [
    ...
  ],
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
    "self": "https://your.url/api/coupons?page=1",
    "first": "https://your.url/api/coupons?page=1",
    "last": "https://your.url/api/coupons?page=1"
  }
}
```

### Create a coupon

Creates a new coupon.

Required abilities: `coupons:write`

```
POST /api/coupons
```

#### Parameters

| Key                  | Type      | Description                                                  |
| -------------------- | --------- | ------------------------------------------------------------ |
| `name`           | `string`  | **Required**. The coupon's name         |
| `code`           | `string`  | **Required**. The coupon's code.         |
| `type`           | `character`  | **Required**. F for fixed value, P for percentage         |
| `discount`           | `float`  | **Required**. The discount value or percentage         |
| `min_total`           | `float`  | The minimum basket total for the coupon to be valid        |
| `redemptions`           | `integer`  | *Required**. The total number of times this coupon can be redeemed       |
| `customer_redemptions`           | `integer`  | *Required**. The number of times a specific customer can redeem this coupon      |
| `description`           | `string`  | A description of the coupon         |
| `validity`           | `string`  | One of: `forever`, `fixed`, `period` or `recurring`        |
| `fixed_date`           | `date`  | Date coupon is valid on. Required when validity is `fixed` |
| `fixed_from_time`           | `time`  | Time coupon is valid from. Required when validity is `fixed` |
| `fixed_to_time`           | `time`  | Time coupon is valid to. Required when validity is `fixed` |
| `period_start_date`           | `date`  | Date coupon is valid from. Required when validity is `period` |
| `period_end_date`           | `date`  | Date coupon is valid to. Required when validity is `period` |
| `recurring_every`           | `array`  | Array of days of the week the coupon is valid from (Sunday is 0, Saturday is 6). Required when validity is `recurring` |
| `recurring_from_time`           | `time`  | Time coupon is valid from. Required when validity is `recurring ` |
| `recurring_to_time`           | `time`  | Time coupon is valid to. Required when validity is `recurring` |
| `order_restriction`           | `string`  | `null` for any delivery type, `delivery` for delivery only, `collection` for pick-up only |
| `status`           | `boolean`  | Has the value `true` if the coupon is enabled or the value `false` if the coupon is disabled.         |
| `locations`           | `array`  | An array of location ids this coupon is valid for         |
| `auto_apply`           | `boolean`  | Has the value `true` if the coupon is to be auto applied or the value `false` if not.         |
| `is_limited_to_cart_item`           | `boolean`  | Has the value `true` if the coupon is limited to specific cart items or the value `false` if not.         |

#### Payload example

```json
{
  "name": "New coupon",
  "code": "test",
  "type": "F",
  "discount": 10,
  "redemptions": 0,
  "customer_redemptions": 0,
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
        "type": "coupons",
        "id": "2",
        "attributes": {
            "name": "New coupon",
            "code": "test",
            "type": "F",
            "discount": 10,
            "min_total": 0,
            "redemptions": 0,
            "customer_redemptions": 0,
            "description": null,
            "status": true,
            "created_at": "-0001-11-30 00:00:00",
            "updated_at": "-0001-11-30 00:00:00",
            "validity": "forever",
            "fixed_date": null,
            "fixed_from_time": null,
            "fixed_to_time": null,
            "period_start_date": null,
            "period_end_date": null,
            "recurring_every": [
                6
            ],
            "recurring_from_time": null,
          "recurring_to_time": null,
          "order_restriction": null,
          "is_limited_to_cart_item": 0,
          "auto_apply": false
        }
      }
    }
  ]
}
```

### Retrieve a coupon

Retrieves a coupon.

Required abilities: `coupons:read`

```
GET /api/coupons/:coupon_id
```

#### Parameters

| Key                  | Type      | Description          |
| -------------------- | --------- | ------------------------- |
| `include`           | `string`  | What relations to include in the response. Options are `menus`, `categories`. To include multiple seperate by comma (e.g. ?include=categories,menus) |

#### Response

```html
Status: 200 OK
```

```json
{
  "data": [
      {
        "type": "coupons",
        "id": "1",
          "attributes": {
              "name": "Half Sundays",
              "code": "2222",
              "type": "F",
              "discount": 100,
              "min_total": 500,
              "redemptions": 0,
              "customer_redemptions": 0,
              "description": null,
              "status": true,
              "created_at": "-0001-11-30 00:00:00",
              "updated_at": "-0001-11-30 00:00:00",
              "validity": "forever",
              "fixed_date": null,
              "fixed_from_time": null,
              "fixed_to_time": null,
              "period_start_date": null,
              "period_end_date": null,
              "recurring_every": [
                  6
              ],
              "recurring_from_time": null,
          "recurring_to_time": null,
          "order_restriction": null,
          "is_limited_to_cart_item": 0,
          "auto_apply": false
	    }
      },
      "relationships": {
        "menus": {
          "data": [...]
        },
        "categories": {
          "data": [...]
        }
      }
    }
  ],
  "included": [
	...
  ]
}
```

### Update a coupon

Updates a coupon.

Required abilities: `coupons:write`

```
PATCH /api/coupons/:coupon_id
```

#### Parameters

| Key                  | Type      | Description                                                  |
| -------------------- | --------- | ------------------------------------------------------------ |
| `name`           | `string`  |     The coupon's name         |
| `code`           | `string`  |     The coupon's code.         |
| `type`           | `character`  |     F for fixed value, P for percentage         |
| `discount`           | `float`  |     The discount value or percentage         |
| `min_total`           | `float`  | The minimum basket total for the coupon to be valid        |
| `redemptions`           | `integer`  | *Required**. The total number of times this coupon can be redeemed       |
| `customer_redemptions`           | `integer`  | *Required**. The number of times a specific customer can redeem this coupon      |
| `description`           | `string`  | A description of the coupon         |
| `validity`           | `string`  | One of: `forever`, `fixed`, `period` or `recurring`        |
| `fixed_date`           | `date`  | Date coupon is valid on. Required when validity is `fixed` |
| `fixed_from_time`           | `time`  | Time coupon is valid from. Required when validity is `fixed` |
| `fixed_to_time`           | `time`  | Time coupon is valid to. Required when validity is `fixed` |
| `period_start_date`           | `date`  | Date coupon is valid from. Required when validity is `period` |
| `period_end_date`           | `date`  | Date coupon is valid to. Required when validity is `period` |
| `recurring_every`           | `array`  | Array of days of the week the coupon is valid from (Sunday is 0, Saturday is 6). Required when validity is `recurring` |
| `recurring_from_time`           | `time`  | Time coupon is valid from. Required when validity is `recurring ` |
| `recurring_to_time`           | `time`  | Time coupon is valid to. Required when validity is `recurring` |
| `order_restriction`           | `string`  | `null` for any delivery type, `delivery` for delivery only, `collection` for pick-up only |
| `status`           | `boolean`  | Has the value `true` if the coupon is enabled or the value `false` if the coupon is disabled.         |
| `locations`           | `array`  | An array of location ids this coupon is valid for         |
| `auto_apply`           | `boolean`  | Has the value `true` if the coupon is to be auto applied or the value `false` if not.         |
| `is_limited_to_cart_item`           | `boolean`  | Has the value `true` if the coupon is limited to specific cart items or the value `false` if not.         |

#### Payload example

```json
{
  "description": "Vivamus interdum erat ac aliquam porttitor.",
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
        "type": "coupons",
        "id": "1",
          "attributes": {
              "name": "Half Sundays",
              "code": "2222",
              "type": "F",
              "discount": 100,
              "min_total": 500,
              "redemptions": 0,
              "customer_redemptions": 0,
              "description": "Vivamus interdum erat ac aliquam porttitor.",
              "status": true,
              "created_at": "-0001-11-30 00:00:00",
              "updated_at": "-0001-11-30 00:00:00",
              "validity": "forever",
              "fixed_date": null,
              "fixed_from_time": null,
              "fixed_to_time": null,
              "period_start_date": null,
              "period_end_date": null,
              "recurring_every": [
                  6
              ],
              "recurring_from_time": null,
          "recurring_to_time": null,
          "order_restriction": null,
          "is_limited_to_cart_item": 0,
          "auto_apply": false
	    }
      }
    }
  ]
}
```

### Delete a coupon

Permanently deletes a coupon. It cannot be undone.

Required abilities: `coupons:write`

```
DELETE /api/coupons/:coupon_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the coupon ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
  "id": 1,
  "object": "coupon",
  "deleted": true
}
```
