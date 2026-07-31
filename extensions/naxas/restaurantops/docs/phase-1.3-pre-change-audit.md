# Phase 1.3 pre-change audit: operational roles and permissions

**Audit date:** 2026-07-31
**Decision:** **GO under the corrected architecture approved after audit**

This document records the mandatory pre-change audit. No Phase 1.3 production code was changed before or as part of this audit. The blocking issue is not a missing hook: the requested role model conflicts with the installed TastyIgniter public data model.

## Executive finding

The installed TastyIgniter version has two distinct concepts:

* `Igniter\User\Models\UserRole` is the authorization role. A staff user has one `user_role_id`; the role owns the serialized permission map and has a stable, unique `code` field.
* `Igniter\User\Models\UserGroup` is an assignment/work-distribution group. A staff user may belong to many groups through `admin_users_groups`; groups have auto-assignment settings and **do not own permissions or a stable code**.

Consequently, the requirements to (a) use existing staff groups as operational roles, (b) store permissions in those groups, (c) expose permissions in a staff-group permission UI, and (d) avoid a duplicate permission system cannot all be met. Implementing them literally would require changing official source/schema or adding parallel group-permission storage, both expressly prohibited. TastyIgniter's existing permission editor is attached to **User Roles**, not User Groups.

The upgrade-safe resolution is to treat existing **User Roles** as the five operational role profiles, while leaving User Groups untouched for assignment workflows. This requires explicit approval of the corrected terminology/architecture before implementation.

## Audit findings

### 1. Authentication, staff, status, and redirect flow

1. The admin guard is the `admin.auth` service and `Igniter\User\Facades\AdminAuth`; it is a session guard backed by `Igniter\User\Models\User`.
2. The current staff/admin model is `Igniter\User\Models\User` on `admin_users`. The older `Igniter\Admin\Models\Staff`/`staffs` relationship is deprecated and slated for removal before v5.
3. The current model combines staff identity and admin authentication. It eagerly loads `role`, `groups`, and `locations` during authentication.
4. `status` is the account-enabled switch. The authentication provider adds `whereIsEnabled()`, so a disabled account is excluded from login/user resolution. `is_activated` is a separate activation field.
5. Login dispatches `igniter.admin.beforeAuthenticate`, attempts `AdminAuth`, regenerates the session, and uses an explicit submitted redirect or `AdminHelper::redirectIntended('dashboard')`. This preserves intended URLs.
6. The dashboard is the normal `dashboard` admin controller and requires `Admin.Dashboard`. No supported post-login operational redirect hook was found in the audited public flow. Replacing the login controller or redirect is not upgrade-safe.
7. Admin controllers already apply the configured admin middleware and `Igniter::adminUri()` through the admin route registrar. Application location routes also use `Igniter::adminUri()` and never hardcode `/admin`.
8. Customer authentication is separate from the admin guard. No reason exists to touch customer login.

### 2. Role/group and permission model

1. A user belongs to one `UserRole` via `user_role_id`. `UserRole` has `name`, stable `code`, `description`, and serialized `permissions`.
2. A user belongs to many `UserGroup` records via `admin_users_groups`. `UserGroup` provides assignment allocation settings and has no permission field or stable code.
3. The staff form already contains separate controls for locations, groups, role, superuser, active status, and order/reservation assignment scope.
4. The permission editor is on the `user_roles` create/edit form. The `user_groups` create/edit form contains allocation settings, not permissions.
5. Extensions register permission definitions through `BaseExtension::registerPermissions()`. `PermissionManager` collects these definitions from enabled extensions, adds their owner, sorts them, and groups them for the role permission editor.
6. Effective permissions come only from the user's single role. Group membership is not consulted.
7. `User::hasPermission()` immediately returns `true` for a superuser. Otherwise it evaluates the role permission map through `PermissionManager`.
8. TastyIgniter supports prefix/suffix wildcard matching, but Phase 1.3 should register and assign explicit codes as requested.
9. Permission definitions are runtime registrations, not rows in a permissions table. Permission grants stored in a role take effect when the authenticated model/relation is refreshed or on the next independently resolved request. There is no separate persistent permission-definition cache to migrate.
10. The existing extension registers exactly the four required `Restaurant.LocationContext.*` codes. Repository search found no competing official `Restaurant.*` permission catalog, so no current code collision was detected.
11. A submitted role permission array is validated only as an array of integer values; the model constrains values to `-1`, `0`, or `1`. The request does not independently restrict submitted keys to the registered catalog. Operational role management therefore must remain limited to superusers or administrators with the official role-management permission unless a safe extension-owned validator is added.

### 3. Staff-location assignment and pivot options

