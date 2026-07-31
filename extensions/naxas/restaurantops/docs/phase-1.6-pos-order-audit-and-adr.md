# Phase 1.6 POS order foundation — pre-change audit and ADR

**Audit date:** 2026-07-31  
**Decision:** **GO**, with production approval withheld until the owner completes the MySQL and browser runbook.

This document records the mandatory audit completed before Phase 1.6 production code was changed. The audit inspected the installed, locked official packages and the application-owned Location Context, role, menu-integration, snapshot, audit, and cashier-shift foundations.

## Official order, cart, checkout, and customer findings

1. `Igniter\Cart\Models\Order` is the authoritative `orders` model. Its primary key is `order_id`; it owns location, customer/address, collection/delivery `order_type`, customer/contact fields, serialized cart, item count, comment, order date/time, total, payment code, processed flag, status, status history, official menu rows, option rows, totals, and payment logs. Official completion means both payment processed and a completed status; cancellation uses official status history and emits `OrderCanceledEvent`.
2. `OrderMenu` is the official item row (`order_menus`) and persists menu identity, display name, quantity, price, subtotal, comment, serialized option values and relational `OrderMenuOptionValue` rows. Its numeric casts are floats, so RestaurantOps continues to calculate and snapshot money as decimal strings/`DECIMAL(15,4)` and converts only at the official boundary.
3. `OrderTotal` is authoritative for official total lines. `OrderManager::getCartTotals()` derives these from the official cart conditions. `OrderManager::saveOrder()` locks an existing order, saves it, then calls official `addOrderMenus()` and `addOrderTotals()` in a retrying database transaction.
4. Official status is configuration driven, not a fixed POS matrix: default, processing, completed, cancelled, accepted and rejected status identifiers are settings. `LogsStatusHistory`, `addStatusHistory()`, `updateOrderStatus()`, the admin Orders controller, and StatusWorkflows are the supported seams. POS operational state must therefore remain separate metadata and must never pretend to be official payment/completion state.
5. `CartManager` owns the session cart lifecycle. It selects a location-specific cart instance, finds a menu through the current location, checks location/order time/mealtime/menu status/minimum/stock/location, validates official options, and delegates add/update/remove to the official `Cart`. Conditions supply tax, delivery and coupon adjustments. Cart events and checkout events are extension seams; no POS code may replace them globally.
6. Storefront add-to-cart already delegates enhanced selections through `MenuSelectionResolver`, `PricingResolver`, `AvailabilityResolver`, `SelectionValidator`, `CartCompatibilityMapper`, and `TastyIgniterCartAdapter`. It enforces a concrete storefront location, canonical collection mapping, menu/location/channel visibility, variants, modifier quantities, combo selections, deterministic hashes, authoritative prices and database idempotency.
7. Official checkout uses session state (`igniter.checkout.order`) and the current storefront Location service. `OrderManager::loadOrder()` may create an unprocessed official order early; `saveOrder()` updates official items/totals; payment processing later assigns default status. Reusing that stateful manager directly from an admin session risks cart/session/customer/location leakage.
8. Delivery is official `delivery`; collection/takeaway is official `collection`. Location order-type availability, date/time restrictions, delivery area/geocoding, delivery amount, minimum order, tax condition, special price, and mealtime rules already exist and remain authoritative. Dine-in has no official cart order type in the installed package, so POS stores canonical `dine_in` metadata and maps its official record conservatively to collection semantics while retaining POS source/service metadata. It does not claim a full table order.
9. Official `Customer` and `Address` remain authoritative. Guest checkout is supported when the location allows it. Registered addresses must be owned by the selected customer; guest delivery data is validated and snapshotted. RestaurantOps must not create another customer table or mutate storefront login/session state.
10. Official numbering is the database-generated `order_id`, with official hash/invoice helpers. POS must not generate a competing legal order number.
11. Official order notes are `comment`; item notes are `OrderMenu::comment`; delivery notes are `delivery_comment`. Official options are reconstructed by `ManagesOrderItems`. RestaurantOps immutable enhanced snapshots already attach one-to-one to official order-menu rows after `igniter.checkout.afterSaveOrder`, with reconciliation failures recorded separately.
12. The official admin Orders controller supports CRUD/form status updates but there is no safe general-purpose POS clone API. Duplication must create a fresh POS draft and re-resolve selections. Paid/finalized official orders must not be edited, cloned in place, cancelled through POS, or have historical kitchen snapshots overwritten.
13. Official seams found include `igniter.checkout.beforeSaveOrder`, `afterSaveOrder`, `beforePayment`, cart coupon hooks, typed payment/cancel events, status history, model extension relations, admin navigation/route extension registration, and official model/service adapters. No official source change is needed.

## Existing RestaurantOps findings

