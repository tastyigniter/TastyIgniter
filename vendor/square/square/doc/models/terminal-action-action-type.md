
# Terminal Action Action Type

Describes the type of this unit and indicates which field contains the unit information. This is an ‘open’ enum.

## Enumeration

`TerminalActionActionType`

## Fields

| Name | Description |
|  --- | --- |
| `PING` | The action represents a request to check if the specific device is<br>online or currently active with the merchant in question. Does not require an action options value. |
| `SAVE_CARD` | Represents a request to save a card for future card-on-file use. Details are contained<br>in the `save_card_options` object. |
| `RECEIPT` | The action represents a request to display the receipt screen options. Details are<br>contained in the `receipt_options` object. |

