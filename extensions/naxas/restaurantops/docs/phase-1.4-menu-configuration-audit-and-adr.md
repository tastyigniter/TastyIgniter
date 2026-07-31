# Phase 1.4 menu configuration audit and ADR

**Audit date:** 2026-07-31  
**Boundary:** This document was completed before production implementation. The audited sources were read-only Composer packages; no `vendor/`, TastyIgniter core, or official extension file is changed.

## Decision

**GO**, with a compatibility-first, additive foundation. RestaurantOps will use **option B**: extension-owned modifier-group and modifier metadata referencing `Igniter\Cart` option and option-value records. Official Menu, Category, MenuOption, MenuOptionValue, MenuItemOption, Cart, Order, Location, Mealtime, and MenuSpecial remain authoritative. Enhanced behavior is opt-in; absence of metadata returns the unchanged official path.

## Existing domain and option architecture

| Area | Audited behavior | Extension implication |
|---|---|---|
| Menu/category | `menus` is the sellable record; `menu_categories` is the many-to-many category pivot. Menu also has mealtime, ingredient, media, location, special, and item-option relations. | Reference `menu_id`; never copy menu/category data. |
| Options | `menu_options` defines a reusable group and `display_type` (`radio`, `checkbox`, `select`, `quantity`). `menu_option_values` defines reusable values/prices. | Metadata references `option_id` and `option_value_id`. |
| Item options | `menu_item_options` attaches an option to a menu with required, min/max, priority and free quantity. `menu_item_option_values` enables values and supports default, override price, priority and free quantity. Linked values provide an upstream conditional-display seam. | Preserve official attachments. RestaurantOps attachments add variant applicability and override precedence only. |
| Selection rules | Upstream validates min <= max; radio/select cap both at one. It supports quantity display, defaults and free quantities. Storefront request validation rejects invalid option/value combinations. | Add stricter server resolver checks for activity, visibility, quantity, attachment, location, service and stale hash. |
| Price | Menu exposes base price and active special price; attached value override falls back to reusable value price. Cart item subtotal adds option-value subtotal and conditions/taxes/totals are applied by official cart/order services. Several official models cast money to float. | Preserve legacy calculation exactly. Enhanced resolver converts decimal strings to integer minor units, then formats decimals; it never accepts client prices. |
| Availability | Menu status, location morph assignments, order-type scope, mealtimes, ingredient/stock state, and `admin.menu.isAvailable` participate. Options are locationable; stockable menu/value records expose stock. | Availability resolver composes rather than replaces official `isAvailable` and adds deterministic overrides. A concrete location is mandatory for transactional enhanced resolution. |
| Media/i18n/tax | Menu uses the official media attachment (`thumb`); model language fields are managed by TastyIgniter translation infrastructure. Menu tax class and checkout tax conditions stay upstream. | No duplicate media, translation, or tax storage. Variant tax override is deferred because no sufficiently safe line-level seam was found. |
| Admin | Official Cart Menus/MenuOptions controllers use model form definitions and extension events. Broad template replacement is fragile. | Use a linked RestaurantOps configuration page and class-action endpoints, not copied official templates. |
| API | Official API transformers expose menu options and values with existing response shapes. | No existing response changes. Enhanced contract is extension-owned/versioned. |

## Pricing, cart, checkout, and order flow

1. Storefront resolves location/order type and lists enabled menus through `Menu::listFrontEnd`; menu `isAvailable` applies schedules and stock-related rules.
2. `CartManager::addCartItem` loads the official menu, validates official submitted options, creates server-derived option objects, and adds the official Buyable. `CartItem` identity is `md5(id + serialized options)`; names, IDs, value quantity and server prices are serialized. Different official options therefore produce different rows, while notes are not part of identity.
3. `CartItem::subtotalWithoutConditions` calculates quantity times menu price plus option totals. Official cart conditions calculate tax/fees/discount totals. Checkout validates through `OrderRequest`, then `OrderManager` dispatches `igniter.checkout.beforeSaveOrder`, saves order/menu/options in a transaction-oriented service flow, and dispatches `igniter.checkout.afterSaveOrder`.
4. Historical `order_menus` stores item name, quantity, price, subtotal, comment and serialized option values; `order_menu_options` stores option/value IDs, captured option name/price, quantity and free quantity. This is a partial snapshot, but category/group name access can still dereference current menu-option data and it cannot represent variants/combos/versioned breakdowns.

## Hooks and events audit

- TastyIgniter's extendable models support runtime `Model::extend`, dynamic relations, model events and observers; extension registration and controller/form extension listeners are stable public seams, but private templates and methods are not.
- Menu create/update and option attachment primarily use normal model lifecycle events/observers; there is no dedicated durable “option attached” domain event. `admin.menu.isAvailable` is an explicit availability event.
- Cart construction has no dedicated public “cart item created” event. The safest Phase 1.4 integration is an explicit RestaurantOps adapter invoked by extension endpoints, leaving legacy official endpoints untouched.
- Order provides `igniter.checkout.beforeSaveOrder` and `igniter.checkout.afterSaveOrder`. Snapshot integration uses the after-save seam and idempotent unique order-item storage; enhanced callers may persist atomically in their surrounding transaction. A future upstream hook improvement is recommended for an explicit post-order-item/pre-commit event.
- Checkout form supports `checkout.form.extendFieldsBefore` and `checkout.form.extendFields`; official controllers support extension listeners. No direct official source edit is needed.

