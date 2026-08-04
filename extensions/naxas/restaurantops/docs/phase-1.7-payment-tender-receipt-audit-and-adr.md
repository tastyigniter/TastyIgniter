# Phase 1.7 pre-change payment, tender, receipt audit and ADR

**Audit completed:** 2026-08-04, before Phase 1.7 production changes. **Scope:** the
installed tree on branch `work` (requested target `Devs` was not checked out). This is
a read-only impact record, not retrospective implementation documentation.

## Baseline and inventory

Phase 1.6 ends at `PosOrderService::lockForPayment`: `payment_pending` records
`payment_locked_at` and copies `order_total` to `outstanding_total`. It records no
tender, invokes no gateway, issues no receipt, creates no cash movement and has no
completed POS state. POS states are draft, held, active, kitchen-pending,
payment-pending and cancelled. The official order is created at confirmation with
official `Order`, `OrderMenu`, `OrderMenuOptionValue` and `OrderTotal` models.

Affected extension surfaces are admin routes in `routes/web.php`; `PosOrders` and
`CashierShifts` controllers; their request DTO/validation; `PosOrderService`, state
machine and contracts; shift context/reconciliation and payment-summary contracts;
`PaymentAdapter`; POS/shift models and migrations; POS and shift Blade/JavaScript;
activity audit adapter; permissions, role profiles, language and navigation; order and
payment events/listeners; verification/install/upgrade commands; unit, feature and
opt-in MySQL tests; README/status, route, schema and runbook documentation. No report
controller exists; official Cart dashboard cards/charts currently derive from official
orders/payments and must remain untouched.

Owned schema is `naxas_restaurant_ops_pos_orders`, items, events, approvals and
idempotency keys; cashier shifts, submissions, denominations and cash movements; menu
configuration and snapshot tables. `pos_orders.order_id` uniquely links the official
order; POS totals are locked operational snapshots. Shift movements support cash
in/out, safe drop, petty expense and adjustment but not sales tender. Official schema
owns `orders` (including `payment`, `processed`, `status_id`, invoice prefix/date and
official totals), `order_menus`, `order_menu_options`, `order_totals`, `payments`, and
`payment_logs`. Official order IDs/invoice prefixes are legal numbering; no existing
extension receipt/payment-reference field exists.

Repository hygiene audit: 18,707 `vendor/` paths are tracked, including installed
TastyIgniter package sources used for this seam audit. `composer.lock` plus Composer
metadata makes installation nominally reproducible, but deployment may intentionally
use the committed vendor tree for network-free/immutable builds. Removing it could
change resolved artifacts, autoloading and deployment availability. Do not touch it in
Phase 1.7; separately confirm the deployment pipeline, build an artifact from
`composer install --no-dev --prefer-dist`, compare it, then remove vendor in its own
reviewed change only if deployments install dependencies.

## Authoritative installed seams

* `Igniter\Cart\Models\Order` owns payment code, `processed`, `status_id`, totals,
  customer/guest fields, `payment_method`, `payment_logs`, status history and invoice.
  `markAsProcessed()` is the public processed seam; invoice comes from `HasInvoice`
  and formats configured prefix plus order ID. Paid and completed are distinct:
  processing establishes successful checkout while configured statuses/history govern
  fulfilment; POS settlement must not invent completion.
* `Igniter\PayRegister\Models\Payment` owns enabled methods and gateway resolution;
  `PaymentGateways`/`BasePaymentGateway::processPaymentForm` are checkout gateway
  invocation seams. COD is the installed offline gateway. Existing Stripe, Square,
  Mollie, PayPal and Authorize.Net behavior is storefront-owned and must not be called
  for manually captured POS card/mobile references.
* `PaymentLog::logAttempt()` is the supported attempt ledger and relates through the
  order payment code. It assumes a single official payment method, whereas split
  tender needs multiple allocations. Refund support is gateway-capability based via
  `WithPaymentRefund` and refund events; it is not a generic reversal API.
* Official `OrderTotal` rows and `order_total` remain authoritative for subtotal,
  tax, discount, delivery/service fees. POS must copy, never independently recompute,
  these after official linkage. Official menu/order lines, customer/guest identity,
  location, status history and admin invoice remain official-owned.

Conclusion: installed public seams support an offline/manual POS synchronization by
selecting a configured offline official payment code, recording a safe successful
payment log, calling `Order::markAsProcessed()` and adding status history through its
public relationship/API. They do **not** expose a safe generic reversal of a processed
multi-tender order. Phase 1.7 reversal therefore stops at immutable request/approval
unless an adapter positively reports executable support; it must never report a fake
refund/reversal.

## Change allocation

| Concern | Owner/change class |
|---|---|
| allocation, money, state, locking, retry | backend payment domain service |
| shapes, references, version/key/reason | Form Request validation |
| processed/payment/log/history mapping | official payment adapter |
| attempts, tenders, events, receipts, sequences, reversals | extension schema + reversible migration |
| create/view/reprint/reversal/summary | additive permissions and role profiles |
| branch/cashier/shift ownership | location/session context and shift contract |
| cash/card/mobile/refund/count summaries | shift reconciliation provider |
| immutable 80mm output | receipt renderer and print handlers |
| modal, split rows, disabled submit/errors | existing admin UI + scoped JavaScript |
| stable replay/error/resource payloads | controllers/API responses |
| all transitions/print/reversal/sync | append-only events + audit logger |
| calculations, routes, permissions, rollback/concurrency | unit, feature and opt-in MySQL tests |

New routes must stay below the configured admin URI with admin, location context,
transactional-location and exact permission middleware. Mutation also validates
resource location, original open shift/cashier, expected version and idempotency in the
service. Extension enable/disable must only register/unregister extension surfaces and
must not delete data.