* Location Context exposes concrete/global mode and assignment checks. Admin routes use `Igniter::adminUri()`, configured admin middleware, `location.context`, class-action routing, permission middleware, and transactional-location middleware; route cache compatibility is an existing invariant.
* The official `UserRole` permission matrix already defines all requested POS codes. Cashier has create/edit/hold/recall/apply/request capabilities; manager/owner profiles have configured approval capabilities; waiter and kitchen profiles do not receive POS access by default.
* `ShiftContextContract::requireOpenShift()` resolves a unique active staff shift. Shift rows use immutable staff/location attribution, status/version fields, row locks and transactions. POS must additionally compare the active location and accept only `open`.
* `AuditLogger` has a production activity-log adapter and a no-sensitive-payload convention. `ShiftClosingWarningProvider` is an explicit replaceable seam. Payment summaries intentionally do not fabricate unsupported cash sales.
* Enhanced menu integration already provides the authoritative POS-capable resolver (`channel=pos`), deterministic configuration/pricing hash, official option mapping, special pricing, location/service visibility, quantities, combos, kitchen names and station resolver. Client price/total fields are not resolver inputs and must be rejected at the HTTP boundary.
* Existing database conventions are additive extension migrations, `naxas_restaurant_ops_` names, decimal money, unique ledgers, transactions with three retries, `lockForUpdate()`, explicit optimistic versions, structured exceptions, and idempotency keys. SQLite proves semantics only; MySQL/InnoDB concurrency, index and decimal definitions require the opt-in suite.
* The known Composer baseline remains: root constraints are valid but `composer.lock` may not reflect the configured patch plugin/metadata. No broad update is permitted. The runtime targets MySQL with the configured prefix; this environment may lack a reachable server and cannot provide browser proof.

## Lifecycle and state matrix

POS uses a separate **operational** state machine while the official order owns legal/status/payment state.

| From | Allowed transitions | Meaning |
|---|---|---|
| `draft` | `held`, `active`, `cancelled` | Extension draft; freely editable; no official order yet |
| `held` | `draft`, `cancelled` | Recall revalidates configuration and price; attribution is unchanged |
| `active` | `held`, `kitchen_pending`, `payment_pending`, `cancelled` | Confirmed and linked idempotently to an official order |
| `kitchen_pending` | `payment_pending`, `cancelled` (controlled) | Dispatch event foundation only; no KOT/KDS queue |
| `payment_pending` | none in Phase 1.6 | Totals locked for a later settlement phase; not paid/completed |
| `cancelled` | none | Terminal in this phase |

`completed`, `voided`, and `kitchen_sent` are reserved for later phases and are not produced. Unsent draft items are archived/removed operationally; once kitchen-pending, removal requires a void approval record. Cancellation requires a reason and permission; official cancellation is not invoked for paid/processed orders.

## ADR: extension draft first, official order at confirmation

**Decision (Option B).** Drafts, held orders and editable item snapshots live in minimal RestaurantOps POS tables. Confirmation resolves every item again, calculates authoritative totals, and creates the official order/items/totals using an isolated official synchronization adapter. It then atomically stores the unique official `order_id` when the installed database/service boundary permits. Duplicate confirmation returns the existing link.

**Why.** `OrderManager::loadOrder()` creates incomplete official records and is coupled to the storefront session cart, customer auth and current storefront Location service. Creating those at POS draft time would pollute official reports and risk admin/storefront session contamination. Extension drafts are not a competing legal order: they are transient operational metadata and immutable configuration/pricing snapshots; the official record becomes authoritative at confirmation.

**Consequences.** The sync adapter is deliberately narrow and documented. Official service-type, customer/address, menu option, totals, numbering and snapshot behavior are preserved. A failure leaves the draft retryable with an audit event, never ambiguously linked. Atomicity is only claimed for database operations on the same connection; session-cart operations are not claimed ACID. Storefront orders do not gain POS metadata or shift requirements.

## Proposed schema and transaction strategy

* `..._pos_orders`: nullable unique official order link; immutable location/shift/cashier; service/source/status/customer/guest/address/note/time foundations; hold/kitchen/payment/cancel timestamps; decimal subtotal/discount/tax/delivery/total/outstanding; configuration/pricing hashes; optimistic version.
* `..._pos_order_items`: draft snapshots linked to POS metadata; official menu/variant identity; quantity/note; immutable configuration/pricing JSON and hash; decimal unit/line totals; status, sent quantity and version. Rows are archived/statused rather than silently destroyed after operational confirmation.
* `..._pos_order_events`: append-only minimal audit timeline.
* `..._pos_approval_requests`: discount/void/cancel request and decision metadata, before/discount/after decimal amounts, requester/approver and timestamps.
* `..._pos_idempotency_keys`: operation/key unique ledger with request hash, resource and response metadata.

