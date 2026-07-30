
# Inventory Change

Represents a single physical count, inventory, adjustment, or transfer
that is part of the history of inventory changes for a particular
[CatalogObject](../../doc/models/catalog-object.md) instance.

## Structure

`InventoryChange`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `type` | [`?string (InventoryChangeType)`](../../doc/models/inventory-change-type.md) | Optional | Indicates how the inventory change was applied to a tracked product quantity. | getType(): ?string | setType(?string type): void |
| `physicalCount` | [`?InventoryPhysicalCount`](../../doc/models/inventory-physical-count.md) | Optional | Represents the quantity of an item variation that is physically present<br>at a specific location, verified by a seller or a seller's employee. For example,<br>a physical count might come from an employee counting the item variations on<br>hand or from syncing with an external system. | getPhysicalCount(): ?InventoryPhysicalCount | setPhysicalCount(?InventoryPhysicalCount physicalCount): void |
| `adjustment` | [`?InventoryAdjustment`](../../doc/models/inventory-adjustment.md) | Optional | Represents a change in state or quantity of product inventory at a<br>particular time and location. | getAdjustment(): ?InventoryAdjustment | setAdjustment(?InventoryAdjustment adjustment): void |
| `transfer` | [`?InventoryTransfer`](../../doc/models/inventory-transfer.md) | Optional | Represents the transfer of a quantity of product inventory at a<br>particular time from one location to another. | getTransfer(): ?InventoryTransfer | setTransfer(?InventoryTransfer transfer): void |
| `measurementUnit` | [`?CatalogMeasurementUnit`](../../doc/models/catalog-measurement-unit.md) | Optional | Represents the unit used to measure a `CatalogItemVariation` and<br>specifies the precision for decimal quantities. | getMeasurementUnit(): ?CatalogMeasurementUnit | setMeasurementUnit(?CatalogMeasurementUnit measurementUnit): void |
| `measurementUnitId` | `?string` | Optional | The ID of the [CatalogMeasurementUnit](entity:CatalogMeasurementUnit) object representing the catalog measurement unit associated with the inventory change. | getMeasurementUnitId(): ?string | setMeasurementUnitId(?string measurementUnitId): void |

## Example (as JSON)

```json
{
  "type": "TRANSFER",
  "physical_count": {
    "id": "id2",
    "reference_id": "reference_id0",
    "catalog_object_id": "catalog_object_id6",
    "catalog_object_type": "catalog_object_type6",
    "state": "RETURNED_BY_CUSTOMER",
    "location_id": "location_id6",
    "quantity": "quantity8",
    "source": {
      "product": "BILLING",
      "application_id": "application_id6",
      "name": "name8"
    },
    "employee_id": "employee_id2",
    "team_member_id": "team_member_id2",
    "occurred_at": "occurred_at6",
    "created_at": "created_at0"
  },
  "adjustment": {
    "id": "id4",
    "reference_id": "reference_id2",
    "from_state": "WASTE",
    "to_state": "DECOMPOSED",
    "location_id": "location_id8",
    "catalog_object_id": "catalog_object_id8",
    "catalog_object_type": "catalog_object_type8",
    "quantity": "quantity0",
    "total_price_money": {
      "amount": 84,
      "currency": "GNF"
    },
    "occurred_at": "occurred_at8",
    "created_at": "created_at2",
    "source": {
      "product": "SQUARE_POS",
      "application_id": "application_id4",
      "name": "name0"
    },
    "employee_id": "employee_id4",
    "team_member_id": "team_member_id4",
    "transaction_id": "transaction_id2",
    "refund_id": "refund_id8",
    "purchase_order_id": "purchase_order_id4",
    "goods_receipt_id": "goods_receipt_id2",
    "adjustment_group": {
      "id": "id6",
      "root_adjustment_id": "root_adjustment_id6",
      "from_state": "RECEIVED_FROM_VENDOR",
      "to_state": "WASTE"
    }
  },
  "transfer": {
    "id": "id8",
    "reference_id": "reference_id6",
    "state": "RESERVED_FOR_SALE",
    "from_location_id": "from_location_id0",
    "to_location_id": "to_location_id0",
    "catalog_object_id": "catalog_object_id2",
    "catalog_object_type": "catalog_object_type2",
    "quantity": "quantity4",
    "occurred_at": "occurred_at2",
    "created_at": "created_at6",
    "source": {
      "product": "PAYROLL",
      "application_id": "application_id0",
      "name": "name4"
    },
    "employee_id": "employee_id8",
    "team_member_id": "team_member_id8"
  },
  "measurement_unit": {
    "measurement_unit": {
      "custom_unit": {
        "name": "name2",
        "abbreviation": "abbreviation4"
      },
      "area_unit": "IMPERIAL_SQUARE_MILE",
      "length_unit": "METRIC_MILLIMETER",
      "volume_unit": "GENERIC_CUP",
      "weight_unit": "IMPERIAL_STONE",
      "generic_unit": "UNIT",
      "time_unit": "GENERIC_MINUTE",
      "type": "TYPE_LENGTH"
    },
    "precision": 184
  },
  "measurement_unit_id": "measurement_unit_id0"
}
```