## Database and test baseline audit

Official tables include `menus`, `categories`, `menu_categories`, `menu_options`, `menu_option_values`, `menu_item_options`, `menu_item_option_values`, `menu_item_option_linked_values`, `menu_specials`, `menu_mealtimes`, `locationables`, `orders`, `order_menus`, `order_menu_options`, and `order_totals`. Official migrations already index primary/foreign lookup columns inconsistently across historical versions, so extension lookup paths need explicit composite indexes and unique constraints.

Existing application tests cover RestaurantOps discovery, route/middleware wiring, Location Context, exact role profiles, permissions and adapters. Official package suites cover menus, option models, cart identity/totals, checkout, collection/delivery, API transformers and orders, but are not all wired into the application PHPUnit suite. Runtime is configured for MySQL; actual database availability must be reported rather than inferred. Composer lock validation and any pre-existing suite failures are baseline concerns and must not be hidden.

## Gap analysis and risks

| Gap/risk | Severity | Mitigation |
|---|---:|---|
| No variants, combos, kitchen names/stations | High | Extension records reference official menus/options and archive used configuration. |
| Partial historical snapshots | High | Versioned immutable extension snapshot keyed uniquely to `order_menu_id`; legacy renderer fallback. |
| Admin/storefront/POS price divergence | Critical | One server-side resolver and canonical minor-unit breakdown/hash; legacy bypass when no enhanced config. |
| Client price/modifier tampering | Critical | Ignore client prices; verify every ID, attachment, active/visible state and quantity server-side. |
| Branch data leakage/global-mode transaction | Critical | Resolve concrete official location through Location Context and reject unauthorized/global transaction context. |
| Stale open carts/concurrent edits | High | Deterministic configuration hash, optimistic version, unique constraints and stale conflict response. |
| Official model/table drift in TastyIgniter 4.x | High | Adapters/contracts and behavior-focused seam tests; no official schema mutation. |
| Duplicate domains | High | References only; official IDs and cart/order records remain canonical. |
| Extension disabled | Medium | Optional tables/relations only; official flows contain no hard dependency. Data is retained on disable. |
| Float use upstream | Medium | Enhanced computation uses minor units; conversion boundary is explicit. Upstream legacy arithmetic remains unchanged for compatibility. |
| Snapshot event atomicity | Medium | Idempotent listener participates in the caller transaction when present; enhanced checkout adapter exposes explicit snapshot write. Document upstream event limitation. |
| Location deletion | Medium | Restrict/soft-reference configuration while snapshots retain scalar location identity. |

## Final additive schema

The smallest practical normalized foundation uses: variants; option-backed modifier group metadata; option-value-backed modifier metadata; menu/variant group attachments; typed availability/price overrides; safe conditional rules; combo, combo group and combo choice records; and order-item snapshots. All tables use the `naxas_restaurant_ops_` prefix, timestamps, archive/status fields where operational records can be used historically, decimal money columns, foreign keys to extension records where safe, and indexed official scalar references. Official records are not migrated or rewritten.

Resolution precedence is **variant attachment override → menu attachment override → modifier-group default**. Override resolution is **location + service + channel → less-specific location override → extension default → official base**. `takeaway` maps to official `collection` at the compatibility boundary while remaining an accepted canonical input.

## Migration, UI, adapter, and testing strategy

- **Migration:** create empty additive tables only. Existing menus/options require no backfill. Rollback drops only extension tables in dependency order. Disable retains the tables/configuration.
- **Admin:** add a permission-gated, configurable-admin-URI RestaurantOps configuration page linked by menu ID. It shows official records as references and exposes foundation endpoints; it does not copy the official menu form or interfere with official saves.
- **Storefront/POS/waiter:** a shared compatibility mapper accepts legacy option payloads unchanged and a versioned enhanced payload containing variant, modifier quantities, combo choices, location, service type, channel and configuration hash. It returns canonical official-compatible options plus an enhanced identity fragment and server price breakdown.
- **Tests:** unit-test invariants, precedence, decimal pricing, hashes, condition/combo cycle detection and cart identity; feature-test migrations, models, routes, permissions, location denial, snapshots and official seam discovery; run existing Location Context/roles/compatibility suites plus route cache, Pint, Composer validation and diff safety checks.

## No-regression checklist

- [ ] Legacy menu without metadata follows official behavior.
- [ ] Existing menu/category/option/value IDs and prices are untouched.
- [ ] Official storefront/API response shapes are untouched.
- [ ] Official cart, checkout, totals, delivery, collection, reservations, auth and payment routes are untouched.
- [ ] Enhanced requests are server-priced and location-authorized.
- [ ] Historical snapshots never resolve mutable names/prices for enhanced orders.
- [ ] All extension routes use admin URI/auth/permissions and branch saves require a concrete location.
- [ ] No global scope or official template override is introduced.
- [ ] No dependency update and no vendor/core/official extension modification occurs.
- [ ] All migrations are reversible and all hot lookup paths indexed.

## Known Phase 1.4 boundaries

This foundation deliberately excludes the full POS/waiter UI, table sessions, shifts, settlement, receipts, KDS/KOT queues or printing, inventory/recipes, purchasing, warehouse, accounting and profitability. Combo and kitchen support stop at configuration, validation, snapshot and resolver contracts.