Every write uses an idempotency claim, a transaction, a `lockForUpdate()` on the POS order, expected-version comparison, state/shift/location revalidation, deterministic hashes and a version increment. Unique official linkage prevents duplicate sync. Same key/same request replays; same key/different request returns `pos_idempotency_conflict`; stale versions return `pos_order_version_conflict` (409). These controls reduce, but SQLite cannot prove, production lock scheduling.

## Domain decisions

* **Shift:** cashier creation requires a concrete active assigned location and own open shift at that location. IDs never change. Writes stop when the shift is no longer open. Storefront orders are untouched. Shift warnings are scoped to shift/location; payment-pending blocks normal submission, while drafts/held/active/kitchen-pending warn and require explicit handling.
* **Service:** `takeaway` is accepted only as an alias and stored as `collection`. Delivery requires phone and a validated customer-owned or guest address and uses official delivery fee/tax seams. Collection clears delivery-only data. Dine-in customer/name/count are optional and no table session is implemented.
* **Discounts:** fixed/percentage, order/line foundations use decimal server calculations. A conservative zero automatic threshold means privileged discounts require approval unless configured. Self-approval and cross-location approval are denied. No coupons, loyalty or client-computed discount is accepted.
* **Void/cancel:** unsent draft removal is allowed; kitchen-visible items require void request/approval. Reasons, before/after totals and actors are retained. Processed/paid official orders are immutable. Refunds are out of scope.
* **Kitchen:** `PosOrderReadyForKitchen` carries location/service/source/revision and immutable item/kitchen/station snapshots. Dispatch is idempotent. It creates no queue, ticket, KOT or preparation state.
* **Payment:** payment preparation locks the authoritative payable/outstanding snapshot and transitions to `payment_pending`. It creates no payment, tender, receipt, gateway call or shift cash movement.

## Risks and upgrade controls

| Risk | Severity | Control |
|---|---:|---|
| Duplicate/incompatible order domain | Critical | Official order remains authoritative; POS tables are drafts/metadata only; unique official link |
| Admin session contaminates storefront cart/customer | Critical | isolated POS draft and sync boundary; never mutate legacy endpoints/session cart |
| Cross-location or global transaction | Critical | context middleware plus service-level resource/location checks |
| Missing/closed/mismatched shift | Critical | require and lock open own shift on every write |
| Client price/total/discount manipulation | Critical | reject price fields; enhanced resolver and decimal calculations only |
| Stale configuration/price | High | hashes and recall/confirm re-resolution with explicit 409 warning |
| Duplicate submit/concurrent edit/approval | High | unique idempotency ledger, row locks, versions and state checks |
| Paid/finalized edit or cancellation | Critical | official processed/completed checks and terminal POS payment lock |
| Historical kitchen data mutation | High | snapshots/events; sent quantities and void workflow |
| Wrong customer/address or PII leakage | High | official ownership validation; minimal snapshots/audits/payloads |
| Official package upgrade | High | contracts/adapters/model extension/events only; no vendor/core edits |
| MySQL/SQLite semantic divergence | High | opt-in MySQL schema/locking suite and owner runbook |
| N+1/catalog load | Medium | paginated order lists, bounded catalog search, eager-loaded item relations |
| Composer lock baseline | Medium | no dependency/update; report validation warning unchanged |

## Verification plan and no-regression checklist

Automated checks cover migration up/down, decimals/indexes/uniqueness, state/service/money/idempotency behavior, open-shift/location authorization, item resolution and client-price rejection, hold/recall, discounts/approvals, void/cancel, sync idempotency, kitchen/payment boundaries, shift warnings, routes/navigation/translations, existing Location Context/roles/menu/menu-integration/snapshot/shift suites, route cache, Pint, Composer validation and forbidden-path diffs. The opt-in MySQL suite verifies real definitions and uniqueness and skips clearly without configuration.

Owner verification must run migrations and rollback on disposable MySQL, execute the 40-step local runbook, inspect official order/items/options/status/totals, confirm no payment/KOT/receipt/cash movement is created, exercise cross-location/global/no-shift/stale/retry paths, disable/re-enable the extension, verify storefront checkout/delivery/collection/reservation/customer authentication/payment remain unchanged, and capture the requested responsive screenshots.

**No-regression boundary:** no `vendor/`, TastyIgniter core, official extension, official route, theme, storefront controller, cart, checkout, delivery, collection, reservation, customer-auth or payment source is modified. New behavior is reachable only through extension-owned admin routes and bindings. Data is retained on extension disable; migration rollback is explicit and destructive only when deliberately run.

## GO / NO-GO

**GO for implementation.** The installed architecture provides sufficient extension seams, authoritative menu pricing/configuration, official order persistence, concrete Location Context, permissions, shifts, audit and warning contracts. Option B avoids incomplete official records and admin-session storefront coupling. **NO-GO for production deployment** remains in force until real MySQL concurrency/schema and browser workflows are verified by the owner.