## Regression matrix

| Existing behavior | Risk and boundary |
|---|---|
| storefront checkout and online gateways | route/event collision or reused session/gateway; add admin-only routes and never touch checkout/session/gateway code |
| delivery/collection and customer history | changed order fields/payment log semantics; preserve official service/customer/guest fields and write only linked POS orders |
| official totals/menu pricing/tax/discount | divergent calculation; settle official total/snapshot without modifying lines/totals |
| status workflow/admin orders | duplicate processed/history transition; adapter must be idempotent and preserve paid versus completed distinction |
| shift open/close and cash in/out | double counted cash or close race; lock order then payment then shift consistently and derive sales from applied tenders |
| held/active POS orders | accidental mutability/settlement; only payment-pending can prepare |
| location/permissions | cross-branch leak or manager impersonation; middleware plus service ownership checks and separate approval actor |
| invoice/receipt | competing legal number or mutable history; print official invoice where available plus explicitly operational receipt snapshot |
| route cache | closure/non-serializable route or duplicate names; controller routes and route-cache test |
| lifecycle/migration rollback | data loss or FK-order failure; additive tables, reverse dependency order, no disable-time deletion |
| Phase 1.3--1.6 tests | changed bindings/statuses/routes; additive contracts and backward-compatible existing state transitions |
| reports/dashboards | POS missing or double counted; official synchronization supplies official reporting while extension tender summary supplies shift reconciliation only |

## Concurrency, security and failure analysis

Double clicks, two cashiers and duplicate completed payment are controlled with a
unique idempotency claim, request hash comparison, row lock, expected version and a
unique one-successful-settlement invariant. Same key/different payload is HTTP 409;
exact replay returns the stored result. Lock ordering is POS order, payment/attempt,
shift, receipt sequence; all same-connection writes use a transaction with bounded
deadlock retry. Do not invoke a remote gateway under these locks and never silently
retry a charge. Phase 1.7 card/mobile are externally captured references, not gateway
charges.

Server money uses integer minor units/decimal-safe helpers; browser totals are ignored.
Amounts must be positive, currency supported, non-cash cannot exceed remaining, cash
may over-tender only last, and applied amounts must exactly equal authoritative
outstanding. Store cash received, applied and change separately; expected drawer uses
applied cash once. References are required by policy for card/mobile, length-limited
and sanitized. Never persist PAN, CVV, PIN, wallet PIN, secrets or raw gateway payload.

Stale versions, cancelled/paid/processed orders, closed/closing/submitted/approved/
rejected shifts, wrong cashier/shift/location and global location fail before official
sync. A transaction rollback handles official-sync, receipt or reconciliation failure
on the same connection. Any uncertain external outcome remains `payment_processing`
with an event/correlation ID for explicit recovery, never success. Transactional
receipt creation plus unique payment/number prevents duplicate issuance. Print/reprint
only increments print metadata and events. Reversal against a closed shift, exported
record or unsupported official adapter is blocked. Original rows are never changed or
deleted; any future execution uses compensating tenders.

## MySQL review

Use `DECIMAL(15,4)` consistently with current tables, normalized strings and no PHP
floats. Explicit short (`rops_*`) index/FK names remain below MySQL's 64-character
limit. Unique keys cover idempotency and receipt number; a generated/nullable success
guard or equivalent transaction invariant is required because MySQL has no partial
unique index. Foreign keys point only among extension tables (official IDs stay scalar
to avoid extension ordering/coupling). Nullable gateway/reference columns are indexed
only where useful. InnoDB row locks require transactions; default isolation can expose
deadlocks, so deterministic lock order and three bounded transaction attempts are
required. Receipt sequences use a locked per-location/day row/upsert, never
`MAX(id)+1`. Down migrations drop children before parents and never alter official
tables. SQLite can validate logic but cannot prove MySQL precision, locking, FK or
concurrency behavior.

## ADR-017: hybrid tender ledger and official synchronization

**Option A -- official tables only.** Attractive for reports/customer history, but
`orders.payment` represents one code and `payment_logs` is an attempt log, not a
split-tender/cash-received/change/shift ledger. Adding operational metadata there would
modify official schema/source and couple upgrades. Rejected.

**Option B -- RestaurantOps only.** Models splits and reconciliation cleanly, but makes
official orders appear unpaid/unprocessed, bypasses status history, admin reporting,
invoices and customer history, creating a competing accounting truth. Rejected.

**Option C -- hybrid.** RestaurantOps owns immutable attempts, allocations,
idempotency, cashier/shift/location attribution, operational receipt and reconciliation;
the installed adapter synchronizes the linked official order through public payment,
log, processed and history seams without changing official totals/items. Chosen. It is
the only option matching both installed cardinality constraints and the no-competing-
order rule. The adapter boundary makes failures explicit and testable and allows a
future documented gateway adapter without pretending manual POS capture is an online
charge.

**Consequences:** official reporting sees one configured POS/offline payment code while
extension reports provide the tender breakdown. Completion occurs only after official
sync succeeds. Operational `RCP-{LOCATIONCODE}-{YYYYMMDD}-{SEQUENCE}` is explicitly not
a legal invoice; print the official order/invoice number alongside it. Generic payment
reversal execution is unsupported by the installed API and remains approval/audit-only
until a separately tested adapter is available.

## Audit gate

Production implementation may begin after this document. Required proof before GO:
extension tests plus opt-in MySQL precision/concurrency/rollback, real browser payment
and 80mm printing, official order/log/history inspection, shift close reconciliation,
route cache, storefront delivery/collection/login/online-payment regression, and
disable/re-enable retention. Without all of these, the release decision is
`CONDITIONALLY GO` or `NO-GO`, never GO.
