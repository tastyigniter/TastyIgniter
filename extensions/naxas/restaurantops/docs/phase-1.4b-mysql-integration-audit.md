# Phase 1.4B MySQL-backed menu integration pre-change audit

**Audit date:** 2026-07-31  
**Repository branch:** `phase1/menu-integration-verification`  
**Audit decision at the time:** **NO-GO / BLOCKED at Phase A**
**Subsequent owner authorization:** implementation may proceed without treating
the unavailable Codex MySQL runtime as a blocker; local MySQL/browser proof is
still mandatory before production readiness.

This is the mandatory pre-change audit. It intentionally contains no runtime
integration implementation. The stated preconditions require work to stop when
MySQL is unavailable; SQLite is not used as substitute evidence.

## Readiness decision

The application resolves the `mysql` connection at `127.0.0.1:3306`, database
`forge`, with table prefix `ti_`. There is no repository `.env`, the effective
`APP_KEY` is empty, no MySQL/MariaDB process or port 3306 listener is present,
and `php artisan db:show`, both migration-status attempts, and
`php artisan migrate --force` fail with `SQLSTATE[HY000] [2002] Connection
refused`. Consequently the configured database, credentials, database version,
extension database enablement, migration status, records, schema, admin runtime,
and order placement cannot be verified.

The Phase 1.4B preconditions therefore fail on at least MySQL availability,
database existence/connectivity, credentials, and `APP_KEY`. Production code,
migrations, routes, listeners, test data, and browser state were not changed.

## Inputs and Phase 1.4 change inventory

The prompt identifies commit `e56f29c5dc6de9ed73daf4f20326fce9bd358261`,
but that object does not exist in this clone. The locally auditable Phase 1.4
foundation is commit `7966b461` (`Add upgrade-safe menu configuration engine
foundation`). It added or changed:

- migration `database/migrations/2026_07_31_000100_create_menu_configuration_tables.php`;
- contracts/decision records `docs/enhanced-cart-and-snapshot-contract.md` and
  `docs/phase-1.4-menu-configuration-audit-and-adr.md`;
- English translations, `routes/web.php`, `src/Extension.php`, and permission
  definitions;
- catalog/detail Blade views and the `MenuConfigurations` admin controller;
- attachment, availability, pricing, selection, cart-compatibility, kitchen
  routing, context, invalid-configuration, and order-snapshot services;
- eleven extension models for metadata, variants, modifiers, availability,
  conditions, combos, and snapshots;
- `MenuConfigurationCompatibilityTest`, `MenuConfigurationEngineTest`, and an
  update to `RestaurantOpsRolesPermissionsTest`.

Later local commits fixed the admin navigation schema and translations. Static
route discovery succeeds and registers ten human-readable, configurable-admin-
URI RestaurantOps routes. Runtime dashboard rendering could not be proven
without its database.

## RestaurantOps migration audit

There are now three owned migrations, in timestamp/dependency order. The third
was added after the owner authorized Phase 1.4B implementation:

1. `2026_07_31_000001_create_restaurant_ops_staff_preferences_table.php` creates
   `naxas_restaurant_ops_staff_preferences`. It has a unique unsigned-bigint
   `staff_id`, nullable unsigned-bigint `default_location_id`, an index on that
   location, and timestamps. It deliberately has no official-table foreign key.
2. `2026_07_31_000100_create_menu_configuration_tables.php` creates eleven
   `naxas_restaurant_ops_*` tables: menu-item metadata, item variants, modifier
   groups, modifier metadata, menu/group attachments, availability overrides,
   modifier conditions, combos, combo groups, combo choices, and order-item
   snapshots.
3. `2026_07_31_000200_create_menu_integration_support_tables.php` creates the
   durable `naxas_restaurant_ops_snapshot_failures` reconciliation table and
   `naxas_restaurant_ops_cart_idempotency` request ledger after the snapshot
   table they support. The failure table has a unique `order_menu_id`, JSON
   snapshot payload, bounded attempt counter, timestamps, and an indexed
   order/last-attempt retry path. The idempotency ledger uniquely scopes hashed
   keys to a hashed storefront session, records only request hashes/minimal
   responses, and expires records. Rollback drops only these support tables.

The menu migration creates parents before dependants and drops them in reverse
dependency order. Its extension-owned foreign keys are restrictive:

- attachment to item variant and modifier group;
- modifier condition to modifier metadata and modifier group;
- combo group to combo;
- combo choice to combo group and item variant.

Official IDs (`menu_id`, `option_id`, `option_value_id`, `location_id`,
`order_id`, `order_menu_id`, staff and station/tax references) are soft scalar
references, avoiding an installation-time coupling to historical official
schema types. Uniqueness covers menu metadata, menu/variant code, option-backed
group, option-value-backed modifier, modifier code, attachment tuple,
condition tuple, combo menu/code, combo-group code, combo choice, and exactly
one snapshot per official order menu. Hot-path composite indexes cover active
variants, active/sold-out modifiers, group attachment resolution, location/menu/
service/channel overrides, override targets, and order/location snapshot reads.

