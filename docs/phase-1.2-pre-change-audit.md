# Phase 1.2 pre-change audit

**Decision:** GO, with a compatibility-first integration. The working Phase 1 location
context stays application-owned; the extension consumes it through a contract. No
working route, controller, middleware, gate, view, or session behavior is moved.

## Current architecture and relevant files

The repository is a Laravel 12 application on PHP 8.3. TastyIgniter core and all
official extensions are Composer-owned under `vendor/tastyigniter`; the local
`extensions/` tree currently contains no custom extension. Composer discovers the
official Local, User, Cart, Reservation, Pay Register, Frontend and other packages.
The root application owns `app/`, `routes/web.php`, `resources/views`, and the root
PHPUnit suite.

Commit `76fec2b7` (the repository equivalent of the supplied `d315e96f`) added the
Phase 1 implementation: `LocationContextController`, `ResolveLocationContext`,
`LocationContext`, changes to both application service providers and the HTTP
kernel, the three configurable-admin-prefix routes, selector view, audit document,
and focused unit/feature tests. It is entirely application-owned and directly tied
to `App\\`; it uses public models/auth/permission APIs, but `admin.auth` and the
official model relationship remain upstream compatibility seams.

The existing behavior comprises session keys `active_location_id` and
`active_location_global`, authorization gates, structured 403 responses, logging,
single-location auto-selection, global mode, and these route names:
`admin.location-context.select`, `.switch`, and `.global`. The routes use
`Igniter::adminUri()` rather than `/admin` and only the route group receives the
location middleware. No official model is globally scoped.

## TastyIgniter 4.x extension conventions

`ExtensionManager` discovers two-level folders containing `extension.json` or
`composer.json`, reads `namespace`/`code`, registers `src/` with the Composer loader,
and resolves `<namespace>Extension`. An extension extends `BaseExtension`, whose
booting callback registers `resources`, translations, migrations, controllers,
views and one conventional route file. Disabled extensions do not boot or enter
the enabled extension set; their migrations remain discoverable for lifecycle
management. `register()` provides container bindings and `boot()` listeners/hooks.

Public registration hooks include `registerPermissions()` and
`registerNavigation()`. Admin navigation consumes the latter; the User extension's
permission manager consumes the former. Routes may use the conventional route file
or the public `igniter.admin.registerRoutes` event; admin URLs must use
`Igniter::adminUri()`/`admin_url()`. Views use the extension code namespace and
translations use `resources/lang`. Migrations belong in `database/migrations`, are
tracked per extension by core, and must provide reversible `up`/`down` behavior.
Official extensions conventionally keep controllers in `src/Http/Controllers`,
models in `src/Models`, model hooks/listeners in `boot()`, and isolated package
tests. Root application tests use `Tests\\TestCase`.

## Integration inventory

The future adapter seams are public official classes/services for staff
(`Igniter\\User\\Models\\User`), locations (`Igniter\\Local\\Models\\Location`),
orders/menus (`Igniter\\Cart`), reservations/tables (`Igniter\\Reservation`),
payments (`Igniter\\PayRegister`), `admin.auth`, `PermissionManager`, the Log
contract, and `Igniter::adminUri()`. The foundation will only verify/resolver these
seams; it will not duplicate or implement their domains.

Composer patches is required solely to apply the existing strict-MySQL timestamp
patch to `tastyigniter/core`. Phase 1.2 needs no package. The lock mismatch is a
pre-existing repository issue and broad dependency resolution would risk unrelated
Laravel/core upgrades, so neither manifest nor lock will be changed.

## Upgrade-risk matrix

| Risk | Likelihood / impact | Mitigation |
|---|---|---|
| Moving working location code | Medium / high regression and stale cache references | Retain `App\\` classes; contract binding only |
| Duplicate route names | High / high route-cache failure | Do not re-register Phase 1 routes in the extension |
| Permission collision | Medium / medium | One canonical definition from the extension; exact existing keys |
| Official class/API rename | Medium / high after upstream update | Named adapters and compatibility smoke tests |
| Table collision/data loss | Low / critical | No Phase 1.2 tables or migrations; reserve `naxas_restaurant_ops_` prefix |
| Namespace/autoload collision | Low / high | `Naxas\\RestaurantOps\\`, extension-owned dynamic PSR-4 discovery |
| Disabled extension affects storefront | Low / critical | No global middleware, scopes, storefront listeners, or business routes |
| Uninstall deletes operations | Low / critical | No destructive hook or tables; require backup before future removal |
| Official/template update conflict | Low / high | Never modify/copy Composer-owned sources |
| Admin URI changes | Medium / medium | Adapter delegates to public Igniter facade |

## ADR: one modular foundation extension

**Choice: Option A for Phase 1** — `Naxas.RestaurantOps` at
`extensions/naxas/restaurantops`, organized into small contracts, integrations,
support, resources, tests, and docs. A single extension minimizes enable/install
ordering and deployment failure while establishing explicit internal boundaries.
It also keeps one permission and migration owner. If independently distributable
inventory or accounting domains later require distinct release cadence/data
ownership, an ADR may extract them into dependent extensions. This is preferable
to prematurely creating a dependency graph of empty packages.

## Proposed structure and migration strategy

The extension will contain metadata and `Extension.php`; minimal route, view and
language resources; a location context contract; narrowly scoped official-domain
adapters; tests; and lifecycle/upgrade documentation. There is no navigation link
until a real extension-owned destination exists. The stable navigation hook is
documented for later use.

No migration or metadata table is justified. Future migrations will be timestamped,
additive, reversible, owned only here, ordered foundation-before-module, and use
`naxas_restaurant_ops_` table names. Disable never runs rollback. Uninstall must be
an explicit, backed-up operator action and must not silently delete operational
data.

## Backward compatibility, rollback, and no-regression checklist

The extension binds its `LocationContextContract` to the unchanged scoped
`App\\Services\\LocationContext`; there are no namespace aliases or serialized
reference changes. Existing application routes, controller, middleware alias,
gates, view, session keys and service binding remain. Permission definitions move
to the standard extension hook only after tests establish identical keys.

Rollback is: disable the extension, restore the prior commit, clear application,
route and extension caches, and run the Phase 1 tests. There is no schema rollback.

- [ ] Existing location unit and feature tests pass.
- [ ] Exactly one copy of every location route and permission exists.
- [ ] Route caching succeeds with configurable admin URI.
- [ ] Storefront/order/delivery/collection/reservation routes remain unwrapped.
- [ ] Superuser behavior and official staff-location relationship remain intact.
- [ ] Extension enable/disable changes no data.
- [ ] No `vendor/`, core, or official extension file is changed.
- [ ] No business feature or duplicate domain/table is introduced.

Known baseline constraints are the missing `APP_KEY` Example feature failure and
two strict-timestamp patch fixture mismatches previously reported. They are not
grounds to alter unrelated production code.
