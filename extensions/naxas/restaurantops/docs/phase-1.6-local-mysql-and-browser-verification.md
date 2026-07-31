# Phase 1.6 local MySQL and browser verification

Status before this runbook: **IMPLEMENTED — LOCAL MYSQL AND BROWSER VERIFICATION REQUIRED. NOT PRODUCTION-READY UNTIL OWNER VERIFICATION.** Use a disposable MySQL 8/InnoDB database and a non-production installation. Retain the database version, PHP version, application/core/extension versions, timezone, commit SHA, command output and screenshots.

## Environment and automated proof

1. Start MySQL; configure a non-production `.env`, non-empty `APP_KEY`, correct timezone and `DB_*` settings.
2. Run `php artisan igniter:up`, `php artisan migrate`, `php artisan restaurant-ops:sync-roles`, and confirm the extension is enabled.
3. Run `php artisan restaurant-ops:verify-pos --check-environment`, the focused regular suites, then `RESTAURANT_OPS_MYSQL_TEST=1 php artisan test --testsuite=RestaurantOpsMySQL --env=testing.mysql` against the disposable database.
4. Inspect all five `naxas_restaurant_ops_pos_*` tables: InnoDB, `utf8mb4`, `DECIMAL(15,4)`, named indexes, foreign keys, unique official linkage and idempotency uniqueness. Run the extension migrations down/up on a disposable copy and confirm data retention when merely disabling/re-enabling the extension.
5. Exercise two concurrent confirmation requests and two stale-version edits. Confirm one official order link, deterministic replay/conflict responses, no deadlock leak, and no duplicate kitchen-ready event revision.

## Browser workflow

1. Create active **Integration POS Branch**; create cashier and manager; assign both to that branch; sync/grant the documented POS permissions.
2. Configure **BBQ Chicken Pizza**, 8/10/12-inch variants, required crust, optional toppings, Extra Cheese quantity support, service/location/channel visibility and kitchen routing. Open the cashier shift with opening cash.
3. Open POS at the configured admin URI. Verify branch/shift, responsive category/search/item areas and large controls. Create Collection (including `takeaway` alias), Delivery and Dine-in foundation drafts.
4. Select variants/modifiers/combo choices including Extra Cheese quantity 2. Confirm required selections, availability/mealtime/special-price rules, server totals, item/order notes, registered customer and minimal guest handling. Submit fake client price/total/discount fields and confirm rejection.
5. Hold, list and recall. Change quantity/configuration, duplicate/add incrementally, remove an unsent item, change menu configuration, then confirm recall/confirm produces an explicit stale warning rather than silent repricing.
6. Apply an allowed discount if configured; request a threshold-exceeding discount; have a different branch manager approve/reject. Confirm self/cross-location approvals fail and audit before/discount/after amounts. Mark kitchen-ready, request item void, approve/reject, and confirm history remains.
7. Confirm the order. Inspect official order number, service mapping, customer/address, notes, official items/options/totals and RestaurantOps snapshots. Retry confirmation and prove it does not create another official order.
8. Select **Send to Kitchen — queue available in a later phase**. Inspect event payload/revision/stations and prove no KOT, ticket, queue or preparation status exists.
9. Select **Prepare for Payment**. Confirm payable/outstanding values and lock timestamp. Prove no payment, tender, gateway call, receipt, processed/paid flag, cash movement or expected-cash increase occurs.
10. Request shift close. Confirm draft/held/active/kitchen-pending warnings and a payment-pending blocker are scoped to the same shift/location and contain minimal identifiers only. Resolve or use documented manager handling; never silently close.
11. Attempt another branch's direct URL, global mode, inactive location/staff, cashier without shift, waiter and kitchen accounts, closed-shift recall/edit, stale version and conflicting idempotency reuse. Verify structured 403/409/422 responses.
12. Verify official storefront legacy cart, enhanced cart, checkout, delivery, collection, reservation, customer login/profile, online ordering and payment routes still work unchanged. Disable/re-enable RestaurantOps and confirm official workflows still work and POS data remains.

## Screenshots to retain

Capture the POS order screen, variant/modifier selection, held list, recalled order, discount approval, confirmed order, official order linkage, kitchen-ready foundation, payment-pending foundation and shift warning. Include the configured admin URI and active branch context but redact customer address/phone/email.

## Cleanup and rollback

Use only records marked for this fixture. `restaurant-ops:verify-pos --cleanup` deliberately does not delete data; remove fixtures using a reviewed local test provider. For a full rollback on a disposable database, run the Phase 1.6 migration `down()` (it drops approval/events/items/idempotency before POS metadata). Never use rollback as an extension-disable procedure and back up retained operational data first.
