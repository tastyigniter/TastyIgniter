## Currencies

This endpoint allows you to `list` your currencies.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The currency object

#### Attributes

| Key                | Type       | Description                                                 |
|--------------------|------------|-------------------------------------------------------------|
| `currency_name`    | `string`   | The currency name                                           |
| `currency_code`    | `string`   | The unique ISO code of the currency                         | 
| `currency_symbol`  | `string`   | The symbol commonly used for the currency                   | 
| `symbol_position`  | `boolean`  | Has the value `true` if after the amount, `false` if before |
| `thousand_sign`    | `string`   | The separator specified to separate thousand values         |
| `decimal_sign`     | `string `  | The separator specified to separate decimal values          |
| `decimal_position` | `string `  | The number of decimal places specified                      |
| `currency_status`  | `boolean ` | Has the value `true` if enabled, or `false` if disabled     |

#### Table object example

```json
{
    "currency_name": "Afghani",
    "currency_code": "AFN",
    "currency_symbol": "؋",
    "symbol_position": false,
    "thousand_sign": ",",
    "decimal_sign": ".",
    "decimal_position": "2",
    "currency_status": false
}
```

### List currencies

Returns a list of currencies you’ve previously created.

Required abilities: `currencies:read`

```
GET /api/currencies
```

#### Parameters

| Key         | Type      | Description                                                                                                                              |
|-------------|-----------|------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer` | The page number.                                                                                                                         |
| `pageLimit` | `integer` | The number of items per page.                                                                                                            |
| `enabled`   | `boolean` | If true only currencies that are enabled will be returned                                                                                |
| `search`    | `string`  | The phrase to search for in the currency name and code                                                                                   |
| `sort`      | `string`  | The order to return results in. Possible values are `currency_name asc`, `currency_name desc`, `currency_code asc`, `currency_code desc` |


#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "currencies",
            "id": "1",
            "attributes": {
                "currency_name": "Afghani",
                "currency_code": "AFN",
                "currency_symbol": "؋",
                "symbol_position": false,
                "thousand_sign": ",",
                "decimal_sign": ".",
                "decimal_position": "2",
                "currency_status": false
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
        "self": "https://your.url/api/currencies?page=1",
        "first": "https://your.url/api/currencies?page=1",
        "last": "https://your.url/api/currencies?page=1"
    }
}
```
