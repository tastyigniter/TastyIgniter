
# Dispute Evidence Type

The type of the dispute evidence.

## Enumeration

`DisputeEvidenceType`

## Fields

| Name | Description |
|  --- | --- |
| `GENERIC_EVIDENCE` | Square assumes this evidence type if you do not provide a type when uploading evidence.<br><br>Use when uploading evidence as a file or string. |
| `ONLINE_OR_APP_ACCESS_LOG` | Server or activity logs that show proof of the cardholder’s identity and that the<br>cardholder successfully ordered and received the goods (digitally or otherwise).<br>Example evidence includes IP addresses, corresponding timestamps/dates, cardholder’s name and email<br>address linked to a cardholder profile held by the seller, proof the same device and card (used<br>in dispute) were previously used in prior undisputed transaction, and any related detailed activity.<br><br>Use when uploading evidence as a file or string. |
| `AUTHORIZATION_DOCUMENTATION` | Evidence that the cardholder did provide authorization for the charge.<br>Example evidence includes a signed credit card authorization.<br><br>Use when uploading evidence as a file. |
| `CANCELLATION_OR_REFUND_DOCUMENTATION` | Evidence that the cardholder acknowledged your refund or cancellation policy.<br>Example evidence includes a signature or checkbox showing the cardholder’s acknowledgement of your<br>refund or cancellation policy.<br><br>Use when uploading evidence as a file or string. |
| `CARDHOLDER_COMMUNICATION` | Evidence that shows relevant communication with the cardholder.<br>Example evidence includes emails or texts that show the cardholder received goods/services or<br>demonstrate cardholder satisfaction.<br><br>Use when uploading evidence as a file. |
| `CARDHOLDER_INFORMATION` | Evidence that validates the customer's identity.<br>Example evidence includes personally identifiable details such as name, email address, purchaser IP<br>address, and a copy of the cardholder ID.<br><br>Use when uploading evidence as a file or string. |
| `PURCHASE_ACKNOWLEDGEMENT` | Evidence that shows proof of the sale/transaction.<br>Example evidence includes an invoice, contract, or other item showing the customer’s acknowledgement<br>of the purchase and your terms.<br><br>Use when uploading evidence as a file or string. |
| `DUPLICATE_CHARGE_DOCUMENTATION` | Evidence that shows the charges in question are valid and distinct from one another.<br>Example evidence includes receipts, shipping labels, and invoices along with their distinct payment IDs.<br><br>Use when uploading evidence as a file. |
| `PRODUCT_OR_SERVICE_DESCRIPTION` | A description of the product or service sold.<br><br>Use when uploading evidence as a file or string. |
| `RECEIPT` | A receipt or message sent to the cardholder detailing the charge.<br>Note: You do not need to upload the Square receipt; Square submits the receipt on your behalf.<br><br>Use when uploading evidence as a file or string. |
| `SERVICE_RECEIVED_DOCUMENTATION` | Evidence that the service was provided to the cardholder or the expected date that services will be rendered.<br>Example evidence includes a signed delivery form, work order, expected delivery date, or other written agreements.<br><br>Use when uploading evidence as a file or string. |
| `PROOF_OF_DELIVERY_DOCUMENTATION` | Evidence that shows the product was provided to the cardholder or the expected date of delivery.<br>Example evidence includes a signed delivery form or written agreement acknowledging receipt of the goods or services.<br><br>Use when uploading evidence as a file or string. |
| `RELATED_TRANSACTION_DOCUMENTATION` | Evidence that shows the cardholder previously processed transactions on the same card and did not dispute them.<br>Note: Square automatically provides up to five distinct Square receipts for related transactions, when available.<br><br>Use when uploading evidence as a file or string. |
| `REBUTTAL_EXPLANATION` | An explanation of why the cardholder’s claim is invalid.<br>Example evidence includes an explanation of why each distinct charge is a legitimate purchase, why the cardholder’s claim<br>for credit owed due to their attempt to cancel, return, or refund is invalid per your stated policy and cardholder<br>agreement, or an explanation of how the cardholder did not attempt to remedy the issue with you first to receive credit.<br><br>Use when uploading evidence as a file or string. |
| `TRACKING_NUMBER` | The tracking number for the order provided by the shipping carrier. If you have multiple numbers, they need to be<br>submitted individually as separate pieces of evidence.<br><br>Use when uploading evidence as a string. |