All persisted prices/surcharges/costs use `DECIMAL(15,4)`; no migration money
column is float. Operational variants, modifier groups, modifier metadata, and
combos have `archived_at`; mutable records also have active/status/version
fields. Override windows and snapshot creation use timestamps (no explicit
fractional precision). Nullable extension foreign keys are variant attachment
and combo-choice variant, both restrictive when populated. Snapshot
`order_menu_id` is unique, making snapshot writes database-idempotent.

Static concerns requiring MySQL proof remain: engine/collation inheritance,
prefixed physical/index names and length limits, nullable-column unique
semantics for attachment/combo tuples, decimal round trips, timestamp defaults,
foreign-key type compatibility, and rollback execution. No rollback was
attempted because there is no disposable connected database.

## Existing runtime and domain audit

### Configuration and data

- Default runtime is MySQL, with effective prefix `ti_`; `.env.example` leaves
  host, port, database, username, password, and prefix blank, while framework
  defaults resolve to the values recorded above.
- PHP is `8.4.22-dev`, not the target PHP 8.3; Laravel is 12.64.0.
- MySQL server version, migration rows, extension database enablement, official
  Menu/MenuOption/MenuOptionValue rows, location activity, and service-type data
  are **unknown** because connection fails.
- Static service semantics canonicalize accepted `takeaway` to official
  `collection`; delivery and collection remain owned by official services.

### Official integration seams

The prior Phase 1.4 source audit establishes these compatibility seams:

- official `Igniter\Cart\Models\Menu`, MenuOption/MenuOptionValue and menu-item
  option attachments remain authoritative;
- official storefront selection enters `CartManager::addCartItem`, which loads
  the menu, validates option/value relationships and derives option prices;
- official line identity is based on the buyable ID plus serialized official
  options; notes are not identity input;
- checkout validates through the official order request/manager, persists
  `OrderMenu` and option rows, and exposes
  `igniter.checkout.beforeSaveOrder` / `igniter.checkout.afterSaveOrder`;
- official historical rows already capture menu name, quantity, price,
  subtotal, comment, and selected option values, but not the complete enhanced
  configuration;
- extension model relations on official Menu and OrderMenu are additive public
  extension seams; `MenuAdapter`, `OrderAdapter`, `LocationContextContract`,
  the pricing/availability/attachment resolvers, compatibility mapper, and
  snapshot service isolate upstream dependencies.

The enhanced mapper is not invoked by any runtime route. The only registered
RestaurantOps routes are admin landing/configuration routes. Snapshot writing
is not connected to a real order path. The current admin UI can list official
menus, display configuration counts, and create/archive variants; it cannot
create the complete required variant/modifier/override test scenario.

Static translation tests and route discovery indicate navigation translation
keys resolve after the later translation fix. Actual admin authentication,
navigation rendering, CSRF behavior, extension enable/disable state, and
location permission enforcement cannot be browser-verified. Storefront routes
remain official catch-all theme routes (`cart`, `checkout`, location menus,
reservation, and account login); RestaurantOps currently adds no storefront or
API route. Admin routes use configured admin URI, admin middleware, location
context, permission middleware, and transactional-location middleware where
applicable.

### Existing test and tooling baseline

Focused application coverage exists for Menu Configuration, Location Context,
RestaurantOps discovery/navigation/adapters, and roles/permissions. Official
package suites cover cart/order behavior but are not all part of this root
suite. The Menu Configuration unit test (14 tests/21 assertions) and
compatibility feature test (3 tests/23 assertions) pass, each with baseline
warnings caused by the deprecated PHPUnit XML schema and unavailable source
files used for coverage metadata. The attempted combined Location Context run
did not produce a conclusive final result and is not recorded as passing.
Composer validation reports the documented
baseline mismatch: `composer.json` is valid, but the lock lacks
`cweagans/composer-patches` and is not current. No Composer update was run.

MySQL-only incompatibilities cannot be discovered or ruled out in this
environment. In particular, no `SHOW CREATE TABLE`, `SHOW INDEX`, or
`information_schema` constraint query can run before connectivity exists.

## Integration proposal (deferred; no implementation)

### Versioned endpoints and contracts

Add extension-owned, route-cache-safe storefront routes only after GO:

- `POST /restaurant-ops/v1/cart/quote`, named
  `naxas.restaurantops.v1.cart.quote`, for validation, canonicalization,
  availability, hash checking, and server pricing without mutation;
- `POST /restaurant-ops/v1/cart/items`, named
  `naxas.restaurantops.v1.cart.items`, repeating all checks and delegating one
  write to an official cart adapter.

Use ordinary storefront `web` session/CSRF and customer/location conventions,
not admin authentication. Accept contract `1.0`, bounded integer quantity,
concrete active location, canonical service/channel, IDs and quantities only;
reject unknown price-related fields rather than silently suggesting support.
Return contract/hash, canonical selections and identity, availability, decimal
breakdown/unit/line totals, and warnings. Map invalid selection to 422,
unauthorized location to 403, and stale hash/idempotency conflict to 409, using
the documented `restaurantops_*` error codes.

### Transactions, idempotency, and snapshot timing

