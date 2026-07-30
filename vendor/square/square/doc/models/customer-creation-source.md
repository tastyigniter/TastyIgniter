
# Customer Creation Source

Indicates the method used to create the customer profile.

## Enumeration

`CustomerCreationSource`

## Fields

| Name | Description |
|  --- | --- |
| `OTHER` | The default creation source. This source is typically used for backward/future<br>compatibility when the original source of a customer profile is<br>unrecognized. For example, when older clients do not support newer<br>source types. |
| `APPOINTMENTS` | The customer profile was created automatically when an appointment<br>was scheduled. |
| `COUPON` | The customer profile was created automatically when a coupon was issued<br>using Square Point of Sale. |
| `DELETION_RECOVERY` | The customer profile was restored through Square's deletion recovery<br>process. |
| `DIRECTORY` | The customer profile was created manually through Square Seller Dashboard or the<br>Point of Sale application. |
| `EGIFTING` | The customer profile was created automatically when a gift card was<br>issued using Square Point of Sale. Customer profiles are created for<br>both the buyer and the recipient of the gift card. |
| `EMAIL_COLLECTION` | The customer profile was created through Square Point of Sale when<br>signing up for marketing emails during checkout. |
| `FEEDBACK` | The customer profile was created automatically when providing feedback<br>through a digital receipt. |
| `IMPORT` | The customer profile was created automatically when importing customer<br>data through Square Seller Dashboard. |
| `INVOICES` | The customer profile was created automatically during an invoice payment. |
| `LOYALTY` | The customer profile was created automatically when customers provide a<br>phone number for loyalty reward programs during checkout. |
| `MARKETING` | The customer profile was created as the result of a campaign managed<br>through Square’s Facebook integration. |
| `MERGE` | The customer profile was created as the result of explicitly merging<br>multiple customer profiles through the Square Seller Dashboard or the Point of<br>Sale application. |
| `ONLINE_STORE` | The customer profile was created through Square's Online Store solution<br>(legacy service). |
| `INSTANT_PROFILE` | The customer profile was created automatically as the result of a successful<br>transaction that did not explicitly link to an existing customer profile. |
| `TERMINAL` | The customer profile was created through Square's Virtual Terminal. |
| `THIRD_PARTY` | The customer profile was created through a Square API call. |
| `THIRD_PARTY_IMPORT` | The customer profile was created by a third-party product and imported<br>through an official integration. |
| `UNMERGE_RECOVERY` | The customer profile was restored through Square's unmerge recovery<br>process. |

