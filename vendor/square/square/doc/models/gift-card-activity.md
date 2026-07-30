
# Gift Card Activity

Represents an action performed on a [gift card](../../doc/models/gift-card.md) that affects its state or balance.
A gift card activity contains information about a specific activity type. For example, a `REDEEM` activity
includes a `redeem_activity_details` field that contains information about the redemption.

## Structure

`GiftCardActivity`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the gift card activity. | getId(): ?string | setId(?string id): void |
| `type` | [`string (GiftCardActivityType)`](../../doc/models/gift-card-activity-type.md) | Required | Indicates the type of [gift card activity](../../doc/models/gift-card-activity.md). | getType(): string | setType(string type): void |
| `locationId` | `string` | Required | The ID of the [business location](entity:Location) where the activity occurred. | getLocationId(): string | setLocationId(string locationId): void |
| `createdAt` | `?string` | Optional | The timestamp when the gift card activity was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `giftCardId` | `?string` | Optional | The gift card ID. When creating a gift card activity, `gift_card_id` is not required if<br>`gift_card_gan` is specified. | getGiftCardId(): ?string | setGiftCardId(?string giftCardId): void |
| `giftCardGan` | `?string` | Optional | The gift card account number (GAN). When creating a gift card activity, `gift_card_gan`<br>is not required if `gift_card_id` is specified. | getGiftCardGan(): ?string | setGiftCardGan(?string giftCardGan): void |
| `giftCardBalanceMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getGiftCardBalanceMoney(): ?Money | setGiftCardBalanceMoney(?Money giftCardBalanceMoney): void |
| `loadActivityDetails` | [`?GiftCardActivityLoad`](../../doc/models/gift-card-activity-load.md) | Optional | Represents details about a `LOAD` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getLoadActivityDetails(): ?GiftCardActivityLoad | setLoadActivityDetails(?GiftCardActivityLoad loadActivityDetails): void |
| `activateActivityDetails` | [`?GiftCardActivityActivate`](../../doc/models/gift-card-activity-activate.md) | Optional | Represents details about an `ACTIVATE` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getActivateActivityDetails(): ?GiftCardActivityActivate | setActivateActivityDetails(?GiftCardActivityActivate activateActivityDetails): void |
| `redeemActivityDetails` | [`?GiftCardActivityRedeem`](../../doc/models/gift-card-activity-redeem.md) | Optional | Represents details about a `REDEEM` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getRedeemActivityDetails(): ?GiftCardActivityRedeem | setRedeemActivityDetails(?GiftCardActivityRedeem redeemActivityDetails): void |
| `clearBalanceActivityDetails` | [`?GiftCardActivityClearBalance`](../../doc/models/gift-card-activity-clear-balance.md) | Optional | Represents details about a `CLEAR_BALANCE` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getClearBalanceActivityDetails(): ?GiftCardActivityClearBalance | setClearBalanceActivityDetails(?GiftCardActivityClearBalance clearBalanceActivityDetails): void |
| `deactivateActivityDetails` | [`?GiftCardActivityDeactivate`](../../doc/models/gift-card-activity-deactivate.md) | Optional | Represents details about a `DEACTIVATE` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getDeactivateActivityDetails(): ?GiftCardActivityDeactivate | setDeactivateActivityDetails(?GiftCardActivityDeactivate deactivateActivityDetails): void |
| `adjustIncrementActivityDetails` | [`?GiftCardActivityAdjustIncrement`](../../doc/models/gift-card-activity-adjust-increment.md) | Optional | Represents details about an `ADJUST_INCREMENT` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getAdjustIncrementActivityDetails(): ?GiftCardActivityAdjustIncrement | setAdjustIncrementActivityDetails(?GiftCardActivityAdjustIncrement adjustIncrementActivityDetails): void |
| `adjustDecrementActivityDetails` | [`?GiftCardActivityAdjustDecrement`](../../doc/models/gift-card-activity-adjust-decrement.md) | Optional | Represents details about an `ADJUST_DECREMENT` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getAdjustDecrementActivityDetails(): ?GiftCardActivityAdjustDecrement | setAdjustDecrementActivityDetails(?GiftCardActivityAdjustDecrement adjustDecrementActivityDetails): void |
| `refundActivityDetails` | [`?GiftCardActivityRefund`](../../doc/models/gift-card-activity-refund.md) | Optional | Represents details about a `REFUND` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getRefundActivityDetails(): ?GiftCardActivityRefund | setRefundActivityDetails(?GiftCardActivityRefund refundActivityDetails): void |
| `unlinkedActivityRefundActivityDetails` | [`?GiftCardActivityUnlinkedActivityRefund`](../../doc/models/gift-card-activity-unlinked-activity-refund.md) | Optional | Represents details about an `UNLINKED_ACTIVITY_REFUND` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getUnlinkedActivityRefundActivityDetails(): ?GiftCardActivityUnlinkedActivityRefund | setUnlinkedActivityRefundActivityDetails(?GiftCardActivityUnlinkedActivityRefund unlinkedActivityRefundActivityDetails): void |
| `importActivityDetails` | [`?GiftCardActivityImport`](../../doc/models/gift-card-activity-import.md) | Optional | Represents details about an `IMPORT` [gift card activity type](../../doc/models/gift-card-activity-type.md).<br>This activity type is used when Square imports a third-party gift card, in which case the<br>`gan_source` of the gift card is set to `OTHER`. | getImportActivityDetails(): ?GiftCardActivityImport | setImportActivityDetails(?GiftCardActivityImport importActivityDetails): void |
| `blockActivityDetails` | [`?GiftCardActivityBlock`](../../doc/models/gift-card-activity-block.md) | Optional | Represents details about a `BLOCK` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getBlockActivityDetails(): ?GiftCardActivityBlock | setBlockActivityDetails(?GiftCardActivityBlock blockActivityDetails): void |
| `unblockActivityDetails` | [`?GiftCardActivityUnblock`](../../doc/models/gift-card-activity-unblock.md) | Optional | Represents details about an `UNBLOCK` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getUnblockActivityDetails(): ?GiftCardActivityUnblock | setUnblockActivityDetails(?GiftCardActivityUnblock unblockActivityDetails): void |
| `importReversalActivityDetails` | [`?GiftCardActivityImportReversal`](../../doc/models/gift-card-activity-import-reversal.md) | Optional | Represents details about an `IMPORT_REVERSAL` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getImportReversalActivityDetails(): ?GiftCardActivityImportReversal | setImportReversalActivityDetails(?GiftCardActivityImportReversal importReversalActivityDetails): void |
| `transferBalanceToActivityDetails` | [`?GiftCardActivityTransferBalanceTo`](../../doc/models/gift-card-activity-transfer-balance-to.md) | Optional | Represents details about a `TRANSFER_BALANCE_TO` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getTransferBalanceToActivityDetails(): ?GiftCardActivityTransferBalanceTo | setTransferBalanceToActivityDetails(?GiftCardActivityTransferBalanceTo transferBalanceToActivityDetails): void |
| `transferBalanceFromActivityDetails` | [`?GiftCardActivityTransferBalanceFrom`](../../doc/models/gift-card-activity-transfer-balance-from.md) | Optional | Represents details about a `TRANSFER_BALANCE_FROM` [gift card activity type](../../doc/models/gift-card-activity-type.md). | getTransferBalanceFromActivityDetails(): ?GiftCardActivityTransferBalanceFrom | setTransferBalanceFromActivityDetails(?GiftCardActivityTransferBalanceFrom transferBalanceFromActivityDetails): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "type": "ADJUST_INCREMENT",
  "location_id": "location_id4",
  "created_at": "created_at2",
  "gift_card_id": "gift_card_id8",
  "gift_card_gan": "gift_card_gan6",
  "gift_card_balance_money": {
    "amount": 82,
    "currency": "LSL"
  },
  "load_activity_details": {
    "amount_money": {
      "amount": 244,
      "currency": "BRL"
    },
    "order_id": "order_id4",
    "line_item_uid": "line_item_uid0",
    "reference_id": "reference_id8",
    "buyer_payment_instrument_ids": [
      "buyer_payment_instrument_ids6",
      "buyer_payment_instrument_ids7"
    ]
  },
  "activate_activity_details": {
    "amount_money": {
      "amount": 16,
      "currency": "AMD"
    },
    "order_id": "order_id4",
    "line_item_uid": "line_item_uid0",
    "reference_id": "reference_id8",
    "buyer_payment_instrument_ids": [
      "buyer_payment_instrument_ids6",
      "buyer_payment_instrument_ids7"
    ]
  },
  "redeem_activity_details": {
    "amount_money": {
      "amount": 128,
      "currency": "MNT"
    },
    "payment_id": "payment_id4",
    "reference_id": "reference_id8",
    "status": "COMPLETED"
  },
  "clear_balance_activity_details": {
    "reason": "REUSE_GIFTCARD"
  },
  "deactivate_activity_details": {
    "reason": "CHARGEBACK_DEACTIVATE"
  },
  "adjust_increment_activity_details": {
    "amount_money": {
      "amount": 240,
      "currency": "PGK"
    },
    "reason": "TRANSACTION_VOIDED"
  },
  "adjust_decrement_activity_details": {
    "amount_money": {
      "amount": 92,
      "currency": "QAR"
    },
    "reason": "SUPPORT_ISSUE"
  },
  "refund_activity_details": {
    "redeem_activity_id": "redeem_activity_id0",
    "amount_money": {
      "amount": 90,
      "currency": "BTC"
    },
    "reference_id": "reference_id8",
    "payment_id": "payment_id0"
  },
  "unlinked_activity_refund_activity_details": {
    "amount_money": {
      "amount": 46,
      "currency": "DKK"
    },
    "reference_id": "reference_id0",
    "payment_id": "payment_id2"
  },
  "import_activity_details": {
    "amount_money": {
      "amount": 170,
      "currency": "LBP"
    }
  },
  "block_activity_details": {
    "reason": "reason2"
  },
  "unblock_activity_details": {
    "reason": "reason0"
  },
  "import_reversal_activity_details": {
    "amount_money": {
      "amount": 106,
      "currency": "BHD"
    }
  },
  "transfer_balance_to_activity_details": {
    "transfer_from_gift_card_id": "transfer_from_gift_card_id4",
    "amount_money": {
      "amount": 224,
      "currency": "DJF"
    }
  },
  "transfer_balance_from_activity_details": {
    "transfer_to_gift_card_id": "transfer_to_gift_card_id6",
    "amount_money": {
      "amount": 42,
      "currency": "MAD"
    }
  }
}
```