- Quote is read-only and must use a consistent configuration version/hash.
- Add re-resolves configuration inside the write boundary, never consumes a
  client price, and calls the official cart adapter exactly once.
- Require `Idempotency-Key` for enhanced writes. Before adding persistence,
  verify whether the official session cart can atomically retain a bounded
  request-key/result mapping. If not, add only a prefixed RestaurantOps table
  keyed by customer/session-safe scope plus idempotency key, request identity
  hash, state, and expiry. Never log session identifiers. Same key/same request
  replays the stored result; same key/different request is 409.
- Carry versioned enhanced metadata on the official cart line. Prefer a public
  post-item-persist/pre-commit order seam. If only `afterSaveOrder` is usable,
  prove whether it runs inside the official transaction. Write the unique
  snapshot immediately after each official enhanced `OrderMenu` is durable.
  Treat a required snapshot failure as fatal while inside the transaction. If
  the seam is post-commit, do not claim atomicity: persist a minimal
  reconciliation record/outbox and retry idempotently.
- Snapshot `firstOrCreate` plus unique `order_menu_id` prevents duplicates, but
  concurrency must explicitly catch/reload unique-key races.

### Rollback strategy

Disable the extension first through supported tooling, clear route/config
caches, retain owned tables by default, and confirm legacy routes. Code rollback
removes only extension routes/listeners. Schema rollback may occur only on a
backed-up or disposable database and must run menu-table rollback before staff
preferences; its reverse-ordered drops affect only
`naxas_restaurant_ops_*`. Restore the code/extension and migrate forward to
recover behavior. Never discard snapshots/configuration as part of routine
disable.

## Risk matrix

| Risk | Severity | Required control before GO |
|---|---:|---|
| MySQL absent or wrong schema semantics | Critical | Real server, disposable DB, migrate/schema/rollback proof |
| Missing APP_KEY/session integrity | Critical | Configure stable APP_KEY before storefront tests |
| Client price tampering | Critical | Strict request contract and one server pricing resolver |
| Cross-location/global transaction | Critical | Concrete active authorized location; reject global mode |
| Duplicate HTTP cart write | Critical | Atomic idempotency scope and replay/conflict tests |
| Snapshot outside order transaction | Critical | Prove event timing or durable reconciliation |
| Duplicate listener/snapshot race | High | Unique key plus concurrency-safe reload |
| Quote/add or cart/order stale config | High | Re-resolve and compare configuration hash at every boundary |
| Canonical identity omits channel/note | High | Include location/service/channel and configured selections; verify note policy |
| Nullable unique tuple behavior | High | MySQL integration test; use normalized keys if needed |
| Official private seam drift | High | Adapter/behavior compatibility tests against public services/events |
| Extension disable breaks legacy | High | Disable/re-enable browser and route tests with tables retained |
| Lightweight UI cannot seed scenario | Medium | Add only the minimal permission-safe controls or a disposable seeder |
| Prefix/index/collation differences | Medium | Inspect physical DDL and information_schema |
| Baseline PHP/Composer divergence | Medium | Test target PHP 8.3; preserve and report lock mismatch |

## No-regression checklist

- [x] No production code, vendor, core, official extension, official route, or
  official schema was changed during this audit.
- [x] Legacy cart/checkout behavior was not intercepted.
- [x] Route cache and route clear succeed on the static application.
- [ ] MySQL connection/version/database/credentials proven.
- [ ] APP_KEY configured.
- [ ] Extension enabled in the connected database.
- [ ] Pre/post migration status and all physical DDL verified.
- [ ] Existing Menu Configuration, Location Context, roles, navigation, and
  compatibility tests pass before implementation.
- [ ] Admin dashboard/navigation renders without exception and labels resolve.
- [ ] Quote and add routes are opt-in, storefront-safe, server-priced, and
  concrete-location-only.
- [ ] Official cart delegation, merge/distinct identity, and idempotent retry
  proven.
- [ ] Enhanced order placement, atomic snapshot or reconciliation, immutable
  history, and legacy fallback proven.
- [ ] Malicious prices, concurrency, stale/archive/disabled-location, cart
  failure, database failure, and rollback cases proven.
- [ ] Legacy storefront, menu, cart, checkout, delivery, collection,
  reservation, authentication, payment, and online-order flows browser-tested.
- [ ] Disable/re-enable and data retention proven.
- [ ] Query counts/N+1 behavior measured and required indexes justified.
- [ ] Browser screenshots/response evidence captured without secrets.
- [ ] Target PHP 8.3 and MySQL-focused/regression suites pass.

## Required remediation and resume point

Provide a real disposable MySQL database (recommended
`tastyigniter_restaurantops_test`), valid least-privilege credentials in `.env`,
a stable `APP_KEY`, and a supported way to inspect/enable
`Naxas.RestaurantOps`. Then restart at Phase A: run the focused baseline tests,
render the authenticated admin dashboard, verify translations and enablement,
inspect existing records and migration status, and only after those checks pass
proceed through Phase B. Until then Phase 1.4B is **blocked, unimplemented, and
not production-ready**.
