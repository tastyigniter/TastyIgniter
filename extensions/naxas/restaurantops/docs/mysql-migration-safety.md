# MySQL migration compatibility and recovery

RestaurantOps supports MySQL/InnoDB through TastyIgniter's native extension lifecycle. Logical table names never contain a database prefix; Laravel applies the configured prefix (for example `ti_`) exactly once.

## Supported lifecycle

Back up every retained database before an upgrade. Install with `php artisan restaurant-ops:install --force`, or directly with the canonical `php artisan igniter:up --force`. Upgrade with `php artisan restaurant-ops:upgrade --force`. Both extension commands run a read-only fail-fast preflight and then delegate to `igniter:up`; they are not a second migration engine. Finish with `php artisan restaurant-ops:sync-roles` and `php artisan restaurant-ops:verify-installation`.

The preflight reports connection, database, MySQL version, prefix, projected identifier failures and unrecorded partial-table drift, and stops before mutation on deterministic failure. Verification checks every migration table and column, schema identifiers, permissions, stable roles, and overview, menu configuration, shifts and POS routes. Failure exits nonzero.

## Identifier policy

MySQL's absolute identifier maximum is 64 characters. Every extension-owned index, unique key and foreign key is explicit, globally unique, lowercase, and uses `rops_<domain>_<purpose>_<kind>`. Kinds are `idx`, `uq`/`unique`, and `fk`. New names must be no longer than 55 characters. Composite names describe lookup purpose rather than concatenating every column. Long tables must never use Laravel implicit names. Prefixes are not included in explicit names or hardcoded into logical tables.

`MigrationSchema::identifierAudit()` scans every extension migration and fails on implicit names, duplicates, names over 55 characters, or an unmatched explicit drop. `RestaurantOpsMigrationSafetyTest` exercises it with the `ti_` prefix.

## Dependency, schema, and rollback contract

Order is staff preferences; menu configuration; integration support; cashier shifts; then POS. Internal dependencies are attachments → variants/groups, conditions → modifiers/groups, combo choices → combo groups/variants, movements/submissions → shifts, denominations → submissions, and POS orders → shifts with POS children → orders/items. Every multi-table `down()` is reverse-dependent.

Official staff, location, menu, order and customer IDs intentionally remain logical integration references. Internal aggregate ownership uses InnoDB foreign keys. IDs are unsigned big integers, money is `decimal(15,4)`, JSON has no default, nullable relationships use declared restrict/null behavior, and indexed strings fit normal utf8mb4/InnoDB limits. Rollback is not an extension-disable mechanism and can destroy operational data; restore a reviewed backup instead.

## Partial migration recovery and edit policy

MySQL DDL can leave a table committed when a later index `ALTER TABLE` fails. Do not rerun blindly, edit history, or use `Schema::hasTable()` as permanent history. Retain `SHOW CREATE TABLE`, `SHOW INDEX`, `ti_migrations` RestaurantOps rows, and TastyIgniter output.

For disposable development use a new empty MySQL database. For retained data, take and verify a backup, compare every column/index/foreign key with the migration contract, and ship a timestamped additive idempotent repair migration. Existence checks may only classify a specifically documented broken state; preserve rows and stop on conflicting shape. Never rewrite deployed schema intent, drop retained tables, or delete/insert migration rows blindly.

The five `2026_07_31` files exist in repository history and are treated as potentially deployed. Their explicit-name correction affects fresh creation and does not rename healthy deployed keys. Future changes require additive migrations inside this extension's `database/migrations` directory.

## Fresh and upgrade verification

On isolated MySQL record `SELECT DATABASE()`, `SELECT VERSION()`, migration rows, `SHOW CREATE TABLE` and `SHOW INDEX` for all 23 tables, and `information_schema.STATISTICS`/`TABLE_CONSTRAINTS` length reports. Run `php artisan optimize:clear`, `php artisan igniter:up` twice, role sync, installation verification, MySQL RestaurantOps tests, and authenticated HTTP checks for overview, menu configuration, shifts and POS. Rehearse both the exact partial-table state and a healthy prior install, proving retained rows, assignments, grants, shifts and orders remain unchanged. SQLite/static inspection is never MySQL acceptance evidence.