1. Current staff uses the official `Locationable` morph-to-many `locations` relationship and the shared `locationables` pivot.
2. The pivot has `location_id`, `locationable_id`, `locationable_type`, and a text `options` column. It has no primary key or unique constraint in its original migration.
3. The existing staff form already presents the location relation. The official request checks that submitted location entries are integers, but does not itself apply `exists`, active-location, or administrator-scope constraints.
4. The model's `addLocations()` uses `sync()`, and registration uses `attach()` when the locations key exists. Any extension must distinguish an intentionally submitted location section from an absent section to avoid replacing assignments.
5. Existing pivot `options` are potentially relation-specific and must be preserved. Storing one staff-wide default location redundantly on one or many assignment pivots creates ambiguous update/removal semantics and risks `sync()` overwriting options. The audit does **not** consider pivot options a safe canonical default-location store without an upstream accessor/contract.
6. There is no true default-location field on the current `User` model or staff form.
7. If Phase 1.3 proceeds, one small extension-owned staff-preferences table is justified for `staff_id -> default_location_id`. It must not duplicate assignments and the referenced default must be revalidated against active official assignments on every use. No migration was added during this NO-GO audit.
8. Location status is `location_status`. The current `LocationContext` permits inactive locations only to users with `Admin.Locations`; operational selection should instead filter to active locations even for ordinary operational administrators.

### 4. Existing Location Context foundation

1. `App\Services\LocationContext` remains application-owned and is exposed as the scoped `Naxas\RestaurantOps\Contracts\LocationContextContract` binding.
2. It stores a concrete location in `active_location_id` and global mode in `active_location_global`.
3. Non-superusers receive locations from the official staff-location relation; superusers receive all locations.
4. `current()` rechecks membership and status on each request and clears stale context. Removing an assignment therefore invalidates the stored active location the next time context is resolved.
5. Global mode is revalidated against `Restaurant.LocationContext.ViewAll` and is cleared when permission is lost.
6. The four gates exist unchanged: `access-location`, `switch-location`, `view-all-locations`, and `manage-location-operations`.
7. The selector middleware requires admin authentication, validates submitted location IDs through the context, auto-selects exactly one authorized location, permits valid global/current context, otherwise redirects to the selector, and returns structured JSON errors.
8. `scopeQuery()` deliberately leaves a query unscoped in global mode. Future transactional services must never call it in global mode without a separate concrete-location guard.
9. A scoped service is mutable through `forUser()`. Reusing the same scoped instance for multiple explicit users during a request can leak the last assigned user into later checks. Operational authorization should avoid cross-user reuse or restore/bind the intended user explicitly.

### 5. Forms, navigation, routes, lifecycle, and audit logging

1. The official user controller exposes `formExtendFields`, demonstrating a controller-level field extension seam, and TastyIgniter has system form extension events. Stability must be covered by a compatibility test before relying on an event signature.
2. Non-superusers cannot edit another staff user's role, status, or superuser switch through the official controller. Superusers retain existing access.
3. Extension navigation is registered through `Extension::registerNavigation()` and filtered by the current admin user's `hasPermission()`. The RestaurantOps extension currently registers no navigation because it owns no destination yet.
4. Navigation is visibility only. Admin controllers/routes must still perform matching server-side permission and location authorization.
5. Application routes are route-cache-compatible closures only at group configuration level; extension routes are currently intentionally empty. New extension routes should use controller class actions and admin route conventions.
6. The extension lifecycle currently only binds the context contract and audit adapter and registers four permissions. It has no migration, install, uninstall, or destructive hook.
7. `ActivityLogAdapter` currently delegates to Laravel's logger. No installed, stable domain activity-log API was exposed by the extension adapter. It is sufficient as the existing audit abstraction, but it is log-based rather than a queryable audit ledger.
8. The extension's current `StaffAdapter` points at the official `Igniter\User\Models\User`, which is the correct current model.

### 6. Existing tests and environment

1. Existing focused coverage includes unit tests for context authorization/session behavior, feature tests for selector authentication/routes, and extension compatibility tests for discovery, contract binding, official adapters, admin URI, no schema, and the four exact permissions.
2. The current compatibility test intentionally asserts empty navigation and no migration; those assertions would need a reviewed update only after the architecture is approved.
3. There are no existing repository tests for operational roles, landing pages, role sync, default locations, or operational middleware.
4. The configured runtime database is MySQL at `127.0.0.1:3306`; it was unavailable (`connection refused`). Existing roles/groups and migration status therefore could not be enumerated.
5. The runtime reports PHP `8.4.22-dev`, despite the requested project target of PHP 8.3.
6. Previously reported baseline issues remain relevant: missing `APP_KEY` in the example feature test, two strict timestamp fixture mismatches, and the Composer lock mismatch involving `cweagans/composer-patches`. None is related to the audit and none was changed.

## Existing flows

### Existing role/group model

