# Restaurant Operations extension foundation

`Naxas.RestaurantOps` 0.1.0 is the application-owned boundary for future restaurant
operations work. It supports PHP 8.3+, Laravel 12, TastyIgniter core 4.3 and the
official Local and User extensions. Cart, Reservation and Pay Register are optional
runtime integration seams in this foundation and are present in this application.
Phase 1.3 adds authorization and operational landing foundations only; it implements no POS, kitchen, waiter, shift, payment, inventory, or accounting workflow.

## Ownership and structure

- `src/Contracts` contains small, stable application-facing contracts.
- `src/Integrations` is the only preferred boundary for calls to official domains.
- `src/Support/PermissionDefinitions.php` is the canonical permission catalogue and `RoleProfiles.php` is the machine-readable default matrix.
- `routes/web.php`, `resources/views`, and `resources/lang` establish conventional
  extension resource roots. Phase 1 routes and UI remain under the application.
- `database/migrations` contains only the extension-owned staff default-location preference table. The preference never grants branch access.
- Root `tests/Feature/RestaurantOpsExtensionTest.php` exercises the extension in
  the complete application bootstrap; Location Context retains its existing tests.

The detailed audits are in `docs/phase-1.2-pre-change-audit.md` and `docs/phase-1.3-pre-change-audit.md`.

## Operational roles and synchronization

Official `UserRole` is the authorization profile mechanism; official `UserGroup` remains untouched for allocation. Stable role codes are `restaurant_ops_owner`, `restaurant_ops_branch_manager`, `restaurant_ops_cashier`, `restaurant_ops_waiter`, and `restaurant_ops_kitchen`.

Preview with `php artisan restaurant-ops:sync-roles --dry-run`. Create absent exact-code roles with `--create-missing`; add only absent extension permission grants with `--add-missing-permissions`. The command never removes grants, changes assignments, disables staff, or claims a similar-name custom role. Run database migrations before using default-location preferences.

Extension-owned admin routes are named `naxas.restaurantops.overview`, `.head-office`, `.branch`, `.cashier`, `.waiter`, and `.kitchen`. All use the configured admin URI, admin authentication, Location Context, explicit permission middleware, and concrete-location middleware on transactional workspaces. These pages are clearly labelled future-work landing pages and contain no simulated business data.

## Location Context compatibility

Moving working `App\\` classes would create route-cache, serialized-reference and
deployment risk without adding capability. The extension therefore binds
`LocationContextContract` to the scoped `App\\Services\\LocationContext`. Existing
routes, route names, controller, middleware alias, gates, view, logs, JSON errors,
and session keys remain unchanged. Future operational modules must type-hint the
contract rather than the application implementation.

The four existing permission names are returned from the official
`registerPermissions()` lifecycle hook. Add a future permission to
`PermissionDefinitions`, using a `Restaurant.<Module>.<Action>` key, and add an
exact-key test. Superuser behavior remains owned by TastyIgniter.

## Routes, UI, events, and modules

Add an extension route only to `routes/web.php`. Use `Igniter::adminUri()` for an
admin prefix, unique `naxas.restaurantops.*` route names, narrow route middleware,
and a route-cache/duplicate-name test. Never wrap storefront routes. Do not move
the Phase 1 application routes until a separate staged ADR proves safe.

`registerNavigation()` deliberately returns no links because the extension owns no
destination yet. A future real page can add a Restaurant Operations parent/child
using `admin_url()` and a registered permission. A branch indicator should be an
extension-owned view component inserted through a documented public admin event;
official theme templates must not be overridden.

Events belong under `src/Events` and listeners under `src/Listeners`; register them
with the extension's EventServiceProvider facilities. Internal future modules may
live under `src/Foundation`, `src/Location`, and feature-named directories, but POS,
kitchen, waiter, shifts, accounting and inventory are explicitly outside 0.1.x.

## Adding migrations and adapters

Create timestamped migrations in `database/migrations`. They must be additive and
reversible, must not mutate official tables unless separately justified, and new
tables must start with `naxas_restaurant_ops_`. Test `up` and `down`. Disabling an
extension never rolls back schema. Uninstalling operational data requires an
explicit reviewed migration, verified backup, and operator confirmation; no silent
destructive uninstall hook is permitted.

Put each official-domain dependency behind a clearly named class in
`src/Integrations`, document the public class/event/helper used, and extend the
compatibility smoke test. Do not call private methods or apply global model scopes.

## Enable, disable, upgrade, and rollback

Enable through the TastyIgniter Extensions administration/lifecycle command, then
clear caches and run the focused tests. Enabling registers resources, contract
bindings and permissions; it adds no storefront middleware or data. Disabling
hides extension-owned resources and future navigation without deleting data. The
application-owned Phase 1 context and an existing `active_location_id` remain safe.
Before later modules depend on the extension, deployment tooling must block an
unsafe disable.

Upgrade order:

1. Back up database, `.env`, custom extension and uploaded assets.
2. Update core/official extensions without editing their installed files.
3. Run Location Context and integration compatibility tests.
4. Update this extension and review upstream release notes.
5. Run `igniter:up`/migrations, focused tests, route cache and manual smoke tests.

For rollback, disable the new extension version, restore code and database backup,
clear config/route/addon caches, and rerun the previous compatibility suite. Never
reverse a data migration against production without its reviewed rollback plan.
Track core 4.x public hooks, model class names/relationships, admin URI helper,
permission hook, route loader, and logging contract on every upstream update.

## Testing and manual verification

Run Composer validation, package discovery, route listing/cache, focused extension
and Location Context tests, Pint, migration status and Git safety checks. Against a
newer TastyIgniter version, install dependencies in a clean environment and run the
adapter smoke test before migrations.

Manually sign in as superuser and assigned staff; verify one-location selection,
multi-location selector, denied switching, global-mode permission and configurable
admin prefix. Then smoke-test storefront home/menu, customer login, delivery,
collection, checkout/payment and reservation. Disable the extension and repeat the
storefront smoke test; verify no schema/data changes.

## Development prohibitions and limitations

Never edit `vendor/`, TastyIgniter core, official extension source or published
generated files; never hardcode `/admin` or location IDs; never duplicate official
staff/location/order/menu/customer/reservation/payment domains. This version has no
extension-owned page, navigation item, migration, uninstall automation, or business
module. Full browser/database verification depends on a configured database and
representative operational fixtures.
