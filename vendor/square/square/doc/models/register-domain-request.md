
# Register Domain Request

Defines the parameters that can be included in the body of
a request to the [RegisterDomain](../../doc/apis/apple-pay.md#register-domain) endpoint.

## Structure

`RegisterDomainRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `domainName` | `string` | Required | A domain name as described in RFC-1034 that will be registered with ApplePay.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getDomainName(): string | setDomainName(string domainName): void |

## Example (as JSON)

```json
{
  "domain_name": "example.com"
}
```