| Concept | Model/storage | Cardinality | Purpose |
|---|---|---:|---|
| Staff authentication | `Igniter\User\Models\User` / `admin_users` | one record | Admin identity, status, activation, superuser |
| Authorization role | `UserRole` / `admin_user_roles` | one per staff | Stable code and permission map |
| Assignment group | `UserGroup` / `admin_user_groups` | many per staff | Work allocation, not authorization |
| Group membership | `admin_users_groups` | many-to-many | Assignment-group membership |
| Branch assignment | `locationables` | many-to-many polymorphic | Authorized staff locations |

### Existing permission flow

`Extension::registerPermissions()` -> `PermissionManager::listPermissions()` -> role permission-editor UI -> serialized `UserRole.permissions` -> `User::getPermissions()` -> `User::hasPermission()` -> superuser bypass or explicit permission evaluation -> controller/navigation/Gate decision.

### Existing location assignment flow

Staff form relation -> official `User.locations` morph-to-many -> `locationables` -> authenticated user eager-load -> `LocationContext::authorizedLocations()` -> current/global session validation -> gate/middleware/query scope.

### Existing authentication and redirect flow

Admin login -> `igniter.admin.beforeAuthenticate` -> enabled-user provider -> session regeneration -> explicit redirect, otherwise intended dashboard -> standard dashboard permission check. The extension must not replace this flow. A later landing integration should be opt-in after dashboard resolution or through a documented event that preserves the intended URL.

## Risk matrix

| Risk | Likelihood | Impact | Required mitigation |
|---|---:|---:|---|
| Treating assignment groups as permission roles | Certain | Critical | Stop; use `UserRole` or obtain an upstream group-permission feature |
| Parallel group-permission storage | High | Critical | Prohibited; do not implement |
| Custom role overwritten by sync | Medium | High | Match exact stable role code; create only missing roles; additive grants only by explicit option |
| Unregistered permission key injection | Medium | High | Validate keys against the registered extension catalog; restrict management authority |
| Unauthorized/inactive location submission | High | Critical | Server-side `exists`, active-state, and delegator-scope validation |
| Default location grants access | Medium | Critical | Preference only; revalidate against current active assignments every request |
| Pivot options lost by relation sync | Medium | High | Do not use pivot options as canonical preference; preserve existing pivot data |
| Stale active location after removal | Low | High | Current context revalidation/clear; retain compatibility tests |
| Revoked role permissions remain in loaded relation | Medium | High | Resolve/refresh authenticated user each request and clear framework caches using official behavior |
| Global context reaches transaction service | High in future | Critical | Dedicated transactional-location middleware/service assertion |
| Resource ID leaks another branch | High in future | Critical | Scope lookup by active location; return non-disclosing 403/404 policy consistently |
| Operational redirect overrides intended URL | Medium | High | Never redirect when an intended/explicit destination exists |
| Landing redirect loop | Medium | Medium | Exclude landing/selector routes and redirect at most once |
| Disabled user continues an existing session | Medium | High | Revalidate active status in operational middleware, not only at login |
| Inactive branch selected by privileged admin | Medium | High | Operational selection only accepts active branches |
| Mutable scoped context used for another user | Low | High | Avoid shared `forUser()` mutation across authorization subjects |
| Permission-code collision with future official extension | Low | High | Compatibility test unique registered codes; namespace ownership documentation |
| Similar custom display name mistaken for standard role | Medium | High | Bootstrap names only for reporting; stable exact role code controls identity |

## Proposed corrected architecture (requires approval)

### Role architecture

Use official `UserRole` records—not assignment `UserGroup` records—with stable codes such as `restaurant_ops_owner`, `restaurant_ops_branch_manager`, `restaurant_ops_cashier`, `restaurant_ops_waiter`, and `restaurant_ops_kitchen`. Existing assignment groups remain unchanged. Profile resolution uses exact role code; display-name matching is preview-only bootstrap assistance and never silently claims a custom role.

### Permission catalog and matrix

Register the requested explicit catalog once from a machine-readable extension class, with translatable labels and logical groups: Foundation, Locations, POS, Dine-in, Waiter, Kitchen, Shifts, and Reports. Preserve the four Location Context codes byte-for-byte. The machine-readable role profiles should contain explicit permission-code arrays (no wildcards).

The human-readable defaults remain:

| Profile | Default scope |
|---|---|
| Owner / Head Office | All catalog permissions; global reporting; concrete branch required for transactions |
| Branch Manager | Branch dashboard/audit, assigned-location switching, supervisory POS/dine-in/waiter/kitchen/shift rights, branch reports; no ViewAll/consolidated report |
| Cashier | POS create/edit/hold/recall, discount apply, void request, settle/reprint, own shift lifecycle; no approval/refund/consolidated rights |
| Waiter | Dine-in open/bill request and waiter order/send/request rights; no settlement or approvals |
| Kitchen Staff | Kitchen accept/prepare/ready/complete only; no financial, administration, discount, void, refund, or shift approval rights |

