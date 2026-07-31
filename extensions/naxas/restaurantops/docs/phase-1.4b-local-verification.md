# Phase 1.4B local MySQL and browser verification

## Status and boundaries

The upgrade-safe integration is implemented, but this repository environment
has no MySQL server or browser-ready installation. The owner must complete this
runbook before production approval. SQLite smoke tests are not MySQL evidence.
The public endpoints are opt-in; official legacy storefront, cart and checkout
routes are not modified.

The official `igniter.checkout.afterSaveOrder` event is dispatched after the
official order transaction commits. Snapshot persistence therefore cannot be
claimed atomic with order creation. The listener is idempotent, and failed
writes are recorded in `naxas_restaurant_ops_snapshot_failures` for explicit
reconciliation with `--reconcile-snapshots`.

The official cart is session-backed while the idempotency claim is database-
backed, so they cannot share one ACID transaction. The implementation claims
before the single official cart call and releases on a reported cart failure.
An infrastructure failure after the cart session write but before completing
the ledger is a known reconciliation boundary; verify this failure mode with
the deployment's actual shared session driver before production approval.

## Create and prepare a disposable database

```bash
mysql -uroot -p -e "CREATE DATABASE tastyigniter_restaurantops_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE USER IF NOT EXISTS 'restaurantops_test'@'localhost' IDENTIFIED BY 'CHANGE_ME'; GRANT ALL ON tastyigniter_restaurantops_test.* TO 'restaurantops_test'@'localhost';"
cp .env.testing.mysql.example .env.testing.mysql
APP_ENV=testing php artisan key:generate --env=testing.mysql
```

Never reuse production credentials or production data. Adjust host grants for
Docker if required. Enable `Naxas.RestaurantOps` through the Extensions admin
screen (System → Extensions), then run:

```bash
php artisan migrate:status --env=testing.mysql
php artisan migrate --force --env=testing.mysql
php artisan restaurant-ops:sync-roles --env=testing.mysql
php artisan restaurant-ops:verify-menu-integration --env=testing.mysql --check-environment
```

## Scenario and automated MySQL suite

Fixture creation and cleanup refuse to run when `APP_ENV=production`.

```bash
php artisan restaurant-ops:verify-menu-integration --env=testing.mysql --seed-scenario
php artisan restaurant-ops:verify-menu-integration --env=testing.mysql --run-smoke
RESTAURANT_OPS_MYSQL_TEST=1 php artisan test --testsuite=RestaurantOpsMySQL --env=testing.mysql
```

The fixture is an active **Integration Test Branch**, **BBQ Chicken Pizza**,
8/10/12-inch variants, required Thin/Regular/Stuffed crust (+100), quantity-
enabled Mushroom/Olive/Extra Cheese toppings (+40/+50/+80), a delivery override
for the 10-inch variant, and an Olive collection-unavailability override. The
smoke selection is 10 inch + Stuffed + Extra Cheese ×2 + delivery. Read the
expected total from the seeded database and server breakdown; do not insert a
client total.

## Endpoint examples

First obtain the session and CSRF token through the normal storefront. Send JSON
with `Accept: application/json` and the standard `X-CSRF-TOKEN` header:

```http
POST /restaurant-ops/v1/cart/quote
Content-Type: application/json

{"contract_version":"1.0","menu_id":123,"location_id":4,"service_type":"delivery","channel":"storefront","quantity":1,"variant_id":12,"modifier_selections":[{"group_id":5,"modifiers":[{"modifier_id":22,"quantity":1}]}],"combo_selections":[],"item_note":"Less spicy"}
```

Copy the returned `configuration_hash` into the same body and add:

```http
POST /restaurant-ops/v1/cart/items
Idempotency-Key: locally-generated-unique-key
```

Price-like request fields (`unit_price`, `price`, `subtotal`, `total`,
`modifier_price`, `discount`) are prohibited. Add requires a prior hash and an
idempotency key. A retry with the same key and body returns the stored result;
the same key with a different body returns 409.

Idempotency keys are stored only as SHA-256 hashes in the extension-owned
`naxas_restaurant_ops_cart_idempotency` table and are scoped with an HMAC of the
storefront session ID. Raw keys and session IDs are neither persisted nor
logged. Pending claims reject concurrent duplicates; completed claims replay
the minimal response for one hour.

## Browser and order checklist

1. Sign in as Owner/Branch Manager; verify human-readable Restaurant Operations
   and Menu Configuration navigation.
2. Confirm the scenario variants, groups and overrides in the application-owned
   configuration UI/database.
3. Select Integration Test Branch in the official storefront and quote the
   documented selection. Record the response and query count.
4. Add malicious price fields and confirm 422; test negative/100 quantity,
   global mode, inactive/cross-location, hidden/unavailable modifier and stale
   hash responses.
5. Add normally; inspect the official cart, its canonical identity and totals.
   Repeat with the same idempotency key, then alter variant/modifier quantities
   and confirm distinct lines.
6. Complete an official delivery order. Confirm one snapshot per order item and
   no `snapshot_failures`; replay the event and confirm no duplicate.
7. Change/archive the menu, variant and modifier. Open
   `/ADMIN_URI/restaurant-ops/order-item-snapshots/{orderMenu}` and confirm the
   purchased names/prices remain unchanged. Open a legacy item and confirm the
   fallback.
8. Exercise official legacy menu, cart, checkout, collection, reservation,
   customer login, payment and online-order paths and capture evidence.
9. Disable RestaurantOps through Extensions. Confirm legacy routes work,
   enhanced routes disappear, and owned tables/data remain. Re-enable; confirm
   routes, permissions, configuration and snapshots return without duplicates.
10. Test concurrent edits, stale quote/add, archive/disable between boundaries,
    official cart failure, snapshot failure, and reconciliation:
    `php artisan restaurant-ops:verify-menu-integration --reconcile-snapshots`.

Capture the menu configuration, quote, cart, historical snapshot and legacy
flow without credentials, session/CSRF values, payment data or personal data.

## Schema inspection, cleanup and rollback

```sql
SELECT VERSION();
SHOW CREATE TABLE ti_naxas_restaurant_ops_order_item_snapshots;
SHOW CREATE TABLE ti_naxas_restaurant_ops_snapshot_failures;
SHOW CREATE TABLE ti_naxas_restaurant_ops_cart_idempotency;
SHOW INDEX FROM ti_naxas_restaurant_ops_order_item_snapshots;
SELECT * FROM information_schema.REFERENTIAL_CONSTRAINTS
 WHERE CONSTRAINT_SCHEMA='tastyigniter_restaurantops_test'
   AND TABLE_NAME LIKE 'ti_naxas_restaurant_ops_%';
```

```bash
php artisan restaurant-ops:verify-menu-integration --env=testing.mysql --cleanup
php artisan migrate:rollback --env=testing.mysql --path=extensions/naxas/restaurantops/database/migrations/2026_07_31_000200_create_menu_integration_support_tables.php
mysql -uroot -p -e "DROP DATABASE tastyigniter_restaurantops_test; DROP USER IF EXISTS 'restaurantops_test'@'localhost';"
```

Rollback only a disposable or verified-backed-up database. Disabling the
extension should normally retain configuration and immutable snapshots.
