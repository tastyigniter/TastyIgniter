
# Customer Sort Field

Specifies customer attributes as the sort key to customer profiles returned from a search.

## Enumeration

`CustomerSortField`

## Fields

| Name | Description |
|  --- | --- |
| `DEFAULT` | Use the default sort key. By default, customers are sorted<br>alphanumerically by concatenating their `given_name` and `family_name`. If<br>neither name field is set, string comparison is performed using one of the<br>remaining fields in the following order: `company_name`, `email`,<br>`phone_number`. |
| `CREATED_AT` | Use the creation date attribute (`created_at`) of customer profiles as the sort key. |

