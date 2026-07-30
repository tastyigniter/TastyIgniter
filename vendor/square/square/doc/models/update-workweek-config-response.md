
# Update Workweek Config Response

The response to a request to update a `WorkweekConfig` object. The response contains
the updated `WorkweekConfig` object and might contain a set of `Error` objects if
the request resulted in errors.

## Structure

`UpdateWorkweekConfigResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `workweekConfig` | [`?WorkweekConfig`](../../doc/models/workweek-config.md) | Optional | Sets the day of the week and hour of the day that a business starts a<br>workweek. This is used to calculate overtime pay. | getWorkweekConfig(): ?WorkweekConfig | setWorkweekConfig(?WorkweekConfig workweekConfig): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "workweek_config": {
    "created_at": "2016-02-04T00:58:24Z",
    "id": "FY4VCAQN700GM",
    "start_of_day_local_time": "10:00",
    "start_of_week": "MON",
    "updated_at": "2019-02-28T01:04:35Z",
    "version": 11
  }
}
```

