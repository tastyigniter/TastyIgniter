# RestaurantOps

## Phase status

- Phase 1.7: Payment, tender, receipt and shift reconciliation approved.
- Phase 1.8: Table, floor and dine-in management implemented as an extension-owned operational layer.

## Phase 1.8 table lifecycle

Create Floor → Create Table → Open Table → Set Guest Count → Create Dine-in POS Order → Add/Confirm Items through existing POS → Running Bill → Additional Items → Bill Request → Transfer/Merge/Split as applicable → Existing Phase 1.7 Payment/Receipt → Close Table → Table Available.

## Permission matrix

- Cashier: `Restaurant.Tables.View`, `Restaurant.Tables.Open`, `Restaurant.Tables.BillRequest`, `Restaurant.Tables.Close`.
- Branch Manager: all `Restaurant.Tables.*` and `Restaurant.Floors.Manage`.
- Waiter: `Restaurant.Tables.View`, `Restaurant.Tables.Open`, `Restaurant.Tables.BillRequest` unless policy grants transfer/merge/split.
- Kitchen: no table management permissions.
- Owner: full access.

## Floor and table configuration

Floors and tables are stored in `naxas_restaurant_ops_floors` and `naxas_restaurant_ops_tables`. Tables include active status, capacity, shape, coordinates, dimensions, rotation and sort order. Reservation logic is not implemented; `reserved` is future-ready only.

## Operational rules

- One active session per table is enforced by nullable unique `active_table_id`.
- Closed, merged and transferred historical sessions are immutable and never deleted.
- Transfers preserve POS order, official order, payments and receipts.
- Merges are operational aggregations; official orders are not rewritten.
- Splits are operational allocations; official order lines are not duplicated.
- Paid orders cannot be merged or split.
- Table close requires zero outstanding balance and no open split.
- All mutating operations validate location context, permission middleware, expected version and row locks.

## Payment and rollback

Payments and receipts continue to use Phase 1.7 POS payment routes and ledgers. Roll back Phase 1.8 by reversing migration `2026_08_12_000700_create_table_floor_management_tables.php` after confirming no active dine-in service depends on the operational records.

## MySQL requirements

Run MySQL verification queries in `docs/phase-1.8-local-mysql-browser-verification.md`, including duplicate active-session checks and `EXPLAIN` for table-map/session lookups.
