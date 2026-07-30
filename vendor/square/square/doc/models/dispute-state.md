
# Dispute State

The list of possible dispute states.

## Enumeration

`DisputeState`

## Fields

| Name | Description |
|  --- | --- |
| `INQUIRY_EVIDENCE_REQUIRED` | The initial state of an inquiry with evidence required |
| `INQUIRY_PROCESSING` | Inquiry evidence has been submitted and the bank is processing the inquiry |
| `INQUIRY_CLOSED` | The inquiry is complete |
| `EVIDENCE_REQUIRED` | The initial state of a dispute with evidence required |
| `PROCESSING` | Dispute evidence has been submitted and the bank is processing the dispute |
| `WON` | The bank has completed processing the dispute and the seller has won |
| `LOST` | The bank has completed processing the dispute and the seller has lost |
| `ACCEPTED` | The seller has accepted the dispute |