Profile defaults seed a role only at controlled creation. Authorization always uses effective permissions, never the profile label.

### Non-destructive synchronization

`restaurant-ops:sync-roles` should default to report-only behavior; `--dry-run` must never write. `--create-missing` may create only roles with absent exact stable codes. Similar names or occupied/conflicting codes must be reported and skipped. `--add-missing-permissions` may add extension-owned grants without removing any key, only when explicitly requested. It must log counts/identifiers but no sensitive data. Re-running must be a no-op.

### Location assignment and default strategy

Keep official staff `locations`. Extend the official staff form through a proven event hook only for an optional default selector and read-only operational summary; do not duplicate role, location, or status controls. Validate assignment IDs as existing, active locations and, for non-superuser delegators, within locations the delegator may manage. Do not sync the relation if its section was absent.

Use one additive `naxas_restaurant_ops_staff_preferences` table only if approved. It contains a unique staff identifier and nullable default location identifier. It is a preference, never an authorization grant. A single active assignment auto-selects; multiple assignments use a currently assigned, active default; otherwise the existing selector remains authoritative. Removed/inactive defaults are ignored and may be cleared during an audited edit.

### Navigation and landing strategy

Register navigation only for implemented extension-owned placeholder controllers. Each item carries the same permission enforced by its controller. Use configurable admin routes and show “scheduled for a later phase,” identity/profile, active/assigned branches, and high-level permission flags only—never fake operational data.

Do not alter the official login controller. Preserve explicit/intended redirects and the standard dashboard for users without an exact operational role code. Before implementing automatic post-login landing, identify and test a stable event seam; otherwise provide an Operations Overview navigation destination rather than a forced redirect.

### Authorization strategy

An extension-owned access service should compose, not replace, `AdminAuth`, `User::hasPermission()`, the Location Context contract, and Laravel authorization. Route middleware should check active admin user, explicit permission, valid active context, assigned active location, and—on transactional placeholders—a concrete non-global location. Resource authorization must compare the resource location with the active location inside the query/policy. JSON denials use stable structured error codes; web denials use the existing authentication redirect or non-disclosing 403.

### Audit strategy

Continue using `AuditLogger` as the extension seam. Log role-sync previews/writes/conflicts, rejected management/assignment attempts, audited preference/profile changes, and useful landing decisions using staff/role/location identifiers only. Do not log credentials, tokens, sessions, payment data, or unnecessary personal fields.

## Privilege-escalation conclusions

* TastyIgniter does not expose permission delegation boundaries between ordinary roles. Operational role creation/sync, role assignment, and location assignment should therefore be limited to superusers or an explicit, narrowly defined management permission plus delegator-location checks.
* A role profile can never grant permission implicitly. A cashier/waiter/kitchen landing must check effective permission every request.
* Group IDs cannot be used as authorization identities because groups are many-to-many allocator groups and lack stable codes.
* Submitted morph type/ID must never be accepted from the client; operate through the loaded official staff relation only.
* Global mode must be rejected before transaction service entry even for Owner and superuser.

## No-regression checklist

- [ ] Preserve admin guard, login, intended redirect, dashboard, and superuser bypass.
- [ ] Preserve customer authentication and all storefront routes.
- [ ] Preserve official user roles, groups, staff-location relation, and custom pivot options.
- [ ] Preserve the four exact Location Context permissions and gates.
- [ ] Do not add global middleware or hardcode the admin URI/location IDs.
- [ ] Do not touch `vendor/`, core, or official extension source.
- [ ] Do not overwrite/deactivate existing staff, roles, groups, permissions, or assignments.
- [ ] Validate both permission and active assigned location on direct requests.
- [ ] Reject global mode for every transactional entry point.
- [ ] Preserve intended URLs and prove no redirect loop.
- [ ] Route-cache all class-action routes.
- [ ] Verify extension disable leaves application/customer/storefront behavior safe.
- [ ] Run focused, existing context, compatibility, route, formatting, Composer, and diff checks.

## GO / NO-GO decision

The initial decision was **NO-GO** because “staff groups as roles with group permissions” does not exist in this TastyIgniter version. The project owner subsequently approved the corrected architecture below, changing the implementation decision to **GO** without weakening the audit finding.

Implementation can move to **GO** after the project owner approves this precise correction:

> Use TastyIgniter `UserRole` (one per staff, stable `code`, owns permissions) for the five operational authorization profiles; preserve `UserGroup` exclusively for its existing assignment/allocation purpose.

The Phase 1.3 implementation follows this approved correction. This audit remains the record of why no group-based permission storage was introduced.
