# Phase 1.8 Table, Floor & Dine-in Audit and ADR

## Read-only audit summary

Searches covered `table`, `floor`, `dining`, `dine_in`, `guest_count`, `restaurant table`, `table map`, `split bill`, `merge order`, and `transfer order` across the repository. No production table/floor/session implementation was found in RestaurantOps before this phase. Existing `Restaurant.DineIn.*` permissions were future-facing only.

1. **POS order lifecycle**: RestaurantOps already owns `naxas_restaurant_ops_pos_orders`, item/event/idempotency tables, and `PosOrderService` state transitions from draft/held through active, kitchen, payment and paid/cancelled.
2. **`service_type`**: `dine_in`, `delivery`, and `collection` are already accepted by POS order creation.
3. **`dine_in` support**: POS supports dine-in as a service type, but no table context existed.
4. **`guest_count`**: POS orders include nullable `guest_count`; Phase 1.8 mirrors active table guest count into the POS order for operational context.
5. **Location/branch context**: `LocationContextContract`, `location.context`, and `restaurant.ops.transactional` already enforce concrete branch selection.
6. **POS order tables**: Existing POS tables remain authoritative for POS sessions/items/totals.
7. **Official TastyIgniter orders**: `Igniter\Cart\Models\Order` remains authoritative once POS confirmation synchronizes it.
8. **Order totals**: POS totals and official totals are not duplicated; running bills aggregate POS order totals.
9. **Payment integration**: Phase 1.7 payment service, tenders, receipts and reversal events remain in place and are reused.
10. **Cashier shifts**: `ShiftContextContract::requireOpenShift` is used by POS creation and therefore by table opening.
11. **Permissions**: Existing permission definitions are centralized in `PermissionDefinitions`.
12. **Audit log**: `AuditLogger` is a PSR/logger adapter; Phase 1.8 adds structured table session events plus audit log calls.
13. **Admin pages**: Explicit Laravel admin routes render via `AdminPageController`.
14. **Navigation**: Extension navigation is registered by `Extension::registerNavigation`.
15. **Menu/item snapshot behavior**: Item pricing/config snapshots remain managed by Phase 1.6/1.7 POS/menu services.
16. **Route patterns**: Admin URI routes live under `{admin}/restaurant-ops` with named `naxas.restaurantops.*` routes.
17. **Migration conventions**: Anonymous migrations, long explicit index names, strings instead of native MySQL ENUMs.
18. **MySQL indexes/FKs**: Existing migrations use FK restrictions/cascades and compact composite indexes.
19. **Events/listeners**: POS and payment emit event objects; Phase 1.8 emits `TableClosed` for later waiter/KDS integration.
20. **UI patterns**: Blade views rendered through admin layout; no SPA/drag-drop prerequisite exists.

## Architecture decision

RestaurantOps owns floors, tables, operational table sessions, transfers, merges, bill requests, bill split calculations and occupancy records. It does **not** create a second order system. A table session references one primary RestaurantOps POS order, and that POS order continues to reference the official TastyIgniter order after confirmation.

## Active session uniqueness

MySQL lacks partial unique indexes. Phase 1.8 uses nullable `active_table_id` on `naxas_restaurant_ops_table_sessions` with a unique key. Active sessions store the current occupied table ID; closed/transferred/merged sessions set it to `NULL`. MySQL permits multiple `NULL` values while enforcing one non-null active marker per table, preventing two active sessions for one table.

## Merge and split limitation

No safe official order merge/split primitive was identified. Phase 1.8 therefore preserves official orders and implements operational aggregation for merges and operational allocation records for bill splits. Paid/cancelled/closed sessions are rejected.

## Concurrency decision

Open, close, transfer, merge, split, bill-request and guest-count operations run inside database transactions with `lockForUpdate`. Multi-table transfer locks table IDs in deterministic ascending order. Laravel transaction deadlock retries are set to 3, consistent with POS/payment service patterns.
