# Phase 1: location-context pre-change audit

Audit completed on 30 July 2026, before implementation. Package files named below are
Composer-managed and are reference points only; they must not be edited.

## Authentication and authorization

- Admin authentication is supplied by `tastyigniter/ti-ext-user`. Its `igniter-admin`
  session guard resolves `Igniter\User\Models\User` from `admin_users`; customer web
  authentication is a separate `igniter-customer` guard. Admin login/logout routes are
  `igniter.admin`, `igniter.admin.login`, `igniter.admin.reset`, and
  `igniter.admin.logout` below the configurable admin URI (normally `/admin`).
- The admin user eagerly loads `role`, `groups`, and `locations`. Permissions are the
  role's JSON permission map and `super_user` bypasses permission checks. Groups are
  organizational; the role is authoritative for permissions.
- Staff/location assignment already exists through the polymorphic `locationables`
  table and the user's `locations` morph-to-many relation. The deprecated `staffs`
  model/table is legacy compatibility and must not become a second assignment system.
- The existing Local extension adds `getAvailableLocations()` and
  `isAssignedLocation()` to admin users. Superusers currently see every location.
  Location-aware models expose `whereHasLocation`/`whereHasOrDoesntHaveLocation`.
- Existing permissions include extension-specific `Admin.*` permissions. Phase 1
  should add four narrowly named permissions without changing existing role records;
  superusers retain access through their existing bypass.

## Location and persistence

- `Igniter\Local\Models\Location` uses `locations.location_id`, `location_name`,
  address/city fields, `location_status`, default marker, and permalink. Location
  settings, areas and working hours are related tables.
- `locationables` is the shared polymorphic pivot used by staff, menus/categories and
  other assignable models. No new staff-location migration is justified.
- The existing Local singleton resolves the storefront location from a route slug or
  its own `location` session namespace, and the admin location from the
  `admin_location` namespace. `CheckLocation` verifies that an admin's selected Local
  location is assigned, but silently drops an unauthorized current location; it does
  not provide a mandatory per-session operational context or structured API errors.
- Session configuration uses Laravel's configured driver/cookie and encrypted cookies;
  cache is independently configured. Location identity must therefore be re-read from
  assignments on every protected request rather than cached as authorization state.

## Operational location usage

- Cart/order creation obtains the storefront location from the Local service and
  writes `orders.location_id`; stocks are location-keyed and menus/categories use
  locationables. Delivery and collection remain coupled to that storefront context.
- Reservations contain `location_id`; dining areas and sections contain location IDs,
  while tables resolve their location through dining areas. Booking availability is
  filtered by location.
- Payment records are associated with orders; payment driver fields named “location”
  (for example Square credentials) are provider identifiers and must not be scoped as
  restaurant IDs.
- API repositories already constrain many resources to enabled locations assigned to
  the token user, but request validators that accept `location_id` generally validate
  type rather than assignment. Broadcast order channels include the order location ID.
- Reports/admin lists rely on Local's current-or-assigned behavior and individual
  location-aware models/widgets. This is not a universal write-side IDOR boundary.

## Routes, controllers, UI, middleware and hooks

- Core admin routes/controllers and dashboard/navigation are Composer package code.
  The Local extension provides `Locations`, `LocationAwareController`,
  `CheckLocation`, `LocationPicker`, selector views and model extension hooks.
- Cart, Reservation, API, User, Local, Pay Register, Frontend and Broadcast-related
  code is installed under `vendor/tastyigniter/*` from Composer. Application-owned
  safe extension points are `app/`, `routes/`, `resources/`, `tests/`, and additive
  application migrations/providers. Package events, dynamic model extension hooks,
  Laravel gates, middleware aliases and view composers are available without package
  edits.
- Admin navigation is built from extension registrations. An application route can be
  added under the existing configurable admin URI without renaming package routes.
  A small selector/indicator can be application-owned; injecting into the package
  header without a stable documented hook is intentionally deferred to avoid a theme
  regression.

## Existing test architecture

- Root PHPUnit 12 tests use Laravel's `Tests\TestCase`; only example and strict-MySQL
  patch coverage currently lives in the application. Composer extensions ship broad
  package suites and factories under `vendor`.
- Foundation tests should unit-test the context with mocked admin users/locations and
  feature-test middleware/controller response contracts. Existing package cart,
  reservation, user login and location tests are the regression suites for unchanged
  flows.

## Data-leak risks

1. A stale/tampered session can name a formerly assigned or unrelated location.
2. Integer-only `location_id` validation permits write-side IDOR unless each endpoint
   additionally authorizes assignment.
3. “All assigned” list scopes do not guarantee that a retrieved route model belongs
   to the active branch.
4. Superuser/global behavior can accidentally leak into transaction creation if
   global mode is treated as an operational location.
5. Inactive assigned branches may remain selectable unless explicitly rejected.
6. Admin browser, customer storefront and token/API guards have different principals;
   mixing their sessions could disrupt online orders.
7. Long-lived workers/singletons must not retain one request's resolved model.

## Architecture decision

Add an application-owned, request-safe `LocationContext` service using the existing
admin user's `locations` relation. Store only `active_location_id` and an explicit
global marker in the authenticated web session, and revalidate on every call. Global
mode requires `Restaurant.LocationContext.ViewAll`; it has no current ID and
`requireCurrent()` rejects it, preventing use as a transaction location.

Add admin-auth-aware middleware and selector/switch endpoints. The middleware returns
stable JSON error objects for JSON/API callers, auto-selects one enabled authorized
location, redirects multi-location users with no context, clears stale context, and
denies a submitted unauthorized `location_id`. Register reusable gates and permissions
through application service providers. Log security-relevant transitions using IDs,
never secrets. Provide `scopeQuery()` as the shared read boundary and require later
operational modules to call `canAccess()` for submitted IDs and `requireCurrent()` for
writes.

No schema change is required: the existing assignment pivot is sufficient.

## No-regression checklist

- [ ] Do not modify `vendor/` or package source.
- [ ] Do not attach context middleware globally to storefront routes.
- [ ] Preserve existing login/logout and all URLs.
- [ ] Preserve Local's customer `location` and admin `admin_location` sessions.
- [ ] Existing users/superusers retain access; new permissions are opt-in for roles.
- [ ] Auto-selection and switches only use current enabled assignments.
- [ ] Explicit unauthorized/tampered IDs produce 403 and are cleared.
- [ ] Global mode is permission-gated and cannot supply a transaction location.
- [ ] JSON errors have a consistent `error.code` and message.
- [ ] Cart/order, delivery/collection, reservation and payment package code is untouched.
- [ ] Focused tests, relevant regressions, Composer validation and formatting pass.
